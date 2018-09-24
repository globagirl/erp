    <?php
include('../connexion/connexionDB.php');

$valeur=@$_POST['valeur'];
$recherche=@$_POST['recherche'];
  if($recherche=="a"){
		if ($valeur==""){
        $req= "SELECT * FROM maintenancefiles";
       }else {
        $req= "SELECT * FROM maintenancefiles where nameF LIKE '%$valeur%'";
  }}else {
        $req= "SELECT * FROM maintenancefiles where dossierF LIKE '%$recherche%'";
     }

  $r=mysql_query($req) or die(mysql_error());
 
   echo"<table border=\"1\" bordercolor=\"BLUE\" ><tr>
  <td style=\"text-align:center\" width=250><b>File name</b> </td>
  <td colspan=2 style=\" text-align:center\" width=250><B>Description</b></td>
  <td style=\" text-align:center\"><b>Path</b></td>
  <td colspan=2></td>
 
  </tr>";
  while($a=mysql_fetch_object($r))
    {
    $nameF = $a->nameF;
    $desc = $a->description;
	$dossierF= $a->dossierF;
	$dataF= $a->dataF;
	
    echo"<tr><td style=\"text-align:center\">$nameF</td><td colspan=2 style=\"text-align:center\">$desc</td>
	<td style=\"text-align:center\">Maintenance/$dossierF/ </td>
	<td style=\"text-align:center\"><a href=\"../files/managementFiles/Maintenance/".$dossierF."/".$nameF."\"><img src=\"../image/viewFile.png\" alt=\"Log Out\" width=\"30\" height=\"30\"></a> </td>
	<td style=\"text-align:center\"><a href=\"#\" onClick=deleteFile('".$dataF."','".$nameF."'); ><img src=\"../image/deleteFile.png\" alt=\"Log Out\" width=\"30\" height=\"30\"></a></td>
	</tr>";
    }
  echo '</table>';
  ?>
