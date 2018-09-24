<?php
include('../connexion/connexionDB.php');
echo '<option value="s">Select ...</option>';
$sqlform = "SELECT * FROM formation_starz";
			$resForm = mysql_query($sqlform) or exit(mysql_error());
			while($dataForm=mysql_fetch_array($resForm)) {
			echo '<option value="'.$dataForm["nomF"].'">'.$dataForm["nomF"].'</option><br/>'; 
			}
mysql_close(); 
?>