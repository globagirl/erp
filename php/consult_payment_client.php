 <?php
    include('../connexion/connexionDB.php');
    
    $val1=@$_POST['valeur1'];
    $val2=@$_POST['valeur2'];
    $recherche=$_POST['recherche'];
    
    if ($recherche=="A"){
        $req= "SELECT * FROM payment_client order by dateP desc";
    }else if($recherche=="dateE" || $recherche=="dateP"){
        $req= "SELECT * FROM payment_client where $recherche >= '$val1' and $recherche <= '$val2' order by dateP desc";
    }else{
		$req= "SELECT * FROM payment_client where $recherche = '$val1' order by dateP desc";
	}
	
    $r=mysql_query($req) or die(mysql_error());
	$x=0;
    while($a=mysql_fetch_array($r)){       
	    $x++;
     $IDpay=$a['IDpay'];
     $IDclient=$a['client'];
     $req1= mysql_query("SELECT nomClient FROM client1 where name_client='$IDclient'");
     $client=@mysql_result($req1,0);
        
		echo ('<tr>
		<td style="width:20%;height:40px;text-align:center">'.$a['IDpay'].'</td>
		<td style="width:20%;height:40px;text-align:center">'.$client.'</td>
		<td style="width:15%;height:40px;text-align:center">'.$a['dateP'].'</td>
		<td style="width:20%;height:40px;text-align:center">'.$a['compte'].'</td>
		<td style="width:15%;height:40px;text-align:center">'.$a['solde'].'</td>
		<td style="width:10%;height:40px;text-align:center">');
														
		echo "<img src=\"../image/viewFile.png\" onclick=affichePayInfo('".$IDpay."'); alt=\"see\" style=\"cursor:pointer;\" width=\"30\" height=\"30\"  /></td></tr>";
    }
  

//echo($val);

  ?>