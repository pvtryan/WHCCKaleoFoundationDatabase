<?php
    check_user([ADMIN,USER]);
    $pagination = new Pagination(PAGES_REPORT, $_GET);



    $reports = report_year($_GET,false,$pagination);
    $input = clean_array($_GET);
    $months = get_months();
    $quarters = get_quarters();
?>
<h1>Reports</h1>
<hr>

<a class="feature-url" href="alldonation.php" >Report PDF</a>
<h3 class='total-count'><?= $pagination->get_total_rows() ?> Item(s)</h3>

<button class="search-button">Search</button>

<div class="backdrop"></div>

<form method="GET" class="search-form">
    <input name="feature" value="list_report" type="text" hidden/>

    <div>
        <label>Year: </label>
        <input type="text" name="year" value="<?= show_value($input,"year") ?>" />
    </div>
  

    <div>
        <label>Order by: </label>
        <select name="order">
            <option value="asc" <?= check_select($input,"order","asc") ?>>Ascending Order</option>
            <option value="desc" <?= check_select($input,"order","desc") ?>>Descending Order</option>
        </select>
    </div>
    <input type="submit" value="Search" />
</form>

<script src="js/search_form.js"></script>


<div class = "div-table">
    <table>
        <tr>
            <th>Year(s)</th>

        </tr>
        <?php foreach($reports as $report):?>
            <tr class = "row">
                <td><?=$report["Year"]?></td>
            </tr>
            <tr>
        <td colspan="100%">
                <div class="info-shown-div">
                    <div class="info-shown-div-info">
                    <a class="feature-url" href="user.php?feature=donationreport&Year=<?=$report["Year"]?>">Donation for all of <?=$report["Year"]?></a>

              

<!-- Trigger/Open The Modal -->
<button class="myBtn_multi">Donation For Month in <?=$report["Year"]?></button>


<!-- The Modal -->
<div class="modal modal_multi">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close close_multi">×</span>
        <div class="modal-header">
        <h3>Donation for <?=$report["Year"]?></h3>
        </div>
        <form method="GET" class="months">
        <input name="feature" value="donationreport" type="text" hidden/>
        <div class="form-group">
            <label>Month for reports</label>
            <input type="text" name="Year" value="<?=show_value($report, "Year")?>" hidden>

            <select  name="Month"  required>

            <option selected disabled hidden></option>
            <?php foreach($months as $month):?>
            <option  value ="<?=$month["MonthID"]?>"><?=$month["MonthName"]?></option>
            <?php endforeach; ?>
            </select>
            <br>
        
            <input type="submit" value="Submit" />
            </form>
        </div>
    </div>
</div>

<button class="myBtn_multi">Donation For Quarter in <?=$report["Year"]?></button>
        
<div class="modal modal_multi">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close close_multi">×</span>
        <div class="modal-header">
        <h3>Donation for <?=$report["Year"]?></h3>
        </div>
        <form method="GET" class="quarter">
        <input name="feature" value="donationreport" type="text" hidden/>
        <div class="form-group">
            <label>Quarter for reports</label>
            <input type="text" name="Year" value="<?=show_value($report, "Year")?>" hidden>
            <select  name="Quarter" required>

                <option selected disabled hidden></option>
                <?php foreach($quarters as $quarter):?>
                    <option  value ="<?=$quarter["QuarterID"]?>"><?=$quarter["QuarterNUM"]?> - <?=$quarter["QuarterAbbv"]?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <input type="submit" value="Submit" />
            </form>
        </div>
    </div>
</div>
            </div>
</div>
</div>       
        </td>
        </tr>
        <?php endforeach;?>
    </table>
</div>
<?php $pagination->print_all_links() ?>
<br>