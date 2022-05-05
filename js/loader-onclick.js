var myVar;

function myFunction() {
  myVar = setTimeout(showPage, 3000);
}

function Start(){
  
  
myVar = setTimeout(Hide,500);

}

function change(){
  var result  = "<?php change_user('user.php');?>";
  console.log(result);
  return false;
}

function Hide(){
    document.getElementById("loader").style.display = "inline";
    document.getElementById("all").style.display = "none";

}

function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("myDiv").style.display = "block";
}