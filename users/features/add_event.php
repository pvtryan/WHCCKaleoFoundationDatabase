<?php
    check_user([ADMIN,USER]);

function vaildate_new_event($input){
    $errors = [];
   
    if(!isset($input['event_name']) || empty($input['event_name'])){
        $errors['event_name'] = "Event Name is Required";
      }else if(strlen($input['event_name']) > 50){
        $errors['Event_name'] = "Max 50 characters for Event Name";
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

    if(!isset($input['event_date']) || empty($input["event_date"])){
        $errors['event_date'] = "Date is Required";
    }else if(strtotime($input['event_date']) < strtotime('today midnight')){
        $errors['event_date'] = "Dates before today are invalid";
    }

    return $errors;
}

$input = [];
$errors = [];

if(isset($_POST["submit_new_event"])){
    $errors = vaildate_new_event($_POST);
    $input = clean_array($_POST);
    if(empty($errors)){
        insert_events($_POST["event_date"],$_POST["event_name"],$_POST["firstname"],$_POST["lastname"],$_POST["phone"],$_POST["email"]);

        echo "<h3 style = 'color:green'>Event Added</h3>";
        $input = [];
    }
}

?>

<h1>Add Event</h1>
<hr>

<form method="post" class = "form">

<div class="form-group">
	<label>Event Name</label>
    <input <?= error_outline($errors, "event_name") ?> type="text" name="event_name" value="<?=show_value($input, "event_name") ?>" >
        <?= show_error($errors, "event_name")?>
  </div>

  <div class="form-group">
	<label>Event Date</label>
    <input <?= error_outline($errors, "event_date") ?> type="date" name="event_date" value="<?=show_value($input, "event_date") ?>" >
        <?= show_error($errors, "event_date")?>
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
  <input <?=error_outline($errors, "email")?> type="email" name="email" value="<?=show_value($input,"email")?>" >
    <?= show_error($errors, "email")?>
  </div>

 <div class="form-group">
  <label>Phone - format: 555-555-5555</label>
  <input <?=error_outline($errors, "phone")?> type="tel" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" value="<?=show_value($input,"phone")?>" >
    <?= show_error($errors, "phone")?>
</div>

<input type="submit" name="submit_new_event">
</form>