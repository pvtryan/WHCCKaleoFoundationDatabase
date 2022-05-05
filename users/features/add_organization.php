<?php
    check_user([ADMIN,USER]);

    function vaildate_new_organization($input){
        $errors = [];
       
        if(!isset($input['org_name']) || empty($input['org_name'])){
            $errors['org_name'] = "Organization Name is Required";
          }else if(strlen($input['org_name']) > 50){
            $errors['org_name'] = "Max 50 characters for Organization Name";
          } 

        if(!isset($input['firstname']) || empty($input['firstname'])){
            $errors['firstname'] = "Contact Firstname is Required";
        }else if(strlen($input['firstname']) > 50){
            $errors['firstname'] = "Max 50 characters for First Name";
        }

        if(!isset($input['lastname']) || empty($input['lastname'])){
            $errors['lastname'] = "Contact Lastname is Required";
        }else if(strlen($input['lastname']) > 50){
            $errors['lastname'] = "Max 50 characters for First Name";
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

    if(isset($_POST["submit_new_organization"])){
        $errors = vaildate_new_organization($_POST);
        $input = clean_array($_POST);
        if(empty($errors)){
            insert_organization($_POST["org_name"],$_POST["firstname"],$_POST["lastname"],$_POST["phone"],$_POST["email"]);
            echo"<div class='alertsuccess' >
            <strong>Success!</strong> ".$_POST["org_name"]." Added <a  style = 'text-decoration: none; color:white'  href='user.php?feature=add_donation'>Click Here to Make Donation</a>
	</div>
            ";
            
            $input = [];
        }
    }
?>

<h1>Add Organization</h1>
<hr>
<form method="post" class = "form">

<div class="form-group">
	<label>Organization Name</label>
    <input <?= error_outline($errors, "org_name") ?> type="text" name="org_name" value="<?=show_value($input, "org_name") ?>" >
        <?= show_error($errors, "org_name")?>
  </div>

<div class="form-group">
	<label>First Name</label>
    <input <?= error_outline($errors, "firstname") ?> type="text" name="firstname" value="<?=show_value($input, "firstname") ?>" >
        <?= show_error($errors, "firstname")?>
  </div>

  <div class="form-group">
  <label>Last Name</label>
  <input <?=error_outline($errors, "lastname")?> type="text" name="lastname" value="<?=show_value($input,"lastname")?>" >
    <?= show_error($errors, "lastname")?>
</div>

  <div class="form-group">
  <label>Email</label>
  <input <?=error_outline($errors, "email")?> type="email" name="email" value="<?=show_value($input,"email")?>">
    <?= show_error($errors, "email")?>
  </div>

 <div class="form-group">
  <label>Phone - format: 555-555-5555</label>
  <input <?=error_outline($errors, "phone")?> type="tel" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" value="<?=show_value($input,"phone")?>" >
    <?= show_error($errors, "phone")?>
</div>

<input type="submit" name="submit_new_organization">
</form>