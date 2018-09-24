 <?php
include('../connexion/connexionDB.php');

$valeur=$_POST['valeur'];

$pos1="|";
$n=strpos($valeur,$pos1);
$recherche=substr($valeur,0,$n); //definir recherche par ? 
$l=strlen($valeur);
$valeur=substr($valeur,$n+1,$l); //mettre a jour la chaine

$val= $valeur;//definir valeur




		if ($recherche=="a"){
$req= "SELECT * FROM cable_par_carton ";
}
	else if ($recherche=="long"){
$req= "SELECT * FROM cable_par_carton where length='$val'";
}

else if($recherche=="qteB"){
$req= "SELECT * FROM cable_par_carton where qte_par_box='$val'";
}
else if($recherche=="tlot"){
$req= "SELECT * FROM cable_par_carton where  taille_lot='$val'";
}
else if($recherche=="nbrP"){
$req= "SELECT * FROM cable_par_carton where nbr_paquet='$val'";
}



  $r=mysql_query($req) or die(mysql_error());

  echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead><tr><td>Longueur</td><td>Quantité par box</td><td>Taille de lot</td><td>Nombre paquet</td>
  </tr>';
  while($a=mysql_fetch_object($r))
    {
	
	
	
    $long =$a->length;
    $qteB =$a->qte_par_box;
	$tlot=$a->taille_lot;
	$nbr =$a->nbr_paquet;
	
	
    echo"<tr><td>$long</td><td>$qteB</td><td>$tlot</td><td>$nbr</td></tr>";
    }
  echo '</thead></table>';

mysql_close();

  ?>