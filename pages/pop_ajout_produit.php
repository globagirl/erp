<?php
session_start ();
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
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
ajout produit
</title>
<script LANGUAGE="javascript">
var i=1;
function addA(){
var nom= "tab"+i ;
var tab=document.getElementById(nom);
tab.style.visibility ="visible";
var vis="v"+i;

i=i+1;
}
function afficheliste(typ,art){
	 
  var liste = document.getElementById(typ);
 var valeur = liste.options[liste.selectedIndex].value;
 if(valeur=="0"){
	 alert("Selectionnez un type SVP !!");
 }else{
	var req = new XMLHttpRequest();
	req.onreadystatechange = function()
   { 
      if(req.readyState == 4)
      {
         if(req.status == 200)
         {
            var prd=document.getElementById(art);
           prd.innerHTML=req.responseText;
		   
              
         }	
        
      } 
   };
   
   req.open("POST", "../php/listeArticle.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("typeA=" + escape(valeur));
 }
}
</script>
</head>

<body>




<p class="there">Ajout produit</p>




<br>

<!-- end --> 
<?php
include('../connexion/connexionDB.php');
?>


<form method="post"  id="form1" action="../php/ajout_produit.php">


<TABLE > 

		<TR> 
			<Th Wcode_articleTH=150 HEIGHT=30  ALIGN="left" >Code Produit: </Th> 
			<TD colspan="3" ><input type="text" name="code_produit" SIZE="20" MAXLENGTH="8" ></TD> 
			
			
			<td>		
			</TD> 
			<td> <input type="submit" id="submitbutton" value="AJOUTER"></td>
		</TR> 
  
  
		<TR> 
			<TH Wcode_articleTH=150 HEIGHT=30  ALIGN="left">Description : </TH> 
			<TD colspan="8"><textarea name="desc" SIZE="50" cols="50" rows="4" MAXLENGTH="150"></textarea></TD> 
			
		</TR> 
  <TR> 

<TH Wcode_articleTH=80 HEIGHT=30  ALIGN="left">Catégorie:</TH> 
			
			<TD colspan="3" > 
<span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			<select name="cat" type="text" class="custom-dropdown__select custom-dropdown__select--white" name="cat">
			<option selected="" value="cat 5">CAT 5</option>
			<option value="cat 6">CAT 6</option>
			<option value="M hd">Modules HD</option>
			<option value="upm3">UPM3</option>
			</select>
			</span>			
			</TD> 
			<Th Wcode_articleTH=150 HEIGHT=30  ALIGN="left" >Longueur: </Th> 
			<TD colspan="3" ><input type="text" name="long" SIZE="8" MAXLENGTH="8" ></TD> 
			
  
			</TR>
			
	


<TR> 
 <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left">Prix unitaire : </TH> 
  <TD colspan="3"> <input type="text" name="prix" SIZE="20"> </TD> 
<TH Wcode_articleTH=80 HEIGHT=30  ALIGN="left">Devise:</TH> 
			
			<TD  colspan="4"> 
<span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			<select name="dev" type="text" class="custom-dropdown__select custom-dropdown__select--white">
			
			<option value="euro">Euro</option>
			<option value="dollar">Dollar</option>
			<option value="tnd">TND</option>
			</select>
			</span>			
			</TD> 
</TR>
<TR> 
 <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left">Taille du lots : </TH> 
  <TD colspan="3"> <input type="text" name="tlots" SIZE="10"> </TD> 
 <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left">Nombre Box : </TH> 
  <TD colspan="4"> <input type="text" name="nbr_box" SIZE="10"> </TD> 
</TR>


<TR> 
 <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left">Couleur : </TH> 
  <TD colspan="3"> <input type="text" name="r" SIZE="3" value="R"> <input type="text" name="v" SIZE="3" value="V"> <input type="text" name="b" SIZE="3" value="B"> </TD> 
  		<TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left">Revision : </TH> 
  <TD colspan="4"> <input type="text" name="rev" SIZE="2"></td>
<TR> 
 <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left" colspan="5" style="text-align:center">Articles  </TH> 
 
<td colspan="4"> <input type="button" onclick="addA()" id="submitbutton" value="+"></td>


 
 </tr>




    </table>
	
	<!-- !!!!!!!!!!!!les articles!!!!!!!!!! -->
	<div style="text-align:center">
<!-- !!!!!!!!!!!!!!!!!!!1!!!!!!!!!!!!! -->
<div id="tab1" style="visibility:hidden">
<b>Type article:</b> 
 <select name="typ1" id="typ1" style="width:150px" >
<option value="0"> ---Choisissez</option> 
<option value="mold"> MOLD</option> 
<option value="splice"> Splice</option> 

   </select> 

<b>Code article:</b> 

 <select name="ar1" id="ar1" onFocus="afficheliste('typ1','ar1');" style="width:150px" >

   </select> 
<B> Quantité: </B>
<input type="text" size="4" name="q1">

 <br/><hr/><br/>
    </div>
		<!-- !!!!!!!!!!!!!!!!!!!2!!!!!!!!!!!!! -->
	<div  id="tab2" style="visibility:hidden"> 

<b>Type article:</b> 
 <select name="typ2" id="typ2" style="width:150px" >
<option value="0"> ---Choisissez</option> 
<option value="mold"> MOLD</option> 
<option value="splice"> Splice</option> 

   </select> 

<b>Code article:</b> 

 <select name="ar2" id="ar2" onFocus="afficheliste('typ2','ar2');" style="width:150px" >

   </select> 
 <B> Quantité: </B>
<input type="text" size="4" name="q2">

<br/><hr/><br/>
</div>
<!-- !!!!!!!!!!!!!!!!!!!3!!!!!!!!!!!!! -->
<div  id="tab3" style="visibility:hidden"> 
<b>Type article:</b> 
 <select name="typ3" id="typ3" style="width:150px" >
<option value="0"> ---Choisissez</option> 
<option value="mold"> MOLD</option> 
<option value="splice"> Splice</option> 

   </select> 

<b>Code article:</b> 

 <select name="ar3" id="ar3" onFocus="afficheliste('typ3','ar3');" style="width:150px" >

   </select> 
  <B> Quantité: </B>
<input type="text" size="4" name="q3">

   <br/><hr/><br/>
    </div>
		<!-- !!!!!!!!!!!!!!!4!!!!!!!!!!!!!!!!! -->
	<div id="tab4" style="visibility:hidden"> 
<b>Type article:</b> 
 <select name="typ4" id="typ4" style="width:150px" >
<option value="0"> ---Choisissez</option> 
<option value="mold"> MOLD</option> 
<option value="splice"> Splice</option> 

   </select> 

<b>Code article:</b> 

 <select name="ar4" id="ar4" onFocus="afficheliste('typ4','ar4');" style="width:150px" >

   </select> 
   <B> Quantité: </B>
<input type="text" size="4" name="q4">

  <br/><hr/><br/>
    </div>
		<!-- !!!!!!!!!!!!!!!!5!!!!!!!!!!!!!!!! -->
	<div id="tab5" style="visibility:hidden"> 
<b>Type article:</b> 
 <select name="typ5" id="typ5" style="width:150px" >
<option value="0"> ---Choisissez</option> 
<option value="mold"> MOLD</option> 
<option value="splice"> Splice</option> 

   </select> 

<b>Code article:</b> 

 <select name="ar5" id="ar5" onFocus="afficheliste('typ5','ar5');" style="width:150px" >

   </select>  
<B> Quantité: </B>
<input type="text" size="4" name="q5">

   <br/><hr/><br/>
    </div>
		<!-- !!!!!!!!!!!!!!!!!6!!!!!!!!!!!!!!! -->
	<div id="tab6" style="visibility:hidden"> 
<b>Type article:</b> 
 <select name="typ6" id="typ6" style="width:150px" >
<option value="0"> ---Choisissez</option> 
<option value="mold"> MOLD</option> 
<option value="splice"> Splice</option> 

   </select> 

<b>Code article:</b> 

 <select name="ar6" id="ar6" onFocus="afficheliste('typ6','ar6');" style="width:150px" >

   </select> 
 <B> Quantité: </B>
<input type="text" size="4" name="q6">

<br/><hr/><br/>
    </div>
		<!-- !!!!!!!!!!!!!!!7!!!!!!!!!!!!!!!!! -->
	<div id="tab7" style="visibility:hidden"> 
<b>Type article:</b> 
 <select name="typ7" id="typ7" style="width:150px" >
<option value="0"> ---Choisissez</option> 
<option value="mold"> MOLD</option> 
<option value="splice"> Splice</option> 

   </select> 

<b>Code article:</b> 

 <select name="ar7" id="ar7" onFocus="afficheliste('typ7','ar7');" style="width:150px" >

   </select> 
<B> Quantité: </B>
<input type="text" size="4" name="q7">

 <br/><hr/><br/>
    </div>
			<!-- !!!!!!!!!!!!!!!8!!!!!!!!!!!!!!!!! -->
	<div id="tab8" style="visibility:hidden"> 
<b>Type article:</b> 
 <select name="typ8" id="typ8" style="width:150px" >
<option value="0"> ---Choisissez</option> 
<option value="mold"> MOLD</option> 
<option value="splice"> Splice</option> 

   </select> 

<b>Code article:</b> 

 <select name="ar8" id="ar8" onFocus="afficheliste('typ8','ar8');" style="width:150px" >

   </select> 
<B> Quantité: </B>
<input type="text" size="4" name="q8">

 <br/><hr/><br/>
    </div>
			<!-- !!!!!!!!!!!!!!!9!!!!!!!!!!!!!!!!! -->
	<div id="tab9" style="visibility:hidden"> 
<b>Type article:</b> 
 <select name="typ9" id="typ9" style="width:150px" >
<option value="0"> ---Choisissez</option> 
<option value="mold"> MOLD</option> 
<option value="splice"> Splice</option> 

   </select> 

<b>Code article:</b> 

 <select name="ar9" id="ar9" onFocus="afficheliste('typ9','ar9');" style="width:150px" >

   </select> 
<B> Quantité: </B>
<input type="text" size="4" name="q9">

 <br/><hr/><br/>
    </div>
		<!-- !!!!!!!!!!!!!!!10!!!!!!!!!!!!!!!!! -->
	<div id="tab10" style="visibility:hidden"> 
<b>Type article:</b> 
 <select name="typ10" id="typ10" style="width:150px" >
 <?php
$sql = "SELECT * FROM  article_type";
$res = mysql_query($sql) or exit(mysql_error());
while($data=mysql_fetch_array($res)) {
   echo '<option value="'.$data["IDtype"].'">'.$data["IDtype"].'</option><br/>'; 
}
?>
   </select> 

<b>Code article:</b> 

 <select name="ar10" id="ar10" onFocus="afficheliste('typ10','ar10');" style="width:150px" >

   </select> 
<B> Quantité: </B>
<input type="text" size="4" name="q10">

 <br/><hr/><br/>
    </div>
	</div>





  
		


 
</form>



</body>

</html>