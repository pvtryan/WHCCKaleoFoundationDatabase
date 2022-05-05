<?php
    check_user([ADMIN,USER]);

    $events = get_events();
    $orgs = get_organizations();

    function validate_new_donation($input){
        if ($input['event'] === '') {
            $input['event'] = null; // or 'NULL' for SQL
        }

        if ($input['org'] === '') {
            $input['org'] = null; // or 'NULL' for SQL
        }

        $errors = [];
        if(!isset($input['event']) && !isset($input['org'])){
            $errors['event'] = "One must be Selected";
            $errors['org'] = "One must be Selected";

        }else if($input['event'] === null || $input['org'] === null){
            if($input['event'] === null && $input['org'] === null){
                $errors['event'] = "One must be Selected";
                $errors['org'] = "One must be Selected";
            }else{
            return $errors;
            }
        }else{
            $errors['event'] = "One must be Empty";
            $errors['org'] = "One must be Empty";
        }

        return $errors;
    }
    $errors = [];
    $input =[];
    if(isset($_POST["submit_new_donation"])){
        $errors = validate_new_donation($_POST);
        $input = clean_array($_POST);
        if(empty($errors)){
            if ($_POST['event'] === '') {
                $_POST['event'] = null; // or 'NULL' for SQL
            }
    
            if ($_POST['org'] === '') {
                $_POST['org'] = null; // or 'NULL' for SQL
            }
            if($_POST['org'] === null){
                insert_donation_event($_POST["event"]);
                $event = get_event_by_id($_POST["event"]);
                $name = $event["EventName"];

            }else if($_POST['event'] === null){
                insert_donation_org($_POST["org"]); 
                $org = get_organization_id($_POST["org"]);
                $name = $org["OrganizationName"];
            }
           
            $previous = get_next_donation();
             $current = $previous["ID"]++;
             echo "<div class='alertsuccess' >
             <strong>Success!</strong>
             <a  style = 'text-decoration: none; color:white' href='user.php?feature=add_productdonation&DonationID=". $current ."'>Click Here to Add to ".$name."</a>
            </div>
             ";
            
            $current = '';
            $input = [];
        }
    }
?>

<h1>Add Donation</h1>
<hr>
<div class = "who">
<h3 style="color:red">* Only select One</h3>
</div>
<form method="post" class="form">

<div class = "form-group">
    <label>If an Event has not been Entered: <a class="clickhere" href="user.php?feature=add_event">Click Here!</a></label> 


</div>
<div class ="who">
<div class="form-group">
        <label>Event</label>
        <select <?= error_outline($errors, "event") ?> name="event" id="event" >
      
          <option selected disabled hidden></option>
            <option value ="">NONE</option>
          <?php foreach($events as $event):?>
		<option <?= check_select($input,"event",$event["EventID"]) ?> value ="<?=$event["EventID"]?>"><?=$event["EventName"]?></option>
	  <?php endforeach; ?>
        </select>
        <?=show_error($errors, "event")?>
    </div>
          </div>

    <div class = "form-group">
    <label>If an Organization has not been Entered: <a class="clickhere" href="user.php?feature=add_organization">Click Here!</a></label>


</div>
<div class = "who">
    <div class="form-group">
        <label>Organization</label>
        <select <?= error_outline($errors, "org") ?> name="org" id="org" >

          <option selected disabled hidden></option>
          <option  value ="">NONE</option>
          <?php foreach($orgs as $org):?>
		<option <?= check_select($input,"org",$org["OrganizationID"]) ?> value ="<?=$org["OrganizationID"]?>"><?=$org["OrganizationName"]?></option>
	  <?php endforeach; ?>
        </select>
        <?=show_error($errors, "org")?>
    </div>
    </div>
    <input type="submit" name="submit_new_donation" >

          </form>
        