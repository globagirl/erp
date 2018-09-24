<?php
session_start ();
if( !isset($_SESSION["role"]) ){
    header('Location: ../index.php');
    exit();
}else{
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
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

<title>Bande retour</title>
<script>
function afficheListe(){		
    var PO = document.getElementById('PO').value;
	var typeR = document.querySelector('input[name=typeR]:checked').value;
    $.ajax({
        type: 'POST',
        data : 'PO=' +PO+'&typeR=' +typeR,
		url: '../php/liste_sortieBRT.php',
		success:function(data){
				if(data != 0){
				$('#OFD').html(data);
				}else{
				bootbox.alert("Vérifier vos valeur SVP !!");
				}
			}});	
 }

//
function affiche_zone(x){	
    var qte="qteR"+x;
    var chek="chek"+x;    
    if(document.getElementById(chek).checked==false){
		document.getElementById(qte).readOnly=true;
		//alert(x);
	}else{
		document.getElementById(qte).readOnly=false;
	}
}

//
function desactiveEnter(){ 
 if (event.keyCode == 13) { 
      event.keyCode = 0; 
      window.event.returnValue = false; 
 } 
} 
//
function verifier(){	 
    var nbr=document.getElementById('nbr').value;
	var typeR = document.querySelector('input[name=typeR]:checked').value;
	var v=0;
	var j=1;
	var qte="";
	var qteR="";
	var q1=0;
	var q2=0;
	if(typeR=="P"){
	  while ((j<=nbr)&&(v==0)){	
	    qte="qte"+j;
		qteR="qteR"+j;
		q1=document.getElementById(qte).value;
		q2=document.getElementById(qteR).value;
		q1=parseFloat(q1);
		q2=parseFloat(q2);
		if(q1<q2){
		   v=1;
		   document.getElementById(qteR).style.backgroundColor='pink'; 
	    }else{
		   j++;
	    }
     }
	}
	if(v==0){
        document.getElementById('form1').submit(); 
	}else{
        bootbox.alert("Vérifier vos valeur SVP !!");
    }   
}
	  
	
</script>
</head>
<body onKeyDown="desactiveEnter()">

<div id="entete">
<div id="logo">
</div>
<div id="boton">
<?php include('../include/logOutIMG.php');?>	
</div>
</div>

<div id="main">
<div id="menu">
<?php
if($role=="ADM"){
   include('../menu/menuAdmin.php');	
}elseif($role=="CTRL"){
   include('../menu/menuCTRL.php');	
}else{
   header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<div class="container" >
<div id="page-wrapper">
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Bande retour  </h1>
                </div>
                <!-- /.col-lg-12 -->
</div>

<?php
include('../connexion/connexionDB.php');
?>


<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
          Bande retour
 </div>
 <div class="panel-body" >
     <form role="form" method="post" name="form1" id="form1" action="../php/bande_retour.php">
        <div class="row">
		                <div class="pull-left col-md-8">
							<div class="form-group">
								<div class="radio-inline">
                                    <label><input type="radio" name="typeR" id="S1" value="P" checked>Par paquet</label>
								</div>
								<div class="radio-inline">
                                    <label><input type="radio" name="typeR" id="S2" value="R">Rebut </label>
								</div>
							</div>
						</div>
                        <div class="col-lg-12">
                            <div class="form-group form-inline">
								
                                <input type="text" class="search form-control" id="PO" name="PO" placeholder="ID commande">
								<input type="button" onclick="afficheListe();" class="btn btn-danger" Value=">>">
							</div>
						</div>
						<div id="OFD" class="col-lg-12"></div>
		</div>
	</form>
</div>
</div>
</div>
</div>
</div>

</div>


</body>

</html>