<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>while</title>
</head>
<body>
  <?php 
   $sum=0;
   $i=1;
   while ($i <= 100) {
       
       if($i%3===0){
          $sum+=$i;
      }
       $i++;
   }
   print $sum;
  ?>
</body>
</html>