<?php
    include('../connexion/connexionDB.php');
    $IDpalette= $_POST['IDpalette'];
    $sq=@mysql_query("SELECT statut FROM palette where IDpalette='$IDpalette'");
	$statut=mysql_result($sq,0);
	if($statut != "closed"){    	
    $IDcart= $_POST['IDcarton']; 
    $IDcart=explode(',',$IDcart);
	$x=1;
	foreach($IDcart as $IDcarton){	
	   $sql2=@mysql_query("UPDATE carton_palette SET IDpalette='$IDpalette' WHERE IDcarton='$IDcarton'");
    }
	//Update palette
    $sql=mysql_query("SELECT count(IDcarton) As nbrCarton ,sum(qte) As totalQte,sum(poids) As Tpoids FROM carton_palette
				  where IDpalette LIKE '$IDpalette'");
    $data=mysql_fetch_array($sql);
    $nbrCarton=$data['nbrCarton'];
    $totalQte=$data['totalQte'];
    $poids=$data['Tpoids'];
    $poids=round($poids,2);
    $sql3=@mysql_query("UPDATE palette SET nbrCarton='$nbrCarton',totalQte='$totalQte',poids='$poids'
                       WHERE IDpalette='$IDpalette'");
    //Determiner type palette
	$sq1=@mysql_query("SELECT DISTINCT(PO) FROM carton_palette where IDpalette LIKE '$IDpalette'");
	$nb1=@mysql_num_rows($sq1);
	$sq2=@mysql_query("SELECT DISTINCT(IDproduit) FROM carton_palette where IDpalette LIKE '$IDpalette'");
    $nb2=@mysql_num_rows($sq2);
	if($nb1==1 && $nb2==1){
	    $sq3=@mysql_query("UPDATE palette SET typeP='3S' WHERE IDpalette='$IDpalette'");
	}else if($nb1==1 && $nb2 > 1){
	    $sq3=@mysql_query("UPDATE palette SET typeP='5S' WHERE IDpalette='$IDpalette'");
	}else if($nb1>1 && $nb2 == 1){
	    $sq3=@mysql_query("UPDATE palette SET typeP='6S' WHERE IDpalette='$IDpalette'");
	}else if($nb1>1 && $nb2 > 1){
	    $sq3=@mysql_query("UPDATE palette SET typeP='7S' WHERE IDpalette='$IDpalette'");
	}
    }//Fin foreach

    mysql_close();
?>