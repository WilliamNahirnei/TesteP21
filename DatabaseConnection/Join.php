<?php

namespace DatabaseConnection;

class Join {
    private string $type;
    private string $table;
    private string $field1;
    private string $comparator;
    private string $field2;
    private ?string $alias;

    public function __construct(string $type, string $table, string $field1, string $comparator, string $field2, ?string $alias = null) {
        $this->type = $type;
        $this->table = $table;
        $this->field1 = $field1;
        $this->comparator = $comparator;
        $this->field2 = $field2;
        $this->alias = $alias;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getTable(): string {
        return $this->table;
    }

    public function getField1(): string {
        return $this->field1;
    }

    public function getComparator(): string {
        return $this->comparator;
    }

    public function getField2(): string {
        return $this->field2;
    }

    public function getAlias(): ?string {
        return $this->alias;
    }

    public function getString(): string {
        $joinString = $this->getType() . ' JOIN ' . $this->getTable() . ' ON ' . $this->getField1() . ' ' . $this->getComparator() . ' ' . $this->getField2();
        return $joinString;
    }
}
?>