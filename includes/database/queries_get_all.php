<?php
/*****************************************************************************
 *                       SQL PAGE GET ALL FROM TABLE 
 *                                     
 *       This page contains function that uses SQL that is connected to 
 *       the server database from the connect page instead of connecting 
 *       database everytime.
 * 
 ******************************************************************************/

function get_users($search = [],$count = false, $pagination = null){

      // initialize names and id, in case they were entered by user
      $name = "%";
      $name .= isset($search["name"]) ? $search["name"] : "";
      $name .= "%";
      $id = isset($search["id"]) && !empty($search["id"]) ? $search["id"] : "%";
      $role = isset($search["role"]) && $search["role"] !== "all" ? $search["role"] : '%';
      $orderby = "ORDER BY full_name, UserID, Role";
  
     
      if (isset($search["order"])) {
          switch ($search["order"]) {
              case "role":
                  $orderby = "ORDER BY Role, full_name, UserID";
                  break;
              case "id":
                  $orderby = "ORDER BY UserID, full_name, Role";
                  break;
              default:
                  $orderby = "ORDER BY full_name, UserID, Role";
                  break;
          }
      }
    
    $sql = "
            SELECT
                UserID,
                userFirstName,
                userLastName,
                Username,
                Role,
                CONCAT(userLastName, ', ', userFirstName ) AS full_name,
                Phone,
                Email
            From Users
            WHERE UserID LIKE ?
            AND Role LIKE ?
            HAVING full_name LIKE ?
            {$orderby}
        ";

        $params = [$id, $role, $name];
        $types = "sss";
        if ($count)
            return Pagination::get_count_query($sql, $types, $params);
        else if ($pagination !== null)
            return $pagination->get_pagination_query($sql, $types, $params);
        else
            return query_many($sql, $types, $params);
    }

function get_products($search = [],$count = false,$pagination = null){
 
    $name = isset($search["name"]) && !empty($search["name"]) ? $search["name"] : "%";
    $id = isset($search["id"]) && !empty($search["id"]) ? $search["id"] : "%";
    $orderby = "ORDER BY ProductName, ProductID ";

   
    if (isset($search["order"])) {
        switch ($search["order"]) {
            case "id":
                $orderby = "ORDER BY ProductID, ProductName";
                break;
            default:
                $orderby = "ORDER BY ProductName, ProductID";
                break;
        }
    }

    $sql = "
    SELECT 
        ProductID,
        ProductName,
        ProductQuantity,
        ProductUnit,
        EstValue
    From Product
    WHERE ProductID LIKE ?
    HAVING ProductName LIKE ?
    {$orderby}
    ";
    $params = [$id, $name];
        $types = "ss";
        if ($count)
            return Pagination::get_count_query($sql, $types, $params);
        else if ($pagination !== null)
            return $pagination->get_pagination_query($sql, $types, $params);
        else
            return query_many($sql, $types, $params);
}

function get_sum_value(){
    $sql ="
        SELECT 
	        sum(EstValue * ProductQuantity) as sum
        From Product
    ";
    return query_one_np($sql);
}

function get_sum_quantity(){
    $sql = "
        Select
            SUM(ProductQuantity) as sum_quantity
        From Product
    ";
    return query_one_np($sql);
}

function get_organizations($search = [],$count = false, $pagination = null){
    $name = isset($search["name"]) && !empty($search["name"]) ? $search["name"] : "%";
    $id = isset($search["id"]) && !empty($search["id"]) ? $search["id"] : "%";
    $orderby = "ORDER BY OrganizationName, OrganizationID ";

   
    if (isset($search["order"])) {
        switch ($search["order"]) {
            case "id":
                $orderby = "ORDER BY  OrganizationID, OrganizationName";
                break;
            default:
                $orderby = "ORDER BY OrganizationName, OrganizationID";
                break;
        }
    }
    
        $sql = "
            Select 
                OrganizationID,
                OrganizationName,
                OrganizationPhone,
                OrganizationEmail,
                Contact_firstname,
                Contact_lastname,
                CONCAT(Contact_lastname, ', ',Contact_firstname) as full_name_rev,
                CONCAT(Contact_firstname,  ' ', Contact_lastname) as full_name
            From Organization
            WHERE OrganizationID LIKE ?
            AND OrganizationName LIKE ?
            {$orderby}
        ";
        $params = [$id,$name];
    $types = "ss";
   
    if ($count)
        return Pagination::get_count_query($sql, $types, $params);
    else if ($pagination !== null)
        return $pagination->get_pagination_query($sql, $types, $params);
    else
        return query_many($sql, $types, $params);
}

function get_events($search=[],$count = false,$pagination = null){
    $name = isset($search["name"]) && !empty($search["name"]) ? $search["name"] : "%";
    $id = isset($search["id"]) && !empty($search["id"]) ? $search["id"] : "%";
    $orderby = "ORDER BY  EventName, EventID ";

   
    if (isset($search["order"])) {
        switch ($search["order"]) {
            case "id":
                $orderby = "ORDER BY  EventID,  EventName";
                break;
            default:
                $orderby = "ORDER BY  EventName, EventID";
                break;
        }
    }
    
    $sql = "
        SELECT
            EventID,
            EventDate,
            EventName,
            Contact_firstname,
            Contact_lastname,
            Phone,
            Email,
            CONCAT(Contact_lastname, ', ',Contact_firstname) as full_name_rev,
            CONCAT(Contact_firstname,  ' ', Contact_lastname) as full_name,
            DATE_FORMAT(EventDate,'%M %D %Y') as format_date
        From Event
        WHERE EventID LIKE ?
            AND EventDate LIKE ?
        {$orderby}
    ";

    $params = [$id,$name];
    $types = "ss";
   
    if ($count)
        return Pagination::get_count_query($sql, $types, $params);
    else if ($pagination !== null)
        return $pagination->get_pagination_query($sql, $types, $params);
    else
        return query_many($sql, $types, $params);
}

