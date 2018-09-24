 <meta charset="utf-8" />
 <?php
 // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=pay_sup.xls");
include('../connexion/connexionDB.php');
$valeur=$_POST['valeur'];
$recherche=$_POST['recherche'];
$dateD=$_POST['dateD'];
$dateF=$_POST['dateF'];
$mois1=substr($dateD,0,7);
$mois2=substr($dateF,0,7);

if($mois1==$mois2){
  
   if($recherche=="A"){
      
      $req1= mysql_query("SELECT matricule,nom FROM personnel_info where etat like 'actif'");   
   }else{
      $req1= mysql_query("SELECT matricule,nom FROM personnel_info where $recherche like '$valeur'");
   }
   if(mysql_num_rows($req1)>0){   
    echo '
		<table  border="1" class="table table-fixed results" id="table3">
				<thead style="width:100%">       
			        <tr>
						<th style="width:14.8%;height:60px;text-align:center">Matricule</th>
						<th style="width:24.8%;height:60px;text-align:center">Nom & prenom</th>
						<th style="width:14.8%;height:60px;text-align:center" >Date debut</th>						
						<th style="width:14.8%;height:60px;text-align:center">Date fin</th>
						
						<th style="width:14.8%;height:60px;text-align:center">Montant</th>
						<th style="width:14.8%;height:60px;text-align:center">Visa</th>
						
				    </tr>
				</thead>
			<tbody id="tbody" style="width:100%">';   
	while($a=mysql_fetch_object($req1)){	  
	  $matricule=$a->matricule;
	  $nom=$a->nom;
	  $req2= mysql_query("SELECT nbm_mois,salaire_base FROM personnel_salaire where matricule like '$matricule'"); 
      if(mysql_num_rows($req2)>0){
	     $b=mysql_fetch_object($req2);
		 $salaireB=$b->salaire_base;
		 $nbrT=$b->nbm_mois;
		 $payMN=$salaireB/$nbrT;
		 $dateX=$dateD;
		 $totalP=0;
		 while($dateX <= $dateF){
		    $req3 = mysql_query("SELECT totalMF FROM personnel_pointage where dateP LIKE '$dateX' and matricule='$matricule'");
	        $totalMP=@mysql_result($req3,0);
			$totalP=$totalP+$totalMP;
			//ajout d'un jour
			$dateX=strtotime($dateX);
			$dateX=strtotime("+1 day",$dateX);
			$dateX=date("Y-m-d",$dateX);
	    }//fin while
	    $montant=$payMN*$totalP;
		$montant=round($montant);
		if($montant > 0){
	      echo"<tr >
		<td  style=\"text-align:center ;width:15%;height:40px;\">$matricule</td>
		<td  style=\"text-align:center ;width:25%;height:40px;\">$nom</td>
		<td  style=\"text-align:center ;width:15%;height:40px;\">$dateD</td>
		<td  style=\"text-align:center ;width:15%;height:40px;\">$dateF</td>
		
		<td  style=\"text-align:center ;width:15%;height:40px;\">$montant</td>
		<td  style=\"text-align:center ;width:15%;height:40px;\"></td>
		
		</tr>";
	    }
		
		
	 }
    }    	 
  }else{
     echo "<b>cet personnel n'existe pas </b>" ;
  }
	
}else{ //else ne sont pas du méme mois
 echo "<b>Vérifier vos dates SVP , il doivent étre du méme mois</b>" ;
}
 mysql_close();
  ?>