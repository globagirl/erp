 <?php
    session_start();
	$role=$_SESSION['role'];
    include('../connexion/connexionDB.php');
    $IDsortie=$_POST['IDsortie']; 
    
	$req1= mysql_query("SELECT * FROM bande_sortie where IDsortie='$IDsortie'");
	$data=mysql_fetch_array($req1);
	$IDop=$data['IDoperateur'];
	$IDcont=$data['IDcontroleur'];
	$statut=$data['statut'];
	$req2= mysql_query("SELECT nom FROM users1 where ID='$IDop'");
	$op=mysql_result($req2,0);
	$req3= mysql_query("SELECT nom FROM users1 where ID='$IDcont'");
	$cont=mysql_result($req3,0);
	
    echo '<div><b>Operateur : '.$op.'  </b>';
    echo '<br><b>Controleur : '.$cont.'</b><br><br>';
	
	echo '<table class="table table-striped table-bordered table-hover ">';
	echo '<tr><th>Paquet </th><th> QTY</th><th>QTY Retour</th></tr>';
	$req= "SELECT * FROM sortie_items where IDbande='$IDsortie' and typeS='P'";
    $r=mysql_query($req) or die(mysql_error());
    while($a=mysql_fetch_array($r)){
	    $rebut=	$a['rebut'];
		if($rebut=="Y"){
		echo ('<tr><td">REBUT : '.$a['IDpaquet'].'</td>');
		}else{		
		echo ('<tr><td >'.$a['IDpaquet'].'</td>');
		}
		echo ('<td>'.$a['qte'].'</td>');
		echo ('<td>'.$a['qteR'].'</td></tr>');												
    }
	if(($statut=="N")and (($role=="CTRL")||($role=="ADM")) ){
	    echo "<tr><td style=\"width:50%;height:40px;text-align:center\">														
		<input type=\"button\" onClick=confirm_sortie('".$IDsortie."'); Value=\"Confirmer >> \" class=\"btn btn-danger\"></td></tr></table></div>";
	}else{
	    echo "</table></div>";
	}
    mysql_close();
  ?>