<?php
include('../connexion/connexionDB.php');
$OF=$_POST['OF'];
$sql = mysql_query("SELECT * FROM fact_items where idF='$fact'");

if(mysql_num_rows($sql)>0){

$data=mysql_fetch_array($sql);
$statut=$data['statut'];
if($statut=="planned"){
$prd=$data['produit'];
$sql1 = mysql_query("SELECT * FROM produit1 where code_produit='$prd'");
$data1=mysql_fetch_array($sql1);
echo('
 <div class="panel panel-blue2 ">
 <div class="panel-heading">N° OF: '.$data['PO'].' <input  type="text" size="10" id="OF" name="OF" value='.$data['OF'].'  HIDDEN>
<input  type="text" id="statutPO" name="statutPO" value="OK" HIDDEN>
 </div>
 <div class="panel-body" >
   <div class="row">
  <div class="col-lg-6">
  <div class="form-group">
  <label>PO</label>
  <input class="form-control" id="PO" name="PO" value='.$data['qty'].' READONLY>                                         
  </div>
  <div class="form-group">
  <label>Produit</label>
  <input class="form-control" id="PRD" name="PRD" value='.$data['prixU'].' READONLY>  
<p class="help-block">Description :'.$data1['prixT'].'</p>   
  </div>
  <div class="form-group">
  <label>Quantity</label>
  <input class="form-control" id="qte" name="qte" value='.$data['qte'].'>                                            
  </div>
   
  <div class="form-group">
  <label>Date lancement</label>
  <input class="form-control" type="date" name="dateL" value='.$data['date_lance'].' id="dateL">                                           
  </div>
 </div>
<div class="col-lg-6">  
  <div class="form-group">
  <label>Date expédition confirmée</label>
  <input  type="date" class="form-control"   id="dateE" name="dateE" value='.$data['date_exped_conf'].'>                                           
  </div>
  <div class="form-group">
  <label>Nombre des plans</label>
  <input class="form-control"  value='.$data['nbr_plan'].' READONLY>                                           
  </div>
   <div class="form-group">
  <label>Taille du lot</label>
  <input class="form-control"  value='.$data1['taille_lot'].' READONLY>                                           
  </div>
 
  <button type="button" class="btn btn-primary " onClick="updatePlan();">Update </button>                                        
 </div>
</div>
</div>
</div>');

}else{
echo("<table><tr><td>Vous ne pouvez pas modifier cet OF <br> Status :".$statut."  </td></table>");
}
}else{
echo("<table><tr><td> OF introuvable </td></table>");
}
mysql_close();
?>