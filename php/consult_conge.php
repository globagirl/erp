 <?php
include('../connexion/connexionDB.php');
$recherche=@$_GET['recherche'];
$valeur=@$_GET['valeur'];

$dateD=@$_GET['dateD'];
$dateF=@$_GET['dateF'];
$year=@$_GET['year'];
$totConge=0;

if($recherche=="A"){
   if(($dateD=="") || ($dateF=="")){
     $req1= "SELECT * FROM personnel_conge where dateD LIKE '$year-%' order by dateD desc";
   }else{
      $req1= "SELECT * FROM personnel_conge where dateD >= '$dateD' and dateD <= '$dateF' order by dateD desc";
	  //echo $dateD;
   }
}else{
   $sql2=mysql_query("select matricule from personnel_info where $recherche='$valeur' ");
   $mat=mysql_result($sql2,0);
   if(($dateD=="") || ($dateF=="")){
     $req1= "SELECT * FROM personnel_conge where dateD LIKE '$year-%' and matricule='$mat' order by dateD desc";
   }else{
      $req1= "SELECT * FROM personnel_conge where dateD >= '$dateD' and dateD <= '$dateF' and matricule='$mat' order by dateD desc";
   }

}

  $r=mysql_query($req1) or die(mysql_error());

  echo'<table  class="table table-fixed results" id="table3">
  <thead style="width:100%">   
  <tr><th  style="width:9.8%;height:60px;"><b>Matricule</b></th>
  <th style="width:19.8%;height:60px;"><b>Nom & Prenom</b></th>  
  <th style="width:14.8%;height:60px;"><b>Date debut</b></th>
  <th style="width:14.8%;height:60px;"><b>Date fin</b></th> 
  <th style="width:9.8%;height:60px;"><b>Raison</b></th>
  <th style="width:9.8%;height:60px;"><b>NBR jours</b></th>
  <th style="width:9.8%;height:60px;"><b>Montant</b></th>
  <th style="width:9.8%;height:60px;"><b></b></th>
  </tr></thead><tbody>';
  while($a=mysql_fetch_object($r))
    {
    $idC=$a->idPC;
    $mat=$a->matricule;
    $D1 =$a->dateD;
    $D2 =$a->dateF;
    $nbrH=$a->nbrH;
    $raison=$a->typeC;
    $montant=$a->montant;
    $req2= mysql_query("SELECT nom FROM personnel_info where matricule ='$mat'");
    $data=mysql_fetch_array($req2);
    $nom=$data['nom'];
    $nbrJ=$nbrH / 8;

    echo"<tr ><td  style=\"width:10%;height:60px;\">$mat</td>
	   <td  style=\"width:20%;height:60px; \">$nom</td>
    <td  style=\"width:15%;height:60px; \">$D1</td>
    <td  style=\"width:15%;height:60px;\">$D2</td>
    <td  style=\"width:10%;height:60px;\">$raison</td>
    <td  style=\"width:10%;height:60px;\">$nbrJ</td>
    <td  style=\"width:10%;height:60px;\">$montant</td>
    <td  style=\"width:10%;height:60px;\">
     <p style=\"float:center\"><img src=\"../image/delete.png\" onclick=deleteConge('".$idC."'); alt=\"delete\" style=\"cursor:pointer;\" width=\"30\" height=\"30\"  />
    </td>
    </tr>";
	   $totConge=$totConge+$nbrJ;   
 
}
if($recherche != "A"){
 echo"<tr ><td  style=\"width:50%;height:60px;text-align:right\"><b>Total:</b> </td>
 <td  style=\"width:50%;height:60px;text-align:left\"><b>".$totConge." Jours </b></td></tr>";
}
 echo '</tbody></table>';
 mysql_close();
  ?>