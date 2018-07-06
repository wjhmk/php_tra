<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>PHP_form</title>
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
  <div class="header">
    <div class="header-left">PHP_form</div>
    <div class="header-right">
      <ul>
        <li>概要</li>
        <li>About</li>
        <li class="selected">お問い合わせ</li>
      </ul>
    </div>
  </div>

  <div class="main">
    <div class="thanks-message">お問い合わせいただきありがとうございます。</div>
    <div class="display-contact">
      <div class="form-title">入力内容</div>

      <div class="form-item">■ 名前</div>
      <?php echo $_POST['name'] ?>

      <div class="form-item">■ 年齢</div>
      <?php echo $_POST['age'] ?>

      <div class="form-item">■ お問い合わせの種類</div>

      <?php echo $_POST['category'] ?>

      <div class="form-item">■ 内容</div>
      <?php echo $_POST['body'] ?>
    </div>
  </div>

<div class="footer">
    <div class="footer-left">
      <ul>
        <li>概要</li>
        <li>採用</li>
        <li>お問い合わせ</li>
      </ul>
    </div>

  </div>
</body>
</html>
