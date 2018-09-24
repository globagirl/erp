<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <title>Afficher la liste des commande</title>
  </head>
  <body>
<h2>Commande</h2>
  <?php
  include('../connexion/connexionDB.php');
  $query='SELECT * FROM commande';
  $r=mysql_query($query);
  mysql_close();
  echo'<table border="1" bordercolor="BLUE" ><tr><td>Num_po</td><td>Client</td><td>date_recep_cmd</td><td>date_entr_cmd</td><td>date_demande_client</td><td>date_exped</td><td>code_article</td><td>qtu_cmd</td><td>Prix_unit</td><td>Prix_total</td><td>devise</td><td>term_paym</td></tr>';
  while($a=mysql_fetch_object($r))
    {
    $num_po=$a->num_po;
    $client=$a->client;
	$date_recep_cmd=$a->date_recep_cmd;
	$date_entr_cmd=$a->date_entr_cmd;
	$date_demande_client=$a->date_demande_client;
	$date_exped=$a->date_exped;
	$code_article=$a->code_article;
	$qtu_cmd=$a->qtu_cmd;
	$prix_unit=$a->prix_unit;
    $prix_total=$a->prix_total;
	$devise=$a->devise;
	$term_paym=$a->term_paym;
    echo"<tr><td>$num_po</td><td>$client</td><td>$date_recep_cmd</td><td>$date_entr_cmd</td><td>$date_demande_client</td><td>$date_exped</td><td>$code_article</td><td>$qtu_cmd</td><td>$prix_unit</td><td>$prix_total</td><td>$devise</td><td>$term_paym</td></tr>";
    }
  echo '</table>';
  ?>
<br/>
<br/>

  </body>
</html>