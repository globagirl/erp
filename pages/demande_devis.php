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
<title>Demande de prix</title>
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
    var PUN="PU"+i;
		var listeC="listeC"+i;
    $(TX).after('<div class="well" id='+T+'> <b> Produit N°'+i+' </b><input type="text" style="width:150px" id='+itemN+' name='+itemN+' onKeyup=autoComplete("'+itemN+'","'+listeC+'"); onBlur=hideListe("'+listeC+'");prix_produit("'+itemN+'","'+PUN+'") onFocus=autoComplete("'+itemN+'","'+listeC+'")> <input type="text" id='+PUN+' name='+PUN+' size="8" placeholder="Prix unitaire" readonly/><div class="divAuto"><ul id='+listeC+' ></ul></div></div>');
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

function prix_produit(zonePrd,zoneP){
  var prd=document.getElementById(zonePrd).value;
  $.ajax({
          type: 'POST',
          data : 'produit=' + prd,
          url: '../php/produit_prixU.php',
          success: function(data) {
              if(data==0 ){
					         bootbox.alert("Vérifier le code produit SVP !!");
					    }else{
	                document.getElementById(zoneP).value=data;
              }
            //  bootbox.alert(data);
           }});
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
          <div class="col-lg-12"><h1 class="page-header">Demande Devis </h1></div>
      </div>
      <form role="form" method="post" name="form1" id="form1" action="../tcpdf/demande_devis.php" target="_blank">
        <div class="row">
          <div class="col-lg-12" >
            <div class="panel panel-default">
                <div class="panel-heading"> Demande</div>
                  <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4">
                          <?php
                          $sq=@mysql_query("select max(IDdemande) FROM demande_devis");
                          $IDdemande=@mysql_result($sq,0);
                          $IDdemande++;
                          if($IDdemande==1){
                            $IDdemande=101;
                          }
                          mysql_close();
                          ?>
                          <div class="form-group">
						                <label>Demande N°:</label>
							              <input type="text" name="IDdemande" id="IDdemande" value="<?php echo $IDdemande; ?>" class="form-control" readonly>
					                </div>
                          <div class="form-group">
						                <label>Client:</label>
							              <textarea name="client" id="client" class="form-control"></textarea>
					                </div>
                          <div class="form-group">
    						            <label>Devise:</label>
                            <select name="dev" id="devise" class="form-control">
                              <?php include('../include/utile/devise.php'); ?>
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
                           <input type="text" style="width:150px" id="P1" name="P1" onKeyup="autoComplete('P1','listeC1');" onBlur="hideListe('listeC1');prix_produit('P1','PU1')"; onFocus="autoComplete('P1','listeC1')">
                           <input type="text" id="PU1" name="PU1" size="8" placeholder="Prix unitaire" readonly/>
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
