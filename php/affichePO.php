<?php
include('../connexion/connexionDB.php');
$commande=$_POST['commande'];
$mSQ=mysql_query("SELECT max(OF) FROM ordre_fabrication1");
$max=mysql_result($mSQ,0);
$OF=$max+1;


$sql = mysql_query("SELECT * FROM commande_items where POitem='$commande'");
$data=mysql_fetch_array($sql);
	$produit=$data['produit'];
	$PO=$data['PO'];
	$qte = $data['qty'];
	$sql = mysql_query("SELECT * FROM commande2 where PO='$PO'");
  $data1=mysql_fetch_array($sql);
	$sql2 = mysql_query("SELECT * FROM produit1 where code_produit='$produit'");
	$data2=mysql_fetch_array($sql2);
	$desc=$data2['description'];
	$cat=$data2['categorie'];
////Determiner la quantité lancée & la qte qui reste 
///////// QTEL 
$qteL=0;
$sql1=mysql_query("SELECT * FROM ordre_fabrication1 where PO='$commande'");
if(mysql_num_rows($sql1) >0){
	while($data3=mysql_fetch_array($sql1)) {
		$qteL=$qteL+$data3['qte'];
	}
}
/////////QTE
$qteP=$qte-$qteL;
///////////	
	
/////OF cable 
	if(($cat != "PCB") and ($cat != "Others")){
	
	$tlots=$data2['taille_lot'];
	
								

$cmdcal=$qteP;
if($cmdcal>$tlots){						
								if (($cmdcal%$tlots)==0)
								{
								$divs = $cmdcal/$tlots;
								$totale = $divs;
								$plan=$tlots;
								$planS=0;
								
								}
								else 
								{
								$divs = $cmdcal/$tlots;
								$totale = intval($divs);
								$totale++;
								$planS=$cmdcal%$tlots;
								$plan=$tlots;
								}
								}
								else{
									$totale=1;
									$plan=$cmdcal;
									$planS=0;
								}
								$dateN=date("d-m-Y");


///////////
//Vérification des produits non TE 
$sqlV=mysql_query("SELECT etat FROM fin_alert where produit='$produit'");
if(@mysql_num_rows($sqlV)>0){
$etat=mysql_result($sqlV,0);
if($etat=="F"){
echo("<br><div class=\"panel panel-red red\">Don't use cable with TE logo for this ITEM</div>");
}else{
echo('<br><div class="panel panel-green green ">You can still use cable with TE logo until end of Janury </div>');
}

}
//Fin verification
echo('<br>
 <div class="panel panel-blue2 ">
 <div class="panel-heading">N° OF: '.$OF.' <input  type="text" size="10" id="OF" name="OF" value='.$OF.'  HIDDEN> </div>
  <div class="panel-body" >
   <div class="row">
  <div class="col-lg-6">
	<div class="form-group">
  <label>UPC</label>
  <input class="form-control" id="UPC" name="UPC" value='.$data1['UPC'].'>

  </div>
  <div class="form-group">
  <label>Item ID</label>
  <input class="form-control" id="PRD" name="PRD" value='.$data['produit'].' READONLY>
	<p class="help-block">Description :'.$desc.'</p>
  </div>
  <div class="form-group">
  <label>Quantity</label>
  <input class="form-control" id="qteC" name="qteC" value='.$data['qty'].' READONLY>                                            <p 
  </div>
  <div class="form-group">
  <label>Date demandée par client</label>
  <input class="form-control"  value='.$data1['date_demande_client'].' READONLY>                                           
  </div> 
  <div class="form-group">
  <label>Date expédition confirmée</label>
  <input class="form-control"  value='.$data1['date_exped'].' READONLY>                                           
  </div>

  <div class="form-group">
  <label>Quantité Lancée</label>
  <input class="form-control"  id="qteL" name="qteL"  value='.$qteL.' READONLY >                                           
  </div>
 </div>
</div>');
echo ("<div class=\"col-lg-6\">
 <div class=\"form-group\">
  <label>Quantité planifiée:</label>
 <input class=\"form-control\"  id=\"qteP\" name=\"qteP\" onBlur=\"updateP('".$tlots."');\" value=\"".$qteP."\">                                           
  </div>

<div class=\"form-group\">
  <label>Nombre des plans</label>
  <input class=\"form-control\"  id=\"nbP\" name=\"nbP\" value=\"".$totale."\"/  READONLY>                                           
  </div>
<div class=\"form-group\">
  <label>Quantité par plan</label>
	<div class=\"form-group form-inline\">
<input  type=\"text\" class=\"form-control\"  id=\"plan\" name=\"plan\" value=\"".$plan."\"/  READONLY>
 *<input type=\"text\" class=\"form-control\"  id=\"planS\" name=\"planS\" value=\"".$planS."\"/  READONLY>
 </div>
</div>
<div class=\"form-group\">
  <label>Date expedition</label>
<input  type=\"date\" class=\"form-control\" id=\"dateE\" name=\"dateE\" >
</div>
<div class=\"form-group\">
  <label>Date lancement</label>
<input  type=\"date\" class=\"form-control\" id=\"dateL\" name=\"dateL\" ></div>
 <button type=\"submit\" class=\"btn btn-primary \" onclick=\"ajoutOF()\">Submit </button>
 <button type=\"Reset\" class=\"btn btn-danger\">Reset </button>

</div>
</div>
</div>
</div>

");}
//////Cas PCB & Others

else{
/*
echo("<table> <TR>	<Th Wcode_articleTH=150 HEIGHT=30 colspan=5 >N° OF: ".$OF." <input  type=\"text\" size=\"10\" id=\"OF\" name=\"OF\" value=\"".$OF."\"/  HIDDEN> </Th></tr>
<TR>	<Th Wcode_articleTH=150 HEIGHT=30  >Code Article:  </Th>
<td colspan=3>".$data['produit']." <input  type=\"text\" size=\"10\" id=\"PRD\" name=\"PRD\" value=\"".$data['produit']."\"/  HIDDEN></td></tr>
<tr><th>Description: </th>
<td colspan=3>".$desc."</td></tr>
<TR>	<Th Wcode_articleTH=150 HEIGHT=30  >Quantité commande:</Th>
<td colspan=3>".$data['qty']." <input  type=\"text\" size=\"10\" id=\"qteC\" name=\"qteC\"  value=\"".$data['qty']."\"/Hidden ></td></tr>
<TR>	<Th Wcode_articleTH=150 HEIGHT=30  >Date demandée par client:</Th>
<td> ".$data1['date_demande_client']."</td>
<th>Date expédition confirmée: </th>
<td>".$data1['date_exped']."</td></tr>
<TR>	<Th Wcode_articleTH=150 HEIGHT=30  >Quantité Lancée:</Th>
<td> <input  type=\"text\" size=\"10\" id=\"qteL\" name=\"qteL\"  value=\"".$qteL."\"/READONLY ></td>
<th>Quantité planifiée: </th>
<td><input  type=\"text\" size=\"10\" id=\"qteP\" name=\"qteP\"  onBlur=\"updateP2();\" value=\"".$qteP."\"/ > </td></tr>
<th>Nombre des plans: </th>
<td> <input  type=\"text\" size=\"10\" id=\"nbP\" name=\"nbP\" value=\"1\"></td>
<th>Quantité par plan: </th>
<td><input  type=\"text\" size=\"10\" id=\"plan\" name=\"plan\" value=\"".$qteP."\"> *<input type=\"text\" size=\"10\" id=\"planS\" name=\"planS\" value=\"0\"></td>


</tr>


<TR>	<Th Wcode_articleTH=150 HEIGHT=30  >Date expedition:</Th>
<td> <input  type=\"date\" size=\"10\" id=\"dateE\" name=\"dateE\" ></td>
<th>Date lancement: </th>
<td> <input  type=\"date\" size=\"10\" id=\"dateL\" name=\"dateL\" ></td></tr>
<tr><td ></td><td colspan=3><input type=\"button\" id=\"submitbutton\" value=\"Valider\" onclick=\"ajoutOF()\"/></td>
</div>
</div>


");
*/
echo 0;
}
mysql_close();
?>