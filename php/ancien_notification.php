<?php
session_start();
 include('../connexion/connexionDB.php');
 $role=$_SESSION['role'];
 $userID=$_SESSION['userID'];
 $V=1;
 $i=0;
while(($i<5) and ($V==1)){
$i++;
$sql2=mysql_query("SELECT IDnote  FROM notification WHERE destinataire='$role' and statut='Y' order by IDnote DESC");
$IDnote=@mysql_result($sql2,0);
if($IDnote==""){
$V=0;
echo("Pas de notification");
}else{
$sql=mysql_query("UPDATE notification SET statut='N' WHERE IDnote='$IDnote'");
}
}

///////Affichage
$sql3 = mysql_query("SELECT * FROM notification where ((destinataire='$role' or destinataire='$userID') and (statut='N')) ORDER BY IDnote DESC");
$i=0;
echo("<br>");
if(mysql_num_rows($sql3)>0){
while($data=mysql_fetch_array($sql3)){
$i++;
echo("<div onClick=deleteN('".$data['IDnote']."');  id=\"".$data['IDnote']."\"  class=\"list-group-item divNote\"><center>".$data['message']."</center></div>");
}
//echo("<br><br><input type=\"button\" style=\"float:right\" onClick=\"reAffiche();\" value=\"Ancien >>\" id=\"bigbutton\">");
}
else{
echo("<div class=\"list-group-item divNote\"><center>Vous n'avez aucune notification <img src=\"../image/face2.png\" alt=\"Log Out\" width=\"50\" height=\"25\">  </center></div><br>");
}
mysql_close();
?>