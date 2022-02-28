<?php
ob_start();//starts output buffer
session_start();//starts a new session 

function is_logged_in(){//This function checks that the users logged in 
    return isset($_SESSION["id"]) && isset($_SESSION["role"]);
}

function login_user($input){//This function will return the users info on the default page 
        $user = get_user_by_username($input['username']);
        $role = get_user_role($user["Role"]);
        login($user["UserID"], $role["Role"]);

}

function go_to_correct_page(){//This functin will direct the user to the right page
    if(!is_logged_in())
        change_page('index.php');
    change_page('user.php');
}

function login($id, $role){//This function saves the id and role of the user when logined
    $_SESSION["id"] = $id;
    $_SESSION["role"] = $role;
}

function logout(){//This function unset the session from the authentication
    unset($_SESSION["id"]);
    unset($_SESSION["role"]);
}


function check_user($valid_users){//This function checks that the user is valid in the database 
    /* Check if user is valid */
    global $role;
    $valid = false;
    foreach($valid_users as $user){
        if($role === $user){
            $valid = true;
            break;
        }
    }
    if(!$valid)
        change_page("user.php");
}

function authenticate(){//This function checks if user is logged if not redirects to homepage
    $errors= [];
    if(!is_logged_in()){
        change_page('index.php');
    }
    $user = false;
    
    $user = get_user_by_id($_SESSION["id"]);
    
    if(!$user)
          change_page('index.php');
    return $user;
}

?>