<?php
check_user([ADMIN,USER,DRIVER]);

    global $user;

    $useredit = get_user_by_id($user["UserID"]);



?>

<h1>Edit User Info</h1>
<hr>
<h3>What Information do you want to Change <?=$useredit["userFirstName"]?>?</h3>
<br>
<a class = "feature-url" href="user.php?feature=edit_info">Change Password</a>
<br>
<br>
<a class = "feature-url" href="user.php?feature=edit_user&useron=<?=$user["UserID"]?>">Change Personal Details</a>