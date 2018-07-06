<?php

define('DB_DATABASE', 'dotinstall_db');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'g6fd7Xx');
define('PDO_DSN', 'mysql:host=localhost;dbname=' . DB_DATABASE);

class User {
    public function show(){
        echo "$this->name $this->score:";
    }
}

try {
    // connect
    $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->beginTransaction();
    $db->exec("update users set score = score -10 where name = 'taguchi' ");
    $db->exec("update users set score = score +10 where name = 'fkoji' ");
    $db->commit();

} catch (PDOException $e) {
    $db->rollback();
    echo $e->getMessage();
  exit;
}
