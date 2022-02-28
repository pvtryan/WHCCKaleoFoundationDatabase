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


?>