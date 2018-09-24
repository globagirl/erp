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
<html><head><meta charset="utf-8" />
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
<title>Création Facture</title>
<script>
function pop_up(url){
window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=750,height=500,directories=no,location=no') 
}
</script></head>
<body>

<div id="entete">
<div id="logo">
</div>
<div id="boton">
</div>
</div>
<div id="main">
<div id="menu">
<?php
if($role=="ADM"){
include('../menu/menuAdmin.php');	
}
elseif($role=="COM"){
include('../menu/menuCommercial.php');	
}
elseif($role=="CONS"){
	include('../menu/menuConsommable.php');	
	}
else{

	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>


<br>
<p class="there">Création Facture</p>
<br>

 <TABLE BORDER="0"> 
<form method="post" name="form1" >
	<input onclick="pop_up('../pages/pop_consult_BL.php');" type="button" value="Afficher BL" id="bigbutton"><br>
   
	<tr>
	<th>Date expédition</th> 
	   <td><input type="date" name="date_fact" SIZE="20" MAXLENGTH="20"></td>
	   <td><input type="submit" value="suivant" id="submitbutton"></td>
    </tr> 
</form> 

<form method="post" name="form2" action="../php/ajout_fact.php">
    <tr>
        <th >Numero Bl:</th> 
        <td>
			<?php
				include('../connexion/connexionDB.php');
				$date= @$_POST['date_fact'];
				$bl = @mysql_query("SELECT min(num_bl) as min_bl,max(num_bl) as max_bl FROM bon_livr WHERE date_bl='$date'");
				$row = @mysql_fetch_array($bl);
				$min = $row['min_bl'];
				$max = $row['max_bl'];
				echo "<input name=\"min_bl\" value=\"".$min."\"/> ";
			?>
			
		</td>
        <th>à</th> 
		<td> 
			<?php  echo "<input name=\"max_bl\" value=\"".$max."\"/> ";	 ?>
	    </td>		
		</tr>
		<tr> 
			<th>Terme payment</th>
			<td> 
			  <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			    <select name="tpay" id="tpay" type="text" class="custom-dropdown__select custom-dropdown__select--white">	
					<?php include('../include/utile/terme_payment.php'); ?>
			    </select>
			  </span>
			</td> 
			<th>Devise : </th> 
				<td>
			        <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			        <select name="devise" id="devise" type="text" class="custom-dropdown__select custom-dropdown__select--white">			  <option value="EUR">EUR</option>
					<?php include('../include/utile/devise.php'); ?>
			        </select>
	                </span>	
	       </td>
		</tr>			
		<tr> 
			<td></td>
			<td><input type="submit" value="VALIDER" id="submitbutton"></td>
			<td colspan="5"> </td> 
		</tr>
		

  </form>
</TABLE> 
<?php mysql_close(); ?>
<?PHP 

if(!empty($_GET['status']))
{ 
     $status = $_GET['status']; 
     if  ($status=="sent")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Les factures ont été ajouté avec succès \');</SCRIPT>';
	 //header('Location: ../pages/ajout_fact.php');
	 }
	 else if ($status=="fail1")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Erreur de connexion au serveur\');</SCRIPT>';}
   	 else if ($status=="fail2")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Erreur de connexion à la base de données\');</SCRIPT>';}
	  else if ($status=="fail")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'BL déja facturée\');</SCRIPT>';}
} 
?>
 

 


</div>

</div>

</body>

</html>