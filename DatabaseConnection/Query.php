<?php
namespace DatabaseConnection;

use PDO;
use PDOException;
use PDOStatement;

class Query {
    private ?DatabaseConnection $databaseConnection = null;
    private string $queryString = "";
    private array $bindRelationValuesList = [];
    private ?PDOStatement $pdoStatement = null;
    private $result = null;
    private ?PDO $pdoConnection = null;
    private string $table;
    private array $relationFieldsValues = [];
    private array $joins = [];
    private array $whereConditions = [];
    private ?OrderBy $orderBy = null;

    private ?int $limit = null;
    public function __construct(
        string $table, 
        array $relationFieldsValues = [], 
        ?array $whereConditions = [], 
        ?array $joins = [], 
        ?int $limit = null,
        ?OrderBy $orderBy = null
    ) {
        $this->setTable($table);
        if ($limit) {
            $this->setLimit($limit);
        }
        $this->setRelationFieldsValues($relationFieldsValues);
        $this->setJoins($joins);
        $this->setWhereConditions($whereConditions);
        $this->setOrderBy($orderBy);
        $this->mountBindRelationValuesList();
    }

    public function getTable(): string {
        return $this->table;
    }

    public function setTable(string $table): void {
        $this->table = $table;
    }

    public function getRelationFieldsValues(): array {
        return $this->relationFieldsValues;
    }

    public function setRelationFieldsValues(array $relationFieldsValues): void {
        $this->relationFieldsValues = $relationFieldsValues;
    }

    public function execute() :bool
     {
        $pdoConnection = $this->connect();
        $this->mountQuery();
        $this->setPdoStatement($pdoConnection->prepare($this->getQueryString()));

        $this->bindParamsList();

        return $this->getPdoStatement()->execute();
    }

    protected function mountQuery(): void {
    }

    private function connect(): PDO {
        $this->setDatabaseConnection(new DatabaseConnection());
        $this->setPdoConnection($this->getDatabaseConnection()->getConnection());
        return $this->getPdoConnection();
    }

    private function bindParamsList() {
        foreach ($this->getBindRelationValuesList() as $paramName => $value) {
            $this->getPdoStatement()->bindValue($paramName, $value);
        }
    }

    private function getDatabaseConnection(): ?DatabaseConnection {
        return $this->databaseConnection;
    }

    private function setDatabaseConnection(?DatabaseConnection $databaseConnection): void {
        $this->databaseConnection = $databaseConnection;
    }

    public function getQueryString(): string {
        return $this->queryString;
    }

    public function setQueryString(string $queryString): void {
        $this->queryString = $queryString;
    }

    protected function getBindRelationValuesList(): array {
        return $this->bindRelationValuesList;
    }

    protected function setBindRelationValuesList(array $bindRelationValuesList): void {
        $this->bindRelationValuesList = $bindRelationValuesList;
    }

    protected function getPdoStatement(): ?PDOStatement {
        return $this->pdoStatement;
    }

    private function setPdoStatement(?PDOStatement $pdoStatement): void {
        $this->pdoStatement = $pdoStatement;
    }

    public function getResult() {
        return $this->result;
    }

    private function setResult($result): void {
        $this->result = $result;
    }

    public function getPdoConnection(): PDO {
        return $this->pdoConnection;
    }

    private function setPdoConnection($pdoConnection): void {
        $this->pdoConnection = $pdoConnection;
    }

    private function mountBindRelationValuesList(): void {
        $bindRelationValuesList = [];
        foreach ($this->getRelationFieldsValues() as $field => $value) {
            $bindRelationValuesList[":$field"] = $value instanceof \DateTime ? $value->format("Y-m-d H:i:s") : $value;
        }
        foreach ($this->getWhereConditions() as $condition) {
            $bindRelationValuesList[":where_{$condition->getColumn()}"] = $condition->getValue();
        }
        $this->setBindRelationValuesList($bindRelationValuesList);
    }

    public function getWhereConditions(): array {
        return $this->whereConditions;
    }

    public function setWhereConditions(array $whereConditions): void {
        $this->whereConditions = $whereConditions;
    }

    protected function getWhereConditionsString(): string {
        $whereConditions = [];
        foreach ($this->getWhereConditions() as $condition) {
            $whereConditions[] = $condition->getConditionString();
        }
        return implode(" ", $whereConditions);
    }


    public function getJoins(): array {
        return $this->joins;
    }

    public function setJoins(array $joins): void {
        $this->joins = $joins;
    }

    protected function getJoinsString(): string {
        $joins = [];
        foreach ($this->getJoins() as $join) {
            $joins[] = $join->getString();
        }
        return implode(" ", $joins);
    }

    public function setOrderBy(?OrderBy $orderBy): void {
        $this->orderBy = $orderBy;
    }

    public function getOrderBy(): ?OrderBy {
        return $this->orderBy;
    }

    public function setLimit(int $limit): void {
        $this->limit = $limit;
    }

    public function getLimit(): ?int {
        return $this->limit;
    }
}