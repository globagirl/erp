<?php
 session_start ();
 $role=@$_SESSION['role'];
$userID=@$_SESSION['userID'];
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
Sertissage
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
	document.pro_sert.qd1.disabled=status;
 }
			 
 function a2(status){
    status=!status;			
	document.pro_sert.qd2.disabled=status;
 }

 function a3(status){
    status=!status;			
	document.pro_sert.qd3.disabled=status;
  }

 function a4(status){
    status=!status;			
	document.pro_sert.qd4.disabled=status;
 }
				
 function a5(status){
    status=!status;			
	document.pro_sert.qd5.disabled=status;
 }
		  
 function a6(status){
    status=!status;			
	document.pro_sert.qd6.disabled=status;
 }
 
 function a7(status){
    status=!status;			
	document.pro_sert.qd7.disabled=status;
 }

 function del1(){
    document.forms['pro_sert'].qte_e.value="";
    document.forms['pro_sert'].qte_e.style.background="#FFFFFF";;
 }

 function del2() {
    document.forms['pro_sert'].qte_s.value="";
    document.forms['pro_sert'].qte_s.style.background="#FFFFFF";
 }
		      			                
</SCRIPT> 
</head>

<body onload="a1(false),a2(false),a3(false),a4(false),a5(false),a6(false),a7(false)">



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
else if($role=="SRT"){
include('../menu/menuSRT.php');	
}
else if($role=="PRD"){
include('../menu/menuProduction.php');	
}
else{
	 //header('Location: ../deny.php');
	 include('../menu/menuSRT.php');	
}
?>
</div>
<div id='contenu'>
<br>

<p class="there">Sertissage > Fin </p>

<br>

<!-- end --> 





