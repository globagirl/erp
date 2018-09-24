 <?php
include('../connexion/connexionDB.php');
  echo'
<div id="DCdiv">
  <h3>Demande de congé </h3>
  <br>
  <table class="table table-fixed  tabScroll2" id="DCtab">
<thead style="width:100%"><tr>

<th style="width:24.8%;height:60px">Personnel</th>
<th style="width:23.7%;height:60px">Debut</th>
<th style="width:23.7%;height:60px">Fin</th>
<th style="width:10.7%;height:60px">Total</th>
<th style="width:7.8%;height:60px"></th>
<th style="width:7.8%;height:60px"></th>
</tr></thead><tbody id="tbody2" style="width:100%">';

$req1=mysql_query("SELECT * FROM personnel_demande_conge where  etat='N'");
while($a=@mysql_fetch_array($req1)){
    $matricule=$a['matricule'];
    $ID=$a['ID'];
    $IDC="R".$ID;
	$req2=mysql_query("SELECT * FROM personnel_info where matricule='$matricule'");
	$data=@mysql_fetch_array($req2);
	
//Affichage
 echo"<tr>

<td style=\"width:25%;height:60px\">".$data['nom']."</td>
<td style=\"width:24%;height:60px\">".$a['dateD']."</td>
<td style=\"width:24%;height:60px\">".$a['dateF']."</td>
<td style=\"width:11%;height:60px\"> ".$a['nbrH']." H</td>
<td style=\"width:8%;height:60px\" ><img src=\"../image/oui.png\"  alt=\"Congé\" style=\"cursor:pointer;\" width=\"25\" height=\"25\"  id=\"".$ID."\"  onClick=confirm_conge('".$ID."');></td>
<td style=\"width:8%;height:60px;text-align:center\" ><img src=\"../image/non.png\"  alt=\"Congé\" style=\"cursor:pointer;\" width=\"25\" height=\"25\"id=\"".$IDC."\"  onClick=refuse_conge('".$ID."'); ></td>
</tr>";
//



}
  echo '</tbody></table></div>'; 
  
 

  ?>