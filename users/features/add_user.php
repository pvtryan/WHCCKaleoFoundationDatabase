<?php
 check_user([ADMIN]);

function validate_new_user($input){
    $errors = [];

    if(!isset($input['first_name']) || empty($input['first_name'])){
        $errors['first_name'] = "First Name Required";
    }else if(!ctype_alpha($input['first_name'])){
        $errors['first_name'] = "First Name can only contain characters";
    }else if(strlen($input['first_name']) > 50){
        $errors['first_name'] = "Max 50 characters for First Name";
    }

    if(!isset($input['last_name']) || empty($input['last_name'])){
        $errors['last_name'] = "Last Name Required";
    }else if(!ctype_alpha($input['last_name'])){
        $errors["last_name"] = "Last Name can only contain characters";
    }else if(strlen($input['last_name']) > 50){
        $errors['last_name'] = "Max 50 characters for Last Name";
    }

    
        if(!isset($input['Role']) || empty($input["Role"])){
            $errors['Role'] = "Role is incorrect";
        }
 }
    $input = [];
    $errors = []; 
//if no errors procede in the adding of new user
if(isset($_POST["submit_new_student"])){
    $errors = validate_new_user($_POST);
    $input = clean_array($_POST);
    
    if(empty($errors)){
        $username = generate_username($_POST["first_name"], $_POST["last_name"], STUDENT);
            $password = generate_random_password();
            $hash_password = PASSWORD_HASH($password, PASSWORD_DEFAULT);

            //Insert function to mail password to new user
            //Add Insert when ready

            //insert_user($_POST["first_name"], $_POST["last_name"];
            
            //$msg = "Username:{$username}\nPassword:{$password}";

            //mail($_POST['email'], "Student Login Information", $msg);

        echo "<h3 style ='color:green'>User Added</h3>";
            $input = [];
    }

}

?>
<h1>Add User</h1>
<hr>


<form method="post" class="form">
    <div class="form-group">
        <label>First Name</label>
        <input <?= error_outline($errors, "first_name") ?> type="text" name="first_name" value="<?=show_value($input, "first_name")?>" >
        <?=show_error($errors, "first_name")?>
    </div>

    <div class="form-group">
        <label>Last Name</label>
        <input <?= error_outline($errors, "last_name") ?> type="text" name="last_name" value="<?=show_value($input, "last_name")?>" >
        <?=show_error($errors, "last_name")?>
    </div>

    <div class="form-group">
        <label>Role</label>
        <select <?= error_outline($errors, "Role") ?> name="Role" id="Role" >
            <option selected disabled hidden></option>
            <option <?= check_select($input,"Role", "1") ?> value="1">Admin</option>
            <option <?= check_select($input,"Role","2") ?> value="2">Standard User</option>
            <option <?= check_select($input,"Role","3") ?> value="3">Driver</option>
           
        </select>
        <?=show_error($errors, "Role")?>
    </div>

    <input type="submit" name="submit_new_student" >

</form>