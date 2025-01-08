<?php
namespace Khalil\Components\Builder;


final class QueryBuilder{
    
    protected string $action = '';
    protected string $table = '';
    protected array $columns = [];
    protected array $values = [];
    protected array $where = [];
    protected array $joins = [];
    protected array $orderBy = [];
    protected array $set = [];
    protected array $groupBy = [];
    protected array $having = [];
    protected array $unions = [];
    protected string $limit = '';
    protected string $offset = '';
    protected bool $debugMode = false;

    /**
     * Définir une action SELECT.
     * 
     * @param array $columns Colonnes à sélectionner.
     * @return $this
     */
    public function select(array $columns = ['*']): self
    {
        $this->action = 'SELECT';
        $this->columns = $columns;
        return $this;
    }

    /**
     * Définir une action INSERT INTO.
     * 
     * @param string $table Nom de la table.
     * @param array $data Données à insérer.
     * @return $this
     */
    public function insert(string $table, array $data): self
    {
        $this->action = 'INSERT';
        $this->table = $table;
        $this->columns = array_keys($data);
        $this->values = array_map([$this, 'quote'], array_values($data));
        return $this;
    }

    /**
     * Définir une action UPDATE.
     * 
     * @param string $table Nom de la table.
     * @param array $data Données à mettre à jour.
     * @return $this
     */
    public function update(string $table, array $data): self
    {
        $this->action = 'UPDATE';
        $this->table = $table;
        $this->set = array_map(fn($k, $v) => "$k = " . $this->quote($v), array_keys($data), $data);
        return $this;
    }

    /**
     * Définir une action DELETE.
     * 
     * @param string $table Nom de la table.
     * @return $this
     */
    public function delete(string $table): self
    {
        $this->action = 'DELETE';
        $this->table = $table;
        return $this;
    }

    /**
     * Définir la table principale.
     * 
     * @param string $table Nom de la table.
     * @param string $alias Alias (facultatif).
     * @return $this
     */
    public function from(string $table, string $alias = ''): self
    {
        $this->table = $alias ? "$table AS $alias" : $table;
        return $this;
    }

    /**
     * Ajouter une clause WHERE.
     * 
     * @param string $condition Condition.
     * @param mixed $value Valeur (optionnelle).
     * @return $this
     */
    public function where(string $condition, $value = null): self
    {
        $this->where[] = $value !== null ? str_replace('?', $this->quote($value), $condition) : $condition;
        return $this;
    }

    /**
     * Ajouter une jointure.
     * 
     * @param string $table Table à joindre.
     * @param string $condition Condition.
     * @param string $type Type de jointure.
     * @param string $alias Alias (facultatif).
     * @return $this
     */
    public function join(string $table, string $condition, string $type = 'INNER', string $alias = ''): self
    {
        $this->joins[] = "$type JOIN " . ($alias ? "$table AS $alias" : $table) . " ON $condition";
        return $this;
    }

    /**
     * Ajouter une sous-requête (inline).
     * 
     * @param callable $callback Fonction générant la sous-requête.
     * @return string
     */
    public function subQuery(callable $callback): string
    {
        $builder = new self();
        $callback($builder);
        return '(' . $builder->getQuery() . ')';
    }

    /**
     * Ajouter une clause GROUP BY.
     * 
     * @param array $columns Colonnes.
     * @return $this
     */
    public function groupBy(array $columns): self
    {
        $this->groupBy = $columns;
        return $this;
    }

    /**
     * Ajouter une clause HAVING.
     * 
     * @param string $condition Condition.
     * @param mixed $value Valeur (optionnelle).
     * @return $this
     */
    public function having(string $condition, $value = null): self
    {
        $this->having[] = $value !== null ? str_replace('?', $this->quote($value), $condition) : $condition;
        return $this;
    }

    /**
     * Ajouter une clause ORDER BY.
     * 
     * @param string $column Colonne.
     * @param string $direction Direction (ASC/DESC).
     * @return $this
     */
    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->orderBy[] = "$column $direction";
        return $this;
    }

    /**
     * Ajouter une clause LIMIT.
     * 
     * @param int $limit Limite.
     * @return $this
     */
    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Ajouter une clause OFFSET.
     * 
     * @param int $offset Décalage.
     * @return $this
     */
    public function offset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * Activer ou désactiver le mode débogage.
     * 
     * @param bool $debug Activer/désactiver.
     * @return $this
     */
    public function debug(bool $debug = true): self
    {
        $this->debugMode = $debug;
        return $this;
    }

    /**
     * Générer et retourner la requête SQL.
     * 
     * @return string
     */
    public function getQuery(): string
    {
        $query = match ($this->action) {
            'SELECT' => $this->buildSelect(),
            'INSERT' => $this->buildInsert(),
            'UPDATE' => $this->buildUpdate(),
            'DELETE' => $this->buildDelete(),
            default => throw new Exception("Action SQL non définie."),
        };

        return $this->debugMode ? $query : trim($query);
    }

    /**
     * Construire une requête SELECT.
     * 
     * @return string
     */
    protected function buildSelect(): string
    {
        $query = "SELECT " . implode(', ', $this->columns) . " FROM $this->table";
        $query .= $this->buildClauses();
        return $query;
    }

    /**
     * Construire une requête INSERT.
     * 
     * @return string
     */
    protected function buildInsert(): string
    {
        return "INSERT INTO $this->table (" . implode(', ', $this->columns) . ") VALUES (" . implode(', ', $this->values) . ")";
    }

    /**
     * Construire une requête UPDATE.
     * 
     * @return string
     */
    protected function buildUpdate(): string
    {
        $query = "UPDATE $this->table SET " . implode(', ', $this->set);
        $query .= $this->buildClauses();
        return $query;
    }

    /**
     * Construire une requête DELETE.
     * 
     * @return string
     */
    protected function buildDelete(): string
    {
        $query = "DELETE FROM $this->table";
        $query .= $this->buildClauses();
        return $query;
    }

    /**
     * Construire les clauses WHERE, GROUP BY, HAVING, ORDER BY, LIMIT, OFFSET.
     * 
     * @return string
     */
    protected function buildClauses(): string
    {
        $clauses = [
            $this->where ? 'WHERE ' . implode(' AND ', $this->where) : '',
            $this->joins ? implode(' ', $this->joins) : '',
            $this->groupBy ? 'GROUP BY ' . implode(', ', $this->groupBy) : '',
            $this->having ? 'HAVING ' . implode(' AND ', $this->having) : '',
            $this->orderBy ? 'ORDER BY ' . implode(', ', $this->orderBy) : '',
            $this->limit ? 'LIMIT ' . $this->limit : '',
            $this->offset ? 'OFFSET ' . $this->offset : '',
        ];

        return ' ' . implode(' ', array_filter($clauses));
    }

    /**
     * Échapper une valeur.
     * 
     * @param mixed $value Valeur à échapper.
     * @return string
     */
    protected function quote($value): string
    {
        return $value === null ? 'NULL' : (is_numeric($value) ? $value : "'" . addslashes($value) . "'");
    }

}