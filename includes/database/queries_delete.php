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

function delete_organization($id){
    $sql = "
        DELETE FROM Organization
        WHERE OrganizationID = ?
    ";
    return query($sql, "i", [$id]);
}

?>