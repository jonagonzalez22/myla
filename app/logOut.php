<?php
	session_start();
	session_destroy();
	header("location:./models/redireccionar_app.php");
?>