<?php
session_start ();
if( !isset($_SESSION["role"]) ){
    header('Location: ../index.php');
    exit();
}else{
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
include('../connexion/connexionDB.php');
}
?>
<html>
<head>
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/bootbox.min.js"></script>
<title>Facture echantillant</title>
<script>
//Auto complete des articles
function autoComplete(c,l){
var zoneC="#"+c;
var zoneL="#"+l;
var min_length =2;
	var keyword = $(zoneC).val();
	if (keyword.length >= min_length) {

		$.ajax({
			url: '../php/auto_liste_produit.php',
			type: 'POST',
			data: "val="+keyword+"&Z="+zoneC,
			success:function(data){
				$(zoneL).show();
				$(zoneL).html(data);
			}});
	}else {
		$(zoneL).hide();
	}
}
///*
function hideListe(l) {
  var zoneL="#"+l;
	$(zoneL).hide();
	}
//
function choixListe(p,z) {
	$(z).val(p);
}
////////////////////////////////////FIN///////////////




////////////////////////
function addP(){
    var i=document.getElementById('nbr').value;
		var TX="#TR"+i;
		i++;
		document.getElementById('nbr').value=i;
		var T="TR"+i;
    var itemN="P"+i;
    var QN="Q"+i;
    var WN="W"+i;
		var listeC="listeC"+i;
    $(TX).after('<div class="well" id='+T+'> <b> Produit N°'+i+' </b><input type="text" style="width:350px" id='+itemN+' name='+itemN+' onKeyup=autoComplete("'+itemN+'","'+listeC+'"); onBlur=hideListe("'+listeC+'"); onFocus=autoComplete("'+itemN+'","'+listeC+'")> <input type="text" id='+QN+' name='+QN+' size="8" placeholder="Quantité"/><input type="text" id='+WN+' name='+WN+' size="8" placeholder="Poids"/><div class="divAuto"><ul id='+listeC+' ></ul></div></div>');
	}
	///
	function deleteP(){
	var i=document.getElementById('nbr').value;
    if(i>1){
		 var D="#TR"+i;
		 $(D).remove();
     i--;
     document.getElementById('nbr').value=i;
    }
   }

</script>
</head>

<body>
<div id="entete">
<div id="logo">
</div>
<div id="boton">
<?php
include('../include/logOutIMG.php');
?>

</div>
</div>

<div id="main">
<div id="menu">
<?php
if($role=="ADM"){
include('../menu/menuAdmin.php');
}else if($role=="COM"){
include('../menu/menuCommercial.php');
}else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
  <div class="container" >
    <div id="page-wrapper">
      <div class="row">
          <div class="col-lg-12"><h1 class="page-header">facture echantillant </h1></div>
      </div>
      <form role="form" method="post" name="form1" id="form1" action="../tcpdf/facture_echantillant.php" target="_blank">
        <div class="row">
          <div class="col-lg-12" >
            <div class="panel panel-default">
                <div class="panel-heading"> Demande</div>
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-lg-4">
                          <?php
                          $sq=@mysql_query("select max(numFact) FROM facture_echantillon");
                          $IDfact=@mysql_result($sq,0);
                          $IDfact++;
                          if($IDfact==1){
                            $IDfact=101;
                          }
                          mysql_close();
                          ?>
                          <div class="form-group">
						                <label>Facture N°:</label>
							              <input type="text" name="IDfact" id="IDfact" value="<?php echo $IDfact; ?>" class="form-control" readonly>
					                </div>
                          <div class="form-group">
						                <label>Client:</label>
							              <textarea name="client" id="client" class="form-control"></textarea>
					                </div>
                        </div>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-4">
                          <div class="form-group">
    						            <label>Devise:</label>
                            <select name="dev" id="devise" class="form-control">
                              <?php include('../include/utile/devise.php'); ?>
                            </select>
    						         </div>
                         <div class="form-group">
                           <label>Terme payment:</label>
                           <select name="termeP" id="termeP" class="form-control">
                             <?php include('../include/utile/terme_payment.php'); ?>
                           </select>
                        </div>
						          </div>
					       </div>
				      </div>
			      </div>
		      </div>
		      <div class="col-lg-12" >
            <div class="panel panel-default">
                <div class="panel-heading">Produits	</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-9">
						             <div class="well" id="TR1">
                           <b> Produit N°1 </b>
                           <input type="text" style="width:350px" id="P1" name="P1" onKeyup="autoComplete('P1','listeC1');" onBlur="hideListe('listeC1');prix_produit('P1','Q1')"; onFocus="autoComplete('P1','listeC1')">
                           <input type="text" id="Q1" name="Q1" size="8" placeholder="Quantité"/>
                           <input type="text" id="W1" name="W1" size="8" placeholder="Poids"/>
                           <div class="divAuto"><ul id="listeC1" ></ul></div>
							           </div>
                      	</div>
                        <div class="col-lg-3">
                          <div class="well">
                            <input type="button" onclick="addP();" value="+" class="btn btn-primary">
                            <input type="button" onclick="deleteP();"  value="-" class="btn btn-primary">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="panel-footer">
                      <div class="form-group form-inline">
                        <input type="text" name="total" id="total" class="form-control" placeholder="Montant total">
                        <input type="submit"  id="add1" value=" Ajout & Impression" class="btn btn-danger">
                        <input type="text" name="nbr" id="nbr" value="1" style="visibility:hidden">
                      </div>
                    </div>
                  </div>
                </div>
              </div>

</form>
</div>
</div>
</body>
</html>
