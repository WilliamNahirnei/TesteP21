<?php

namespace DatabaseConnection;

class OrderBy {

    public const ORDER_BY = "ORDER BY";
    public const ORDER_DESC = "DESC";
    public const ORDER_ASC = "ASC";
    private array $fieldList;
    private string $direction;

    public function __construct(array $fieldList, ?string $direction = self::ORDER_DESC) {
        $this->fieldList = $fieldList;
        $this->direction = $direction;

    }

    public function getFieldList(): array {
        return $this->fieldList;
    }

    public function getDirection(): string {
        return $this->direction;
    }

    public function getString(): string {
        $orderBy = " " . self::ORDER_BY . " " . implode(", ", $this->getFieldList()) . " {$this->getDirection()}";
        return $orderBy;
    }
}
?>