<?php

    function get_donation_by_id($id){
        $sql="
            SELECT
                DonationProducts.DonationID,
                DonationProducts.ProductID,
                Product.ProductName as item,
                Product.ProductUnit as unit,
                Quantity
            From DonationProducts
            INNER JOIN Product
                ON DonationProducts.ProductID = Product.ProductID
            WHERE DonationID = ?
        
        ";
        return query_many($sql, "s", [$id]);
    }


    function get_products_donated_by($id){
        $sql = "
            SELECT 
                DonationProducts.DonationID, 
                Product.ProductName, 
                Product.ProductUnit,
                DonationProducts.Value,
                DonationProducts.Quantity as productused 
            FROM DonationProducts 
            INNER JOIN Product 
                ON DonationProducts.ProductID = Product.ProductID 
            WHERE DonationProducts.DonationID = ?
        ";

        return query_many($sql,"s", [$id]);
    }

    function get_donation_by_year($year,$search=[],$count = false,$pagination = null){
        $sql = "
        SELECT 
            Donation.DonationID, 
            DATE_FORMAT(Donation.DonationDate, '%M %D %Y') as Date, 
            Donation.EventID, Donation.OrganizationID, 
            Event.EventName as event_name, 
            Organization.OrganizationName as org_name 
            FROM Donation 
            LEFT OUTER JOIN Organization ON 
            Donation.OrganizationID = Organization.OrganizationID 
            LEFT OUTER JOIN Event ON Donation.EventID = Event.EventID 
            WHERE Year(Donation.DonationDate) = ?
        ";

        $params= [$year];
        $types = "s";
    
            return query_many($sql, $types, $params);
    }

    function get_donation_by_year_month($year,$month){
        $sql = "
            SELECT 
                Donation.DonationID, 
                DATE_FORMAT(Donation.DonationDate, '%M %D %Y') as Date, 
                Donation.EventID, Donation.OrganizationID, 
                Event.EventName as event_name, 
                Organization.OrganizationName as org_name 
            FROM Donation 
            LEFT OUTER JOIN Organization ON 
                Donation.OrganizationID = Organization.OrganizationID 
            LEFT OUTER JOIN Event ON Donation.EventID = Event.EventID 
            WHERE Year(Donation.DonationDate) = ? 
            AND Month(Donation.DonationDate) = ?   
        ";
        $params = [$year,$month];
        $types = "ii";
     
            return query_many($sql, $types, $params);
    }

    function get_donation_by_year_quarter($year,$quarter){
        $sql = "
            SELECT 
                Donation.DonationID, 
                DATE_FORMAT(Donation.DonationDate, '%M %D %Y') as Date, 
                Donation.EventID, Donation.OrganizationID, 
                Event.EventName as event_name, 
                Organization.OrganizationName as org_name 
            FROM Donation 
            LEFT OUTER JOIN Organization ON 
                Donation.OrganizationID = Organization.OrganizationID 
            LEFT OUTER JOIN Event ON Donation.EventID = Event.EventID 
            WHERE Year(Donation.DonationDate) = ? 
            AND Quarter(Donation.DonationDate) = ?   
        ";

        $params = [$year,$quarter];
        $types = "ii";
       
            return query_many($sql, $types, $params);
    }
?>