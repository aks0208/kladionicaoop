<?php
include("admin/config.php");
if (isset($_POST['logout'])) {
	User::logout();
	User::redirect('login.php');
}
