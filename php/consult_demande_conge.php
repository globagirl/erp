 <?php
include('../connexion/connexionDB.php');

$date1=$_POST['date1'];
$date2=$_POST['date2'];
$val=$_POST['valeur'];
$recherche=$_POST['recherche'];
if($date2==""){
    $date2=$date1;
}
if($recherche="a"){
    if($date1==""){
        $req1=mysql_query("SELECT * FROM personnel_demande_conge");
    }else{
        $req1=mysql_query("SELECT * FROM personnel_demande_conge where  dateD >= '$date1' and dateF<= '$date2'");
    }
}else{
    $req=mysql_query("SELECT matricule FROM personnel_info where  $recherche LIKE '$val'");
	$mat=@mysql_result($req,0);
	$req1=mysql_query("SELECT * FROM personnel_demande_conge where  (dateD >= '$date1') and (dateF<= '$date2') and (matricule='$mat')");
}

echo'<table>
<tr>

<th>Matricule</th>
<th>Personnel</th>
<th>Catégorie</th>
<th>Type</th>
<th>Debut</th>
<th>Fin</th>
<th>Nbr heures</th>
<th>Etat</th>

</tr>';

while($a=mysql_fetch_array($req1)){
    $matricule=$a['matricule'];
    $ID=$a['ID'];
    $IDC="R".$ID;
	$req2=mysql_query("SELECT * FROM personnel_info where matricule='$matricule'");
	$data=@mysql_fetch_array($req2);
	$etat=$a['etat'];
	
//Affichage
 echo"<tr>

<td>".$data['matricule']."</td>
<td>".$data['nom']."</td>
<td>".$data['category']."</td>
<td>".$a['typeC']."</td>
<td>".$a['dateD']."</td>
<td>".$a['dateF']."</td>
<td>".$a['nbrH']." H</td>";

if($etat=="NC"){
	echo "<td>Non confirmée</td>";
	}else if($etat=="C"){
	echo "<td>Confirmée</td>";
	}else{
	echo "<td><center><img src=\"../image/oui.png\"  alt=\"Congé\" style=\"cursor:pointer;\" width=\"25\" height=\"25\"  id=\"".$ID."\"  onClick=confirm_conge('".$ID."');>
    <img src=\"../image/non.png\"  alt=\"Congé\" style=\"cursor:pointer;\" width=\"25\" height=\"25\"id=\"".$IDC."\"  onClick=refuse_conge('".$ID."'); ></center></td>";
	}



//



}
  echo '</table>'; 
  
 

  ?>