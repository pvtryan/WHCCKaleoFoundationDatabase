<?php
    function get_info_all(){
        $sql="
            SELECT
                COUNT(DonationProducts.ProductID) AS countnum, 
                SUM(DonationProducts.Quantity) as total_quantity, 
                FORMAT(SUM(DonationProducts.Value),2) as total_value 
            FROM DonationProducts 
            INNER JOIN Donation 
                ON DonationProducts.DonationID = Donation.DonationID
            ";
        return query_one_np($sql);
    } 
?>