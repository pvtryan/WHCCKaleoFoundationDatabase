<?php

function validate_login($input){//This function contains login and verify the users by username and password 
    $errors = [];

    $error_msg = "Could not login";

    if(!isset($input["username"])|| !isset($input["password"])){
        $errors['login'] = $error_msg;
    }

    if(!empty($errors)) return $errors;

    $user = false;
    
 
        $user = get_user_by_username($input["username"]);
    

    if(!$user)
        $errors['login'] = "Not a registered user or Wrong username";
    else{
        $hash_password = $user["Password"];
     
        $password = $input["password"];
        if(!password_verify($password, $hash_password))
            $errors['login'] = "Wrong username or password";
    }

    return $errors;
}

?>