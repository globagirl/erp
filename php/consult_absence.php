 <?php
include('../connexion/connexionDB.php');
  $recherche=$_POST['recherche'];
  $valeur=@$_POST['valeur'];
  $date1=@$_POST['date1'];
  $date2=@$_POST['date2'];
 if ($date2==""){
 $date2=$date1;
 }

echo'<table><tr>
  <th></th>
  <th style=text-align:center><b>Matricule</b></th>
  <th style=text-align:center><b>Nom & Prenom</b></th>
  <th style=text-align:center><b>Catégorie</b></th> 
  <th style=text-align:center><b>NBR heures</b></th>
  <th style=text-align:center><b>Etat</b></th>
  </tr>';
while($date1 <= $date2){
	$sun=strtotime($date1);
    $sun=strftime ("%a",$sun);
    if($sun != "Sun"){	
	if($recherche =="a"){
	    if($date1==""){
	        $req2= mysql_query("SELECT * FROM personnel_absence");
	    }else{
	        $req2= mysql_query("SELECT * FROM personnel_absence where dateD >= '$date1' and dateF <= '$date2'");
	    }
	}else{
	    $req1= mysql_query("SELECT matricule FROM personnel_info where $recherche LIKE '$valeur%'");
	    $matricule=@mysql_result($req1,0);	 
	    if($date1==""){
		    $req2=@mysql_query("SELECT * FROM personnel_absence where matricule='$matricule'");
	    }else{
	        $req2=@mysql_query("SELECT * FROM personnel_absence where dateD <= '$date1' and dateF >= '$date1' and matricule='$matricule'");
	    }
	}
	$nbr=mysql_num_rows($req2);
	if($nbr>0){
	    echo "<tr><td colspan=3> <b>Date : ".$date1."</b></td><td colspan=3> <b>Total : ".$nbr."</b></td></tr>";
		while($data=mysql_fetch_array($req2)){
	        $matricule=$data['matricule'];
			$idAB=$data['idAB'];
			$etat=$data['Etat'];
			$req3= mysql_query("SELECT * FROM personnel_info where matricule ='$matricule'");
			$a=mysql_fetch_array($req3);
			echo"<tr ><td></td>
	        <td  style=\"text-align:center \">".$matricule."</td>
	        <td  style=\"text-align:center \">".$a['nom']."</td>
			<td  style=\"text-align:center \">".$a['category']."</td>
			<td  style=\"text-align:center \">".$data['nbrH']."</td>
			<td  style=\"text-align:center \">
			<input type=\"text\" id=\"".$idAB."\"  class=\"inputBorder\" onBlur=\"updateAB('".$idAB."','".$etat."')\" value=\"".$data['Etat']."\"></td></tr>";
	   }
    }
	
	}
	$date1=strtotime($date1);
    $date1=strtotime("+1 day",$date1);
    $date1=date("Y-m-d",$date1);
}//fin while
echo '</table>';
mysql_close();
?>