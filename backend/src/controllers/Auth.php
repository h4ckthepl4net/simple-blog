<?php
namespace {
    include './database_connection.php';
}

namespace ReactBlog\Backend\controllers {

    class Auth
    {
        public function login()
        {
            global $db;
            $db->query("
                SELECT * FROM users WHERE username = 'admin'
            ");
        }

        public function register()
        {
            global $db;
            $db->query("
                INSERT INTO users (username, password) VALUES ('admin', 'admin')
            ");
        }

    }

}