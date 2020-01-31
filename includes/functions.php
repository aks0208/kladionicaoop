<?php


function redirectTo ($location) {
	header('location:' . $location);
	exit;
} 

function errorMessage () {
	if ( isset($_SESSION['errorMessage'])) {
		$ouput = "
			<div class='alert alert-danger'>" .
			htmlentities($_SESSION["errorMessage"]) .
			"</div>
		";
		$_SESSION['errorMessage'] = null;
		return $ouput;
	}
} 

function successMessage () {
	if ( isset($_SESSION['successMessage'])) {
		$ouput = "
			<div class='alert alert-success'>" .
			htmlentities($_SESSION["successMessage"]) .
			"</div>
		";
		$_SESSION['successMessage'] = null;
		return $ouput;
	}
}
?>