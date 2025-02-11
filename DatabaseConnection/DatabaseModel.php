<?php
namespace DatabaseConnection;

use stdClass;

abstract class DatabaseModel {
    protected static $table_name = '';
    protected static $columnList = [];
    protected ?int $id;

    public function __construct() {
        static::defineTableName();
        static::defineColumnList();
    }

    protected abstract static function defineTableName(): string;

    protected abstract static function defineColumnList(): array;

    public function create() {
        static::defineTableName();
        static::defineColumnList();
        $dataInsert = $this->mountArrayDataPersist();
        $insertQuery = new InsertDatabase(static::$table_name, $dataInsert);
        $insertQueryResult = $insertQuery->execute();

        if ($insertQueryResult) {
            $this->setId($insertQuery->getPdoConnection()->lastInsertId());
            return true;
        }

        return false;
    }

    public function update() {
        return $this->updateLimited(static::$columnList);
    }

    public function updateLimited(array $fieldList) {
        static::defineTableName();
        static::defineColumnList();
        $updateData = $this->mountArrayDataPersist($fieldList);
        $whereConditions = [
            new WhereCondition('id', '=', $this->getId())
        ];

        $updateQuery = new UpdateDatabase(static::$table_name, $updateData, $whereConditions);
        return $updateQuery->execute();
    }

    public function delete() {
        static::defineTableName();
        static::defineColumnList();
        $whereConditions = [
            new WhereCondition('id', '=', $this->getId())
        ];

        $deleteQuery = new DeleteDatabase(static::$table_name, [], $whereConditions);
        return $deleteQuery->execute();
    }

    private function mountArrayDataPersist(?array $fieldList = null): array {
        if ($fieldList) {
            static::$columnList = $fieldList;
        }
        $dataPersist = [];
        foreach (static::$columnList as $column) {
            $methodName = 'get' . ucfirst($column);
            if (method_exists($this, $methodName)) {
                $dataPersist[$column] = $this->$methodName();
            }
        }
        return $dataPersist;
    }

    public function toArray() {
        $arrayObject = [];
        $arrayObject["id"] = $this->getId();
        foreach (static::$columnList as $column) {
            $methodName = 'get' . ucfirst($column);
            if (method_exists($this, $methodName)) {
                $value = $this->$methodName();
                if (is_object($value) && method_exists($value, 'toArray')) {
                    $arrayObject[$column] = $value->toArray(); // Chamada recursiva para objetos internos
                } else {
                    $arrayObject[$column] = $value;
                }
            }
        }
        return $arrayObject;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public static function findObjects(?array $fieldList = [], ?array $joins = [], ?array$whereConditions = [], ?array$incrementsClass = [], ?int $limit = null, ?OrderBy $orderBy = null) :?array {
        static::defineTableName();
        static::defineColumnList();

        $selectQuery = new SelectDatabase(static::$table_name, [], $whereConditions, $joins, $limit, $orderBy);
        $result = $selectQuery->fetchAll();

        if ($result) {
            return self::mapObjects($result);
        }

        return [];
    }

    public static function findById(int $id): ?self {
        static::defineTableName();
        static::defineColumnList();

        $whereConditions = [
            new WhereCondition('id', '=', $id)
        ];
        $selectQuery = new SelectDatabase(static::$table_name, [], $whereConditions);
        $result = $selectQuery->fetchOne();

        if ($result) {
            return self::mapObject($result);
        }

        return null;
    }

    public static function findOne(?array $fieldList = [], ?array $joins = [], ?array$whereConditions = [], ?array$incrementsClass = [], ?int $limit = null, ?OrderBy $orderBy = null) : ?self {
        static::defineTableName();
        static::defineColumnList();

        $selectQuery = new SelectDatabase(static::$table_name, [], $whereConditions, $joins, 1, $orderBy);
        $result = $selectQuery->fetchOne();

        if ($result) {
            return self::mapObject($result);
        }

        return null;
    }

    private static function mapObjects(?array $list): ?array {
        if ($list) {
            $objectList = [];
            foreach ($list as $resultLine) {
                $objectList[] = static::mapObject($resultLine);
            }
            return $objectList;
        }

        return null;
    }

    private static function mapObject(?stdClass $stdObject) {
        if ($stdObject instanceof stdClass) {
            $class = get_called_class();
            $object = new $class();
            foreach ($stdObject as $property => $value) {
                $method = 'set' . ucfirst($property);
                if (method_exists($object, $method)) {
                    $object->$method($value);
                }
            }
            return $object;
        }

    }
}