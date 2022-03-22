<?php
    check_user([ADMIN,USER]);
    
    $pagination = new Pagination(PAGES_EVENT, $_GET);
    $events = get_events($_GET,false, $pagination);
    $input = clean_array($_GET);



?>
<h1>Events</h1>
<hr>
<?php if($role === ADMIN || $role === USER): ?>
    <a class="feature-url"  href="user.php?feature=add_event">Add Event</a>
    <a class="feature-url"  href="eventlist.php">Generate PDF</a>
    <?php endif; ?>

<h3 class='total-count'><?= $pagination->get_total_rows() ?> Event(s)</h3>

<button class="search-button">Search</button>

<div class="backdrop"></div>

<form method="GET" class="search-form">
<input name="feature" value="list_event" type="text" hidden/>
<div>
    <label>Event Name: </label>
    <input  type="text" name="name" value="<?= show_value($input,"name") ?>" />
</div>
<div>
    <label>ID: </label>
    <input type="text" name="id" value="<?= show_value($input,"id") ?>" />
</div>


<div>
    <label>Order by: </label>
    <select name="order">
        <option value="name" <?= check_select($input,"order","name") ?>>Name</option>
        <option value="id" <?= check_select($input,"order","id") ?>>ID</option>
    </select>
</div>
<input type="submit" value="Search" />
</form>

<script src="js/search_form.js"></script>

<div class="div-table">
    <table>
    <tr>
            <th>EventID</th>
            <th>Event</th>
            <th>EventDate</th>
            <th>Contact</th>
        </tr>
            <?php foreach($events as $event):?>
                <tr class = "row">
                    <td><?=$event["EventID"]?></td>
                    <td><?=$event["EventName"]?></td>
                    <td><?=$event["format_date"]?></td>
                    <td><?=$event["full_name_rev"]?></td>

                </tr>
                
                <tr>
             <td colspan="100%">
                <div class="info-shown-div">
                    <div class="info-shown-div-info">
                        <p><strong>Contact: </strong><?=$event["full_name"]?></p>
                        <p><strong>Contact Email: </strong><?=$event["Email"]?></p>
                        <p><strong>Contact Phone: </strong><?=$event["Phone"]?></p>
                    </div>
                  <div class="info-shown-div-links">
                        <a class="feature-url" href="user.php?feature=edit_event&EventID=<?=$event["EventID"]?>">Edit Event</a>
                        <a class="feature-url" href="">Delete Event</a>
                    </div>    
                </div>
            
            </td>
            </tr>

            <?php endforeach; ?>
    </table>
</div>
<?php $pagination->print_all_links() ?>
<br>