<?php
$host     = 'localhost';
$username = 'codecamp39934';        // MySQLのユーザ名（マイページのアカウント情報を参照）
$password = 'codecamp39934';       // MySQLのパスワード（マイページのアカウント情報を参照）
$dbname   = 'codecamp39934';   // MySQLのDB名(このコースではMySQLのユーザ名と同じです）
$charset  = 'utf8';   // データベースの文字コード
 
// MySQL用のDSN文字列
$dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;
$err_msg =array();
$pattern = '/^[0-9]+$/';//数字のみ

if (isset($_POST['buy']) === TRUE){
  
    $your_price = '';
    if (isset($_POST['your_price']) === TRUE) {
        $your_price = ($_POST['your_price']);
    }
    if ($your_price === '') {
        $err_msg[]='金額を入力してください'; 
    }else if(preg_match($pattern,$your_price) !== 1){
        $err_msg[]='金額が不適です';
    }
    
    $drink_id= '';
    if (isset($_POST['select']) === TRUE) {
    $drink_id = $_POST['select'];
    }
    if($drink_id ===''){
      $err_msg[] ='商品を選択してください';
    }
    
    if(count($err_msg ) === 0){
        try {
          // データベースに接続
          $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
          $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
          
          $sql='SELECT img, drink_name, price, drink_master.drink_id, stock ,status
                FROM drink_master INNER JOIN drink_stock
                ON drink_master.drink_id = drink_stock.drink_id
                WHERE drink_master.drink_id= ?';
                
          $stmt = $dbh->prepare($sql);
          $stmt ->bindValue(1, $drink_id,PDO::PARAM_INT);
          // SQLを実行
          $stmt->execute();
          $read=$stmt->fetch();//1レコードを取り出す
          
          if($read === false){
              $err_msg[]='商品情報取得できませんでした';
          }else{
              if($read['stock'] <= 0){
                $err_msg[]='在庫がありませんでした';  
              }
              if((int)$read['status'] === 0){
                $err_msg[]='公開されていません';   
              }
              if($read['price'] > $your_price){
                 $err_msg[]= 'お金が足りません';
              }
          }
          
          if(count($err_msg) === 0){
              
              //トランザクション開始
              $dbh->beginTransaction();
              try{
                  
                  
                  $sql ='UPDATE drink_stock SET stock=stock-1 ,update_datetime = NOW() WHERE drink_id= ?';  
                  $stmt = $dbh->prepare($sql);
                  $stmt->bindValue(1, $drink_id,PDO::PARAM_INT);
                  $stmt->execute();
                  
                  $sql ='INSERT INTO drink_history (drink_id,create_datetime) VALUES (?,NOW())';
                  $stmt = $dbh->prepare($sql);
                  $stmt->bindValue(1, $drink_id,PDO::PARAM_INT);
                  $stmt->execute();
                  
                  $dbh->commit();
                  echo 'データ登録ができました';
                  
              }catch(PDOException $e){
                //ロールバック処理
                $dbh->rollback();
                //例外をスロー
                throw $e;
              }
          }
                
        } catch (PDOException $e) {
          echo '接続できませんでした。理由：'.$e->getMessage();
        }
    }
    
}

?>
 
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>自動販売機管理ツール</title>
  <style>
      
  </style>
</head>
<body>
  <h1>自動販売機結果</h1> 
  
<?php foreach ($err_msg as $read) { ?>
 <p><?php print $read; ?></p>
 <?php } ?>
 
 <?php if(count( $err_msg) === 0){ ?>
      <div><img src="./img/<?php print htmlspecialchars($read['img'], ENT_QUOTES); ?>"></div>
      <p><?php print 'がしゃん!【'.htmlspecialchars($read['drink_name'], ENT_QUOTES) .'】が買えました!'; ?></p>
      <p><?php print 'おつりは【' .htmlspecialchars( $your_price-(int)$read['price'], ENT_QUOTES). '円】です!'; ?></p>
  <?php } ?>
  
 <a href="index.php">戻る</a>   
          
</form>
</body>
</html>
