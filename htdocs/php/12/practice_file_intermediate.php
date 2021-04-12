<?php
$filename = './tokyo.csv';
 
$data = array();
 
if (is_readable($filename) === TRUE) {
  if (($fp = fopen($filename, 'r')) !== FALSE) {
    while (($tmp = fgetcsv($fp)) !== FALSE) {
  
      $data[] = $tmp;
    }
    fclose($fp);
  }
  var_dump($data);
  
} else {
  $data[] = 'ファイルがありません';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ファイル操作</title>
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
  <h1>ファイル操作</h1>
  <p>以下にファイルから読み込んだデータの中身を表示</p>
  <table>
      <tr>
          <th>郵便番号</th> 
          <th>都道府県</th> 
          <th>市区町村</th> 
          <th>町域</th> 
      </tr>

<?php foreach ($data as $read) { ?>
      <tr>
          <td><?php print htmlspecialchars($read[2], ENT_QUOTES); ?></td>
          <td><?php print htmlspecialchars($read[6], ENT_QUOTES); ?></td>
          <td><?php print htmlspecialchars($read[7], ENT_QUOTES); ?></td>
          <td><?php print htmlspecialchars($read[8], ENT_QUOTES); ?></td>
      </tr>
  
<?php } ?>
</table>
</body>
</html>