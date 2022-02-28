<?php
// depending on the role of the current user, then show those links
switch($role){
	case ADMIN:
		require_once('users/links/admin.php');
		break;
    case USER:
        require_once('users/links/user.php');
        break;
    case DRIVER:
        require_once('users/links/driver.php');
        break;
}

// below is dynamic renderin of links based on the user's links
?>

<?php foreach($links as $link=>$name): ?>
	<a class="mainlink" href="user.php?feature=<?= $link ?>"><?= $name ?></a>
<?php endforeach; ?>