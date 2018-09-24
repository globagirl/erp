 <?php
    include('../connexion/connexionDB.php');
    $mat=@$_POST['matricule'];	
    $nbrH=@$_POST['nbrH'];	
    $dateD=@$_POST['dateD'];	
    $dateF=@$_POST['dateF'];	
    $req= "INSERT INTO personnel_heure_allait(matricule, nbrH, dateD, dateF) VALUES ('$mat','$nbrH','$dateD','$dateF') ";			
    if (!mysql_query($req)) {
      die('Error: ' . mysql_error());   
    }else{
	  echo "Heure d'allaitement ajouté avec succés";
	}
    
    mysql_close(); 
  ?>