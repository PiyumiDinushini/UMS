<?php

	$dbserver="localhost";
	$dbuser="root";
	$dbpass="";
	$dbname="userdb";

	$connection=mysqli_connect($dbserver,$dbuser,$dbpass,$dbname);

	//checking the connection
	if(mysqli_connect_errno()){
		die("error connecting database ".mysqli_connnect_error());
	}

	/*
	else{
		echo "successfully connected tothe database";
	}
	*/

?>