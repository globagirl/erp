<?php
 session_start ();
 $role=$_SESSION['role'];
$userID=$_SESSION['userID'];
include('../connexion/connexionDB.php');
?>
<html>

<head>
<meta charset="utf-8" />
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<title>
Test
</title>
<SCRIPT> 
 function myF1(){
    var qtei=document.getElementById("qte_e");
    qtei.innerHTML="";
    var x=document.getElementById("qte_e").value; 
    if((x=="") || (x<0) || (!x.match(/^(0|[1-9][0-9]*)$/))){  
        qtei.value="saisi incorrect";
        qtei.style.background="#DB5776";
        return false;
    }else{
    return true;  
    }
}
			   
 function myF2(){
    var qtei=document.getElementById("qte_s");
    qtei.innerHTML="";
    var x=document.getElementById("qte_s").value; 
    if((x=="") || (x<0) || (!x.match(/^(0|[1-9][0-9]*)$/))){  
        qtei.value="saisi incorrect";
        qtei.style.background="#DB5776";
        return false;
    }else{
    return true;  
	document.getElementById("N_D").value = document.getElementById("qte_e").value - document.getElementById("qte_s").value;
    }
 }
			
 function calc(){
 var qte_e=document.getElementById("qte_e").value;
var qte_s=document.getElementById("qte_s").value;
var qte_e = parseInt(qte_e);
var qte_s = parseInt(qte_s);

if(qte_e >= qte_s){
document.getElementById("N_D").value = qte_e - qte_s;
}else{
alert("Vérifier la quantité sortie SVP !!");
document.getElementById("N_D").value=0;
document.getElementById("qte_s").value=qte_e;
}
 }
			   

 function a1(status){
    status=!status;
	document.pro_test.qd1.disabled=status;
 }
		  	  
                
 function a2(status){
    status=!status;			
	document.pro_test.qd2.disabled=status;
 }
		  
 function a3(status){
    status=!status;			
	document.pro_test.qd3.disabled=status;
 }
		  
		       
  function a4(status){
    status=!status;			
	document.pro_test.qd4.disabled=status;
 }
		

		     
 function del2(){
    document.forms['pro_test'].qte_s.value="";
     document.forms['pro_test'].qte_s.style.background = "#FFFFFF";
 }
		      
/////			                
function affichePlan(){
		 
 var valeur = document.getElementById("plan").value;
 if(valeur==""){
	 alert("Selectionnez un plan SVP !!");
 }
 else{
   $.ajax({
           type: 'POST',
		   data:'plan=' +valeur,
           url: '../php/affichePlanTP2.php',
           success: function(data) {
           $('#tab').html(data);
		   document.getElementById("tab2").style.visibility = "visible";

           }});
 
 ///
	
}
}   
			   
		      </SCRIPT> 
</head>

<body onload="a1(false),a2(false),a3(false),a4(false)">


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
elseif($role=="TST"){
include('../menu/menuTST.php');	
}
elseif($role=="PRD"){
include('../menu/menuProduction.php');	
}
else{
	include('../menu/menuTST.php');	
}
?>
</div>
<div id='contenu'>
<br>


<p class="there">Test polarité > Fin </p>

<br>

<!-- end --> 






 <form name="pro_test" method="POST" action="../php/ajoutTest2.php">
 <table>
 <TH>N° Plan: </TH> 
 <td>
	  <input name="plan" id="plan" type="text" size="20" placeholder="Plan N°">  
 <input type="button" id="submitbutton" value="OK" onclick="affichePlan()"/></div>  
 </td>
 </tr>
 </table>
 <table id="tab">
 </table>

           
		
