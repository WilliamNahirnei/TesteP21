<?php
namespace DatabaseConnection;

class WhereCondition {

    public const LOGICAL_OPERATOR_AND = 'AND';
    private string $column;
    private string $operator;
    private $value;
    private ?string $logicalOperator;

    public function __construct(string $column, string $operator, $value, ?string $logicalOperator = null) {
        $this->column = $column;
        $this->operator = $operator;
        $this->value = $value;
        $this->logicalOperator = $logicalOperator;
    }

    public function getConditionString(): string {
        $logicalOperator = $this->getLogicalOperator() ? $this->getLogicalOperator() . ' ' : '';
        $conditionString = $logicalOperator . $this->getColumn() . ' ' . $this->getOperator() . ' ' . $this->getBindParamName();
        return $conditionString;
    }

    public function getColumn(): string {
        return $this->column;
    }

    public function getOperator(): string {
        return $this->operator;
    }

    public function getValue() {
        return $this->value;
    }

    public function getLogicalOperator(): ?string {
        return $this->logicalOperator;
    }

    public function getBindParamName(): string {
        return ':where_' . $this->column;
    }
}