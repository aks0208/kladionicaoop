<?php 
class Pages {
	public static function IncludePages($pages) {

		$pages = array(
  			"index" => "index.php",
		  	"register" => "register.php",
		    "1" => "../login.php"
		);

	$default_page = (isset($_GET['page']))?$_GET['page']:"index";

	if (isset($pages[$default_page])) {
		$path = 'c:/wamp64/www/kladionicaoop/classes/';
		include $path.$pages[$default_page];
		print_r($path.$pages[$default_page]);
    
  	}
		
	}

}