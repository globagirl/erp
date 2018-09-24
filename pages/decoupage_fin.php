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
Découpage
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
	document.pro_decoup.qd1.disabled=status;
}
		  	  
function a2(status){
    status=!status;			
	document.pro_decoup.qd2.disabled=status;
}
     
			 
function del2(){
     document.getElementById("qte_s").value="";
	document.getElementById("qte_s").style.background="#FFF";
}

		      



			   
			   
</SCRIPT> 
</head>

<body onload="a1(false);a2(false)">



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
else if($role=="DEC"){
include('../menu/menuDEC.php');	
}
else if($role=="PRD"){
include('../menu/menuProduction.php');	
}
else{
	 //header('Location: ../deny.php');
	 include('../menu/menuDEC.php');
}
?>
</div>
<div id='contenu'>
<br>
<p class="there">Découpage  > Fin Opération</p>
<br>

<!-- end --> 





<form  name="pro_decoup" id="pro_decoup" method="post" action="../php/ajoutDecoup2.php">

                          <?php 
						  $numD=$_SESSION['IDdecoup'];
						  $sql33 = mysql_query("SELECT * FROM decoup where num_decoupage='$numD'");
                          $data2=mysql_fetch_array($sql33);
                          $plan=$data2['plan'];
                          
                          $qtE=$data2['qte_e'];
						  $dateD=$data2['date_debut'];
						  echo("<table><TR><th>Plan: </th>
                          <td> <input  type=\"text\" size=\"15\" id=\"plan\" name=\"plan\" value=\"".$plan."\"/  READONLY></td>
                          <Th Wcode_articleTH=150 HEIGHT=30  >Quantité entrée :</Th>
                          <td><input  type=\"text\" size=\"10\" id=\"qte_e\" name=\"qte_e\" value=\"".$data2['qte_e']."\"/ READONLY></td>
						  <Th Wcode_articleTH=150 HEIGHT=30  > Debut :</Th>
                          <td><input  type=\"text\" size=\"10\" id=\"dateD\" value=\"".$dateD."\"/ READONLY></td></tr>
                          </table>");
						  ?>
  
 <table>
    <tr>
        <th id="LarTH">Nom Opérateur:*</th> 
        <td colspan="5">
		<select name="nom_oper" >
		<?php
		$nom_prenom_list = mysql_query(" SELECT nom,prenom FROM ouvrier1 WHERE tache='decoup' ");
        while ($row = mysql_fetch_array($nom_prenom_list)){
		echo '<option value="'. $row['nom'],' '.$row ['prenom'] .'">'. $row['nom'] ,' '.$row ['prenom'] .'</option>';
		}
        ?>
		</select>	
        </td>
		
    </tr>
    <tr>
        <th>N° machine découpage:*</th> 
        <td colspan="5">
		<select name="mach_dec">
		<?php
		$nom_machine_list = @mysql_query("SELECT nom_machine FROM machines WHERE zone='decoupage'");
        while ($row = @mysql_fetch_array($nom_machine_list)){
		echo '<option value="'. $row['nom_machine'] .'">'. $row['nom_machine'] .'</option>';
		}
        ?>
		</select>				
        </TD>
    </tr>
    <tr> 
        <th>Batch:* </th> 
        <td colspan="5"><input type="text" name="batch" id="batch" SIZE="15"  ></td>
    </tr> 	
    <tr> 
        <th> Qté Sortie:* </th> 
        <td colspan="2"><input type="text" name="q_sor" id="qte_s" value="<?php echo $qtE; ?>" SIZE="8" onblur="myF2();calc()" onFocus="del2();"></td>
		<th>Nombre de REBUT:</th> 
        <td colspan="2"><input type="Nombre" name="q_reb" ID="N_D" SIZE="4" value="0" READONLY></td>
					  
    </tr> 		
	<tr>
		<td WIDTH=150 HEIGHT=30  ALIGN="right">ECHANTILLON 1:</td> 
        <td WIDTH=150 HEIGHT=10  ALIGN="right"><input type="text" name="e1" SIZE="8" MAXLENGTH="8">  </td>
		<td WIDTH=150 HEIGHT=30  ALIGN="right">ECHANTILLON 2:</td> 
        <td WIDTH=150 HEIGHT=10 ALIGN="right"><input type="text" name="e2" SIZE="8" MAXLENGTH="8">  </td>
		<td WIDTH=150 HEIGHT=30  ALIGN="right">ECHANTILLON 3:</td> 
		<td WIDTH=150 HEIGHT=10 ALIGN="right"><input type="text" name="e3" SIZE="8" MAXLENGTH="8">  </td>
						  
    </tr>
    <tr>
        <th WIDTH=150 HEIGHT=30  ALIGN="left" colspan=6> Type de REBUT :</th> 
	</tr>
    <tr>
		<td> <input type="checkbox" name="option1"  id="lgn" onclick="a1(this.checked)" > longueur <br> </td>
        <td  WIDTH=10 HEIGHT=30  ALIGN="left"><input type="text" name="def_long" id= "qd1" SIZE="8" MAXLENGTH="2"> </td>
		<td colspan=4></td>
    </tr>
	<tr>
		<td> <input type="checkbox" name="option2" id="denud" onclick="a2(this.checked)" >dénudage </td>
        <td WIDTH=100 HEIGHT=30  ALIGN="left"><input type="text" name="def_den" id= "qd2" SIZE="8" MAXLENGTH="8">  </td>
		<td colspan=4></td>
    </tr>  
    <tr>
	    <td></td>
	    <td colspan=5>   <input type="submit" id="submitbutton"></td>
	</tr>
</table>  
 <?php mysql_close();?>
 
   




 

 
 
</form>
</div>
</div>




</body>

</html>