<form name="pro_sert" method="post" action="../php/ajoutSertissage2.php">
				   
		 <?php 
						  $numA=$_SESSION['IDsert'];
						  $sql33 = mysql_query("SELECT * FROM pro_sertiss where num_sert='$numA'");
                          $data2=mysql_fetch_array($sql33);
                          $plan=$data2['plan'];
                          $qtE=$data2['qte_e'];
						  $dateD=$data2['date_debut'];
						  
						  echo("<table><TR><th>Plan: </th>
                          <td> <input  type=\"text\" size=\"15\" id=\"plan\" name=\"plan\" value=\"".$plan."\"/  READONLY></td>
                          <Th Wcode_articleTH=150 HEIGHT=30  >Quantité entrée :</Th>
                          <td><input  type=\"text\" size=\"10\" id=\"qte_e\" name=\"qte_e\" value=\"".$data2['qte_e']."\"/ READONLY></td>
                          <Th Wcode_articleTH=150 HEIGHT=30  > Debut :</Th>
                          <td><input  type=\"text\" size=\"20\" id=\"dateD\" value=\"".$dateD."\"/ READONLY></td></tr>
                          </table>");
						  ?>	
		<TABLE BORDER="0"> 


		<TR> 
			              <TH WIDTH=200 HEIGHT=30  ALIGN="left">Selectionner la chaine : </TH> 
			              <TD >
						  <select name="num_ch">
								<?php
								
								$ID_list = mysql_query("SELECT nom FROM ajout_chaine WHERE type='sertissage_cable'");

								while ($row = mysql_fetch_array($ID_list)){
								echo '<option value="'. $row['nom'] .'">'. $row['nom'] .'</option>';
								}

								?>
								</select>			
			              </TD>
						  
						  
						 <TH WIDTH=200 HEIGHT=30  ALIGN="left"> Num machine sertissage </TH>  
						  <TD >
						  <select name="num_mach">
								<?php
								

								$ID_list = mysql_query("SELECT nom_machine FROM machines WHERE zone='sertissage'");

								while ($row = mysql_fetch_array($ID_list)){
								echo '<option value="'. $row['nom_machine'] .'">'. $row['nom_machine'] .'</option>';
								}

								?>
								</select>			
			              </TD>
	    </TR> 
  
  
		<TR> 
			              <TH WIDTH=150 HEIGHT=30  ALIGN="left">Nom Opérateur: *</TH> 
			              <TD>
						  
			                   <select name="nom_opr">
								<?php
								

								$nom_prenom_list = mysql_query(" SELECT nom,prenom FROM ouvrier1 WHERE tache='sertissage' ");

								while ($row = mysql_fetch_array($nom_prenom_list)){
								echo '<option value="'. $row['nom'],' '.$row ['prenom'] .'">'. $row['nom'] ,' '.$row ['prenom'] .'</option>';
								}

								?>
								</select>		
			              </TD>
						   <TH WIDTH=150 HEIGHT=30  ALIGN="left">Agent Contrôle: *:</TH> 
                          <TD >
                            
							   <select name="ag_cont">
								<?php
								
								$nom_prenom_list = mysql_query(" SELECT nom,prenom FROM agent_qual1 WHERE tache ='cont_serti' ");

								while ($row = mysql_fetch_array($nom_prenom_list)){
								echo '<option value="'. $row['nom'],' '.$row ['prenom'] .'">'. $row['nom'] ,' '.$row ['prenom'] .'</option>';
								}

								?>
								</select>	
                          </TD>
		</TR> 
		
         <TR> 
                          
                            <Th WIDTH=150 HEIGHT=30  ALIGN="left" > Qté Sortie:* </Th> 
                            <Td><input type="text" name="qte_s" id="qte_s" SIZE="12" value="<?php echo $qtE; ?>"  onblur="myF2(),calc()" onFocus="del2()" ></Td>
							<TH WIDTH=150 HEIGHT=30  ALIGN="left">Nombre de défaut:</TH> 
                            <Td><input type="text" name="nbr_def" id="N_D"  SIZE="4" value="0" readonly ></Td>
        </TR> 

		
	
		
  
                        <TR> 
                         <TH WIDTH=150 HEIGHT=30  ALIGN="left" colspan=4> Type de défaut :</TH> 
						
         <tr>
		 
                         <td> <input type="checkbox" name="option1" id="lon_pair" onclick="a1(this.checked)"> Longueur Paire<br> </td>
                         <td WIDTH=10 HEIGHT=30  ALIGN="left"><input type="text" id= "qd1" name="long_pair" SIZE="8" MAXLENGTH="8"> </td>
						 <TD colspan="3">
                            
							  <select name="action">
                              <option selected="selected" value="A_C_1">CHOISIR</option>
							  <option value="A_C_0">-----------------</option>
                              <option value="A_C_2">trie</option>
							  <option value="A_C_3">rejet</option>
							  <option value="A_C_4">réparation</option>
                              </select>
						 </td>
         </tr>
		 
		 
         <tr>
                         <td> <input type="checkbox" name="option2" id="prod_souil" onclick="a2(this.checked)">produit souillé </td>
                         <td WIDTH=100 HEIGHT=30  ALIGN="left"><input type="text" id="qd2" name="pro_souil" SIZE="8" MAXLENGTH="8">  </td>
						 <TD colspan="3">
                            
							  <select name="action">
                              <option selected="selected" value="A_C_1">CHOISIR</option>
							  <option value="A_C_0">-----------------</option>
                              <option value="A_C_2">trie</option>
							  <option value="A_C_3">rejet</option>
							  <option value="A_C_4">réparation</option>
                              </select>
						 </td>
         </tr>
		 
         <tr>
                         <td> <input type="checkbox" name="option3" id="shield_endom" onclick="a3(this.checked)"> Shield endommagé<br> </td>
                         <td WIDTH=100 HEIGHT=30  ALIGN="left"><input type="text" id="qd3" name="sh_end" SIZE="8" MAXLENGTH="8"></td>
						 <TD colspan="3">
                            
							  <select name="action">
                              <option selected="selected" value="A_C_1">CHOISIR</option>
							  <option value="A_C_0">-----------------</option>
                              <option value="A_C_2">trie</option>
							  <option value="A_C_3">rejet</option>
							  <option value="A_C_4">réparation</option>
                              </select>
						</td>
         </tr>
		 
		 <tr>
                         <td> <input type="checkbox" name="option3" id="ang_cas" onclick="a4(this.checked)"> angle Plug cassé<br> </td>
                         <td WIDTH=100 HEIGHT=30  ALIGN="left"><input type="text" id="qd4" name="ang_pl_end" SIZE="8" MAXLENGTH="8"></td>
						 <TD colspan="3">
                            
							  <select name="action">
                              <option selected="selected" value="A_C_1">CHOISIR</option>
							  <option value="A_C_0">-----------------</option>
                              <option value="A_C_2">trie</option>
							  <option value="A_C_3">rejet</option>
							  <option value="A_C_4">réparation</option>
                              </select>
						</td>
         </tr>
		 <tr>
                         <td> <input type="checkbox" name="option3" id="Boots_endom" onclick="a5(this.checked)"> Boots endommagé<br> </td>
                         <td WIDTH=100 HEIGHT=30  ALIGN="left"><input type="text" id="qd5" name="boots_end" SIZE="8" MAXLENGTH="8"></td>
						 <TD colspan="3">
                            
							  <select name="action">
                              <option selected="selected" value="A_C_1">CHOISIR</option>
							  <option value="A_C_0">-----------------</option>
                              <option value="A_C_2">trie</option>
							  <option value="A_C_3">rejet</option>
							  <option value="A_C_4">réparation</option>
                              </select>
						</td>
         </tr>
		 <tr>
                         <td> <input type="checkbox" name="option3" id="cab_ray" onclick="a6(this.checked)"> câble rayé<br> </td>
                         <td WIDTH=100 HEIGHT=30  ALIGN="left"><input type="text" id="qd6" name="cable_r" SIZE="8" MAXLENGTH="8"></td>
						 <TD colspan="3">
                            
							  <select name="action">
                              <option selected="selected" value="A_C_1">CHOISIR</option>
							  <option value="A_C_0">-----------------</option>
                              <option value="A_C_2">trie</option>
							  <option value="A_C_3">rejet</option>
							  <option value="A_C_4">réparation</option>
                              </select>
						</td>
         </tr>
		 <tr>
      <td> <input type="checkbox" name="option3" id="PIN_endom" onclick="a7(this.checked)"> PIN endommagé<br> </td>
       <td WIDTH=100 HEIGHT=30  ALIGN="left"><input type="text" id="qd7" name="pin_end" SIZE="8" MAXLENGTH="8"></td>
						 <TD colspan="3">                            
							  <select name="action">
                              <option selected="selected" value="A_C_1">CHOISIR</option>
							  <option value="A_C_0">-----------------</option>
                              <option value="A_C_2">trie</option>
							  <option value="A_C_3">rejet</option>
							  <option value="A_C_4">réparation</option>
       </select>
						</td>
         </tr>
    <tr>
      <td> <input type="checkbox" name="option3" id="alum_end" onclick="a7(this.checked)">Aluminium endommagé <br> </td>
       <td WIDTH=100 HEIGHT=30  ALIGN="left"><input type="text" id="qd8" name="alum_end" SIZE="8" MAXLENGTH="8"></td>
						 <TD colspan="3">                            
							  <select name="action">
                              <option selected="selected" value="A_C_1">CHOISIR</option>
							  <option value="A_C_0">-----------------</option>
                              <option value="A_C_2">trie</option>
							  <option value="A_C_3">rejet</option>
							  <option value="A_C_4">réparation</option>
       </select>
						</td>
         </tr>
  <tr><td></td><td colspan=3> <input type="submit" id="submitbutton"></td></tr>
 </TABLE>  
 
 


 
</form>


</div>

</div>

</body>

</html>