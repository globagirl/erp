<?php 
include('../connexion/connexionDB.php');
$val=$_POST['val'];

		$sql=mysql_query("select IDreception from reception where IDreception LIKE '%$val'");
		if (mysql_num_rows($sql)<1){
		echo "R1/".$val;
		}else{
		$nbr=mysql_num_rows($sql);
		$nbr++;
		echo "R".$nbr."/".$val;
		}
		
		//echo $val;
		?>