<?php
    session_start();
    require_once('controller.class.php');
    require_once('flagcontainer.class.php');
    
    $GLOBALS['data'] = new prepareddata();
    $GLOBALS['flags'] = new flagcontainer();
    $controller = new maincontroller();
    
    include_once('template.php');
    
?>