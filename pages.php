<?php

$pages = array(
  "index" => "index.php",
  "register" => "register.php",
  "1" => "login.php"
);
$default_page = (isset($_GET['page']))?$_GET['page']:"index";

  if (isset($pages[$default_page])) {
    require_once  $pages[$default_page];
  }