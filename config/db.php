<?php
	$conn = mysqli_connect('localhost', 'root', '1234', 'wevote');
	if(mysqli_connect_errno()){
		echo 'Failed to connnect to MySQL '. mysqli_connect_errno();
	}
?>