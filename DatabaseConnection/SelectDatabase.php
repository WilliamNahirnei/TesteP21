<?php
namespace DatabaseConnection;

use PDO;

class SelectDatabase extends Query {
    public function mountQuery(): void {
        $selectQuery = "SELECT * FROM {$this->getTable()}";
        $joinsStrings = $this->getJoinsString();
        $whereConditionsString = $this->getWhereConditionsString();

        if (!empty($joinsStrings)) {
            $selectQuery .= " $joinsStrings";
        }

        if (!empty($whereConditionsString)) {
            $selectQuery .= " WHERE $whereConditionsString";
        }

        if (!empty($this->getOrderBy())) {
            $selectQuery .= $this->getOrderBy()->getString();
        }

        if ($this->getLimit() !== null) {
            $selectQuery .= " LIMIT {$this->getLimit()}";
        }

        $this->setQueryString($selectQuery);
    }

    public function fetchAll() {
        if ($this->execute()) {
            return $this->getPdoStatement()->fetchAll(PDO::FETCH_OBJ);
        }
        return null;
    }

    public function fetchOne() {
        $this->setLimit(1);
        $results = $this->fetchAll();
        return $results ? $results[0] : null;
    }
}