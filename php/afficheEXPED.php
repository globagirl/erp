<?php 
include('../connexion/connexionDB.php');
$PO=$_POST['PO'];
$i=0;
$sql1=mysql_query("select statut from commande_items where POitem='$PO'");
if(mysql_num_rows($sql1)<1){
echo("  <div class=\"alert alert-danger\">Ce PO n'exixte pas , vérifier vos donnés SVP !!  </div>");
}else{    
$sql=mysql_query("select * from ordre_fabrication1 where PO='$PO'");
while($data=mysql_fetch_array($sql)) {
$i++;
$tab="tab".$i;
$OF=$data['OF'];
$statut=$data['statut'];
echo(" <div class=\"row\" id=\"".$tab."\" >
     <div class=\"col-lg-4\">
     <div class=\"form-group\">
     <label> N° PO </label>
     <input type=\"text\" class=\"form-control\" value=\"".$data['PO']."\"  /READONLY>
     </div>
     <div class=\"form-group\">
     <label> N° ordre de fabrication  </label>
     <input type=\"text\" class=\"form-control\" value=\"".$OF."\"  /READONLY>
     </div>
     <div class=\"form-group\">
     <label> Produit </label>
     <input type=\"text\" class=\"form-control\" value=\"".$data['produit']."\"  /READONLY>
     </div>
     </div>
     <div class=\"col-lg-4\">
     <div class=\"form-group\">
     <label> Quantité </label>
     <input type=\"text\" class=\"form-control\" value=\"".$data['qte']."\"  /READONLY>
     </div>
     <div class=\"form-group\">
     <label> Date lancement  </label>
     <input type=\"text\" class=\"form-control\" value=\"".$data['date_lance']."\"  /READONLY>
     </div>
     <div class=\"form-group\">
     <label> Date expédition </label>
     <input type=\"text\" class=\"form-control\" id=\"dateE\" value=\"".$data['date_exped_conf']."\"  /READONLY>
     </div>
    ");
     if($statut=="in progres"){
        echo "<div class=\"form-group\"><input type=\"button\" class=\"btn btn-primary\" value=\"Valider\" onclick=\"ajoutEXPED('".$OF."','".$tab."');\"></div>";
     }else{
        $stat=@mysql_result($sql1,0);
        echo("  <div class=\"alert alert-danger\">Statut commande : ".$stat."  </div>");
     }
     echo ("</div></div>");

}
}

mysql_close();
?>