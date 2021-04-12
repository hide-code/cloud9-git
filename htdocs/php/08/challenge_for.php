<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>for</title>
</head>
<body>
  <?php 
  $sum=0;
  for ($i = 1; $i <= 100; $i++){
      if($i%3===0){
          $sum+=$i;
      }
  }
  print $sum;
  ?>
  
</body>
</html>