<?php
function affiche_ligne($data){
    $PO=$data['PO'];
     $req11= mysql_query("SELECT client FROM commande2 where PO='$PO'");
     $client=mysql_result($req11,0);
     $req12= mysql_query("SELECT nomClient FROM client1 where name_client='$client'");
     $clt=mysql_result($req12,0);
     $statut=$data['statut'];
	    if($statut == 'waiting'){
		      $col="#F5A9A9";
	    }else{
		      $col="#F2F2F2";
     }
	    $POitem =$data['POitem'];
 echo("<tr><td style=\"width:15%;height:50px;text-align:center;background-color:".$col."\" >".$data['POitem']."</td>");
	echo ('<td style="width:15%;height:50px;text-align:center;background-color:'.$col.'">'.$data['produit'].'</td>
       <td style="width:10%;height:50px;text-align:center;background-color:'.$col.'">'.$data['qty'].'</td>
       <td style="width:12%;height:50px;text-align:center;background-color:'.$col.'">'.$data['prixU'].'</td>
       <td style="width:12%;height:50px;text-align:center;background-color:'.$col.'">'.$data['prixT'].'</td>
       <td style="width:12%;height:50px;text-align:center;background-color:'.$col.'">'.$data['dateExp'].'</td>
	<td style="width:12%;height:50px;text-align:center;background-color:'.$col.'">'.$clt.'</td>');
	echo "<td style=\"width:10%;height:50px;text-align:center;background-color:".$col."\">
			<input type=\"button\" onClick=afficheInfoPO('".$PO."','".$statut."'); Value=\">>\"></td></tr>";
}
?>