<!DOCTYPE html>
<html="ja">
    <head>
        <meta charset="UTF-8">
        <title>challenge-if</title>
    </head>
    <body>
        <?php
        $rand=mt_rand(1,6);
        ?>
        <p>サイコロの目:<?php print $rand; ?></p>
        <?php if($rand%2===0){ ?>
        <p>偶数</p>
        <?php }else{ ?>
        <p>奇数</p>
        <?php } ?>
        
    </body>
</html>