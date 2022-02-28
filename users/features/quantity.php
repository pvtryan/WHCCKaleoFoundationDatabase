<?php
        check_user([ADMIN,USER]);
        
        $DonationID  =  isset($_GET["DonationID"])? $_GET["DonationID"] : "";
        $ProductID = isset($_GET["ProductID"])? $_GET["ProductID"] : "";
        $product = get_product_by_id($ProductID);
        $cnt = 1;
        
    function validate_new_quantity($input,$product){
        $errors = [];
        if(!isset($input['quantity']) || empty($input['quantity'])){
            $errors['quantity'] = "Quantity Required";
        }else if(strlen($input['quantity']) > 50){
            $errors['quantity'] = "Max 50 characters for First Name";
        }else if($input['quantity'] >  $product["ProductQuantity"]){
            $errors['quantity'] = "Don't have enough Inventory";
        }


        return $errors;
    }
        $input = [];
        $errors = []; 
    //if no errors procede in the adding of new user
    
    if(isset($_POST["submit_new_quantity"])){
        $errors = validate_new_quantity($_POST,$product);
        $input = clean_array($_POST);
        if(empty($errors)){
            insert_donated($DonationID, $ProductID,$_POST["quantity"]);
            $new_quantity = $product["ProductQuantity"] - $_POST["quantity"];
            update_product_quantity($ProductID,$new_quantity);
            echo "<h3 style ='color:green'>Product Added</h3>";
            $input = [];
            change_page("user.php?feature=add_productdonation&DonationID={$DonationID}");
        }


    
    }

?>


<h1>Quantity</h1>
<hr>
    <div class="who">
    <h3><?= $DonationID?></h3>
    <h3><?= $ProductID?></h3>
    </div>
<form method = "post" class="form">

 
    <div class = "form-group">
        <label>Quantity</label>
        <input <?= error_outline($errors,"quantity") ?> type="text" name="quantity" value="<?=show_value($product,"quantity")?>" required>
        <?=show_error($errors, "quantity")?>
    </div>

    <input type="submit" name="submit_new_quantity" >
      

</form>