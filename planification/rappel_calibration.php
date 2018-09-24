<?php
    include('../connexion/connexionDB.php');
	echo "<h1>Sélection des delai des calibration </h1>";
	$sql=mysql_query("SELECT * FROM materiel");
    while($data=mysql_fetch_array($sql)){
        $IDmat=$data['IDmat'];
        $lastCal=$data['lastCal'];
        $cal=$data['calibrage'];
		$dateNC = strtotime($lastCal."+".$cal." months");
        $dateNC= date('Y-m-d',$dateNC);
        //	echo $dateNC.'<br>';
		$sql2=mysql_query("SELECT * FROM rappel_calibrage where IDmat='$IDmat'");
		while($data2=mysql_fetch_array($sql2)){
		    $x=$data2['rappel'];
			$dateJ = date('Y-m-d');
			$dateNJ = strtotime($dateJ."+".$x." days");
            $dateNJ= date('Y-m-d',$dateNJ);
			if($dateNJ==$dateNC){
			$msg= " Warning!Your calibration for <b>".$IDmat." </b> will fail within a ".$x." days";
			echo $msg."<br>";
            $sql3=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('ADM','LOG','$msg',NOW(),'msg')");
			}
		}
    }

?>