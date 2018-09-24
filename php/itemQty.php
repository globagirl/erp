<?php

include('../connexion/connexionDB.php');
$ordre=$_POST['ordre'];
$article=$_POST['article'];
$sql = "SELECT * FROM ordre_achat_article1 where IDordre='$ordre' and IDarticle='$article' ";
$res = mysql_query($sql) or exit(mysql_error());
 $sqlU=mysql_query("select unit from article1 where code_article='$article'");
 $unit=mysql_result($sqlU,0);
$data=mysql_fetch_array($res);
   echo '<b>Requested : <b> '.$data["qte_demande"].' '.$unit.'<p> <b>Received : </b>'.$data["qte_recue"].' '.$unit.'</p>'; 

mysql_close();

?>