<?php

$files = ['connect_variables','connect','queries_get_all',
'queries_get_many_by','queries_get_one_by','queries_insert',
'queries_update','queries_delete','pagination'];

//loops for the file to be loaded in project to be only called once 
foreach($files as $file){
    require_once("includes/database/{$file}.php");
}

?>