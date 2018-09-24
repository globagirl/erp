 <?php
include('../connexion/connexionDB.php');
$valeur=$_POST['valeur'];
$recherche=$_POST['recherche'];
$dateD=$_POST['dateD'];
$dateF=$_POST['dateF'];
$mois1=substr($dateD,0,7);
$mois2=substr($dateF,0,7);

if($mois1==$mois2){
  
   if($recherche=="A"){
      
      $req1= mysql_query("SELECT matricule,nom FROM personnel_info where etat like 'actif' and typeS like 'V'");   
   }else{
      $req1= mysql_query("SELECT matricule,nom FROM personnel_info where $recherche like '$valeur'");
   }
   if(mysql_num_rows($req1)>0){   
    echo '<div><div class="col-lg-12">
		<p style="float:right"><img src="../image/print.png" onclick="printPS();" alt="Print" style="cursor:pointer;" width="60" height="50"  />
		<img src="../image/excel.png" onclick="excelPS();" alt="Excel" style="cursor:pointer;" width="60" height="50"  />
		</p>
        </div>	</div>
		<table  class="table table-fixed results" id="table3">
				<thead style="width:100%">       
			        <tr>
						<th style="width:14.8%;height:60px;text-align:center">Matricule</th>
						<th style="width:24.8%;height:60px;text-align:center">Nom & prenom</th>
						<th style="width:14.8%;height:60px;text-align:center" >Date debut</th>						
						<th style="width:14.8%;height:60px;text-align:center">Date fin</th>
						<th style="width:14.8%;height:60px;text-align:center">Total minute</th>
						<th style="width:14.8%;height:60px;text-align:center">Montant</th>
						
						
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
		if($montant <= 0){
	       $col="#FBEFF5";
	    }else{
	      $col="#E0F8F1";
	    }
		$req4=mysql_query("INSERT INTO personnail_paie_sup(matricule, dateD, dateF, totalM, montant) VALUES('$matricule','$dateD','$dateF','$totalP','$montant')");
		echo"<tr >
		<td  style=\"text-align:center ;width:15%;height:70px;background-color:".$col."\">$matricule</td>
		<td  style=\"text-align:center ;width:25%;height:70px;background-color:".$col."\">$nom</td>
		<td  style=\"text-align:center ;width:15%;height:70px;background-color:".$col."\">$dateD</td>
		<td  style=\"text-align:center ;width:15%;height:70px;background-color:".$col."\">$dateF</td>
		<td  style=\"text-align:center ;width:15%;height:70px;background-color:".$col."\">$totalP</td>
		<td  style=\"text-align:center ;width:15%;height:70px;background-color:".$col."\">$montant</td></tr>";
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