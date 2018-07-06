<?php

namespace MyApp;

class Todo {
  private $_db;

  public function __construct() {
    try {
      $this->_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
      $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
      echo $e->getMessage();
      exit;
    }

  }

  private function _createToken(){
      if(!isset($_SESSION['token'])){
          // tokenを生成して代入
          $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
      }
  }

  public function getAll() {
    $stmt = $this->_db->query("select * from todos order by id desc");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function post() {
     $this ->_validateToken();

     if(!isset($_POST['mode'])){
         throw new \Exception("mode not set!");
     }
     switch ($_POST['mode']) {
         case 'update':
           return $this->_update();
        case 'create':
           return $this->_create();
        case '_delete':
           return $this->_delete();
     }
  }

   private  function _validateToken() {
      // tokenが生成されていない、tokenが送信されていない、それらの値が等しくない時に例外発生
      if(!isset($_SESSION['token']) ||!isset($_POST['token']) ||$_SESSION['token'] !== $_POST['token']){
          throw new \Exception("invalide token!");
      }
  }


    private function _update() {
        if(!isset($_POST['id'])){
            throw new \Exception("[updata] id not set!");
        }
        // トランザクション開始
        $this->_db->beginTransaction();
        // stateが1なら0に、0なら1に変更する
        $sql = sprintf("update todos set state = (state + 1) %%2 where id = %d",$_POST['id']);
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();
        // 更新されたstateを返す
        $sql = sprintf("select state from todos where id = %d", $_POST["id"]);
        $stmt = $this->_db->query($sql);
        $state = $stmt->fetchColumn();
        // トランザクション終了
        $this ->_db->commit();

        // 結果を配列で返していく
        return [
            'state' => $state
        ];

    }

    private function _create() {

    }

    private function _delete() {

    }

}
