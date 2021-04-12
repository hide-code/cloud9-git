<?php
/**
* 特殊文字をHTMLエンティティに変換する
* @param str  $str 変換前文字
* @return str 変換後文字
*/
function entity_str($str) {
 
  return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}
 
/**
* 特殊文字をHTMLエンティティに変換する(2次元配列の値)
* @param array  $assoc_array 変換前配列
* @return array 変換後配列
*/
function entity_assoc_array($assoc_array) {
 
  foreach ($assoc_array as $key => $value) {
    foreach ($value as $keys => $values) {
      // 特殊文字をHTMLエンティティに変換
      $assoc_array[$key][$keys] = entity_str($values);
    }
  }
 
  return $assoc_array;
}
 
/**
* DBハンドルを取得
* @return obj $dbh DBハンドル
*/
function get_db_connect() {
 
  try {
    // データベースに接続
    $dbh = new PDO(DSN, DB_USER, DB_PASSWD, array(PDO::MYSQL_ATTR_INIT_COMMAND => DB_CHARSET));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  } catch (PDOException $e) {
    throw $e;
  }
 
  return $dbh;
}
 
/**
* クエリを実行しその結果を配列で取得する
*
* @param obj  $dbh DBハンドル
* @param str  $sql SQL文
* @return array 結果配列データ
*/
function get_as_array($dbh, $sql) {
 
  try {
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
  } catch (PDOException $e) {
    throw $e;
  }
 
  return $rows;
}
 
/**
* 商品の一覧を取得する
*
* @param obj $dbh DBハンドル
* @return array 商品一覧配列データ
*/
function get_goods_table_list($dbh) {
 
  // SQL生成
  $sql = 'SELECT name, price FROM test_products';
  // クエリ実行
  return get_as_array($dbh, $sql);
}
function get_post($key){
    
    $value='';
     
    if (isset($_POST[$key]) === TRUE) {
        $value = $_POST[$key];
    
    }
    return $value;
}
function check_name($str){
    
    global $error;
    
    if(mb_strlen($str)>20){
        $error[] = '２０文字以内にしてください';
    } else if($str === '') {
        $error[] = '名前を入力してください';
    }
}
function check_comment($str){
    
    global $error;
    
    if(mb_strlen($str)>100){
        $error[] = '100文字以内にしてください';
    } else if($str === '') {
        $error[] = 'コメントを入力してください';
    }
}
function create($dbh,$name,$comment){
    
    global $error;
    
    try{
    
        // SQL文を作成
        $sql = 'INSERT INTO post (user_name, user_comment,create_datetime) VALUES(?, ?, NOW())';
        // SQL文を実行する準備
        $stmt = $dbh->prepare($sql);
        // SQL文のプレースホルダに値をバインド
        $stmt->bindValue(1, $name,    PDO::PARAM_STR);
        $stmt->bindValue(2, $comment, PDO::PARAM_STR);
        
        $stmt->execute();
    
    }catch (PDOException $e) {
        $error[]='接続できませんでした。理由：'.$e->getMessage();
    }
    
}
function get_db($dbh){
    // SQL文を作成
    $sql = 'select * from post';
    $data=get_as_array($dbh, $sql);
    return entity_assoc_array($data);
}
?>