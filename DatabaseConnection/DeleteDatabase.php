<?php
namespace DatabaseConnection;

class DeleteDatabase extends Query {
    public function mountQuery(): void {
        $deleteQuery = "DELETE FROM {$this->getTable()} WHERE {$this->getWhereConditionsString()}";
        $this->setQueryString($deleteQuery);
    }
}