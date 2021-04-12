<?php
// 設定ファイル読み込み
require_once './conf/setting.php';
// 関数ファイル読み込み
require_once './model/model.php';

 $error=[];
 $dbh=get_db_connect();
 
if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $name=get_post('name');
    $comment=get_post('comment');
    
    check_name($name);
    check_comment($comment);

    if (empty($error)) {//エラーがなかったら行を作成してファイルに書き込む
      
      create($dbh,$name,$comment);
      
      }
}

    $data=get_db($dbh);

// 商品一覧テンプレートファイル読み込み
include_once './view/view.php';
 
?>