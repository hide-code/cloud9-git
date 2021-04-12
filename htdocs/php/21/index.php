<?php
$host     = 'localhost';
$username = 'codecamp39934';        // MySQLのユーザ名（マイページのアカウント情報を参照）
$password = 'codecamp39934';       // MySQLのパスワード（マイページのアカウント情報を参照）
$dbname   = 'codecamp39934';   // MySQLのDB名(このコースではMySQLのユーザ名と同じです）
$charset  = 'utf8';   // データベースの文字コード
 
// MySQL用のDSN文字列
$dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;
$err_msg = array();

try {
  // データベースに接続
  $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  
  $sql='SELECT img, drink_name, price, drink_master.drink_id, stock
        FROM drink_master INNER JOIN drink_stock
        ON drink_master.drink_id = drink_stock.drink_id
        WHERE status=1';
  
  $stmt = $dbh->prepare($sql);
    
  // SQLを実行
  $stmt->execute();
  $data=$stmt->fetchAll();//配列に入れる
  
} catch (PDOException $e) {
  $err_msg[] = '接続できませんでした。理由：'.$e->getMessage();
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
  <h1>自動販売機</h1> 
  <?php foreach ($err_msg as $read) { ?>
  <p><?php print $read ?></p>
  <?php } ?>
  
<form method="post" action="result.php">
      <label>金額<input type="text" name="your_price"></labbel>
    
      <?php foreach ($data as $read) { ?>
        <section>
            <div><img src="./img/<?php print htmlspecialchars($read['img'], ENT_QUOTES); ?>"></div>
            <div><?php print htmlspecialchars($read['drink_name'], ENT_QUOTES); ?></div>
            <div><?php print htmlspecialchars($read['price'], ENT_QUOTES); ?></div>
            
            <?php if((int)$read['stock'] === 0){ ?>
            <div><?php print '売り切れ'?></div>
            <?php }else{ ?>
            <input type="radio" name="select" value="<?php print htmlspecialchars($read['drink_id'], ENT_QUOTES); ?>">
            <?php } ?>
            
        </section> 
     <?php } ?>
    <input type="submit" name="buy" value="■□■□購入■□■□">
    
</form>
</body>
</html>
