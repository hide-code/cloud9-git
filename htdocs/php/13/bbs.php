<?php
$filename = './review.txt';
$name='';
$comment='';
$name_length=0;
$comment_length=0;
$error=array();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
  if (isset($_POST['name']) === TRUE) {
    $name = $_POST['name'];
    $name_length = mb_strlen($name);
  }
  if (isset($_POST['comment']) === TRUE) {
    $comment = $_POST['comment'];
    $comment_length = mb_strlen($comment);
  }
  
  if($name_length>20){
    $error[] = '２０文字以内にしてください';
  } else if($name_length === 0) {
    $error[] = '名前を入力してください';
  }
  
  if($comment_length>100){
    $error[] = '100文字以内にしてください';
  } else if($comment_length === 0) {
    $error[] = '文字を入力してください';
  }
  
  if (empty($error)) {//エラーがなかったら行を作成してファイルに書き込む
    
    $log = $name . ':' . $comment . "\t" . date('-Y-m-d H:i:s') . "\n";//追加する行を作成
    
    if (($fp = fopen($filename, 'a')) !== FALSE) {
      if (fwrite($fp, $log) === FALSE) {
      $error[]='書き込み失敗';
      }
    }    
  }
    
}
$data = array();
 
if (is_readable($filename) === TRUE) {
  if (($fp = fopen($filename, 'r')) !== FALSE) {
    while (($tmp = fgets($fp)) !== FALSE) {
      $data[] = htmlspecialchars($tmp, ENT_QUOTES, 'UTF-8');
    }
    fclose($fp);
  }
} else {
  $data[] = 'ファイルがありません';
}
var_dump($error);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ひとこと掲示板</title>
</head>
<body>
  <h1>ひとこと掲示板</h1>
  <ul>
 <?php 
 foreach ($error as $read) { ?>
  <li>
   <?php  print $read; ?>
  </li>
<?php } ?>
  </ul>

  <form method="post">
    <label>名前：<input type="text" name="name"></labbel>
    <label>ひとこと：<input type="text" name="comment"></label>
    <input type="submit" name="submit" value="送信">
  </form>
  <p>以下に<?php print $filename; ?>の中身を表示</p>
  
  <ul>
 <?php foreach ($data as $read) { ?>
   <li><?php  print $read; ?></li>
<?php } ?>
 </ul>

</body>
</html>