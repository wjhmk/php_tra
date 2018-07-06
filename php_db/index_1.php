<?php

define('DB_DATABASE', 'dotinstall_db');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'g6fd7Xx');
define('PDO_DSN', 'mysql:host=localhost;dbname=' . DB_DATABASE);

try {
    // connect
    $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


      /*
      (1) exec(): 結果を返さない、安全なSQL
      $db->exec("insert into users (name, score) values ('taguchi', 55)");
      echo "user added!";

      (2) query(): 結果を返す、安全、何回も実行されないSQL

      (3) prepare(): 結果を返す、安全対策が必要、複数回実行されるSQL
      */
    // $stmt = $db->prepare("insert into users (name, score) values (?, ?)"); #結果を返す
    // $stmt->execute(['taguchi', 44]);#executeの引数に配列を渡すと、values (?, ?)に値が代入される

    $stmt = $db->prepare("insert into users (name, score) values (:name, :score)"); #名前付きパラメーター
    $stmt->execute([':name' => 'taguchi', ':score'=> '555']);#配列を、key と value の形で渡す

    echo "inserted: " . $db->lastInsertId();
    // dbと接続削除
    $db = null;

} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
}
