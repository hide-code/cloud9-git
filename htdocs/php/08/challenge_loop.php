<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>for</title>
</head>
<body>
  <?php 
  
  for($i=1;$i<=100;$i++){
      
      if($i%3===0 && $i%5===0){
          print '<p>fizzbuzz</p>';
      }else if($i%3===0){
          print '<p>fizz</p>';
      }else if($i%5===0){
          print '<p>buzz</p>';
      }else{
          print '<p>'. $i .'</p>';
      }
  }
  
  ?>
</body>
</html>