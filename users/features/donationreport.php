<?php
   check_user([ADMIN,USER]);
   
   $year  =  isset($_GET["Year"])? $_GET["Year"] : "";
    if(isset($_GET["Month"])){
        $pagination = new Pagination(PAGES_DONATIONREPORTMONTH, $_GET,$year,$_GET["Month"]);
        $month = isset($_GET["Month"])? $_GET["Month"] : "";
        $donations=get_donation_by_year_month($year,$month);
        $info = get_info_by_year_month($year,$month);
        $name = get_monthname($month);
    }else if(isset($_GET["Quarter"])){
        $pagination = new Pagination(PAGES_DONATIONREPORTQUARTER, $_GET,$year,$_GET["Quarter"]);
        $quarter = isset($_GET["Quarter"])? $_GET["Quarter"] : "";
        $donations = get_donation_by_year_quarter($year,$quarter);
        $info = get_info_by_year_quarter($year,$quarter);
        $name = get_quarter($quarter);
    }else{
        $pagination = new Pagination(PAGES_DONATIONREPORTYEAR, $_GET,$year);
        $donations = get_donation_by_year($year,$_GET,false,$pagination);
        $info = get_info_by_year($year);
        
    }
    
?>
<h1>Donation report for <?php
            if(isset($_GET["Month"])){
                echo $name["MonthName"] . " in " . $year;
            }else if(isset($_GET["Quarter"])){
                echo $name["QuarterNUM"] . " Quarter of " . $year ;
            }else{
                echo $year;
            }
            ?></h1>
<hr>
    <?php
        if(isset($_GET["Month"])){
            $link = "donationreportpdf.php?Year=" . $year . "&Month=" . $month;
            echo '<a class="feature-url" href="' . $link . '">Report PDF</a>';
            
        }else if(isset($_GET["Quarter"])){
            $link = "donationreportpdf.php?Year=" . $year . "&Quarter=" . $quarter;
            echo '<a class="feature-url" href="' . $link . '">Report PDF</a>';
  
        }else{

            $link = "donationreportpdf.php?Year=" . $year;
            echo '<a class="feature-url" href="' . $link . '">Report PDF</a>';
            
        }

    ?>

<h3 class='total-count'><?=$pagination->get_total_rows()?> Item(s)</h3>


  <div class="who">
    <h3>Count of Products Given: <?= $info["countnum"]?> Product(s)</h3>
    <h3>Total Quantity: <?php
                if($info["total_quantity"] === 0 || $info["total_quantity"] == NULL){
                    echo "NO ITEMS DONATED";
                }else{
                    echo $info["total_quantity"];
                }
                ?></h3>
                
    <h3>Total Value in <?php
            if(isset($_GET["Month"])){
                echo $name["MonthName"] . " in " . $year;
            }else if(isset($_GET["Quarter"])){
                echo $name["QuarterNUM"] . " Quarter of " . $year ;
            }else{
                echo $year;
            }
            ?>: <?php if($info["total_value"] === 0 || $info["total_value"] == NULL){
                            echo "NO ITEMS DONATED";
                    }else{
                        echo "$". $info["total_value"];
                 }?></h3>

            <h3> Total Count: <?php 
                 $cnt;
                 if(isset($_GET["Month"])){
                    $cnt = count_donation_year_month($year,$month);
                }else if(isset($_GET["Quarter"])){
                    $cnt = count_donation_year_quarter($year,$quarter);
                }else{
                    $cnt = count_donation_year($year);
                }   

                echo $cnt["cnt"];
                ?></h3>
    </div>
	
    
<div class = "div-table">
    <table > 
        <tr>
            <th>ID</th>
            <th>Date Added</th>
            <th>Recipient</th>
            <th>Recipient Type</th>
    </tr>
    <?php foreach($donations as $donation):?>
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
                      <?php $value= get_donation_value($donation["DonationID"])?>
                        <p><strong>Total Value of Donation:</strong>$ <?=$value["total"]?></p>
                        <?php
                            if($donation["EventID"] == NULL){
                              $name = $donation["org_name"];
                           }else{
                               $name  = $donation["event_name"];
                           }
                       
                            $link = "productsperdonation.php?DonationID=" . $donation["DonationID"] ;
                        echo '<a class="feature-url" href="' . $link .'">Donations For '. $name .' </a>';?>
                        <button class="myBtn_multi">DonationS For <?php 
                            if($donation["EventID"] == NULL){
                                 echo $donation["org_name"];
                            }else{
                                echo $donation["event_name"];
                            }?> </button>
        
<div class="modal modal_multi">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close close_multi">×</span>
        <div class="modal-header">
        <h3><strong>Products Donated:</strong></h3>
        </div>
                            
                    <?php $products = get_products_donated_by($donation["DonationID"])?>
                    <?php foreach($products as $product):?>
                            <p><?=$product["ProductName"]?> - $<?=$product["Value"]?></p>
                        <?php endforeach;?>
    </div>
</div>
           
           
                        
                    </div>
                </div>
        </td>
        </tr>
    <?php endforeach; ?>
    </table>

</div>
<?php $pagination->print_all_links() ?>
<br>
<br>