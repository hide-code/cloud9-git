<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>challenge-foreach</title>
</head>
<body>
    <?php
     $class = array('ガリ勉' => '鈴木', '委員長' => '佐藤', 'セレブ' => '斎藤', 'メガネ' => '伊藤', '女神' => '杉内');
     foreach($class as $nickname => $lastname){
         print '<p>'.$lastname.'さんのあだ名は'.$nickname.'です。</p>';
     }
     
     ?>
</body>
</html>