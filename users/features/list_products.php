<?php
    check_user([ADMIN,USER]);


    $pagination = new Pagination(PAGES_INVENTORY, $_GET);
    $products = get_products($_GET,false,$pagination);
    $input = clean_array($_GET);



   

?>

<h1>Inventory</h1>
<hr>

    <a class="feature-url"  href="user.php?feature=add_product">Add Product</a>
    <a class="feature-url"  href="itemlist.php">Generate PDF</a>
    <h3 class='total-count'><?= $pagination->get_total_rows() ?> Item(s)</h3>

    <button class="search-button">Search</button>

<div class="backdrop"></div>

<form method="GET" class="search-form">
    <input name="feature" value="list_products" type="text" hidden/>
    <div>
        <label>Item Name: </label>
        <input  type="text" name="name" value="<?= show_value($input,"name") ?>" />
    </div>
    <div>
        <label>ID: </label>
        <input type="text" name="id" value="<?= show_value($input,"id") ?>" />
    </div>
    
    
    <div>
        <label>Order by: </label>
        <select name="order">
            <option value="name" <?= check_select($input,"order","name") ?>>Name</option>
            <option value="id" <?= check_select($input,"order","id") ?>>ID</option>
        </select>
    </div>
    <input type="submit" value="Search" />
</form>

<script src="js/search_form.js"></script>

<div class="div-table">
	<table>
        <tr>
            <th>ID</th>
            <th>Item Name</th>
            <th>Item Quantity</th>
        </tr>
        <?php foreach($products as $product): ?>
            <tr class="row">
            <td><?=$product["ProductID"]?></td>
            <td><?=$product["ProductName"]?></td>
            <td><?php if($product["ProductQuantity"] == 0){
                echo "NO ITEMS AVAILABILE" ;}
                else{echo $product["ProductQuantity"] . ' ' . $product["ProductUnit"];}?> 
            </td>
            
        </tr>

        <tr>
        <td colspan="100%">
                <div class="info-shown-div">
                    <div class="info-shown-div-info">
                           <p><strong>Unit: </strong><?=$product["ProductUnit"]?></p>
                           <p><strong>Estimated Price Per <?=$product["ProductUnit"]?>: $</strong><?=$product["EstValue"]?>.00</p>
                    </div>
                    <div class="info-shown-div-links">
                        <a class="feature-url" href="user.php?feature=edit_product&ProductID=<?=$product["ProductID"]?>">Edit Product</a>
                        <a class="feature-url" href="">Delete Item</a>
                    </div>
                </div>
        </td>

        </tr>
        <?php endforeach;?>
    </table>
</div>
<?php $pagination->print_all_links() ?>
<br>