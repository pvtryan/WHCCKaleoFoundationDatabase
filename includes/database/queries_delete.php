<?php
/****************************************************************** 
 * 
 * 
 * 
 * 
 * 
******************************************************************/

function delete_donation($id){
    $sql = "
            DELETE FROM Donation 
            WHERE DonationID = ?
    ";
    return query($sql, "i", [$id]);
}


?>