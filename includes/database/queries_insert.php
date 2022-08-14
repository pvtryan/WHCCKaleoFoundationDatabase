<?php
    function insert_product($ProductName,$ProductQuantity,$ProductUnit,$EstValue){
            $sql = "
            INSERT INTO Product(ProductName,ProductQuantity,ProductUnit,EstValue)
            VALUES(?,?,?,?);
            ";
            return query($sql, "sisi",[$ProductName,$ProductQuantity,$ProductUnit,$EstValue]);
    }

    function insert_user($userFirstName,$userLastName,$Username,$Password,$Role,$phone,$userEmail){
        $sql = "
            INSERT INTO Users(userFirstName,userLastName,Username,Password,Role,Phone,Email)
            VALUES(?,?,?,?,?,?,?);
        ";
        return query($sql,"ssssiss", [$userFirstName,$userLastName,$Username,$Password,$Role,$phone,$userEmail]);
    }


    function insert_events($eventdate,$eventname,$firstname,$lastname,$phone,$email){
        $sql = "
            INSERT INTO Event(EventDate,EventName,Contact_firstname,Contact_lastname,Phone,Email)
            VALUES(?,?,?,?,?,?);
        ";
        return query($sql, "ssssss" , [$eventdate,$eventname,$firstname,$lastname,$phone,$email]);

    }

    function insert_organization($orgname,$firstname,$lastname,$phone,$email){
        $sql = "
            INSERT INTO Organization(OrganizationName,Contact_firstname,Contact_lastname,OrganizationPhone,OrganizationEmail)
            VALUES(?,?,?,?,?);
        ";
        return query($sql, "sssss" , [$orgname,$firstname,$lastname,$phone,$email]);

    }

    function insert_donation($eventID,$OrgID){
        $sql = "
            INSERT INTO Donation(DonationDate,EventID,OrganizationID)
            VALUES(CURRENT_TIMESTAMP(),?,?);
        ";
        return query($sql,"ii",[$eventID,$OrgID]);
    }

    function insert_donated($donationID,$ProductID,$Quantity,$value){
        $sql = "
            INSERT INTO DonationProducts(DonationID,ProductID,Quantity,Value)
            VALUES(?,?,?,?);
        ";
        return query($sql, "iiii", [$donationID,$ProductID,$Quantity,$value]);
    }

    function insert_logindate($userID,$IP){
        $sql = "
            INSERT INTO Login_Log(UserID,Date,ip_address)
            VALUES(?,CURRENT_TIMESTAMP(),?);
        ";
        return query($sql, "is", [$userID,$IP]);
    }


    function insert_donation_event($eventID){
        $sql = "
            INSERT INTO Donation(DonationDate,EventID)
            VALUES(CURRENT_TIMESTAMP(),?);
        ";
        return query($sql,"i",[$eventID]);
    }


    function insert_donation_org($OrgID){
        $sql = "
            INSERT INTO Donation(DonationDate,OrganizationID)
            VALUES(CURRENT_TIMESTAMP(),?);
        ";
        return query($sql,"i",[$OrgID]);
    }

    function insert_vistors($ip){
        $sql = "
            INSERT INTO Vistors($ip,Date)
            VALUES(?,CURRENT_TIMESTAMP())
        ";
        return query($sql,"s", [$ip]);
    }

?>
