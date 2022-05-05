<?php
    check_user([ADMIN]);

    $eventID= isset($_GET["EventID"])? $_GET["EventID"] : "";

    $event = get_event_by_id($eventID);

    function verify_event($input){
        $errors = [];
        
        if(!isset($input['EventName']) || empty($input['EventName'])){
                $errors['EventName'] = "Event Name is Required";
        }else if(strlen($input['EventName']) > 50){
                $errors['EventName'] = "Max 50 characters for Event Name";
        } 
        
        
        if(!isset($input['contactfirstname']) || empty($input['contactfirstname'])){
                $errors['contactfirstname'] = "Firstname Required";
        }else if(strlen($input['contactfirstname']) > 50){
                $errors['contactfirstname'] = "Max 50 characters for First Name";
        }
        
        if(!isset($input['contactlastname']) || empty($input['contactlastname'])){
                $errors['contactlastname'] = "Lastname Required";
        }else if(strlen($input['contactlastname']) > 50){
                $errors['contactlastname'] = "Max 50 characters for Last Name";
        }
        
        if(!isset($input['event_date']) || empty($input["event_date"])){
                $errors['event_date'] = "Event Date is required";
        }

        if(!isset($input['contactphone']) || empty($input["contactphone"])){
                $errors['contactphone'] = "Phone is required";
            }else if(strlen($input['contactphone']) > 14){
                $errors['contactphone'] = "Max 14 characters for Phone";
            }


            if(!isset($input['contactemail']) || empty($input['contactemail'])){
                $errors['contactemail'] = "Email is required";
            }else if(!filter_var($input['contactemail'], FILTER_VALIDATE_EMAIL)){
                $errors['contactemail'] = "Email is not Valid";
            }else if(strlen($input['contactemail']) > 50){
              $errors['contactemail'] = "Max 50 characters for Email";    
            }

        return $errors;
    }

    $errors = [];
    $input = [];
    if(isset($_POST["submit_event"])){
            $errors = verify_event($_POST);
            if(empty($errors)){
                update_event($_POST["event_date"],$_POST["EventName"],$_POST["contactfirstname"],$_POST["contactlastname"],$_POST["contactphone"],$_POST["contactemail"],$eventID);
                echo"<div class='alertsuccess' >
                <strong>Success!</strong> Event Edited
                </div>
                ";

                $event = get_event_by_id($eventID);
                }
    }

?>
<h3>Edit Event</h3>
<hr>
<form method="post" class="form">

<div class="form-group">
        <label>Event Name</label>
        <input <?= error_outline($errors, "EventName") ?> type="text" name="EventName" value="<?=show_value($event, "EventName")?>" >
        <?=show_error($errors, "EventName")?>
</div>


<div class="form-group">
	<label>Event Date</label>
    <input <?= error_outline($errors, "event_date") ?> type="date" name="event_date" value="<?=show_value($event, "EventDate") ?>" >
        <?= show_error($errors, "event_date")?>
  </div>

  <div class="form-group">
        <label>Contact Firstname</label>
        <input <?= error_outline($errors, "contactfirstname") ?> type="text" name="contactfirstname" value="<?=show_value($event, "Contact_firstname")?>" >
        <?=show_error($errors, "contact")?>
</div>

<div class="form-group">
        <label>Contact Lastname</label>
        <input <?= error_outline($errors, "contactlastname") ?> type="text" name="contactlastname" value="<?=show_value($event, "Contact_lastname")?>" >
        <?=show_error($errors, "contactlastname")?>
</div>

<div class="form-group">
        <label>Contact Phone</label>
        <input <?= error_outline($errors, "contactphone") ?> type="text" name="contactphone" value="<?=show_value($event, "Phone")?>" >
        <?=show_error($errors, "contactphone")?>
</div>

<div class="form-group">
        <label>Contact Email</label>
        <input <?= error_outline($errors, "contactemail") ?> type="text" name="contactemail" value="<?=show_value($event, "Email")?>" >
        <?=show_error($errors, "contactemail")?>
</div>

<input type="submit" name="submit_event"/>

</form>
<br>