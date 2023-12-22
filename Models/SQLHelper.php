<?php
    class SQLHelper {
        public static function bindValues(PDOStatement $pdoStatement, array $valuesToBind, int $currentBindValue = 1, int $pdoType = PDO::PARAM_INT) : array {
            /*
                Bind values to values that were sent through $valuesToBind
                using the $currentBindValue integer argument
                Default is PDO::PARAM_INT for the bind value
            */
            foreach($valuesToBind as $morphId) {
                $pdoStatement->bindValue($currentBindValue, $morphId, $pdoType);
                ++$currentBindValue;
            }

            return [
                "pdoStatement" => $pdoStatement,
                "currentBindValue" => $currentBindValue
            ];
        }

        public static function concatenateConditions(array $arrayToIterateOn, string $sqlQuery, string $sqlCondition) : string {
            /*
                Concatenate conditions for the WHERE clause in an SQL query
                where the condition to concatenate and the count of conditions to concatenate is given
                (usually an array full of primary keys, such as IDs)
                Bind value is the current bind value for PDOStatement::bindValue
                Send the current index to bind on to this function
            */
            $sqlQuery .= implode(" AND ", array_fill(0, count($arrayToIterateOn), $sqlCondition));
            return $sqlQuery;
        }
    }

?>