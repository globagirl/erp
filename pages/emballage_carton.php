<?php
session_start ();
$role=@$_SESSION['role'];
$userID=@$_SESSION['userID'];
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
Emballage Carton
</title>
<script>
function addE(){
var val1=document.getElementById("n_p_o").value;
var val2=document.getElementById("code_cart").value;



		  if(val1==""){
			  alert("Ajouter un PO SVP !!");
			  document.getElementById('n_p_o').style.backgroundColor='pink'; 
			 
          }	 else if(val2==""){
			  alert("Ajouter un code carton SVP !!");
			  document.getElementById('code_cart').style.backgroundColor='pink'; 
          } else {
		
		document.forms['form1'].submit(); 
		 }
	}	 
</script>
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
elseif($role=="CONS"){
include('../menu/menuConsommable.php');	
}
else{
	 include('../menu/menuEMB.php');	
}
?>
</div>
<div id='contenu'>
<br>
<p class="there">Emballage Carton</p>

<br>

<!-- end --> 






<TABLE BORDER="0"> 
<?php
include('../connexion/connexionDB.php');
?>

		<form name="form1" id="form1" method="POST" action="../php/emb_carton.php">
                                <tr>
								
								
                                   <Th WIDTH=30 HEIGHT=30 ALIGN="left">Num_PO </Th> 
								   <td>
	 <input type="text" name="n_p_o" id="n_p_o" size="20">
			

								   
								
                                   
								   <Th WIDTH=30 HEIGHT=30 ALIGN="left">Code_carton </Th> 
								   
								   <Td><input type="text" name="code_cart" id="code_cart" SIZE="30" > </Td> 
								   
                                 </tr>

        <TR> 
		
                            <TH WIDTH=150 HEIGHT=30  ALIGN="left">Date de Récéption:*   </TH> 
                            <TD colspan="3"> 
							      <div class="ex">
                                  <script  language="javascript">
                                    var dateString = "";

                                     var newDate = new Date();
                                     
                                                 // Get the month, day, and year.
									dateString += newDate.getFullYear() +"/";
                                    dateString += (newDate.getMonth() + 1) + "/";
                                    dateString += newDate.getDate() + "&nbsp;";
									
                                    
                                    dateString += newDate.getHours() + ":";
									dateString += newDate.getMinutes() + ":";
									dateString += newDate.getSeconds();
                                    document.write(dateString);
                                   </script>
                                   </div>
                            </TD>
       </TR>
 

 
 
        

 </TABLE>  
 
 
   
 <input type="button" id="submitbutton" onClick="addE();" value="ADD >>">

  
<?PHP 

if(!empty($_GET['status']))
{ 
     $status = $_GET['status']; 
     if  ($status=="sent")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'La commande a été ajouté avec succès \');</SCRIPT>';}
	 else if ($status=="fail1")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Erreur de connexion au serveur\');</SCRIPT>';}
   	 else if ($status=="fail2")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Erreur de connexion à la base de données\');</SCRIPT>';}
	  else if ($status=="fail")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'N° PO existe déja\');</SCRIPT>';}
} 
?>
 
</form>


</div>

</div>

</body>

</html>