<?php
    check_user([ADMIN]);
    
    $UserID  =  isset($_GET["UserID"])? $_GET["UserID"] : "";

    
   
    $user = get_user_by_id($UserID);


    function validate_edit($input){
        $errors = [];

        if(!isset($input['first_name']) || empty($input['first_name'])){
            $errors['first_name'] = "First Name Required";
        }else if(!ctype_alpha($input['first_name'])){
            $errors['first_name'] = "First Name can only contain characters";
        }
        else if(strlen($input['first_name']) > 50){
            $errors['first_name'] = "Max 50 characters for First Name";
        }

        if(!isset($input['last_name']) || empty($input['last_name'])){
            $errors['last_name'] = "Last Name Required";
        }else if(!ctype_alpha($input['last_name'])){
            $errors["last_name"] = "Last Name can only contain characters";
        }else if(strlen($input['last_name']) > 50){
            $errors['last_name'] = "Max 50 characters for Last Name";
        }
        
        if(!isset($input['username']) || empty($input['username'])){
            $errors['username'] = "Username Required";
        }else if(strlen($input["username"]) > 50){
            $errors['username'] = "Max 50 characters for Username";
        }

        if(!isset($input['email']) || empty($input['email'])){
            $errors['email'] = "Email is required";
        }else if(!filter_var($input['email'], FILTER_VALIDATE_EMAIL)){
            $errors['email'] = "Email is not Valid";
        }else if(strlen($input['email']) > 50){
            $errors['email'] = "Max 50 characters for Email";
        }

        if(!isset($input['role']) || empty($input['role'])){
            $errors['role'] = "Role is incorrect";
        }

        return $errors;
    }

    $input = [];
    $errors = [];

    if(isset($_POST["submit_edit"])){
        $errors = validate_edit($_POST);
        $input = clean_array($_POST);
        if(empty($errors)){
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];
            $username = $_POST["username"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $role = $_POST["role"];

            update_user_info($user["UserID"],$first_name,$last_name,$username,$role,$phone,$email);

            $user = get_user_by_id($UserID);
            echo "<h3 style='color:green'>Successfully edited: " . $user["full_name"] ."</h3>";
        }
    }
?>

<h1>Editing <?=$user["full_name"]  ?></h1>
<hr>
    <div class = "who">
        <h3>ID: <?= $user["UserID"]?></h3>
        <h3>Name: <?= $user["full_name_rev"]?></h3>
        <h3>Role: <?= get_role_name($user["Role"])?></h3>

</div>
<form method="post" class="form">

<div class="form-group">
        <label>First Name</label>
        <input <?= error_outline($errors, "first_name") ?> type="text" name="first_name" value="<?=show_value($user, "userFirstName")?>" >
        <?=show_error($errors, "first_name")?>
</div>

<div class="form-group">
        <label>Last Name</label>
        <input <?= error_outline($errors, "last_name") ?> type="text" name="last_name" value="<?=show_value($user, "userLastName")?>">
        <?=show_error($errors, "userLastName")?>
</div>

<div class="form-group">
        <label>Username</label>
        <input <?= error_outline($errors, "username") ?> type="text" name="username" value="<?=show_value($user, "Username")?>" >
        <?=show_error($errors, "username")?>
</div>

<div class="form-group">
        <label>Email</label>
        <input <?= error_outline($errors, "email") ?> type="email" name="email" value="<?=show_value($user, "Email")?>" >
        <?=show_error($errors, "Email")?>
</div>

<div class="form-group">
        <label>Phone</label>
        <input <?= error_outline($errors, "phone") ?> type="text" name="phone" value="<?=show_value($user, "Phone")?>" required>
        <?=show_error($errors, "Phone")?>
</div>

<div class="form-group">
    <label>Role</label>
        <select <?=error_outline($errors, "role")?> name="role" id="role" required>
            <option <?=check_select($user, "Role" , 1)?>  value="1">Admin</option>
            <option <?=check_select($user, "Role" , 2)?>  value="2">Standard User</option>
            <option <?=check_select($user, "Role" , 3)?>  value="3">Driver</option>
        </select>
</div>

<input type="submit" name="submit_edit" >

</form>