<?php

		#connect to DB
		$servername="sql.njit.edu";
		$user="fdm8";
		$password="dnPvZprB";
		($conn=mysql_connect($servername, $user, $password) or die(mysql_error())); 
		$query="use fdm8";
		($result=mysql_query($query) or die(mysql_error()));
		#Authenticates username/password against database
		$u=$_POST['username'];
		$p=$_POST['password'];
		$query="select * from logins where username='$u' and password='$p'";
		($result=mysql_query($query) or die(mysql_error()));
		$numrows=mysql_num_rows($result);
		if($numrows == 0 ){
			echo json_encode(0);
			mysql_close($conn); #closes mysql connections
			die();
		}
		$returnUser=mysql_fetch_assoc($result);
		print json_encode($returnUser);
		mysql_close($conn); #closes mysql connections
		
?>
