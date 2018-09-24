<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
  <meta charset="utf-8" />
    <title>consultation stock</title>

<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
  </head>
  <body>
<h2>consultation stock</h2>

<form method="post">
<table>
<tr>
<th>Date expidition confirmer: </th>
<td>
<input type="date" name="date_exped">
</td>
<th>Numero PO: </th>
<td>
<input type="text" name="numpo" id="num_po">
</td>
<th>code article </th>
<td>
<input type="text" name="code_art">
</td>
<td>
<input type="submit" value="afficher" target="_blank">

</td>
</tr>
</table>

  <?php
 
// Fonction construction des requete
function getRequete($a)
{

$requete="select * from recep_ordr_acha where ";

foreach($a as $cle => $val)
{ 
  $requete.= "".$cle."='".$val."' and " ;
}

 $requete.=" 1=1 " ;

return $requete ;

}
// fin construction req

include('../connexion/connexionDB.php');

$arr = array();

$num_po = @$_POST["numpo"];
if( !empty($num_po))
$arr['num_po']=$num_po;

$code_artic = @$_POST["code_art"];
if( !empty($code_artic))
$arr['code_article']=$code_artic;

$date = @$_POST['date_exped'];
if( !empty($date))
$arr['date_exped']=$date;

$req = getRequete($arr) ;
  $r=mysql_query($req) or die(mysql_error());;

  mysql_close();
  echo'<table border="1" bordercolor="BLUE"><tr><td>id_box</td><td>num_ordr_achat</td><td>code article</td><td>quantité</td></tr>';
  while($a=mysql_fetch_object($r))
    {
    $num_po=$a->id_box;
    $client=$a->num_ordr_achat;
	$date_recep_cmd=$a->code_article;
	$date_entr_cmd=$a->qtu_box;

    echo"<tr><td>$num_po</td><td>$client</td><td>$date_recep_cmd</td><td>$date_entr_cmd</td></tr>";
    }
  echo '</table>';
  
  ?>
<br/>
<br/>

  </body>
</html>