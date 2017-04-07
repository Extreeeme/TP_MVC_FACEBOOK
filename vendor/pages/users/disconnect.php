<?php 
	unset($_SESSION['Auth']);
	header('location: index.php?p=home');
	exit();