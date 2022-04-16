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

function delete_donation_product($donationid,$productID){
    $sql = "
        DELETE FROM DonationProducts
        WHERE DonationID = ?
        AND ProductID = ?
    ";
    return query($sql, "ii",[$donationid,$productID]);
}

function delete_event($id){
    $sql = "
        DELETE From Event
        Where EventID = ?
    ";
    return query($sql, "i" ,[$id]);
}

function can_event_be_delete($EventID){
    $sql="
        SELECT 
            count(Event.EventID) as event
        From Donation
        INNER JOIN Event
        On Event.EventID = Donation.EventID
        WHERE Donation.EventID = ?
    ";

    $row = query_one($sql,"s",[$EventID]);
    if(!$row) return true;
    return (int)$row["event"] === 0;
}

function can_org_be_delete($org_id){
    $sql="
        SELECT
            Count(Organization.OrganizationID) as org
        From Donation
        INNER JOIN Organization
            ON Organization.OrganizationID = Donation.OrganizationID
        Where Donation.OrganizationID = ?
    ";

    $row = query_one($sql,"s",[$org_id]);
    if(!$row) return true;
    return (int)$row["org"] === 0;
}
?>