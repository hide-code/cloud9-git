<?php
 $my_name = '';
 $mail = '';
 $gender = '';
// 送信ボタンがクリックされた場合の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  if (isset($_POST['my_name']) === TRUE) {
     $my_name = htmlspecialchars($_POST['my_name'], ENT_QUOTES, 'UTF-8');
  }
  if (isset($_POST['gender']) === TRUE) {
     $gender = htmlspecialchars($_POST['gender'], ENT_QUOTES, 'UTF-8');
  }
  if (isset($_POST['mail']) === TRUE) {
     $mail = htmlspecialchars($_POST['mail'], ENT_QUOTES, 'UTF-8');
  }
}
 
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>課題</title>
</head>
<body>
  <?php if($my_name !== ''){ ?>
  <p><?php print'ここに入力したお名前を表示：'.$my_name; ?></p>
  <?php } ?>
  <?php if($gender !== ''){ ?>
  <p><?php print'ここに選択した性別を表示：'.$gender; ?></p>
  <?php } ?>
  <?php if($mail !== ''){ ?>
  <p><?php print'ここにメールを受け取るかを表示：'.$mail; ?></p>
  <?php } ?>
   
  <h1>課題</h1>
  <form method="post">
      <p>お名前: <input id="my_name" type="text" name="my_name" value="<?php if($my_name!==''){print $my_name;} ?>"></p>
      
      
      <p>性別: <input type="radio" name="gender" value="man" <?php if($gender==='男'){print 'checked';} ?>>男
      <p>性別: <input type="radio" name="gender" value="women" <?php if($gender==='女'){print 'checked';} ?>>女
      
      <p><input type="checkbox" name="mail" value="OK" <?php if($mail!==''){print 'checked';} ?>>お知らせメールを受け取る</p>
      <input type="submit" name="submit" value="送信">
  </form>
</body>
</html>