<?php
    check_user([ADMIN]);
    $orgID = isset($_GET["OrganizationID"])? $_GET["OrganizationID"] : "";

    $org = get_organization_id($orgID);

    function verify_organization($input){
        if(!isset($input['OrganizationName']) || empty($input['OrganizationName'])){
            $errors['OrganizationName'] = "Organization Name is Required";
        }else if(strlen($input['OrganizationName']) > 50){
            $errors['OrganizationName'] = "Max 50 characters for Event Name";
        } 
    
        if(!isset($input['contactfirstname']) || empty($input['contactfirstname'])){
            $errors['contactfirstname'] = "Firstname Required";
        }else if(strlen($input['contactfirstname']) > 50){
            $errors['contactfirstname'] = "Max 50 characters for First Name";
        }

        if(!isset($input['contactlastname']) || empty($input['contactlastname'])){
            $errors['contactlastname'] = "Lastname Required";
        }else if(strlen($input['contactlastname']) > 50){
            $errors['contactlastname'] = "Max 50 characters for Last Name";
        }

        if(!isset($input['contactphone']) || empty($input["contactphone"])){
            $errors['contactphone'] = "Phone is required";
        }else if(strlen($input['contactphone']) > 14){
            $errors['contactphone'] = "Max 14 characters for Phone";
        }

        if(!isset($input['contactemail']) || empty($input['contactemail'])){
            $errors['contactemail'] = "Email is required";
        }else if(!filter_var($input['contactemail'], FILTER_VALIDATE_EMAIL)){
            $errors['contactemail'] = "Email is not Valid";
        }else if(strlen($input['contactemail']) > 50){
          $errors['contactemail'] = "Max 50 characters for Email";    
        }

        return $errors;
    }

    $errors = [];
    $input=[];

   


?>

<h1>Edit Organization</h1>
<hr>