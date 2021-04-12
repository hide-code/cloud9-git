<?php
    if(isset($_POST['delete'])){
      // Cookieを削除する
          setcookie('visit_count', '', time() - 3600);
          setcookie('visit_history' , '', time() - 3600);
                
    }else{
    
        $now_date = date('Y-M-d h:i:s');
        // cookieが設定されていなければ(初回アクセス)、cookieを設定する
        if ( !isset($_COOKIE['visit_count']) ) {
          // cookieを設定
          setcookie('visit_count', 1);
          setcookie('visit_history',$now_date);
          print("初めてのアクセスです<br>");
          print($now_date."(現在日時)");
          }
        // cookieがすでに設定されていれば(2回目以降のアクセス)、cookieで設定した数値を加算する
        else {
          $count = $_COOKIE['visit_count'] + 1;
          $last_date = $_COOKIE['visit_history'];
          
          setcookie('visit_count', $count);
          setcookie('visit_history',$now_date);
          
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