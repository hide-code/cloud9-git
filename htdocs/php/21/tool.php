<?php
$host     = 'localhost';
$username = 'codecamp39934';        // MySQLのユーザ名（マイページのアカウント情報を参照）
$password = 'codecamp39934';       // MySQLのパスワード（マイページのアカウント情報を参照）
$dbname   = 'codecamp39934';   // MySQLのDB名(このコースではMySQLのユーザ名と同じです）
$charset  = 'utf8';   // データベースの文字コード
 
// MySQL用のDSN文字列
$dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;
 
$img_dir    = './img/';    // アップロードした画像ファイルの保存ディレクトリ
$data       = array();
$err_msg    = array();     // エラーメッセージ
$new_img_filename = '';   // アップロードした新しい画像ファイル名
$pattern = '/^[0-9]+$/';//数字のみ
$message='';//システムが正しく動いたことを伝える

if (isset($_POST['new']) === TRUE) {
  
  $name = '';
  if (isset($_POST['name']) === TRUE) {
      $name = trim($_POST['name']);//trimは先頭と末尾の空白を取り除く
  }
  if ($name === '') {
      $err_msg[]='商品名を入力してください'; 
  }
  
  $price = '';
  if (isset($_POST['price']) === TRUE) {
      $price = $_POST['price'];
  }
  if($price===''){
      $err_msg[]='値段を入力してください'; 
  }else if(preg_match($pattern,$price)!==1){
    $err_msg[]='値段が不適です';
  }
  
  $quantity = '';
  if (isset($_POST['quantity']) === TRUE) {
      $quantity = $_POST['quantity'];
  }
  if($quantity===''){
      $err_msg[]='個数を入力してください'; 
  }else if(preg_match($pattern,$quantity)!==1){
    $err_msg[]='個数が不適です';
  }
  
  $status='';
  if (isset($_POST['release']) === TRUE) {
      $status = $_POST['release'];
  }
  if($status !== '0' && $status !== '1'){//postで送られるものは、文字列
    $err_msg[]='ステータスが不適です';
  }

  // HTTP POST でファイルがアップロードされたかどうかチェック
  if (is_uploaded_file($_FILES['file']['tmp_name']) === TRUE) {//引数がfileだから変える
    // 画像の拡張子を取得
    $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);//引数がfileだから変える
    // 指定の拡張子であるかどうかチェック
    if ($extension === 'jpg' || $extension === 'jpeg' || $extension === 'png') {
      // 保存する新しいファイル名の生成（ユニークな値を設定する）
      $new_img_filename = sha1(uniqid(mt_rand(), true)). '.' . $extension;
      // 同名ファイルが存在するかどうかチェック
      if (is_file($img_dir . $new_img_filename) !== TRUE) {
        // アップロードされたファイルを指定ディレクトリに移動して保存
        if (move_uploaded_file($_FILES['file']['tmp_name'], $img_dir . $new_img_filename) !== TRUE) {
            $err_msg[] = 'ファイルアップロードに失敗しました';
        }
      } else {
        $err_msg[] = 'ファイルアップロードに失敗しました。再度お試しください。';
      }
    } else {
      $err_msg[] = 'ファイル形式が異なります。画像ファイルはJPEGまたはPNGのみ利用可能です。';
    }
  } else {
    $err_msg[] = 'ファイルを選択してください';
  }
}else if(isset($_POST['update']) === TRUE){
  
  $stock= '';
  if (isset($_POST['stock']) === TRUE) {
      $stock = $_POST['stock'];
  }
  if($stock === ''){
      $err_msg[]='在庫数を入力してください'; 
  }else if(preg_match($pattern,$stock)!==1){
    $err_msg[]='在庫数が正常でない';
  }
  
  $drink_id= '';
  if (isset($_POST['drink_id']) === TRUE) {
      $drink_id = $_POST['drink_id'];
  }
  
}else if(isset($_POST['status_update']) === TRUE){
  
  $status='';
  if (isset($_POST['status']) === TRUE) {
      $status = $_POST['status'];
  }
  if($status !== '0' && $status !== '1'){
    $err_msg[]='ステータスが不適です';
  }
  
  $drink_id= '';
  if (isset($_POST['drink_id']) === TRUE) {
      $drink_id = $_POST['drink_id'];
  }
  
}
 
