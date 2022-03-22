<?php

    function update_password($userid, $password){
        $sql = "
            UPDATE Users SET
            Password = ?
            where UserID = ?
        ";
        return query($sql, "ss", [$password, $userid]);
    }

    function update_user_info($userid,$userfirstname,$userlastname,$username,$role,$phone,$email){
        $sql = "
        UPDATE Users SET
        userFirstName = ?,
        userLastName = ?,
        Username = ?,
        Role = ?,
        Phone = ?,
        Email = ?
        WHERE UserID = ?
        ";
        return query($sql, "ssssssi", [$userfirstname,$userlastname,$username,$role,$phone,$email,$userid]);
    }

    function update_product_quantity($id,$quantity){
        $sql = "
            UPDATE Product SET
            ProductQuantity = ?
            WHERE ProductID = ?
        ";
        return query($sql, "ii", [$quantity,$id]);
    }

    function update_product_info($id,$name,$quantity, $unit,$value){
        $sql="
            UPDATE Product SET
            ProductName = ?,
            ProductQuantity = ?,
            ProductUnit = ?,
            EstValue = ?
            WHERE ProductID = ?
        ";
        return query($sql, "sisii",[$name,$quantity, $unit, $value,$id]);
    }

    function update_quantity_donation($quantity,$value,$donationID,$productID){
        $sql="
            UPDATE DonationProducts 
            SET Quantity = ?, Value = ?
            WHERE DonationID = ? AND ProductID = ?
        ";
        return query($sql,"iiii",[$quantity,$value,$donationID,$productID]);
    }

    function update_event($date,$name,$first,$last,$phone,$email,$id){
        $sql = "
            UPDATE Event 
            SET 
            EventDate = ?, 
            EventName=?,
            Contact_firstname=?,
            Contact_lastname=?,
            Phone=?,
            Email=? 
            WHERE EventID = ?
        ";
        return query($sql,"ssssssi",[$date,$name,$first,$last,$phone,$email,$id]);
    }

    function update_organization(){

    }

?>