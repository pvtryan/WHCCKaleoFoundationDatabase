<?php
 check_user([ADMIN,USER]);

    function validate_new_product($input){
        $errors = [];

        if(!isset($input['product_name']) || empty($input['product_name'])){
            $errors['product_name'] = "Product Name is Required";
          }else if(strlen($input['product_name']) > 50){
            $errors['product_name'] = "Max 50 characters for Product Name";
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
        
    
        $input = [];
        $errors = []; 
    //if no errors procede in the adding of new user
    
    if(isset($_POST["submit_new_product"])){
        $errors = validate_new_product($_POST);
        $input = clean_array($_POST);
        
        if(empty($errors)){
         insert_product($_POST["product_name"],$_POST["quantity"],$_POST["productunits"],$_POST["estvalue"]);
          echo "<h3 style ='color:green'>Product Added</h3>";
            $input = [];
        }
    }

    


?>
<h1>Add Inventory</h1>
<hr>

<form method="post" class="form">
    <div class = "form-group">
        <label>Product Name</label>
        <input <?= error_outline($errors,"product_name") ?> type="text" name="product_name" value="<?=show_value($input,"product_name")?>" >
        <?=show_error($errors, "product_name")?>
    </div>

    <div class = "form-group">
        <label>Quantity</label>
        <input <?= error_outline($errors,"quantity") ?> type="text" name="quantity" value="<?=show_value($input,"quantity")?>" >
        <?=show_error($errors, "quantity")?>
    </div>

    <div class = "form-group">
        <label>Est. Value</label>
        <input <?= error_outline($errors,"estvalue") ?> type="text" name="estvalue" value="<?=show_value($input,"estvalue")?>" >
        <?=show_error($errors, "estvalue")?>
    </div>

    <div class="form-group">
        <label>Product Units</label>
        <select <?= error_outline($errors, "productunits") ?> name="productunits" >
            <option selected disabled hidden></option>
            <option <?= check_select($input,"productunits", "Cases") ?> value="Cases">Cases</option>
            <option <?= check_select($input,"productunits","Boxes") ?> value="Boxes">Boxes</option>
            <option <?= check_select($input,"productunits","Pallets") ?> value="Pallets">Pallets</option>
            <option <?= check_select($input,"productunits","Bags") ?> value="Bags">Bags</option>
        </select>
        <?=show_error($errors, "productunits")?>
    </div>

    <input type="submit" name="submit_new_product" >
</form>