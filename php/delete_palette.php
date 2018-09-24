<?php
    session_start();
    include('../connexion/connexionDB.php');
    $IDpalette= $_POST['IDpalette'];   

	$sql1=@mysql_query("SELECT IDcarton,qte,poids FROM carton_palette where IDpalette LIKE '$IDpalette'");
	while($data=@mysql_fetch_array($sql1)){
	   $IDcarton=$data["IDcarton"];   
       $sql2=@mysql_query("UPDATE carton_palette SET IDpalette='X' WHERE IDcarton='$IDcarton'");
      
    }
    $sql3=@mysql_query("DELETE FROM palette WHERE IDpalette LIKE '$IDpalette'");
	$userid=$_SESSION['userID'];
	$msg="a supprimé la palette N° <b>".$IDpalette."</b>";
    $His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','$msg','palette','$IDpalette',NOW())");
    mysql_close();
?>