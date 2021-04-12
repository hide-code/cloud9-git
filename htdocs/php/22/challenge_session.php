<?php
// セッション開始
session_start();

    if(isset($_POST['delete'])){
      // Cookieを削除する
        // セッション名取得 ※デフォルトはPHPSESSID
        $session_name = session_name();
        // セッション変数を全て削除
        $_SESSION = array();
        // ユーザのCookieに保存されているセッションIDを削除
        if (isset($_COOKIE[$session_name])) {
          // sessionに関連する設定を取得
          $params = session_get_cookie_params();
         
          // sessionに利用しているクッキーの有効期限を過去に設定することで無効化
          setcookie($session_name, '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
          );
        }
        // セッションIDを無効化
        session_destroy();
        
        
    }else{
        
        $now_date = date('Y-M-d h:i:s');
        // cookieが設定されていなければ(初回アクセス)、cookieを設定する
        if (! isset($_SESSION['visit_count']) ) {
          // cookieを設定
          $_SESSION['visit_count'] = 1; 
          $_SESSION['visit_history'] = $now_date;
          
          print("初めてのアクセスです<br>");
          print($now_date."(現在日時)");
          }
        // cookieがすでに設定されていれば(2回目以降のアクセス)、cookieで設定した数値を加算する
        else {
          $count = $_SESSION['visit_count'] + 1;
          $last_date = $_SESSION['visit_history'];
          
          $_SESSION['visit_count'] = $count; 
          $_SESSION['visit_history'] = $now_date;
          print("合計".$count."回目のアクセスです<br>");
          print($now_date."(現在日時)");
          print($last_date."(前回のアクセス日時)");
          
        }
    }
    
    ?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>Challenge_Cookie</title>
  </head>
  <body>
    <form method="post">
      <input type="submit" name="delete" value="履歴削除">
    </form>
  </body>
</html>