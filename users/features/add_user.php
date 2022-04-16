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


        if(!isset($input['phone']) || empty($input["phone"])){
            $errors['phone'] = "Phone is incorrect";
        }else if(strlen($input['phone']) > 14){
            $errors['phone'] = "Max 14 characters for Phone";
        }
        
        if(!isset($input['email']) || empty($input['email'])){
            $errors['email'] = "Email is required";
        }else if(!filter_var($input['email'], FILTER_VALIDATE_EMAIL)){
            $errors['email'] = "Email is not Valid";
        }else if(strlen($input['email']) > 50){
          $errors['email'] = "Max 50 characters for Email";    
        }
        return $errors;
 }
    $input = [];
    $errors = []; 
//if no errors procede in the adding of new user
if(isset($_POST["submit_new_student"])){
    $errors = validate_new_user($_POST);
    $input = clean_array($_POST);
    
    if(empty($errors)){
        $username = generate_username($_POST["first_name"], $_POST["last_name"]);
            $password = generate_random_password();
            $hash_password = PASSWORD_HASH($password, PASSWORD_DEFAULT);
            

         
            insert_user($_POST["first_name"], $_POST["last_name"],$username,$hash_password,$_POST["Role"],$_POST["phone"],$_POST["email"]);
           

        echo "<h3 style ='color:green'>User Added " .$_POST["first_name"]." </h3><br>";
        $link = "userdetails.php?username=" .$username . "&password=" .$password;
        echo '<a style="color:green" href="' .$link. '">Generate User PDF</a>';


            $input = [];
    }

}

?>
<h1>Add User</h1>
<hr>

<div class="who">
    <h1 style="color:red;">Warning!</h1>
    <h1 style="color:red;">User Username and Password is shown in a generated PDF after addition</h1>

</div>

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

    <div class="form-group">
        <label>Phone:</label>
        <input <?= error_outline($errors, "phone") ?> type="text" name="phone" value="<?=show_value($input, "phone")?>" >
        <?=show_error($errors, "phone")?>
    </div>

    <div class="form-group">
        <label>Email:</label>
        <input <?= error_outline($errors, "email") ?> type="email" name="email" value="<?=show_value($input, "email")?>" >
        <?=show_error($errors, "email")?>
    </div>

    <input type="submit" name="submit_new_student" >

</form>