function get_donation($search = [],$count = false, $pagination = null){
    $id = isset($search["id"]) && !empty($search["id"]) ? $search["id"] : "%";
    $event = isset($search["event"]) && !empty($search["event"]) ? $search["event"] : "%";
    $org = isset($search["org"]) && !empty($search["org"]) ? $search["org"] : "%";
    $orderby = "ORDER BY Donation.DonationID";

   
    if (isset($search["order"])) {
        switch ($search["order"]) {
            case "event":
                $orderby = "ORDER BY event_name, Date, org_name, Donation.DonationID";
                break;
            case "org":
                $orderby = "ORDER BY org_name, Donation.DonationID";
                break;
            case "date":
                $orderby = "ORDER BY Date, Donation.DonationID,event_name,org_name";
                break;
            case "id":
                $orderby = "ORDER BY Donation.DonationID, event_name, org_name,Date";
                break;
            default:
                $orderby = "ORDER BY Donation.DonationID, Date,event_name, org_name";
                break;
        }
    }

    $sql = "
    SELECT 
        Donation.DonationID, 
        DATE_FORMAT(Donation.DonationDate, '%M %D %Y  - %h:%i:%s') as Date, 
        Donation.EventID, 
        Donation.OrganizationID, 
        Event.EventName as event_name, 
        Organization.OrganizationName as org_name 
    FROM Donation 
    LEFT OUTER JOIN Organization 
        ON Donation.OrganizationID = Organization.OrganizationID 
    LEFT OUTER JOIN Event 
        ON Donation.EventID = Event.EventID
    WHERE Donation.DonationID LIKE ?
    {$orderby} 
    ";
    
    $params = [$id];
    $types = "s";
    if ($count)
        return Pagination::get_count_query($sql, $types, $params);
    else if ($pagination !== null)
        return $pagination->get_pagination_query($sql, $types, $params);
    else
        return query_many($sql, $types, $params);
}

function get_login(){
    $sql = "
        SELECT 
            Login_Log.UserID,
            Date,
            convert_tz(Date,'+00:00','-06:00') as adjustedDate,          
            Users.Username
        FROM Login_Log
        INNER JOIN Users
        ON Login_Log.UserID = Users.UserID
    ";
    return query_one_np($sql);
}


function product_pdf(){
    $sql ="
    SELECT 
        ProductID,
        ProductName,
        ProductQuantity,
        ProductUnit,
        EstValue,
        IF(ProductQuantity = 0, 'No Items',CONCAT(ProductQuantity, ' ',  ProductUnit))as combine,
        CONCAT('$',EstValue, ' per ', IF(ProductUnit = 'Boxes', 'Box', TRIM(TRAILING 's' FROM ProductUnit))) as value,
        IF(ProductQuantity = 0, 'No Items',CONCAT('$',ProductQuantity * EstValue,'.00')) as total
    From Product 
    ";
    return query_many_np($sql);
}

function report_donation(){
    $sql = "
        SELECT
            Donation.DonationID, 
            DATE_FORMAT(Donation.DonationDate, '%M %D %Y  - %h:%i:%s') as Date, 
            DATE_FORMAT(Donation.DonationDate, '%Y') as Year,
            Donation.EventID, 
            Donation.OrganizationID, 
            Event.EventName as event_name, 
            Organization.OrganizationName as org_name 
        FROM Donation 
        LEFT OUTER JOIN Organization 
        ON Donation.OrganizationID = Organization.OrganizationID 
        LEFT OUTER JOIN Event 
        ON Donation.EventID = Event.EventID
    ";
    return query_many_np($sql);
}

function report_year($search=[],$count = false,$pagination = null){
    
    $year = isset($search["year"]) && !empty($search["year"]) ? $search["year"] : "%";
    $orderby = "ORDER BY Year(DonationDate) ASC";

   
    if (isset($search["order"])) {
        switch ($search["order"]) {
            case "desc":
                $orderby = "ORDER BY  Year(DonationDate) DESC";
                break;
            default:
                $orderby = "ORDER BY Year(DonationDate) ASC";
                break;
        }
    }
    
    
    $sql = "
        Select Distinct 
            Year(DonationDate) as Year
        From Donation
        {$orderby}
    ";
  
    $types = [$year];
    $params = "s";
    if ($count)
        return Pagination::get_count_query($sql, $types, $params);
    else if ($pagination !== null)
        return $pagination->get_pagination_query($sql, $types, $params);
    else
        return query_many($sql, $types, $params);
}

function get_donation_list(){
 $sql = "
    SELECT 
    Donation.DonationID, 
    DATE_FORMAT(Donation.DonationDate, '%M %D %Y  - %h:%i:%s') as Date, 
    Donation.EventID, 
    Donation.OrganizationID, 
    Event.EventName as event_name, 
    Organization.OrganizationName as org_name 
FROM Donation 
LEFT OUTER JOIN Organization 
    ON Donation.OrganizationID = Organization.OrganizationID 
LEFT OUTER JOIN Event 
    ON Donation.EventID = Event.EventID
ORDER BY Date
";
return query_many_np($sql);
}

function get_months(){
    $sql = "
        SELECT
            MonthID,
            MonthName,
            monthabb
        From Constants_Months
    ";
    return query_many_np($sql);
}

function get_quarters(){
    $sql = "
        SELECT 
            QuarterID,
            QuarterNUM,
            QuarterAbbv
        FROM Constants_Quarter
    ";
    return query_many_np($sql);
}
?>  