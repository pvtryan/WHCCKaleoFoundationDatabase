<?php
    check_user([ADMIN]);
    

    
    $pagination = new Pagination(PAGES_USERS, $_GET);
    $users = get_users($_GET,false,$pagination);

    $input = clean_array($_GET);

    if(isset($_GET["delete"])){
        delete_user($_GET["delete"]);
        echo"<div class='alertsuccess' >
        <strong>Success!</strong> User was Removed.
        </div>";

    }
?>
<h1>List of Users</h1>
<hr>

<?php if($role === ADMIN): ?>
    <a class="feature-url"  href="user.php?feature=add_user">Add User</a>
<?php endif; ?>


<h3 class='total-count'><?= $pagination->get_total_rows() ?> USER(s)</h3>

<!-- Search function for list feature -->
<button class="search-button">Search</button>

<div class="backdrop"></div>

<form method="GET" class="search-form">
    <input name="feature" value="list_user" type="text" hidden/>
    <div>
        <label>Name: </label>
        <input placeholder="Ex. Smith, John" type="text" name="name" value="<?= show_value($input,"name") ?>" />
    </div>
    <div>
        <label>ID: </label>
        <input type="text" name="id" value="<?= show_value($input,"id") ?>" />
    </div>
    <div>
	<div>
		<label>Role: </label>
		<select name="role">
		<option value="all">All</option>
			<option value="ADMIN" <?= check_select($input,'role',"ADMIN") ?>>Admin</option>
            <option value="USER" <?= check_select($input,'role',"USER") ?>>USER</option>
            <option value="DRIVER" <?= check_select($input,'role',"DRIVER") ?>>DRIVER</option>
		</select>
	</div>
    </div>
    
    <div>
        <label>Order by: </label>
        <select name="order">
            <option value="name" <?= check_select($input,"order","name") ?>>Name</option>
            <option value="id" <?= check_select($input,"order","id") ?>>ID</option>
            <option value="role" <?= check_select($input,"order","role") ?>>Role</option>
        </select>
    </div>
    <input type="submit" value="Search" />
</form>

<script src="js/search_form.js"></script>

<div class="div-table">
	<table>
        <tr >

            <th>ID</th>
            <th>Full Name</th>
            
            <th>Role</th>
        </tr>
    <?php foreach($users as $user): ?>
        <tr class="row">
            <td><?=$user["UserID"]?></td>
            <td><?=$user["full_name"]?></td>

            <td> <?php
                                if($user["Role"] == "1"){
                                    echo "Admin";
                                }elseif($user["Role"] == "2"){
                                    echo "User";
                                }else{
                                    echo "Driver";
                                }
                            ?>
            </td>
        </tr>

        <tr>
        <td colspan="100%">
                <div class="info-shown-div">
                    <div class="info-shown-div-info">
                        <p><strong>Fullname:</strong><?=$user["full_name"]?></p>
                        <p><strong>Username:</strong><?=$user["Username"]?></p>
                        <p><strong>Role:</strong>
                            <?php
                                if($user["Role"] == "1"){
                                    echo "Admin";
                                }elseif($user["Role"] == "2"){
                                    echo "User";
                                }else{
                                    echo "Driver";
                                }
                            ?>
                    </p>
                    <p><strong>Phone: </strong><?=$user["Phone"]?></p>
                    <p><strong>Email: </strong><?=$user["Email"]?></p>
                    </div>
                    <div class="info-shown-div-links">
                                <?php if($user["UserID"] == $_SESSION["id"]):?>
                                        <p class="error">User Cannot Edit From this Page </p>
                                <?php else: ?>
                                    <a class="feature-url" href="user.php?feature=edit_user&UserID=<?=$user["UserID"]?>">Edit Info</a>
                                    
                                    <?php endif;?>
                                <a class="feature-url" onclick="return confirm('Are you sure you want to remove <?=$user['full_name_rev']?>')" href="user.php?feature=list_user&delete=<?=$user["UserID"]?>">Delete User</a>
                     <div>
                </div>
        </td>

        </tr>
        <?php endforeach; ?>

    

</table>

</div>
<?php $pagination->print_all_links() ?>
<br>