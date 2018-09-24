 <?php
    include('../connexion/connexionDB.php');
    $val=$_POST['valeur'];
    $recherche=$_POST['recherche'];
    $statut=$_POST['statut'];
    if($statut=="A"){
		if ($recherche=="A"){
            $req= "SELECT * FROM ordre_fabrication1 order by OF DESC ";
        }else{
            $req= "SELECT * FROM ordre_fabrication1 where $recherche='$val' order by OF DESC";
        }
	}else{	
		if ($recherche=="A"){
            $req= "SELECT * FROM ordre_fabrication1 where statut='$statut' order by OF DESC";
        }else{
            $req= "SELECT * FROM ordre_fabrication1 where  $recherche='$val' and statut='$statut' order by OF DESC";
        }
    }
    $r=mysql_query($req) or die(mysql_error());
    while($a=mysql_fetch_array($r)){	
        $OF =$a['OF'];
		$req1= mysql_query("SELECT qte_p FROM plan1 where OF='$OF'");
		$qte_p=mysql_result($req1,0);	
        echo("<tr><td style=\"width:10%;height:40px;text-align:center\" class=\"tdTab\" onClick=affichePlan('".$OF."')>".$OF."</td>");
	    echo ('<td  style="width:15%;height:40px;text-align:center">'.$a['PO'].'</td>
		<td  style="width:15%;height:40px;text-align:center">'.$a['produit'].'</td>
		<td style="width:8%;height:40px;text-align:center">'.$a['qte'].'</td>
		<td style="width:8%;height:40px;text-align:center">'.$a['nbr_plan'].'</td>
		<td style="width:8%;height:40px;text-align:center">'.$qte_p.'</td>
		<td style="width:12%;height:40px;text-align:center">'.$a['date_lance'].'</td>
		<td style="width:12%;height:40px;text-align:center">'.$a['date_exped_conf'].'</td>
		<td style="width:12%;height:40px;text-align:center">'.$a['statut'].'</td></tr>
	    ');
    }
    mysql_close();


  ?>