// アップロードした新しい画像ファイル名の登録、既存の画像ファイル名の取得
try {
  // データベースに接続
  $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  
  


    // エラーがなければ、アップロードした新しい画像ファイル名�����保存
    if (count($err_msg) === 0 && isset($_POST['new']) === TRUE) {
      try {
        $dbh->beginTransaction();
        // SQL文を作成
        $sql = 'INSERT INTO drink_master(drink_name,price,img,create_datetime,status) VALUES(?,?,?,NOW(),?)';
        // SQL文を実行する準備
        $stmt = $dbh->prepare($sql);
        // SQL文のプレースホルダに値をバインド
        $stmt->bindValue(1, $name,PDO::PARAM_STR);
        $stmt->bindValue(2, $price,PDO::PARAM_INT);
        $stmt->bindValue(3, $new_img_filename, PDO::PARAM_STR);
        $stmt->bindValue(4, $status, PDO::PARAM_STR);
        //var_dump($sql,$name,$price,$new_img_filename,$status);
         // SQLを実行
        $stmt->execute();
        
        $drink_id = $dbh->lastInsertId();
        // SQL文を作成
        $sql = 'insert into drink_stock(drink_id, stock, create_datetime) values(?, ?, NOW());';
        // SQL文を実行する準備
        $stmt = $dbh->prepare($sql);
        
        $stmt->bindValue(1, $drink_id,PDO::PARAM_INT);
        $stmt->bindValue(2, $quantity,PDO::PARAM_INT);
        // SQLを実行
        $stmt->execute();
        $dbh->commit();
        $message='登録完了';
      } catch (PDOException $e) {
        $dbh->rollback();
        throw $e;
      }
    
  }else if(count($err_msg) === 0 && isset($_POST['update']) === TRUE ){
    
    $sql = 'UPDATE drink_stock SET stock=?,update_datetime = NOW() WHERE drink_id = ?';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    
    $stmt->bindValue(1, $stock,PDO::PARAM_INT);
    $stmt->bindValue(2, $drink_id,PDO::PARAM_INT);
    // SQLを実行
    $stmt->execute();
    $message='在庫変更完了';
    
  }else if(count($err_msg) === 0 && isset($_POST['status_update']) === TRUE){
    
    $sql = 'UPDATE drink_master SET status=?,update_datetime = NOW() WHERE drink_id = ?';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    
    $stmt->bindValue(1, $status,PDO::PARAM_INT);
    $stmt->bindValue(2, $drink_id,PDO::PARAM_INT);
    
    // SQLを実行
    $stmt->execute();
    $message='ステータス変更完了';
  }
  
  $sql = 'SELECT drink_name, price, img, drink_master.drink_id , stock, status
    FROM drink_master
    INNER JOIN drink_stock ON drink_master.drink_id = drink_stock.drink_id';
    
    $stmt = $dbh->prepare($sql);
    
    // SQLを実行
    $stmt->execute();
    $data=$stmt->fetchAll();
    
  
} catch (PDOException $e) {
  // 接続失敗した場合
  $err_msg[] = 'DBエラー：'.$e->getMessage();
}
      
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>自動販売機管理ツール</title>
  <style>
      table{
          border:1px solid;
          border-collapse:collapse;
      }
      th,td{
          border:1px solid;
      } 
  </style>
</head>
<body>
 <?php foreach ($err_msg as $read) { ?>
 <p><?php print $read; ?></p>
 <?php } ?>
 <?php if($message !== ''){ ?>
 <p><?php print $message; ?></p>
 <?php } ?>
 

  <h1>自動販売機管理ツール</h1>
  <section>
          <h2>新規商品追加</h2>
        
          <form method="post" enctype="multipart/form-data">
            <label>名前：<input type="text" name="name"></labbel>
            <label>値段：<input type="text" name="price"></label>
            <label>個数：<input type="text" name="quantity"></label>
            <input type="file" name="file">
            <select name=release>
                <option value="0">非公開</option>
                <option value="1">公開</option>
            </select>
            <input type="submit" name="new" value="商品を追加">
          </form>
  </section>
  
  <p>商品情報変更</p>
  <table>
      <tr>
          <th>商品画像</th> 
          <th>商品名</th> 
          <th>価格</th> 
          <th>在個数</th> 
          <th>ステータス</th>
      </tr>

<?php foreach ($data as $read) { ?>
      <tr>
          <td><img src="./img/<?php print htmlspecialchars($read['img'], ENT_QUOTES); ?>"></td>
          <td><?php print htmlspecialchars($read['drink_name'], ENT_QUOTES); ?></td>
          <td><?php print htmlspecialchars($read['price'], ENT_QUOTES); ?></td>
          <td>
            <form method="post">
            <input type="text" name="stock" value="<?php print htmlspecialchars($read['stock'], ENT_QUOTES); ?>">
            <input type="hidden" name="drink_id" value="<?php print htmlspecialchars($read['drink_id'], ENT_QUOTES); ?>">
            <input type="submit" name="update" value="変更">
            </form>
          </td>
          <td>
            <form method="post">
              
            <?php if((int)$read['status']===0){ ?>  
            <input type="submit" name='status_update' value="非公開->公開">
            <input type="hidden" name="status" value="1">
            <?php }else{ ?>
            <input type="submit" name='status_update' value="公開->非公開">
            <input type="hidden" name="status" value="0">
            <?php } ?>
            
            <input type="hidden" name="drink_id" value="<?php print htmlspecialchars($read['drink_id'], ENT_QUOTES); ?>">
            </form>
          </td>
      </tr>
  
<?php } ?>
  </table>
  

</body>
</html>