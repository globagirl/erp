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
			url: '../php/auto_liste_article.php',
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
function addA(){

        var i=document.getElementById('nbr').value;
		var TX="#TR"+i;
		i++;
		document.getElementById('nbr').value=i;

		var T="TR"+i;

        var itemN="I"+i;
        var qtyN="Q"+i;

		var listeC="listeC"+i;
       $(TX).after('<div class="well" id='+T+'> <b> Article N°'+i+' </b><input type="text" style="width:150px" id='+itemN+' name='+itemN+' onKeyup=autoComplete("'+itemN+'","'+listeC+'"); onBlur=hideListe("'+listeC+'"); onFocus=autoComplete("'+itemN+'","'+listeC+'")> <b>Quantité </b><input type="text" id='+qtyN+' name='+qtyN+' size="8" placeholder="QTE" /><div class="divAuto"><ul id='+listeC+' ></ul></div></div>');
	}
	///
	function deleteI(){
	var i=document.getElementById('nbr').value;
    if(i>1){
		var D="#TR"+i;


		$(D).remove();

   	     i--;
         document.getElementById('nbr').value=i;
     }

   }

function affichelisteF(){
        $.ajax({
        type: 'POST',

        url: '../php/listeFournisseur.php',
        success: function(data) {
        $('#four').html(data);
       }});


}


</script>
</head>

<body onLoad="affichelisteF();">
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
          <div class="col-lg-12"><h1 class="page-header">Demande des prix </h1></div>
      </div>
      <form role="form" method="post" name="form1" id="form1" action="../tcpdf/demande_prix_article.php" target="_blank">
        <div class="row">
          <div class="col-lg-12" >
            <div class="panel panel-default">
                <div class="panel-heading"> Demande</div>
                  <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4">
                          <?php
                          $sq=@mysql_query("select max(IDdemande) FROM demande_prix");
                          $IDdemande=@mysql_result($sq,0);
                          $IDdemande++;
                          mysql_close();
                          ?>
                          <div class="form-group">
						                <label>Demande N°:</label>
							              <input type="text" name="IDdemande" id="IDdemande" value="<?php echo $IDdemande; ?>" class="form-control" readonly>
					                </div>
                          <div class="form-group">
						                <label>Fournisseur:</label>
							              <select name="four" id="four"  class="form-control"></select>
					                </div>
						              <div class="form-group">
						                <label>Date demandée par Starz:</label>
							              <input type="date" name="dateD" id="dateD" class="form-control">
						             </div>
						          </div>
						          <div class="col-lg-1"></div>
                      <div class="col-lg-4">
                      <div class="form-group">
                        <label>Terme de payment:</label>
                        <select name="tpay" type="text" class="form-control">
						            <?php include('../include/utile/terme_payment.php'); ?>
                        </select>
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
                <div class="panel-heading">Articles	</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-9">
						             <div class="well" id="TR1">
                           <b> Article N°1 </b>
                           <input type="text" style="width:150px" id="I1" name="I1"onKeyup="autoComplete('I1','listeC1');" onBlur="hideListe('listeC1')"; onFocus="autoComplete('I1','listeC1')">
                           <b> Quantité  </b>
                           <input type="text" id="Q1" name="Q1" size="8" placeholder="QTE" />
                           <div class="divAuto"><ul id="listeC1" ></ul></div>
							           </div>
                      	</div>
                        <div class="col-lg-3">
                          <div class="well">
                            <input type="button" onclick="addA();" value="+" class="btn btn-primary">
                            <input type="button" onclick="deleteI();"  value="-" class="btn btn-primary">
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
