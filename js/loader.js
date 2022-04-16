var myVar;

function myFunction() {
  myVar = setTimeout(showPage, 3000);
}

function Start(){
  Hide();
  
myVar = setTimeout(change,500);

}

function change(){
  var result  = "<?php change_user('user.php');?>";
  console.log(result);
  return false;
}

function Hide(){
    document.getElementById("loader").style.display = "inline";
    document.getElementById("myDiv").style.display = "none";
    document.getElementsByClassName("form__login").style.height= "250px";
}

function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("myDiv").style.display = "block";
}