<?php

namespace ReactBlog\Backend\models {

    class BaseModel
    {
        protected $db;

        public function __construct()
        {
            require_once "../database_connection.php";
            global $db;
            $this->db = $db;
        }

        public function query($sql, $params = [], $closeCursor = true)
        {
            $stmt = $this->db->prepare($sql);
            $paramKeys = array_keys($params);
            $paramsCount = count($params);
            if ($params && $paramsCount > 0) {
                for ($i = 0; $i < $paramsCount; $i++) {
                    $paramKey = $paramKeys[$i];
                    $paramValue = $params[$paramKey];
                    $paramType = \PDO::PARAM_STR;
                    if (is_int($paramValue))
                        $paramType = \PDO::PARAM_INT;
                    else if (is_bool($paramValue))
                        $paramType = \PDO::PARAM_BOOL;
                    else if (is_null($paramValue))
                        $paramType = \PDO::PARAM_NULL;
                    $stmt->bindValue(':'.$paramKey, $paramValue, $paramType);
                }
            }
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            if ($closeCursor) {
                $stmt->closeCursor(); // TODO maybe do something to optimize DB access time
            }
            return $result;
        }


    }

}