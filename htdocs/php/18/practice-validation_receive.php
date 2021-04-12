<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>バリデーション演習</title>
  </head>
  <body>
    <?php
  
    // ユーザIDをチェック
    $userid = $_POST['userid'];
 
    // 正規表現
    $userid_regex = '/[a-zA-Z0-9]{6,8}/';
 
    // バリデーション実行
    if( preg_match($userid_regex, $userid) ) {
      print($userid."は正しいユーザIDです。<br>");
    }else{
      print($userid."は正しくないユーザIDです。<br>");
    }
    // 年齢をチェック
    $age = $_POST['age'];
 
    // 正規表現
    $age_regex = '/[0-9].+?/';
 
    // バリデーション実行
    if( preg_match($age_regex, $age) ) {
      print($age."は年齢です。<br>");
    }else{
      print($age."は年齢です。<br>");
    }
    // メールアドレスをチェック
    $email = $_POST['email'];
 
    // 正規表現
    $email_regex = '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/iD';
 
    // バリデーション実行
    if( preg_match($email_regex, $email) ) {
      print($email."は正しいメールアドレスです。<br>");
    }else{
      print($email."は正しくないメールアドレスです。<br>");
    }
 
    // 電話番号をチェック
    $tel = $_POST['tel'];
 
    // 正規表現
    $tel_regex = '/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}/';
 
    // バリデーション実行
    if( preg_match($tel_regex, $tel) ) {
      print($tel."は正しい電話番号です。<br>");
    }else{
      print($tel."は正しくない電話番号です。<br>");
    }
    ?>
  </body>
</html>