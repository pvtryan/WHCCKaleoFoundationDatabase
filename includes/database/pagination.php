<?php
/********************************************************************
			******** PAGINATION PAGE ********
	Purpose: This page contains the function used to break up 
			 tables to format pages make sure a list page doesn't 
			 scroll
********************************************************************/


// Constants to determine which function is being used
// and appropriate links
define('PAGES_USERS',1);
define('PAGES_INVENTORY',2);
define('PAGES_DONATION',3);
define('PAGES_ORGANIZATION',4);
define('PAGES_EVENT',4);
define('PAGES_REPORT',5);
define('PAGES_DONATIONREPORTYEAR',6);
define('PAGES_DONATIONREPORTMONTH',7);
define('PAGES_DONATIONREPORTQUARTER',8);
define('PAGES_INVENTORYADD',9);
define('PAGES_DONATIONPRODUCT',10);

class Pagination{//Thisclass for the pagination for the list pages to limit amount of rows per page 
  private $list_type;
  private $input;
  private $limit;
  private $current_page;
  private $total_pages;
  private $total_rows;
  private $id; 
  private $id2;

  public function __construct($list_type, $input, $id = -1,$id2 =-1, $do_default_limit = false){//This function will construct the pagination 
    $this->list_type = $list_type;
    $this->input = $input;
    echo "<script src='js/pagination.js'></script>";
    $this->limit = $do_default_limit? 9 : $this->get_list_limit();
    $this->id = $id;
    $this->id2= $id2;
    $this->set_total_pages();
    $this->set_current_page();
  }

  public function get_list_limit(){//This function will limit amount of rows per page by using cookies to gather info about the window
      $w_height =  $_COOKIE["windowHeight"];
      // I only changed this line of code, instead of using intval(), I casted
      // $w_height as an integer instead of a string, then it worked. I also changed
      // 70 to 30 to fit more on a page
      // height is equal to screen height - navbar - h1 - hr - h3 - button - pagination-link - footer
      $height = $w_height - 48 - 30 - 41 - 33 - 19 - 45 - 55 - 64;     
      $list_limit = round((int)$height/30) - 9;      
      return $list_limit > 9? $list_limit : 9;
  }

  public function get_limit(){//Will pass the limit for a page 
    return $this->limit;
  }

  public function get_offset(){//Will return offset a page 
    return ($this->current_page - 1) * $this->limit;
  }
  
  public function get_total_rows(){//This function will pass the total rows of records in a list page 
    return $this->total_rows;
  }

  public function get_pagination_query($sql,$types,$params){//This function get the queries that included in the pagination 
    $sql.= "
        LIMIT {$this->get_limit()}
        OFFSET {$this->get_offset()}
    ";
    return query_many($sql, $types, $params);
  }

  public static function get_count_query($sql, $types, $params){//This function get the count of the rows from the table that will use the pagination 
    $f_sql = "
      SELECT COUNT(*) as cnt
      FROM ({$sql}) as count_table
    ";
    $row = query_one($f_sql, $types, $params);
    return isset($row["cnt"])? (int)$row["cnt"] : 0;
  }

  private function get_count($id = null,$id2 = null){//This function directs from what pages will need the records to be counted for the pagination 
    switch($this->list_type){
      case PAGES_USERS:
        return get_users($_GET, true);
        break;
      case PAGES_INVENTORY:
        return get_products($_GET, true);
        break;
      case PAGES_DONATION:
        return get_donation($_GET,true);
        break;
      case PAGES_ORGANIZATION:
        return get_organizations($_GET,true);
        break;
      case PAGES_EVENT:
        return get_events($_GET,true);
        break;
      case PAGES_REPORT:
        return report_year($_GET,true);
        break;
      case PAGES_DONATIONREPORTYEAR:
        return get_donation_by_year($this->id,$_GET,true);
        break;
      case PAGES_DONATIONREPORTMONTH:
        return get_donation_by_year_month($this->id,$this->id2,$_GET,true);
        break;
      case PAGES_DONATIONREPORTQUARTER:
        return get_donation_by_year_quarter($this->id,$this->id2,$_GET,true);
        break;
      case PAGES_INVENTORYADD:
        return get_products_not_empty($_GET,true);
        break;
      case PAGES_DONATIONPRODUCT:
        return get_donation_by_id($this->id,$_GET,true);
        break;
      default:
        return -1;
    }
    return -1;
  }

  private function set_total_pages(){//This function will pass the total pages needed for the pagination for a given page 
    $this->total_rows = $this->get_count();
    $this->total_pages = ceil($this->total_rows / $this->limit);
    if($this->total_pages <= 0)
      $this->total_pages = 1;
  }

  private function set_current_page(){//This function will set the page with total page 
    $page = isset($this->input["page"])? (int)$this->input["page"] : 1;
    $this->current_page = $page !== 0 && $page <= $this->total_pages? $page : 1;
  }

  private function get_one_link($page){//This function will add the link for pagination page of the page 
    if($page === $this->current_page){
      return "<span class='pagination-link'>{$page}</span>";
    }
    
    $href = "user.php?";
    $params = [];
    foreach($this->input as $key=>$value){
      if($key !== "page")
        $params[] = $key . "=" . $value;
    }
    $params[] = "page={$page}";
    $href .= implode($params,"&");
    $link = "<a class='pagination-link' href={$href}>{$page}</a>";
    return $link;
  }

  public function print_next_link(){
    
    if($this->current_page == $this->total_pages){
      

    }else{
      $page = $this->current_page;

      $page++;
      
      $href = "user.php?";
      $params = [];
      foreach($this->input as $key=>$value){
        if($key !== "page")
          $params[] = $key . "=" . $value;
      }
      $params[] = "page={$page}";
      $href .= implode($params,"&");
      echo "<a class='pagination-link' href={$href}>></a>";
      
    }

  }
  public function print_back_link(){
  
    if($this->current_page == 1){
     

    }else{
      $page = $this->current_page;

      $page--;
      
      $href = "user.php?";
      $params = [];
      foreach($this->input as $key=>$value){
        if($key !== "page")
          $params[] = $key . "=" . $value;
      }
      $params[] = "page={$page}";
      $href .= implode($params,"&");
      echo "<a class='pagination-link' href={$href}><</a>";
    }
  }

  public function print_all_links(){//This function is used to print out all links of each page in the pagination 
    echo "<div class='pagination'>";
    $this->print_back_link();
    for($i=1;$i<=$this->total_pages;$i++){
      echo $this->get_one_link($i);
    }
    $this->print_next_link();
    echo "</div>";
  }
}

?>