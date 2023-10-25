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

        public function query($sql, $params = [])
        {
            $stmt = $this->db->prepare($sql);
            $paramKeys = array_keys($params);
            $paramsCount = count($params);
            if ($params && $paramsCount > 0) {
                for ($i = 0; $i < $paramsCount; $i++) {
                    $param = $paramKeys[$i];
                    $stmt->bindParam(':'.$param, $params[$param]);
                }
            }
            $stmt->execute($params);
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result;
        }


    }

}