<?php
    include('../connexion/connexionDB.php');
    
	$sql2=@mysql_query("SELECT IDcarton,PO,IDproduit FROM carton_palette where IDpalette LIKE 'X'");
	while($data2=@mysql_fetch_array($sql2)){
	  
      echo "<option value=\"".$data2["IDcarton"]."\" >".$data2["IDcarton"]."&nbsp&nbsp&nbsp&nbsp".$data2["PO"]."&nbsp&nbsp&nbsp".$data2["IDproduit"]."</option>"; 
    }

    mysql_close();
?>