<TABLE id="tab2" style="visibility:hidden" BORDER="0"> 
		<TR> 
			              <TH>Selectionner la chaine : </TH> 
			              <TD colspan="3">
						  
			                 <select name="ch_ins">
								<?php
								

								$ID_list = mysql_query("SELECT nom FROM ajout_chaine WHERE type='test_cable'");

								while ($row = mysql_fetch_array($ID_list)){
								echo '<option value="'. $row['nom'] .'">'. $row['nom'] .'</option>';
								}

								?>
								</select>	
			              </TD>
	    </TR> 
  
  
		 <TR> 
                         <TH> Opératrice 1 :</TH>
						
		        <TD>
                          
			                   <select name="op_1">
								<?php
							

								$nom_prenom_list = mysql_query(" SELECT nom,prenom FROM ouvrier1 WHERE tache='test' ");

								while ($row = mysql_fetch_array($nom_prenom_list)){
								echo '<option value="'. $row['nom'],' '.$row ['prenom'] .'">'. $row['nom'] ,' '.$row ['prenom'] .'</option>';
								}

								?>
								</select>		
			              </TD>
						 
						   <TH> Opératrice 2 :</TH>
						  <TD colspan=3>
                          
			                   <select name="op_2">
								<?php
								

								$nom_prenom_list = mysql_query(" SELECT nom,prenom FROM ouvrier1 WHERE tache='test' ");

								while ($row = mysql_fetch_array($nom_prenom_list)){
								echo '<option value="'. $row['nom'],' '.$row ['prenom'] .'">'. $row['nom'] ,' '.$row ['prenom'] .'</option>';
								}

								?>
								</select>		
			              </TD>
						   
     </TR>
  
        <TR> 
                          <TH >Agent Contrôle:*</TH> 
                          <TD colspan="3">
                            
							  <select name="ag_cont">
								<?php
								

								$nom_prenom_list = mysql_query(" SELECT nom,prenom FROM agent_qual1 WHERE tache ='test' ");

								while ($row = mysql_fetch_array($nom_prenom_list)){
								echo '<option value="'. $row['nom'],' '.$row ['prenom'] .'">'. $row['nom'] ,' '.$row ['prenom'] .'</option>';
								}

								?>
								</select>	
                          </TD>
        </TR>


		
      
 

 
 


		
		
    
		
		
  
     <TR> 
                         <TH colspan=4> Type de défaut :</TH> 
						 
         </tr><tr>
		 
						 <td> <input type="checkbox" name="option1"  id="qlt" onclick="a1(this.checked)" > Qualité <br> </td>
                         <td  WIDTH=10 HEIGHT=30  ALIGN="left"><input type="text" name="qlty" id= "qd1" SIZE="8" MAXLENGTH="2"> </td>
						 <TD colspan="3" >
                         
                            
							  <select name="action">
                              <option selected="selected" value="A_C_1">CHOISIR</option>
							  <option value="A_C_2">-------------</option>
                              <option value="A_C_2">trie</option>
							  <option value="A_C_3">rejet</option>
							  <option value="A_C_4">réparation</option>
                              </select>
						</td>
						
         </tr>
		 
		 
         <tr>
                         <td> <input type="checkbox" name="option2" id="p_c_c" onclick="a2(this.checked)" >Paire cour_circuitée </td>
                         <td WIDTH=100 HEIGHT=30  ALIGN="left"><input type="text" name="p_cc" id= "qd2" SIZE="8" MAXLENGTH="8">  </td>
						 <TD colspan="3">
                            
							  <select name="action">
                              <option selected="selected" value="A_C_1">CHOISIR</option>
							  <option value="A_C_2">-----------------</option>
                              <option value="A_C_2">trie</option>
							  <option value="A_C_3">rejet</option>
							  <option value="A_C_4">réparation</option>
                              </select>
						</td>
         </tr>
		 
         <tr>
                         <td> <input type="checkbox" name="option3" id="contin" onclick="a3(this.checked)"> Continuité<br> </td>
                         <td WIDTH=100 HEIGHT=30  ALIGN="left"><input type="text" name="cntn" id= "qd3" SIZE="8" MAXLENGTH="8"></td>
						 <TD colspan="3">
                            
							  <select name="action">
                              <option selected="selected" value="A_C_1">CHOISIR</option>
							  <option value="A_C_2">-------------------</option>
                              <option value="A_C_2">trie</option>
							  <option value="A_C_3">rejet</option>
							  <option value="A_C_4">réparation</option>
                              </select>
						</td>
         </tr>
		 
		 <tr>
                         <td> <input type="checkbox" name="option3" id="pair_inv" onclick="a4(this.checked)"> Paire inversée<br> </td>
                         <td WIDTH=100 HEIGHT=30  ALIGN="left"><input type="text" name="p_inv" id= "qd4" SIZE="8" MAXLENGTH="8"></td>
						 <TD colspan="3">
                            
							  <select name="action">
                              <option selected="selected" value="A_C_1">CHOISIR</option>
							  <option value="A_C_2">--------------</option>
                              <option value="A_C_2">trie</option>
							  <option value="A_C_3">rejet</option>
							  <option value="A_C_4">réparation</option>
                              </select>
						</td>
         </tr>
		 
		 
             
    <tr><td></td><td colspan=4><input type="submit" name="valider" id="submitbutton"></td>
  
    
  
  
  
  
  
  
 </TABLE>  
 

 
</form>


</div>

</div>

</body>

</html>