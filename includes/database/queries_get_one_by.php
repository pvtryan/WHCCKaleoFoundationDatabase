<?php

    function get_user_by_username($username){
            $sql = "
            SELECT 
                 UserID,
                 userFirstName,
                 userLastName,
                 Username,
                 Password,
                 Role,
                 Phone,
                 Email
            FROM Users 
            WHERE Username = ?
            ";

            return query_one_no_clean($sql, "s", [$username]);
    }

    function get_user_role($id){
        $sql = "
            SELECT 
                Role 
            From Users 
            Where UserID = ?
        ";

        return query_one_no_clean($sql, "s", [$id]);
    }

    function get_user_by_id($id){
        $sql="
            SELECT 
                    UserID,
                    Username,
                    Password,
                    userFirstName,
                    userLastName,
                    CONCAT(userLastName, ', ', userFirstName) as full_name_rev,
                    CONCAT( userFirstName,  ' ', userLastName) as full_name,
                    Role,
                    Email,
                    Phone
            From Users
            WHERE UserID = ?
        ";

        return query_one_no_clean($sql, "s", [$id]);
    }

    function get_donation_name_by_id($id){
        
        $sql ="
        SELECT
        Donation.DonationID, 
        DATE_FORMAT(Donation.DonationDate, '%M %D %Y %h:%i:%s') as Date, 
        Donation.EventID, 
        Donation.OrganizationID, 
        Event.EventName as event_name, 
        Organization.OrganizationName as org_name 
    FROM Donation 
    LEFT OUTER JOIN Organization 
        ON Donation.OrganizationID = Organization.OrganizationID 
    LEFT OUTER JOIN Event 
        ON Donation.EventID = Event.EventID 
        WHERE Donation.DonationID = ?
        ";
        return query_one_no_clean($sql, "s", [$id]);
    }

    function get_product_by_id($id){
        $sql = "
            SELECT 
                ProductID,
                ProductName,
                ProductQuantity,
                ProductUnit,
                EstValue
            From Product
            WHERE ProductID = ?
        ";

        return query_one_no_clean($sql, "s", [$id]);
    }

    function get_event_by_id($id){
        $sql = "
            SELECT
            EventID,
            EventDate,
            EventName,
            Contact_firstname,
            Contact_lastname,
            CONCAT(Contact_lastname, ', ', Contact_firstname) as full_name,
            Phone,
            Email
            From Event
            WHERE EventID = ?
        ";

        return query_one_no_clean($sql, "s", [$id]);
    }

    function get_donation_value($id){
        $sql="
            select
                sum(Value) as total,
                sum(Quantity) as count
            from DonationProducts
            where DonationID = ?
        ";
        return query_one_no_clean($sql,"s", [$id]);
    }


    function get_count_products($id){
        $sql = "
            select 
                COUNT(ProductID) as numofProduct
            from DonationProducts
            WHERE DonationID = ?
           
        ";
        return query_one_no_clean($sql,"s",[$id]);
    }


    function get_value_per_donation($id){
        $sql="
            select 
                sum(Quantity * Value) as total_value
            From DonationProduct
            WHERE DonationID = ?
        ";

        return query_one_no_clean($sql,"s",[$id]);
    }

    function get_value_of_donation($id){
        $sql ="
            SELECT 
                FORMAT(SUM(Value),2) as total
            FROM DonationProducts
            WHERE DonationID = ?
        ";
        return query_one_no_clean($sql,"s",[$id]);
    }

    function get_info_by_year($year){
        $sql = "
        SELECT
            COUNT(DonationProducts.ProductID) AS countnum, 
            SUM(DonationProducts.Quantity) as total_quantity, 
            FORMAT(SUM(DonationProducts.Value),2) as total_value 
        FROM DonationProducts 
        INNER JOIN Donation 
        ON DonationProducts.DonationID = Donation.DonationID 
        WHERE Year(Donation.DonationDate) = ?
        ";
        return query_one_no_clean($sql, "i" , [$year]);
}

function get_info_by_year_month($year,$month){
    $sql = "
    SELECT
        COUNT(DonationProducts.ProductID) AS countnum, 
        SUM(DonationProducts.Quantity) as total_quantity, 
        FORMAT(SUM(DonationProducts.Value),2) as total_value 
    FROM DonationProducts 
    INNER JOIN Donation 
    ON DonationProducts.DonationID = Donation.DonationID 
    WHERE Year(Donation.DonationDate) = ?
    AND Month(Donation.DonationDate) = ?
    ";
    return query_one_no_clean($sql, "ii" , [$year,$month]);

}

function get_monthname($month){
    $sql = "
        SELECT 
            MonthID,
            MonthName,
            Monthabb
        From Constants_Months
        Where MonthID = ?
    ";
    return query_one_no_clean($sql, "i" , [$month]);
}

function get_info_by_year_quarter($year,$quarter){
    $sql = "
    SELECT
        COUNT(DonationProducts.ProductID) AS countnum, 
        SUM(DonationProducts.Quantity) as total_quantity, 
        FORMAT(SUM(DonationProducts.Value),2) as total_value 
    FROM DonationProducts 
    INNER JOIN Donation 
    ON DonationProducts.DonationID = Donation.DonationID 
    WHERE Year(Donation.DonationDate) = ?
    AND Quarter(Donation.DonationDate) = ?
    ";
    return query_one_no_clean($sql, "ii" , [$year,$quarter]);
}

function get_quarter($quarter){
    $sql ="
        SELECT 
            QuarterID,
            QuarterNUM,
            QuarterAbbv
        FROM Constants_Quarter
        Where QuarterID = ?
    ";
    return query_one_no_clean($sql, "i" , [$quarter]);
}

function get_rec_name_by_id($id){
    $sql ="
    SELECT
    Donation.DonationID, 
    if(Event.EventName = NULL,
    Event.EventName,
    Organization.OrganizationName) as name
FROM Donation 
LEFT OUTER JOIN Organization 
    ON Donation.OrganizationID = Organization.OrganizationID 
LEFT OUTER JOIN Event 
    ON Donation.EventID = Event.EventID 
    WHERE Donation.DonationID = ?
    ";
    return query_one_no_clean($sql, "s", [$id]);
}

function get_product_donated($donationID,$productID){
    $sql = "
        SELECT 
        Quantity,
        Value
        FROM DonationProducts 
        WHERE DonationID = ? 
        AND ProductID = ?
    ";

    return query_one_no_clean($sql, "ii", [$donationID,$productID]);
}

function get_organization_id($id){
    $sql="
        SELECT 
            OrganizationID,
            OrganizationName,
            Contact_firstname,
            Contact_lastname,
            OrganizationPhone,
            OrganizationEmail
        From Organization
    ";
    return query_one_no_clean($sql, "i", [$id]);
}

?>