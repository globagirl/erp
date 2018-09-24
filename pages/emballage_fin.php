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
Emballage
</title>
<SCRIPT> 
  
function myF2(){
    var qtei=document.getElementById("qte_s");
    qtei.innerHTML="";
    var x=document.getElementById("qte_s").value; 
    if((x=="") || (x<0) || (!x.match(/^(0|[1-9][0-9]*)$/))){  
        qtei.value="saisi incorrect";
        qtei.style.background="#DB5776";
      
    }
}
			
function calc(){
var qte_e=document.getElementById("qte_e").value;
var qte_s=document.getElementById("qte_s").value;
qte_e = parseInt(qte_e);
qte_s = parseInt(qte_s);

if(qte_e < qte_s){
alert("Vérifier la quantité sortie SVP !!");
document.getElementById("qte_s").value=qte_e;
document.getElementById("qte_s").style.background="#DB5776";
}	
}
			   

			 
function del2(){
    document.getElementById("qte_s").value="";
	document.getElementById("qte_s").style.background="#FFF";
}

		      



			   
			   
</SCRIPT> 
</head>

<body>


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
elseif($role=="EMB"){
include('../menu/menuEMB.php');	
}
elseif($role=="PRD"){
include('../menu/menuProduction.php');	
}
else{
	 include('../menu/menuEMB.php');	
}
?>

</div>
<div id='contenu'>


<p class="there">Emballage > Fin </p>

<br>

<!-- end --> 








		
<form name ="pro_emb" method="post" action="../php/ajoutEmballage2.php">
<?php 
$numA=$_SESSION['IDemb'];
$sql33 = mysql_query("SELECT * FROM pro_emb where num_emb='$numA'");
$data2=mysql_fetch_array($sql33);
$plan=$data2['plan'];
$qtE=$data2['qte_e'];
$dateD=$data2['date_debut'];
				
echo("<table><TR><th>Plan: </th>
<td> <input  type=\"text\" size=\"15\" id=\"plan\" value=\"".$plan."\"/  READONLY></td>
<Th Wcode_articleTH=150 HEIGHT=30  >Quantité entrée :</Th>
<td><input  type=\"text\" size=\"10\" id=\"qte_e\" value=\"".$data2['qte_e']."\"/ READONLY></td>
<Th Wcode_articleTH=150 HEIGHT=30  > Debut :</Th>
<td><input  type=\"text\" size=\"20\" value=\"".$dateD."\"/ READONLY></td></tr>
</table>");
 ?>
 <TABLE BORDER="0"> 
		

		<TR> 
			              <TH WIDTH=200 HEIGHT=30  ALIGN="left">Selectionner la chaine : </TH> 
			              <TD colspan="3">
						  
			                   <select name="ch_ins">
								<?php
								
								$ID_list = mysql_query("SELECT nom FROM ajout_chaine WHERE type='emb_cable'");

								while ($row = mysql_fetch_array($ID_list)){
								echo '<option value="'. $row['nom'] .'">'. $row['nom'] .'</option>';
								}

								?>
								</select>	
			              </TD>
	    </TR> 
  
  
		        
		 
  
        <TR> 
                          <TH WIDTH=150 HEIGHT=30  ALIGN="left">Agent Contrôle: *:</TH> 
                          <TD colspan="3">
                            
							 <select name="ag_cont">
								<?php
								

								$nom_prenom_list = mysql_query(" SELECT nom,prenom FROM agent_qual1 WHERE tache ='emballage' ");

								while ($row = mysql_fetch_array($nom_prenom_list)){
								echo '<option value="'. $row['nom'],' '.$row ['prenom'] .'">'. $row['nom'] ,' '.$row ['prenom'] .'</option>';
								}

								?>
								</select>	
                          </TD>
        </TR>


		
       
 

 
 
        <TR> 
                     <Th>Qté Sortie: * </Th> 
                     <Td><input type="text" name="qte_s" id="qte_s" value="<?php echo $qtE; ?>" SIZE="8" onblur="myF2(),calc()" onFocus="del2()"></Td> 
                            
        </TR> 

 </TABLE>  
 
 
   
 <input type="submit" id="submitbutton">

  

 
</form>


</div>

</div>

</body>

</html>