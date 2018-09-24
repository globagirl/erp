<?php
//To delete
include('../connexion/connexionDB.php');
$PO=$_POST['commande'];
$sql=mysql_query("SELECT OF,produit,date_exped_conf,qte,statut FROM ordre_fabrication1 where PO='$PO'");
if(mysql_num_rows($sql)>0){
    $data=mysql_fetch_array($sql);
	$produit=$data['produit'];	
	$qte = $data['qte'];
	$statut = $data['statut'];	
	$sql2 = mysql_query("SELECT description,nbr_box FROM produit1 where code_produit='$produit'");
	$data2=mysql_fetch_array($sql2);
	
	$nbP=$data2['nbr_box'];
	if($nbP==0){
	    $box=1;
    }else if($nbP>$qte){
        $box=1;
    }else{
        $box=$qte/$nbP;
    }
	$box=$box+0.4;
	$box=round($box);
//Fin verification
echo(' <div class="panel panel-blue2 ">
<div class="panel-heading">N° PO: '.$PO.'</div>
<div class="panel-body" >
  <div class="row">');
 if(($statut != "in progres") && ($statut != "planned")&& ($statut != "finished")){
       echo("<div class=\" panel panel-red red\">Statut commande : ".$statut."</div>");
	  }
echo ('<div class="col-lg-6">
        <div class="form-group">
			<label>OF</label>
			<input class="form-control" id="OF" name="OF" value='.$data['OF'].' READONLY>
		</div>
		<div class="form-group">
            <label>Produit </label>
			<input class="form-control" id="prd" name="prd" value='.$data['produit'].' READONLY>            
            <textarea class="form-control" rows="1" id="desc" name="desc">'.$data2['description'].' </textarea>                                           
        </div>');
echo ("<div class=\"form-group\">
        <label>Date expedition</label>
				<input  type=\"date\" class=\"form-control\" value=\"".$data['date_exped_conf']."\" id=\"dateE\" name=\"dateE\" READONLY>
			</div>
		
			<div class=\"form-group\">
			  <label>Quantity</label>
				<input class=\"form-control\" id=\"qty\" name=\"qty\" value=\"".$data['qte']."\" READONLY>                                           
      </div>
			<div class=\"form-group\">
			  <label>Quantity par carton</label>
				<input class=\"form-control\" id=\"qtyB\" name=\"qtyB\" value=\"".$data2['nbr_box']."\" READONLY>                                           
      </div>
			<div class=\"form-group\">
        <label>Nbr carton total</label>
				<input class=\"form-control\" id=\"nbrBT\" name=\"nbrBT\" value=\"".$box."\" READONLY>
			</div>
	 
	</div>
	<div class=\"col-lg-6\">
	  <div class=\"well\">
		  <div class=\"form-group\">
			  <label>Debut ==> Nbr cartons</label>
              <div class=\"form-inline\">
					  <input class=\"form-control\"  id=\"FR\" name=\"FR\" value=\"1\"/>
					  <input class=\"form-control\"  id=\"nbrB\" name=\"nbrB\" value=\"".$box."\"/>
			  </div>
          </div>
		  <div class=\"form-group\">
              <label>N° palette </label>
			  <input class=\"form-control\" id=\"numP\" name=\"numP\">  
          </div>");
   
    echo ' <div class=\"form-group\">
		<input type="button" class="btn btn-primary" onclick="tickPaq()" target="_blank" value="TICKET CARTON  >>" >
		</div>
		</div>';
		echo ("<div class=\"well\">
		  <div class=\"form-group\">
			  <label>Debut ==> Nbr des saches</label>
              <div class=\"form-inline\">
					<input class=\"form-control\"  id=\"frBag\" name=\"frBag\" value=\"1\"/>
					<input class=\"form-control\"  id=\"nbrBag\" name=\"nbrBag\" value=\"".$data['qte']."\" />
			  </div>
          </div>");
	  echo '<div class="form-group">
      <button type="button" class="btn btn-success" onclick="tickBag()" target="_blank">TICKET SACHET  >> </button>     
      </div>
      </div>
      </div>';   
	
echo ("
</div>
</div>
</div>
</div>

");
}


mysql_close();

?>