<?php    
    include('../connexion/connexionDB.php');
    $article = $_POST['article'];
    $stockR = $_POST['stockR'];
    $stockSys= $_POST['stockSys'];
	$dateI= $_POST['dateI'];
    $val=50;
    $res=false;
    if($stockR>$stockSys){
        if($stockR <= ($stockSys+$val)){
            $res=true;
        }else{
            $res=false;
        }
    }else{
         if($stockSys <= ($stockR+$val)){
            $res=true;
        }else{
            $res=false;
        }
        
    }
    if($res){
      
    $IDinventaire="INV".$dateI;
    $ID=$IDinventaire.$article;
    $sql=mysql_query("INSERT INTO inventaire_items(idIN, IDinventaire, IDarticle, stockSys, stockReel, dateE)
                      VALUES ('$ID','$IDinventaire','$article','$stockSys','$stockR',NOW())");
    $nbr=mysql_affected_rows();
    if($nbr>0){
        echo "1";
    }else{
        echo "0";
    }
    }else{
        echo "2";
    }
    //echo $nbr;
    mysql_close();
  
?>