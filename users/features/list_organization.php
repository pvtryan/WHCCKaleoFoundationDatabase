<?php 
check_user([ADMIN,USER]);

$pagination = new Pagination(PAGES_ORGANIZATION, $_GET);
$organizations = get_organizations($_GET,false,$pagination);
$input = clean_array($_GET);


?>

<h1>Organizations</h1>
<hr>
<?php if($role === ADMIN || $role === USER): ?>
    <a class="feature-url"  href="user.php?feature=add_organization">Add Org.</a>
    <a class="feature-url"  href="organizationlist.php">Generate PDF</a>
<?php endif; ?>

<h3 class='total-count'><?= $pagination->get_total_rows() ?> Organization(s)</h3>

<button class="search-button">Search</button>

<div class="backdrop"></div>

<form method="GET" class="search-form">
<input name="feature" value="list_organization" type="text" hidden/>
<div>
    <label>Organization Name: </label>
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
            <th>OrganizationID</th>
            <th>Name</th>
            <th>Contact</th>
        </tr>
            <?php foreach($organizations as $organization):?>
                <tr class = "row">
                    <td><?=$organization["OrganizationID"]?></td>
                    <td><?=$organization["OrganizationName"]?></td>
                    <td><?=$organization["full_name_rev"]?></td>

                </tr>

               <tr>
            <td colspan="100%">
                <div class="info-shown-div">
                    <div class="info-shown-div-info">
                        <p><strong>Contact: </strong><?=$organization["full_name"]?></p>
                        <p><strong>Contact Email: </strong><?=$organization["OrganizationEmail"]?></p>
                        <p><strong>Contact Phone: </strong><?=$organization["OrganizationPhone"]?></p>
                  </div>
                  <div class="info-shown-div-links">
                        <a class="feature-url" href="user.php?feature=edit_organization&OrganizationID=<?=$organization["OrganizationID"]?>">Edit <?= $organization["OrganizationName"]?></a>
                        <a class="feature-url">Delete <?= $organization["OrganizationName"]?></a>
                    </div>
                </div>
            </td>
            </tr>
            <?php endforeach;?>
    </table>
</div>
<?php $pagination->print_all_links() ?>
<br>