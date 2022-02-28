<?php
    check_user([ADMIN]);

    $eventID= isset($_GET["EventID"])? $_GET["EventID"] : "";

    $event = get_event_by_id($eventID);




?>
<h3>Edit Event</h3>
<hr>
<form method="post" class="form">

<div class="form-group">
        <label>Event Name</label>
        <input <?= error_outline($errors, "EventName") ?> type="text" name="EventName" value="<?=show_value($event, "EventName")?>" required>
        <?=show_error($errors, "EventName")?>
</div>

<div class="form-group">
        <label>Event Name</label>
        <input <?= error_outline($errors, "EventName") ?> type="text" name="EventName" value="<?=show_value($event, "EventName")?>" required>
        <?=show_error($errors, "EventName")?>
</div>

<div class="form-group">
	<label>Event Date</label>
    <input <?= error_outline($errors, "event_date") ?> type="date" name="event_date" value="<?=show_value($input, "event_date") ?>" required>
        <?= show_error($errors, "event_date")?>
  </div>

  <div class="form-group">
        <label>Contact Firstname</label>
        <input <?= error_outline($errors, "EventName") ?> type="text" name="EventName" value="<?=show_value($event, "EventName")?>" required>
        <?=show_error($errors, "EventName")?>
</div>

<div class="form-group">
        <label>Contact Lastname</label>
        <input <?= error_outline($errors, "EventName") ?> type="text" name="EventName" value="<?=show_value($event, "EventName")?>" required>
        <?=show_error($errors, "EventName")?>
</div>

</form>
<br>