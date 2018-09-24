 <?php
include('../connexion/connexionDB.php');
$date1=@$_POST['date1'];
$date2=@$_POST['date2'];

if(($date1=="")and ($date2=="")){
    $req1= "SELECT * FROM personnel_pointage where statut='n'";
}else if( ($date1!="")and ($date2!="")){
    $req1= "SELECT * FROM personnel_pointage where ((dateP >= '$date1') and (dateP <= '$date2')) and statut='n'";

}

  $r=mysql_query($req1) or die(mysql_error());

  echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead><tr style=text-align:center><th style=text-align:center><b>Matricule</b></th>
  <th style=text-align:center><b>Nom & Prenom</b></th>
  <th style=text-align:center><b>Catégorie</b></th>
  <th style=text-align:center><b>Date</b></th>
  <th style=text-align:center><b>Heure Debut</b></th>
  <th style=text-align:center><b>Heure Fin</b></th>
  <th></th>
  </tr>';
  $i=0;
  while($a=mysql_fetch_object($r))
    {
	
	$i++;
	$matN="mat".$i;
	$dateN="D".$i;
	$hND="HD".$i;
	$hNF="HF".$i;
	$B="B".$i;
    $mat=$a->matricule;
    $dateP =$a->dateP;
	$hD=$a->heureD;
	$hF=$a->heureF;
	$statut=$a->statut;

	$req2= mysql_query("SELECT * FROM personnel_info where matricule ='$mat'");
	$data=mysql_fetch_array($req2);
	$nom=$data['nom'];
	$category=$data['category'];
    echo"<tr ><td  style=\"text-align:center \"><input type=\"text \" name=\"".$matN."\" id=\"".$matN."\" value=\"".$mat."\" size=8 READONLY></td>
	<td  style=\"text-align:center \"><input type=\"text \"  value=\"".$nom."\" size=20 READONLY></td>
	<td  style=\"text-align:center \"><input type=\"text \"  value=\"".$category."\" size=12 READONLY></td>
	<td  style=\"text-align:center \"><input type=\"text \" name=\"".$dateN."\" id=\"".$dateN."\" value=\"".$dateP."\" size=20 READONLY></td>
	<td  style=\"text-align:center \"><input type=\"text \" name=\"".$hND."\" id=\"".$hND."\" value=\"".$hD."\" size=20></td>
	<td  style=\"text-align:center \"><input type=\"text \" name=\"".$hNF."\" id=\"".$hNF."\" value=\"".$hF."\" size=20></td>
	<td><input type=\"button\" class=\"OKB\" id=\"".$B."\" onClick=updateP('".$i."'); value=\">> \" /></td></tr>";

 
}
 echo "<tr><td colspan=3></td><td colspan=4> <input type=\"button\" id=\"submitbutton\"  onClick=updateALL(); value=\" Update ALL>> \" /> </td></tr></thead></table>";

  ?>