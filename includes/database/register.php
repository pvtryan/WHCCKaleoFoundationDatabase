<?php
/*********************************************************
 * 
 * 
 * 
 * 
 * 
 *********************************************************/

function get_next_id(){
	$sql = "
	SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'kaleo' AND TABLE_NAME = 'Users'";
	$result = query_one_np($sql);
	return $result;
}

function generate_random_password(){//This function will generate a password for new users before emailing the user when account is created
	$password = "";
	for($i=0;$i<10;$i++){
		$ascii = 48 + rand()%75;
		$password .= CHR($ascii);
	}
	return $password;
}

function generate_username($first_name, $last_name){//this function wil generate a username when account is created by combining user first name and last and then their ID
	$id = get_next_id();
	$username = $first_name . $last_name . $id["AUTO_INCREMENT"];

	return strtolower($username);
}

function generate_random_pin(){
	return 1000 + rand()%9000;
}

?>