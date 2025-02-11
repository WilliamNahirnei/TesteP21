<?php
namespace DatabaseConnection;

class UpdateDatabase extends Query {
    public function mountQuery(): void {
        $updateQuery = "UPDATE {$this->getTable()} SET {$this->getUpdateFieldsStringList()} WHERE {$this->getWhereConditionsString()}";
        $this->setQueryString($updateQuery);
    }

    private function getUpdateFieldsStringList(): string {
        $updateFields = [];
        foreach ($this->getRelationFieldsValues() as $field => $value) {
            $updateFields[] = "$field = :$field";
        }
        return implode(", ", $updateFields);
    }
}