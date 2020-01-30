<?php
//DEFINE ("DB","betlive");
//DEFINE ("DBHOST", "127.0.0.1");
//DEFINE ("DBUSER", "root");
//DEFINE ("DBPASS", "");
DEFINE ("APP_DIR", "c:/wamp64/www/betting/");


spl_autoload_register(function ($class) {
    include_once APP_DIR . "classes/" . $class . ".php";
});




?>
