<?php
    session_start();
    include('../connexion/connexionDB.php');
    $userid=$_SESSION['userID'];
    $IDcartonT=@$_POST['IDcartonT'];
    $IDcartonT=explode(',',$IDcartonT);
    foreach ($IDcartonT as $IDcarton) {
        $sql=@mysql_query("SELECT IDpalette FROM carton_palette WHERE  IDcarton='$IDcarton'");
        $IDpalette=@mysql_result($sql,0);       
       $sql1=@mysql_query("DELETE FROM carton_palette WHERE  IDcarton='$IDcarton'");
       //echo '<br>'.var_dump($IDcartonT);
        if($IDpalette != 'X'){
            //Update palette
            $sq=@mysql_query("SELECT count(IDcarton) As nbrCarton ,sum(qte) As totalQte,sum(poids) As Tpoids FROM carton_palette
				  where IDpalette LIKE '$IDpalette'");
            $data=mysql_fetch_array($sq);
            $nbrCarton=$data['nbrCarton'];
            $totalQte=$data['totalQte'];
            $poids=$data['Tpoids'];
            $poids=round($poids,2);
            $sq2=@mysql_query("UPDATE palette SET nbrCarton='$nbrCarton',totalQte='$totalQte',poids='$poids'
                       WHERE IDpalette='$IDpalette'");
        }
      
    }
    $msg="a supprimé des cartons ";
    $His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','$msg','Carton','$IDcarton',NOW())");
    mysql_close();
?>