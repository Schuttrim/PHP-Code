<?php
    
?>

         
         
<style type="text/css">
    article.div {
        float: left;
    }
    a {
        text-decoration: none;
        color: black;
    }
    .article .header p {
        margin-bottom: 0;
        width: 100px;
        float: left;
    }
</style>

<html>
    <body>
        <div id="login">
            <?php
                echo $GLOBALS['data']->getloginbox();
            ?>
        </div>
        <div id="usercommands">
            <?php
                echo $GLOBALS['data']->getusercmd();
            ?>
        </div>
        <div id="content">
            <?php
                echo $GLOBALS['data']->getbody();
            ?>
        </div>
    </body>
</html>
