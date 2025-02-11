<?php
namespace DatabaseConnection;

class InsertDatabase extends Query {

    public function mountQuery(): void {
        $insertQuery = "INSERT INTO {$this->getTable()} ({$this->getDatabaseFieldsStringList()}) VALUES ({$this->getClassParamsBindName()})";
        $this->setQueryString($insertQuery);
    }

    private function getDatabaseFieldsStringList(): string {
        return implode(",", array_keys($this->getRelationFieldsValues()));
    }

    private function getClassParamsBindName(): string {
        return implode(",", array_keys($this->getBindRelationValuesList()));
    }
}