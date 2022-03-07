<?php
    check_user([ADMIN,USER]);

    $DonationID  =  isset($_GET["DonationID"])? $_GET["DonationID"] : "";
    $name = get_rec_name_by_id($DonationID);
    $donated = get_products_donated_by($DonationID);
    $products = get_products();
    $inputs = [];
    $errors = [];
  /*  if($_GET["complete"] === true){
        echo "<h3 style ='color:green'>Product Added</h3>";
    }

    if($_GET["complete"] === false){
        echo "<h3 style='color:red'>Quantity Cannot be Empty</h3>";
    }

*/
    if(isset($_POST["submit_donation"])){
        if ($_POST['newquantity'] === '') {
    
            change_page("user.php?feature=add_productdonation&DonationID={$DonationID}&complete=false");
        }else{

        change_page("user.php?feature=add_productdonation&DonationID={$DonationID}&productID={$_POST["productID"]}&quantity={$_POST["newquantity"]}");
        }
    }

    if(isset($_POST["submit_change"])){
        if ($_POST['changequantity'] === '') {
            change_page("user.php?feature=add_productdonation&DonationID={$DonationID}&complete=false");
        }else{
            change_page("user.php?feature=add_productdonation&DonationID={$DonationID}&productID={$_POST["productID"]}&changequantity={$_POST["changequantity"]}");
        }
    }

    if($_GET["complete"] === true){
        echo "<h3 style ='color:green'>Product Added</h3>";
    }

   

    if(isset($_GET["quantity"])){
        $productID = $_GET["productID"];
        if($_GET["changequantity"]){
            $changequantity = $_GET["changequantity"];
        }else{
            $newquantity = $_GET["quantity"];
        }
      
         $product = get_product_by_id($productID);
        if($_GET["complete"] === 0){
            $errors["quantity"] = "Quantity Cannot be Empty";
        }  
      
        if(isset($product)){
            
            if($productID == $product["ProductID"]){
                if(isset($errors)){
                    echo "<h3 style ='color:red'>". $errors["quantity"] . "</h3>";
                }
         
               
                if(empty($errors)){
                    if(isset($changequantity)){
                        $product_cur = get_product_by_id($productID);
                        $product_cur["ProductQuantity"];
                        $old=get_product_donated($DonationID,$productID);
                       
                        $new_value =  $product_cur["ProductQuantity"] + $old["Quantity"];
                        update_quantity_donation($changequantity,$changequantity * $product["EstValue"],$DonationID,$productID);
                        
                        
                        update_product_quantity($productID,$new_value-$changequantity);
                        echo "<h3 style ='color:green'>Product Added</h3>";
                    }else{
                        insert_donated($DonationID, $productID, $newquantity,$newquantity * $product["EstValue"]);
                        $new_quantity = $product["ProductQuantity"] -  $newquantity;
                        update_product_quantity($productID,$new_quantity);
                        echo "<h3 style ='color:green'>Product Added</h3>";
                    }
                    echo "<h3 style ='color:green'>Product Added</h3>";
                    $input = [];
                    change_page("user.php?feature=add_productdonation&DonationID={$DonationID}&complete=true");
                    
                }

    
        
            }
        }else{
            $errors["quantity"] = "Cannot";
        }
    }


    
    

    


?>

<h1>Add Products to Donation</h1>
<hr>
<div class="who">
    <h1>Items Added to Donation</h1>
</div>

<div class = "div-table">
    <table>
        <tr>
            <th>DonationID</th>
            <th>Product Name</th>
            <th>Donation Quantity</th>
        </tr>

        <?php foreach($donated as $donate):?>
            <tr class = "row">
                <td><?=$donate["DonationID"]?></td>
                <td><?=$donate["ProductName"]?></td>
                <td><?=$donate["productused"]?> <?=$donate["ProductUnit"]?></td>           
            </tr>
            <tr>
            <td colspan="100%">
                <div class="info-shown-div">
                <div class="info-shown-div-info">
                  
                </div>
                <div class="info-shown-div-links">
                <button class="myBtn_multi">Change Quantity</button>


<!-- The Modal -->
<div class="modal modal_multi">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close close_multi">×</span>
        <div class="modal-header">
        <h3>Change Quantity For <?=$donate["ProductName"]?></h3>
        </div>
        <form method="post" class="quantity">
        <div class="form-group">
            <label>Change Quantity</label>
            <input type = "number" min = "1" max="<?php 
                 $product_cur = get_product_by_id($donate["ID"]);
                $all = $product_cur["ProductQuantity"] + $donate["productused"];
                    echo $all; ?>" 
                    value="changequantity" name="changequantity" placeholder="MAX: <?php $product_cur2 = get_product_by_id($donate["ID"]);
                    $all = $product_cur2["ProductQuantity"] + $donate["productused"];
                    echo $all; ?>">
                            <input type ="hidden" value="<?=show_value($donate, "ID")?>" name="productID">
                            
                          
            <br>
        
            <input type="submit" name="submit_change" />
            </form>
        </div>
    </div>
</div>    
            
                </div>
        </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<div class="who">
    <h1>Items available</h1>
</div>
<div class = "div-table">
<table>
        <tr>
            <th>ProductID</th>
            <th>Product Name</th>
            <th>Inventory Quantity</th>
        </tr>

        <?php foreach($products as $product):?>
            <tr class = "row">
                <td><?=$product["ProductID"]?></td>
                <td><?=$product["ProductName"]?></td>
                <td><?php if($product["ProductQuantity"] == 0){
                echo "NO ITEMS AVAILABILE" ;}
                else{echo $product["ProductQuantity"] . ' ' . $product["ProductUnit"];}?> </td>           
            </tr>
            <tr>
            <td colspan="100%">
                <div class="info-shown-div">
                <div class="info-shown-div-info">
                  
                </div>
                <div class="info-shown-div-links"> 
                   <!--<a class="feature-url" href="user.php?feature=quantity&DonationID=<?=$DonationID ?>&ProductID=<?=$product["ProductID"]?>">Add to Donation</a>-->

                    <!-- Trigger/Open The Modal -->
<button class="myBtn_multi">Add Donation to <?=$name["name"]?></button>


<!-- The Modal -->
<div class="modal modal_multi">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close close_multi">×</span>
        <div class="modal-header">
        <h3>Add to Donation </h3>
        </div>
        <form method="post" class="quantity">
      
        <div class="form-group">
        <input type = "number" min = "1" max="<?=$product["ProductQuantity"]?>" value="newquantity" name="newquantity" placeholder="MAX:<?=$product["ProductQuantity"]?>">
                            <input type ="hidden" value="<?=show_value($product, "ProductID")?>" name="productID">
                            <input type="submit" name="submit_donation" >
            </form>
        </div>
    </div>
</div>


            </div>
        </td>
        </tr>
        <?php endforeach; ?>
    </table> 

</div>