 <?php
    include('../connexion/connexionDB.php');
	$recherche=$_POST['recherche'];
	$valeur=@$_POST['valeur'];
	$date1=@$_POST['date1'];
	$date2=@$_POST['date2'];
	if ($date2==""){
        $date2=$date1;
    }
    echo'<table><tr>
        <th></th>
        <th style=text-align:center><b>Matricule</b></th>
		<th style=text-align:center><b>Nom & Prenom</b></th>
		<th style=text-align:center><b>Catégorie</b></th>
		<th style=text-align:center><b>Durée</b></th>
		<th style=text-align:center><b>Raison</b></th>  
    </tr>';	
	if($recherche =="a"){
	    if($date1==""){
	        $req2= mysql_query("SELECT * FROM personnel_permission");
	    }else{
	        $req2= mysql_query("SELECT * FROM personnel_permission where dateP >='$date1' and dateP <='$date2'");
	    }
	}else{
	    $req1= mysql_query("SELECT matricule FROM personnel_info where $recherche LIKE '$valeur%'");
	    $matricule=@mysql_result($req1,0);	 
	    if($date1==""){
		    $req2=@mysql_query("SELECT * FROM personnel_permission where matricule='$matricule'");
	    }else{
	        $req2=@mysql_query("SELECT * FROM personnel_permission where dateP >='$date1' and dateP <='$date2' and matricule='$matricule'");
	    }
	}
    $i=0;
	while($data=@mysql_fetch_array($req2)){
		$i++;
	    $matricule=$data['matricule'];			
		$req3= mysql_query("SELECT * FROM personnel_info where matricule ='$matricule'");
		$a=mysql_fetch_array($req3);
		echo"<tr >
	        <td  style=\"text-align:center \">".$i."</td>
	        <td  style=\"text-align:center \">".$matricule."</td>	       
	        <td  style=\"text-align:center \">".$a['nom']."</td>
			<td  style=\"text-align:center \">".$a['category']."</td>
			<td  style=\"text-align:center \">".$data['nbrH']." mn </td>
			<td  style=\"text-align:center \">".$data['message']."</td>
		</tr>";
	}
	echo '</table>';
?>