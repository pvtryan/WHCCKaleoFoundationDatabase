<?php require_once("includes/all.php") ?>

<?php require_once("partials/home/header.php") ?>

<?php


function getUserIP()
{
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
              $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
              $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}


$errors = [];
$input = [];

// If the submit button is set, then validate the form.
// If no errors, then login the user
// else, show the erros
if(isset($_POST["submit_login"])){
    $errors = validate_login($_POST);
    if(empty($errors)){
        $ip = getUserIP();
        login_user($_POST);
        $username = get_user_by_username($_POST["username"]);
        insert_logindate($username["UserID"],$ip);
        sleep(2);
        
        change_page('user.php');
    }
    $input = clean_array($_POST);
} else{
    logout();
}

?>

<!-- 
	LOGIN FORM
	includes username, password, and role as input
-->


<div id="myDiv">
<div class="form__login login">
 
    <?= show_error($errors,"login") ?>
    
    <h1>Login</h1>

    <form action="<?= action() ?>" method="POST">

        <div class="container__input">
            <input type="text" name="username" value="<?= show_value($input,'username') ?>" autocomplete="off" required />
            <label>Username</label>
        </div>

        <div class="container__input">
            <input type="password" name="password" value="<?= show_value($input,"password") ?>" autocomplete="off" required />
            <label>Password</label>    
        </div>

      
        <input type="submit" onclick="Start()" name="submit_login" value="Login">
        
    </form>
</div>
</div>


<script>
document.querySelector('input').focus();
</script>

<?php require_once("partials/home/footer.php") ?>

