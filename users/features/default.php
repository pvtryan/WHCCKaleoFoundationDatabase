

<h1>Welcome, <?= get_current_user_name() ?></h1>
<hr>
<div class='info-table'>
<table>
<caption>Your Information</caption>
	<tr>
		
	<td>Role: </td>
		<td><?= get_role_name($role) ?></td>
	</tr>
	<tr>
		<td>Username: </td>
		<td><?= $user["Username"] ?></td>
	</tr>
</table>

	<?php if($role === ADMIN):  ?>

<table>
	<caption>Statistics</caption>
	<tr>
		<td># of Users</td>
		<td><?= count(get_users()) ?></td>
	</tr>
	<tr>
		<td># of Products</td>
		<td><?= count(get_products()) ?></td>
	</tr>

	<tr> 
		<td>Estimated Value of All Inventory</td>
		<td>$<?php $sum = get_sum_value(); 
			echo $sum["sum"];?></td>

	</tr>

	<tr>
		<td>Sum of all Quantity</td>
		<td><?php $sum = get_sum_quantity();
			echo $sum["sum_quantity"];?></td>
	</tr>
	
		<tr>
		<td>Estimated Values of All Donation</td>
		<td><?php
			$info = get_info_all();

			echo "$" .$info["total_value"];
		?>
		</td>
	</tr>
	<tr><td>Total Quantity of Items Donated</td>
	<td>
		<?php
			$info = get_info_all();
			echo $info["total_quantity"];
		?>
	</td>
	</tr>


</table>

<?php endif ?>

	</div>