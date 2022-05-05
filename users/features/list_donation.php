<?php check_user([ADMIN,USER]);

$pagination = new Pagination(PAGES_DONATION, $_GET);
$donations = get_donation($_GET,false,$pagination);
$input = clean_array($_GET);

if(isset($_GET["delete"])){
    delete_donation($_GET["delete"]);
        change_page(link_without("delete"));
}


?>
<h1>Kaleo Donation</h1>
<hr>

    <a class = "feature-url" href="user.php?feature=add_donation">Add Donation </a>
    <a class="feature-url"  href="donationlist.php">Generate PDF</a>
    <h3 class='total-count'><?= $pagination->get_total_rows() ?> DONATION(s)</h3>

<!-- Search function for list feature -->
<button class="search-button">Search</button>

<div class="backdrop"></div>

<form method="GET" class="search-form">
    <input name="feature" value="list_donation" type="text" hidden/>

    <div>
        <label>ID: </label>
        <input type="text" name="id" value="<?= show_value($input,"id") ?>" />
    </div>
        
    <div>
        <label>Date: </label>
       <input type="date" name="date" value="<?= show_value($input,"date") ?>" />
    </div>


    <div>
        <label>Order by: </label>
        <select name="order">
            <option value="event" <?= check_select($input,"order","event") ?>>Event Name</option>
            <option value="id" <?= check_select($input,"order","id") ?>>ID</option>
            <option value="org" <?= check_select($input,"order","org") ?>>Organization Name</option>
        </select>
    </div>
    <input type="submit" value="Search" />
</form>

<script src="js/search_form.js"></script>




<div class = "div-table">
    <table>
        <tr>
            <th>ID</th>
            <th>Date Added</th>
            <th>Recipient</th>
            <th>Recipient Type</th>

        </tr>
    <?php foreach($donations as $donation):?>
        <?php $total = get_donation_value($donation["DonationID"]);
        $count= get_count_products($donation["DonationID"]);?>
        <tr class = "row">
            <td><?=$donation["DonationID"]?></td>
            <td><?= $donation["Date"]?></td>
            <td><?php 
                if($donation["EventID"] == NULL){
                    echo $donation["org_name"];
                }else{
                    echo $donation["event_name"];
                }

            ?></td>
            <td><?php 
                if($donation["EventID"] == NULL){
                    echo "Organization";
                }else{
                    echo "Event";
                }?>

            </tr>

            <tr>
        <td colspan="100%">
                <div class="info-shown-div">
                    <div class="info-shown-div-info">
                    <p><strong>Count of Products:</strong> <?=$count["numofProduct"]?></p>
                    <p><strong>Total of Quantity:</strong> <?php if($total["count"] == 0 || $total["count"]== NULL){
                        echo "No Products";
                        }else{ echo $total["count"];
                        }?></p>
                    <p><strong>Total Value Given:</strong> <?php if($total["total"] == 0 || $total["total"]== NULL){
                        echo "No Products";
                        }else{ echo "$" . $total["total"];
                        }?></p>

                    </div>
                    <div class="info-shown-div-links">
                                <a class="feature-url" href="user.php?feature=donationproduct&DonationID=<?=$donation["DonationID"]?>">Show Products</a>
                                <?php if($count["numofProduct"] != 0):?>
                           
                                <?php else:?>
                                <a class="feature-url" onclick="return confirm('Are you sure you want to delete donation <?php
                                if($donation["EventID"] == NULL){
                                    echo $donation["org_name"];
                                }else{
                                    echo $donation["event_name"];
                                }?> from any donation')" href="<?=link_without("") . "&delete={$donation["DonationID"]}"?>" >Delete <?php
                                if($donation["EventID"] == NULL){
                                    echo $donation["org_name"];
                                }else{
                                    echo $donation["event_name"];
                                }
                                ?></a>
                                <?php endif;?>
                     <div>
                </div>
        </td>

        </tr>

    <?php endforeach; ?>
    </table>
            </div>
            <?php $pagination->print_all_links() ?>
<br>