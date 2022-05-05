<?php
    check_user([ADMIN,USER]);
    
    $DonationID  =  isset($_GET["DonationID"])? $_GET["DonationID"] : "";
    $pagination = new Pagination(PAGES_DONATIONPRODUCT, $_GET, $DonationID);
    $donations = get_donation_by_id($DonationID,$_GET,false,$pagination);
    $recipient = get_donation_name_by_id($DonationID);

    function validate_quantity($input){
        $errors=[];
     
        if(!isset($input["productID"]) || empty($input["productID"])){
            $errors["productID"]  = "NO VALUED PRODUCT";
        }

        $invent = get_product_by_id($input["productID"]);

        if(!isset($input["changequantity"]) || empty($input["changequantity"])){
            $errors["changequantity"] = "No Quantity to change";
        }else if($input["changequantity"] < 0){
            $errors["changequantity"] = "Cannot be less than 0";
        }else if($input["changequantity"] > ($invent["ProductQuantity"]+$input["changequantity"])){
            $errors["changequantity"] = "DO NOT HAVE INVENTORY FOR DONATION";
        }

        

        return $errors;
    }


$errors = [];
$input = [];

    if(isset($_POST["submit_quantity"])){
        $errors = validate_quantity($_POST);
       
        
        if(empty($errors)){
            $product_cur = get_product_by_id($_POST["productID"]);
            $old=get_product_donated($DonationID,$_POST["productID"]);
            
            $new_value =  $product_cur["ProductQuantity"] + $old["Quantity"];
            update_quantity_donation($_POST["changequantity"],$_POST["changequantity"] * $product_cur["EstValue"],$DonationID,$_POST["productID"]);

            update_product_quantity($_POST["productID"],$new_value-$_POST["changequantity"]);
            $input = clean_array($_POST);
            change_page("user.php?feature=donationproduct&DonationID={$DonationID}&productID={$_POST["productID"]}");
            
        }
    }

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
    <?php $link = "productsperdonation.php?DonationID=" . $DonationID;
     if($recipient["EventID"] == NULL){
        $name =  $recipient["org_name"];
    }else{
        $name =  $recipient["event_name"];
    }
    
    echo '<a class="feature-url" href="'. $link .'">Donations For '. $name .' </a>';?>

 
<h3 class='total-count'><?= $pagination->get_total_rows() ?> Item(s)</h3>


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
                    <button class="myBtn_multi">Change Quantity</button>
        
        <div class="modal modal_multi">
        
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close close_multi">×</span>
                <div class="modal-header">
                <h3>Change Quantity for <?=$donation["item"]?></h3>
                </div>
                <form method="post" class="quantity">
                
                <div class="form-group">
                    <label style="width:90%;align-self:center">Change Quantity for <?=$donation["item"]?></label>
                    <input style="width:90%;align-self:center"<?= error_outline($errors,"changequantity") ?> type = "number" min = "1" max="<?php 
                        $product_cur = get_product_by_id($donation["ProductID"]);
                        $all = $product_cur["ProductQuantity"] + $donation["Quantity"];
                        echo $all;                    
                    ?>" 
                    
                

                    value="<?=show_value($input,"changequantity")?>" name="changequantity" placeholder="MAX: <?php
                         $product_cur = get_product_by_id($donation["ProductID"]);
                         $all = $product_cur["ProductQuantity"] + $donation["Quantity"];
                         echo $all;  
                    ?>">

                    <?=show_error($errors, "changequantity")?>
                    <br>
                    <?=show_error($errors, "productID")?>
                    <input name="productID" value="<?=show_value($donation,"ProductID")?>" type="text" hidden/>
                
                    <input style="width:90%;align-self:center" type="submit" name="submit_quantity" />
                    </form>
                </div>
            </div>
        </div>
                     <div>
                </div>
        </td>

        </tr>
        <?php endforeach; ?>
</table>
    </div>
    <?php $pagination->print_all_links() ?>
    <br>