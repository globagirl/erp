<?php
include('../connexion/connexionDB.php');
echo "<h1>Select Expired contracts </h1>";
//Selection avant une 1 jour
$dateFF = strtotime("+1 days");
$dateFF= date('Y-m-d',$dateFF);
$sql=mysql_query("SELECT * FROM personnel_contrat where dateF='$dateFF' and etat='en cours'");
if(@mysql_num_rows($sql)>0){
    while($data=mysql_fetch_array($sql)){
        $mat=$data['matricule'];
        $sql1 = mysql_query("SELECT nom FROM personnel_info where matricule='$mat'");
        $nom=@mysql_result($sql1,0);
        $msg= " The contract N° ".$data['numContrat'] ." will expire TOMORROW <br> End contract Date : ".$data['dateF']." <br> Employee : ".$nom.".";
        echo $msg."<br>";
        $sql2=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('ADM','GRH','$msg',NOW(),'msg')");
    }
}
//Selection avant une 3 jours
$dateFF = strtotime("+3 days");
$dateFF= date('Y-m-d',$dateFF);
$sql=mysql_query("SELECT * FROM personnel_contrat where dateF='$dateFF' and etat='en cours'");
if(@mysql_num_rows($sql)>0){
    while($data=mysql_fetch_array($sql)){
        $mat=$data['matricule'];
        $sql1 = mysql_query("SELECT nom FROM personnel_info where matricule='$mat'");
        $nom=@mysql_result($sql1,0);
        $msg= " The contract N° ".$data['numContrat'] ." will be expired in 3 Days <br> End contract Date  : ".$data['dateF']." <br> Employee : ".$nom.".";
        echo $msg."<br>";
        $sql2=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('ADM','GRH','$msg',NOW(),'msg')");
    }
}
//Selection avant une semaine
$dateF = strtotime("+ 7 days");
$dateF= date('Y-m-d',$dateF);
$sq=mysql_query("SELECT * FROM personnel_contrat where dateF='$dateF' and etat='en cours'");
if(@mysql_num_rows($sq)>0){
    while($data2=mysql_fetch_array($sq)){
        $mat=$data2['matricule'];
        $sql1 = mysql_query("SELECT nom FROM personnel_info where matricule='$mat'");
        $nom=@mysql_result($sql1,0);
        $msg= " The contract N° ".$data2['numContrat'] ." will be expired in a week <br> End contract Date  : ".$data2['dateF']." <br> Employee : ".$nom.".";
        echo $msg."<br>";
        $sql2=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('ADM','GRH','$msg',NOW(),'msg')");
    }
}


//selection des contrat fini
$dateS = date("Y-m-d");
echo $dateS;
$sqlF =mysql_query("SELECT * FROM personnel_contrat where dateF <='$dateS' and etat LIKE 'en cours'");

if(@mysql_num_rows($sqlF)>0){
    while($dataF=mysql_fetch_array($sqlF)){
        $mat=$dataF['matricule'];
        $sql1 = mysql_query("SELECT nom FROM personnel_info where matricule='$mat'");
        $nom=@mysql_result($sql1,0);
        $msg= "The contract N° ".$dataF['numContrat']." is expired <br> End contract Date : ".$dataF['dateF']." <br> Employee : ".$nom.".";
        echo $msg."<br>";
        $idC=$dataF['idC'];
        $sql3=mysql_query("UPDATE personnel_contrat SET etat='Fini' WHERE idC='$idC'");
        $sql4=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('ADM','GRH','$msg',NOW(),'msg')");
    }
}
mysql_close();
?>