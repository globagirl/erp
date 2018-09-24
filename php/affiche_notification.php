<?php
session_start ();
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
include('../connexion/connexionDB.php');
echo'<div class="panel panel-blue">
     <div class="panel-heading">
     <i class="glyphicon glyphicon-bell"></i>Notifications Panel
	 </div>
     <div class="panel-body" id="notePane">';



$sql = mysql_query("SELECT * FROM notification where ((destinataire='$role' or destinataire='$userID') and (statut='N')) ORDER BY IDnote DESC");
$i=0;
echo("<br>");
if(mysql_num_rows($sql)>0){
while($data=mysql_fetch_array($sql)){
$i++;
echo("<div onClick=deleteN('".$data['IDnote']."');  id=\"".$data['IDnote']."\"  class=\"list-group-item divNote\"><center>".$data['message']."</center></div>");
}
}
else{
echo("<div class=\"list-group-item divNote\"><center>Vous n'avez aucune notification <img src=\"../image/face2.png\" alt=\"Log Out\" width=\"50\" height=\"25\">  </center></div><br>");
}

echo '  </div>
 <div class="panel-footer">
 <center><a href="#" class="btn btn-default blue" onClick="reAffiche();">
 <i class="glyphicon glyphicon-eye-open"></i> View more Alerts
 </a>
 
 <a href="#" class="btn btn-default red" onClick="deleteAll();">
 <i class="glyphicon glyphicon-ok"></i> Mark as read
 </a></center>
</div>  
 </div>';
 mysql_close();
?>