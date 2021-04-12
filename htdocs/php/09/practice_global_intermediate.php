<?php
 $me='';
 $you = '';
 $result='';
// 送信ボタンがクリックされた場合の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['janken']) === TRUE) {
     $me = htmlspecialchars($_POST['janken'], ENT_QUOTES, 'UTF-8');
     
     $index=mt_rand(0,2);
     $class=array('グー','チョキ','パー');
     $you=$class[$index];
     
     if(($me==='グー'&&$you==='チョキ')||($me==='チョキ'&&$you==='パー')||($me==='パー'&&$you==='グー')){
         $result='win';
     }else if(($me==='グー'&&$you==='パー')||($me==='チョキ'&&$you==='グー')||($me==='パー'&&$you==='チョキ')){
         $result='lose';
     }else{
         $result='draw';
     }
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>課題</title>
</head>
<body></body>
  <h1>ジャンケン勝負</h1>
  
   <?php if($me!== ''){ ?>
  <p><?php print'自分：'.$me; ?></p>
  <?php } ?>
  <?php if( $you!== ''){ ?>
  <p><?php print'相手：'.$you; ?></p>
  <?php } ?>
  <?php if( $result!== ''){ ?>
  <p><?php print'結果：'.$result; ?></p>
  <?php } ?>
  
  <form method="post">
    <p>
      <input type="radio" name="janken" value="グー" <?php if($me==='グー'){print 'checked';} ?> >グー
      <input type="radio" name="janken" value="チョキ" <?php if($me==='チョキ'){print 'checked';} ?>>チョキ
      <input type="radio" name="janken" value="パー" <?php if($me==='パー'){print 'checked';} ?>>パー
    </p>
    <input type="submit" name="submit" value="勝負">
  </form>
</body>
</html>