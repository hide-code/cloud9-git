<?php

$name='';
$comment='';
$name_length=0;
$comment_length=0;
$error=array();

$host     = 'localhost';
$username = 'codecamp39934';   // MySQLのユーザ名
$password = 'codecamp39934';       // MySQLのパスワード
$dbname = 'codecamp39934';   // MySQLのDB名(今回、MySQLのユーザ名を入力してください)
$charset  = 'utf8';   // データベースの文字コード
 
 // MySQL用のDSN文字列
$dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;
 

try {
      // データベースに接続
      $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
 
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
      
            $log=date('Y-m-d H:i:s') ;//時間を書き込むための変数作成
      
              if (empty($error)) {//エラーがなかったら行を作成してファイルに書き込む
              
              // SQL文を作成
                $sql = 'INSERT INTO post (user_name, user_comment,create_datetime) VALUES(?, ?, ?)';
              // SQL文を実行する準備
                $stmt = $dbh->prepare($sql);
                // SQL文のプレースホルダに値をバインド
                $stmt->bindValue(1, $name,    PDO::PARAM_STR);
                $stmt->bindValue(2, $comment, PDO::PARAM_STR);
                $stmt->bindValue(3, $log, PDO::PARAM_STR);
                
                $stmt->execute();
                      
              }
        }

    // SQL文を作成
    $sql = 'select * from post';
    //SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    //SQLを実行
    $stmt->execute();
        
    $data = $stmt->fetchAll();
    var_dump($data);

} catch (PDOException $e) {
      echo '接続できませんでした。理由：'.$e->getMessage();
}

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
  
  
  <ul>
 <?php foreach ($data as $read) { ?>
  <li><?php  print htmlspecialchars($read['user_name'] . ':' . $read['user_comment'] . ' ' . $read['create_datetime'], ENT_QUOTES, 'UTF-8'); ?></li>
<?php } ?>
 </ul>

</body>
</html>