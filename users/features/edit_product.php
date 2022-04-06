<?php
check_user([ADMIN,USER]);
$productID = isset($_GET["ProductID"])? $_GET["ProductID"] : "";

$product=get_product_by_id($productID);

function validate_product($input){
    $errors = [];

    if(!isset($input['productname']) || empty($input['productname'])){
        $errors['productname'] = "Product Name is Required";
      }else if(strlen($input['productname']) > 50){
        $errors['productname'] = "Max 50 characters for Product Name";
      } 


    if(!isset($input['quantity']) || empty($input['quantity'])){
        $errors['quantity'] = "Quantity Required";
    }else if(strlen($input['quantity']) > 50){
        $errors['quantity'] = "Max 50 characters for First Name";
    }

    if(!isset($input['estvalue']) || empty($input['estvalue'])){
        $errors['estvalue'] = "Value Quantity Required";
    }else if(strlen($input['estvalue']) > 50){
        $errors['estvalue'] = "Max 50 characters for First Name";
    }

    if(!isset($input['productunits']) || empty($input["productunits"])){
        $errors['productunits'] = "Productunit is incorrect";
    }

    return $errors;
}

    $errors = [];
    $input = [];

    if(isset($_POST["submit_update_product"])){
            $errors = validate_product($_POST);
            $input = clean_array($_POST);
            if(empty($errors)){
                update_product_info($productID,$_POST["productname"],$_POST["quantity"], $_POST["productunits"],$_POST["estvalue"]);
                echo "<h3 style='color:green'>Updated ". $_POST["productname"] ."</h3>";
                $input = [];
            }
    }

?>

<h3>Editing Product <?=$product["ProductName"]?></h3>
<hr>

<form method="post" class="form">
    
    <div class="form-group">
        <label>Product Name</label>
        <input <?= error_outline($errors, "productname")?> type="text" name="productname" value="<?=show_value($product, "ProductName")?>" >
        <?=show_error($errors,"productname")?>
    </div>

    
    <div class="form-group">
        <label>Quantity</label>
        <input <?= error_outline($errors, "quantity")?> type="text" name="quantity" value="<?=show_value($product, "ProductQuantity")?>" >
        <?=show_error($errors,"quantity")?>
    </div>

    
    <div class="form-group">
        <label>Product Unit</label>
        <input <?=error_outline($errors, "productunits")?> type="text" name="productunits" value="<?=show_value($product,"ProductUnit")?>" >
        <?=show_error($errors,"productunits")?>
    </div>

    
    <div class="form-group">
        <label>Estimated Price per <?=$product["ProductUnit"]?></label>
        <input <?=error_outline($errors,"estvalue")?> type="text" name="estvalue" value="<?=show_value($product,"EstValue")?>" >
        <?=show_error($errors, "estvalue")?>
        </div>

<input type="submit" name="submit_update_product" >
</form>