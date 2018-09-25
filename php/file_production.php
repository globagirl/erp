<?php
include('../connexion/connexionDB.php');
$valeur=@$_POST['valeur'];
$recherche=@$_POST['recherche'];
if($recherche=="a"){
    if ($valeur==""){
        $req= "SELECT * FROM productionfiles";
    }else {
        $req= "SELECT * FROM productionfiles where nameF LIKE '%$valeur%'";
    }}else {
    $req= "SELECT * FROM productionfiles where dossierF LIKE '%$recherche%'";
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
    $nameF2=str_replace('|',' ',$nameF);
    echo"<tr><td style=\"text-align:center\">$nameF</td><td colspan=2 style=\"text-align:center\">$desc</td>
	<td style=\"text-align:center\">Production/$dossierF/ </td>
	<td style=\"text-align:center\"><a href=\"../files/managementFiles/Production/".$dossierF."/".$nameF."\"><img src=\"../image/viewFile.png\" alt=\"Log Out\" width=\"30\" height=\"30\"></a> </td>
	<td style=\"text-align:center\"><a href=\"#\" onClick=deleteFile('".$dataF."','".$nameF2."'); ><img src=\"../image/deleteFile.png\" alt=\"Log Out\" width=\"30\" height=\"30\"></a></td>
	</tr>";
}
echo '</table>';
?>