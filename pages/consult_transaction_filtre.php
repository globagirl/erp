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
<link href="../tablecloth/table.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/bootbox.min.js"></script>
<link href="../theme/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<script type='text/javascript' src='../include/scripts/consult_transaction_compte.js'></script>
<title>
Consult transaction
</title>
<script>
//
function consult_transaction(){
    var compte=document.getElementById("compte").value;
    var catT=document.getElementById("catT").value;

		$.ajax({
			url: '../php/consult_transaction_filtre.php',
			type: 'POST',
			data: "compte="+compte+"&catT="+catT,
			success:function(data){
			$('#divRel').html(data);

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
}else if($role=="DIR"){
    include('../menu/menuDirecteur.php');
}elseif($role=="FIN"){
    include('../menu/menuFinance.php');
}elseif($role=="GRH"){
    include('../menu/menuGRH.php');
}else{
	header('Location: ../deny.php');
}

?>
</div>
<div id='contenu'>
<div class="container" >
<div id="page-wrapper">
<div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">Transaction  </h1>
                </div>
                <!-- /.col-md-12 -->
</div>



<div class="row">
 <div class="col-md-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
       Ajout transaction
 </div>
 <div class="panel-body" >

<form role="form" method="post" name="formD" id="formD">
    <div class="col-md-4">
        <div class="form-group" >
          <label>Compte</label>
				  <select class="form-control" id="compte" name="compte">
					<?php
						$q2 = mysql_query("SELECT * FROM compte_banque");
						echo '<option value="S">Selectionnez...</option>';
						while($data2=mysql_fetch_array($q2)) {
							echo '<option value="'.$data2["REFcompte"].'">'.$data2["REFcompte"].'</option>';
            }
					?>
        </select>
			</div>
      <div class="form-group">
        <label>Catégorie </label>
        <select class="form-control" id="catT" name="catT">
          <?php
          $sq3 = "SELECT typeCat,catName FROM invoice_category ";
          $res = mysql_query($sq3) or exit(mysql_error());
          echo '<option value="s">---Categorie</option><br/>';
          while($data=mysql_fetch_array($res)) {
             echo '<option value="'.$data["catName"].'">'.$data["catName"].'</option><br/>';
          }
           ?>
        </select>
      </div>


      <div class="form-group">
         <input type="button" onClick="consult_transaction();" class="btn btn-default blue" Value="Consult >> ">
                <!--<input type="button" onClick="verif_cheque();" class="btn btn-default blue" Value="Ajouter >> ">-->
      </div>
     <div class="col-md-1">
    </div>
		<div class="col-md-5">

    </div>
</form>
</div>
</div>
</div><!-- fin ajout transaction -->
<div class="col-md-12" >
  <div class="table-responsive" id="divRel"></div>
 </div>
</div><!-- fin row -->

</div>
<?php mysql_close(); ?>
</body>

</html>
