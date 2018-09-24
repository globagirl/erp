 <?PHP
 session_start ();
include('../connexion/connexionDB.php');
    $idDecoup=$_SESSION['IDdecoup'];
   
	$nom_oper = $_POST['nom_oper'];
	$batch = $_POST['batch'];
    $mach_dec = $_POST['mach_dec']; 	
	//$date_exe = date("Y-m-d H:i:s");
	$q_sor = $_POST['q_sor'];
	$q_reb = $_POST['q_reb'];
	$plan = $_POST['plan'];
	$e1 = $_POST['e1'];
	$e2 = $_POST['e2'];
	$e3 = $_POST['e3'];
	$def_long = @$_POST['def_long'];
	$def_den = @$_POST['def_den'];
	
	
$sql = "UPDATE decoup SET nom_oper='$nom_oper', mach_dec='$mach_dec', date_fin=CURRENT_TIMESTAMP(),q_sor='$q_sor',q_reb='$q_reb',e1='$e1',e2='$e2',e3='$e3',def_long='$def_long',def_den='$def_den' ,batch='$batch' 
WHERE num_decoupage='$idDecoup'";
if (!mysql_query($sql)) {
die('Error: ' . mysql_error());
    mysql_close(); 
    echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Erreur de connexion à la base de données\');</SCRIPT>';
}else{  
$sql2 = mysql_query("UPDATE plan1 SET statut='Fin decoupage',nbr_defaut=nbr_defaut+'$q_reb' where numPlan='$plan'");
unset($_SESSION['IDdecoup']);
mysql_close();
header('Location: ../pages/decoupage.php?status=sent');
	 
	
}  	 

 ?>