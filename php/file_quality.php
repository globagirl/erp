<?php
include('../connexion/connexionDB.php');
$valeur=@$_POST['valeur'];
$recherche=@$_POST['recherche'];
$dossier=@$_POST['dossier'];
if($recherche=="a"){
    if ($valeur==""){
        $req= "SELECT * FROM qualityfiles";
    }else {
        $req= "SELECT * FROM qualityfiles where nameF LIKE '%$valeur%'";
    }}else {
    if ($valeur==""){
        $req= "SELECT * FROM qualityfiles where dossierF LIKE '%$recherche%' and dossierF LIKE '%$dossier%'";
    }else{
        $req= "SELECT * FROM qualityfiles where dossierF LIKE '%$recherche%' and dossierF LIKE '%$dossier%' and nameF LIKE '%$valeur%'";
    }
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
    //<input type=\"button\" id=\"submitbutton\" onClick=afficheFile('".$nameF."'); value=\"View\" >
    echo"<tr><td style=\"text-align:center\">$nameF</td><td colspan=2 style=\"text-align:center\">$desc</td>
        <td style=\"text-align:center\"> Quality/$dossierF/ </td>
        <td style=\"text-align:center\"><a href=\"../files/managementFiles/Quality/".$dossierF."/".$nameF."\" ><img src=\"../image/viewFile.png\" alt=\"Log Out\" width=\"30\" height=\"30\"></a> </td>
        <td style=\"text-align:center\"><a href=\"#\" onClick=deleteFile('".$dataF."','".$nameF."'); ><img src=\"../image/deleteFile.png\" alt=\"Log Out\" width=\"30\" height=\"30\"></a></td>
        </tr>";
}
echo '</table>';
?>