<?php
    include('../connexion/connexionDB.php');
    $IDpal= $_POST['IDpalette'];
    $IDpal=explode(',',$IDpal);
	$msg="<b>Palettes fermées :</b>";
    
	foreach($IDpal as $IDpalette){	
      $sql3=@mysql_query("UPDATE palette SET statut='closed' where IDpalette='$IDpalette'");
      $msg=$msg."<br>".$IDpalette;
    }
    echo $msg;
	mysql_close();
    
?>