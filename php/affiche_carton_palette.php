<?php
    include('../connexion/connexionDB.php');
    $IDpalette= $_POST['IDpalette'];
    $sql2=@mysql_query("SELECT IDcarton,PO,IDproduit FROM carton_palette where IDpalette LIKE '$IDpalette'");
    $nbr=@mysql_num_rows($sql2);	
	echo '
	<div class="form-group">
  		    <label>'.$IDpalette.'</label>
			  <select multiple class="form-control" size="10" id="cartPal" name="cartPal">';
	
	while($data2=@mysql_fetch_array($sql2)){
	  
       echo "<option value=\"".$data2["IDcarton"]."\" >".$data2["IDcarton"]."&nbsp&nbsp&nbsp&nbsp".$data2["PO"]."&nbsp&nbsp&nbsp".$data2["IDproduit"]."</option>"; 
    }
	echo'</select>
	<label>Total : '.$nbr.'</label>
	</div>';
    mysql_close();
?>