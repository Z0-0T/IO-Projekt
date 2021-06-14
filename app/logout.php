<?php
	session_start();
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($_SESSION["logged"])) {
			if($_SESSION["logged"] == 1) {
				session_destroy();
				header('Location: /app/index.php');
			}
		}
	}
?>