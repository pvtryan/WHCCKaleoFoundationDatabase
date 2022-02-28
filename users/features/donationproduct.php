<?php
    check_user([ADMIN,USER]);

    $DonationID  =  isset($_GET["DonationID"])? $_GET["DonationID"] : "";

    $donations = get_donation_by_id($DonationID);
    $recipient = get_donation_name_by_id($DonationID)

?>

<h1>Products Donated To <?php 
                if($recipient["EventID"] == NULL){
                    echo $recipient["org_name"];
                }else{
                    echo $recipient["event_name"];
                }

            ?></h1>
<hr>

<a class="feature-url"  href="user.php?feature=add_productdonation&DonationID=<?=$DonationID?>">Add Products</a>


<div class="div-table">
	<table>
        <tr >

            <th>ID</th>
            <th>Product Name</th>
            <th>Quantity</th>
        </tr>
    <?php foreach($donations as $donation): ?>
        <tr class = "row">
            <td><?=$donation["DonationID"]?></td>
            <td><?=$donation["item"]?></td>
            <td><?=$donation["Quantity"]?> <?=$donation["unit"]?></td>  
        </tr>

        <tr>
        <td colspan="100%">
                <div class="info-shown-div">
                    <div class="info-shown-div-info">
                    
                    </div>
                    <div class="info-shown-div-links">
                             
                     <div>
                </div>
        </td>

        </tr>
        <?php endforeach; ?>
</table>
    </div>
    <br>