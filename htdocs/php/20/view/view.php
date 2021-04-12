<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ひとこと掲示板</title>
</head>
<body>
  <h1>ひとこと掲示板</h1>
  <ul>
 <?php 
 foreach ($error as $read) { ?>
  <li>
   <?php  print $read; ?>
  </li>
<?php } ?>
  </ul>

  <form method="post">
    <label>名前：<input type="text" name="name"></labbel>
    <label>ひとこと：<input type="text" name="comment"></label>
    <input type="submit" name="submit" value="送信">
  </form>
  
  
  <ul>
 <?php foreach ($data as $read) { ?>
  <li><?php  print htmlspecialchars($read['user_name'] . ':' . $read['user_comment'] . ' ' . $read['create_datetime'], ENT_QUOTES, 'UTF-8'); ?></li>
<?php } ?>
 </ul>

</body>
</html>