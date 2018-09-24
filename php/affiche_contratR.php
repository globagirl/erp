<?php
include('../connexion/connexionDB.php');
$recherche=$_POST['recherche'];
$val=$_POST['P1'];
$sql = mysql_query("SELECT * FROM personnel_info where $recherche='$val'");
$data1=mysql_fetch_array($sql);
$matricule=$data1['matricule'];

$sql2 = mysql_query("SELECT * FROM personnel_contrat where matricule='$matricule'");
$data=mysql_fetch_array($sql2);

echo("<table> <tr><Th  >Personnel:  </Th><td>".$data1['nom']."</td></tr>
<TR><Th>N° contrat: </th><td><input  type=\"text\" size=\"10\" id=\"contratID\" name=\"contratID\" value=\"".$data['idC']."\"/ HIDDEN> ".$data['numContrat']."</Td></tr>
<TR>	<Th  >Delai:  </Th><td><b>Du </b> ".$data['dateD']."  <b>au</b> ".$data['dateF']."</td></tr>
<tr><Th  >Type Contrat:  </Th><td>".$data['typeContrat']."</td></tr>
<tr><td></td><td> <input type=\"button\" id=\"submitbutton\" value=\"Rompre >>\" onClick=\"rompreContrat()\"</tr>");

?>