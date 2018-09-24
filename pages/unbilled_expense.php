<?php
session_start ();
if( !isset($_SESSION["role"]) ){
    header('Location: ../index.php');
    exit();
}else{
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
}
?>
<html>
<head>
<meta charset="utf-8" />
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />



<title>
Unbilled Expense
</title>
<script>

/////////
function submitE(){
     var liste2 = document.getElementById("category");
     var val1 = liste2.options[liste2.selectedIndex].value;

     var val4= document.getElementById("amount").value;  
	 var val2= document.getElementById("desc").value;
	 var val3= document.getElementById("dateE").value;
	 if(val1=="s"){
	 alert("Select a category PLEASE !!");
	 }else if(val2==""){
	 alert("Enter a description PLEASE !!");
	 }else if(val3==""){
	 alert("Enter a date PLEASE !!");
	 }else if(val4==""){
	 alert("Enter a amount PLEASE !!");
	 }else{
	document.form1.action="../php/unbilled_expense.php";
    document.form1.submit(); }
}

/////////////
function checkA(){
 var amount= document.getElementById("amount").value;
 amount=parseFloat(amount);
 if(amount>100){
 alert("You amount exceeds the threshold");
  document.getElementById("amount").value="";
 }
}
////////////////
function pop_up(url){
window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=768,height=600,directories=no,location=no') 
}
/////////////
function afficheCat(){
  $.ajax({
        type: 'POST',
      
        url: '../php/listeCategory.php',
        success: function(data) {
        $('#category').html(data);
       }});
	   }

</script>

</head>

<body onLoad="afficheCat();">



<div id="entete">
<div id="logo">
</div>
<div id="boton">
<?php 
include('../include/logOutIMG.php');
?>	
</div>
</div>

<div id="main">
<div id="menu">
<?php
if($role=="ADM"){
include('../menu/menuAdmin.php');	
}
elseif($role=="FIN"){
include('../menu/menuFinance.php');	
}elseif($role=="FIN2"){
include('../menu/menuFin2.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>


<p class="there">Unbilled Expense</p>


<br>
<hr size=2 />



<!-- end --> 
<?php
include('../connexion/connexionDB.php');
?>


<form method="POST"  id="form1" name="form1" action="../php/supplier_invoice2.php" enctype="multipart/form-data">


<TABLE > 

		<TR> 
			<TH>Category: </TH> 
			<TD >
			<span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
            <select name="category" id="category"  style="width:200px" class="custom-dropdown__select custom-dropdown__select--white" onFocus="afficheCat();" >
             <option value="s">---Category</option>
          
            </select> 
            </span>
			
			<input type="button" onclick="pop_up('../pages/pop_ajout_category.php');" value="+" >
		
			</td>
			</tr>
			<tr>
			<TH>Description: </TH> 
			<TD id="TDsupplier">
			<textarea id="desc" name="desc" rows=5 cols=40 ></textarea>
           </td>
			</tr>
			<tr>
			<Th >Date: </Th> 
			<td><input type="date" name="dateE" size="15" id="dateE"></td></tr>
			<tr>
			<Th>Amount: </Th> 
			<td><input type="text" name="amount" size="10" id="amount" onBlur="checkA();">
			<span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			<select name="currency" id="currency" type="text" class="custom-dropdown__select custom-dropdown__select--white">
			<option value="TND">TND</option>
			<option value="Euro">Euro</option>
			<option value="Dollar">Dollar</option>
			
			</select>
			</span>	
			</td>			
			</tr>
			<tr>
			<td></td>
			<td >
            <input type= "file" name="expF" id="expF" />
            </td>
			</tr>
			<tr><td></td>
			<td><input type="button" onclick="submitE();" value="Submit >> " id="submitbutton"></td>
	        </tr>
	
	
		</TR> 
  </table>
 
  







<hr size=2 />
</form>

</div>
</div>
</body>
</html>