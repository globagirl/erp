<?php
  include('../connexion/connexionDB.php');
  $recherche=$_POST['recherche'];  
  $valeur=@$_POST['valeur'];
  if($recherche=='X'){
     $recherche='IDpalette';
	   $valeur='X';
  }  
  $req= mysql_query("SELECT IDcarton,PO,OF,IDproduit,IDpalette,qte FROM carton_palette where $recherche='$valeur'");
  while($a=@mysql_fetch_array($req)){
		 $IDcart =$a['IDcarton'];  
		 echo('<tr>
		 <td style="width:5%;height:60px;text-align:center">
		 <input type="checkbox" name="IDcarton[]" value='.$IDcart.'>
		 </td> 
		 <td style="width:15%;height:60px;text-align:center">'.$IDcart.'</td>
     <td  style="width:19%;height:60px;text-align:center">'.$a['PO'].'</td>
     <td  style="width:15%;height:60px;text-align:center">'.$a['OF'].'</td>	
		 <td style="width:15%;height:60px;text-align:center">'.$a['IDproduit'].'</td>
		 <td style="width:10%;height:60px;text-align:center">'.$a['qte'].'</td>
		 <td style="width:20%;height:60px;text-align:center">'.$a['IDpalette'].'</td>	
		 </tr>');
  }
  mysql_close();
?>