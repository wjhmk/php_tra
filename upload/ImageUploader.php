<?php

namespace MyApp;

class ImageUploader {

  private $_imageFileName;
  private $_imageType;

  public function upload() {
    try {
        $this -> _validateUpload(); #エラーチェック
        $ext = $this -> _validateImageType(); #画像の拡張子判別
        $savePath = $this ->_save($ext); #保存。$extは拡張子
        $this -> _createThumbnail($savePath); #サムネイル作成
        $_SESSION['success'] = 'uoload DONE!'; #成功したら$_SESSION['success']にメッセージを代入

    } catch (\Exception $e) {
      $_SESSION['error'] =  $e->getMessage();
    }
    header('Location: http://' . $_SERVER['HTTP_HOST']. '/upload/index.php'); #画像を投稿した後に index.php を再読み込みしてしまうと二重投稿になってしまうので、それを防ぐために終わったら index.php にリダイレクト
    exit;
  }

  public function getResults(){
      $success = null;
      $error = null;
      if(isset($_SESSION['success'])){
          $success =  $_SESSION['success'];
          unset($_SESSION['success']);  #メッセージの存在意義がなくなるので、消す.何度もリロードした時に同じメッセージが出てきてしまうので必ず消す。
      }
      if(isset($_SESSION['error'])){
          $error =  $_SESSION['error'];
          unset($_SESSION['error']);  #メッセージの存在意義がなくなるので、消す.何度もリロードした時に同じメッセージが出てきてしまうので必ず消す。
      }
      return [$success,$error]; #配列で返す
  }

   public function getImages() {
    $images = [];
    $files = [];
    $imageDir = opendir(IMAGES_DIR);
    while (false !== ($file = readdir($imageDir))) {
      if ($file === '.' || $file === '..') {#readdir関数が返す値には「.」と「..」が含まれる。なので、スキップ。
        continue;
      }
      $files[] = $file;#$fileには1528171451_f6e5d14b8fb01379479d151018356d484adbfc76.pngのような値が入っている
      if (file_exists(THUMBNAIL_DIR . '/' . $file)) {#サムネイルが作成されていれば（ファイルが大きいと作成される）$imagesにサムネイルを格納。
                                                                                 #(uploadメソッドが終わった後にgetImagesメソッドが呼ばれる）
        $images[] = basename(THUMBNAIL_DIR) . '/' . $file;
      } else {
        $images[] = basename(IMAGES_DIR) . '/' . $file;
      }
    }
    array_multisort($files, SORT_DESC, $images);#$imagesを$files 順に降順で をソートする
    return $images;
  }

  private function _createThumbnail($savePath) {
    $imageSize = getimagesize($savePath);
    $width = $imageSize[0];
    $height = $imageSize[1];
    if ($width > THUMBNAIL_WIDTH) {
      $this->_createThumbnailMain($savePath, $width, $height);
    }
  }

  private function _createThumbnailMain($savePath, $width, $height) {
    switch($this->_imageType) {
      case IMAGETYPE_GIF:
        $srcImage = imagecreatefromgif($savePath);
        break;
      case IMAGETYPE_JPEG:
        $srcImage = imagecreatefromjpeg($savePath);
        break;
      case IMAGETYPE_PNG:
        $srcImage = imagecreatefrompng($savePath);
        break;
    }
    $thumbHeight = round($height * THUMBNAIL_WIDTH / $width);
    $thumbImage = imagecreatetruecolor(THUMBNAIL_WIDTH, $thumbHeight);
    imagecopyresampled($thumbImage, $srcImage, 0, 0, 0, 0, THUMBNAIL_WIDTH, $thumbHeight, $width, $height);

    switch($this->_imageType) {
      case IMAGETYPE_GIF:
        imagegif($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
        break;
      case IMAGETYPE_JPEG:
        imagejpeg($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
        break;
      case IMAGETYPE_PNG:
        imagepng($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
        break;
    }

  }

  private function _save($ext) {
    $this->_imageFileName = sprintf(
      '%s_%s.%s',
      time(),
      sha1(uniqid(mt_rand(), true)),
      $ext
    );
    $savePath = IMAGES_DIR . '/' . $this->_imageFileName;
    $res = move_uploaded_file($_FILES['image']['tmp_name'], $savePath);
    if ($res === false) {
      throw new \Exception('Could not upload!');
    }
    return $savePath;
  }

  private function _validateImageType() {
    $this->_imageType = exif_imagetype($_FILES['image']['tmp_name']);
    switch($this->_imageType) {
      case IMAGETYPE_GIF:
        return 'gif';
      case IMAGETYPE_JPEG:
        return 'jpg';
      case IMAGETYPE_PNG:
        return 'png';
      default:
        throw new \Exception('PNG/JPEG/GIF only!');
    }
  }

  private function _validateUpload() {
    // var_dump($_FILES);
    // exit;

    if (!isset($_FILES['image']) || !isset($_FILES['image']['error'])) {
      throw new \Exception('Upload Error!');
    }

    switch($_FILES['image']['error']) {
      case UPLOAD_ERR_OK:
        return true;
      case UPLOAD_ERR_INI_SIZE:
      case UPLOAD_ERR_FORM_SIZE:
        throw new \Exception('File too large!');
      default:
        throw new \Exception('Err: ' . $_FILES['image']['error']);
    }

  }
}
