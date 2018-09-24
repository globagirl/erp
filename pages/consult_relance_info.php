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
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
<script src="../theme/dist/js/sb-admin-2.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<link href="../theme/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="../theme/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
<script src="../theme/bower_components/metisMenu/dist/metisMenu.min.js"></script>
<title>Bande relance</title>
<script> 
//Confirmation relance
function relance_confirme(ID){
			  $.ajax({
                type: 'POST',
				data:'IDrelance='+ID,
				url: '../php/bande_relanceC.php',
				success: function(data) {
                     document.location.href="../pages/consult_relance_info.php";
                }});

            }
//Refuser relance
	function relance_refuse(ID){
			  $.ajax({
                type: 'POST',
				data:'IDrelance='+ID,
				url: '../php/bande_relanceR.php',
				success: function(data) {
                     document.location.href="../pages/consult_relance_info.php";
                }});

            }
///Confirmer la sortie du stock du relance
function confirm_sortieRL(ID){
			  $.ajax({
                type: 'POST',
				data:'IDrelance='+ID,
				url: '../php/confirm_bandeRL_sortie.php',
				success: function(data) {                    
					 location.reload();
                }});
}

function changePage(){
	document.location.href="../pages/consult_bande_relance.php";
}	
</script> 
</head>

<body >

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
}else if($role=="CTRL"){
   include('../menu/menuCTRL.php');	
}else if($role=="MAG"){
   include('../menu/menuMagazin.php');	
}else if($role=="LOG"){
   include('../menu/menuLogistique.php');	
}else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>


<div class="container">

<?php
include('../connexion/connexionDB.php');
if(isset($_POST['IDrelance'])){
$IDrelance=$_POST['IDrelance'];
$_SESSION['IDrelance']=$IDrelance;	
}
else{
	$IDrelance=$_SESSION['IDrelance'];
	$sql = mysql_query("SELECT * FROM bande_relance where IDrelance='$IDrelance'");
	$data=mysql_fetch_array($sql);
	$OF=$data['OF'];
	$sql1 = mysql_query("SELECT PO,produit FROM ordre_fabrication1 where OF='$OF'");
	$data1=mysql_fetch_array($sql1);
	$stat=$data['statut'];
	if($stat=="A"){
	   $statut="En attente ";
	}else if($stat=="C"){
	   $statut="Confirmé ";
	}else if($stat=="R"){
	   $statut="Refusée ";
	}else if($stat=="T"){
	   $statut="Traité ";
	}else if($stat=="CT"){
	   $statut="Controlé ";
	}

}
?>

<div id="page-wrapper">
<div class="row">
<div class="col-lg-12">
    <h1 class="page-header">
	Bande relance N° : <?php echo $data['IDrelance']; ?> 
	<img src="../image/change.png" onclick="changePage();" style="float:right;cursor:pointer;"  width="60" height="50"  />
	</h1>
</div>



<form  id="form1" name="form1" method="POST">
<div class="row">
<div class="col-lg-12">
  <div class="col-lg-6">    
  <div class="form-group">
    <label>Ordre de fabrication</label>
    <input type="text" class="form-control" value="<?php echo $data['OF']; ?>" Readonly>                     
  </div>
  <div class="form-group">
    <label>Commande</label>
    <input type="text" class="form-control" value="<?php echo $data1['PO'];?>" Readonly> 
  </div>
  <div class="form-group">
    <label>Produit</label>
    <input type="text" class="form-control" value="<?php echo $data1['produit'];?>" Readonly> 
  </div> 
  <div class="form-group">
    <label>Nombre de piéces</label>
    <input type="text" class="form-control" value="<?php echo $data['nbr_piece'];?>" Readonly> 
  </div> 
</div> 
  <div class="col-lg-6">  
   <div class="form-group">
    <label>Statut</label>  
    <input type="text" class="form-control" value="<?php echo $statut ;?>" Readonly>                   
  </div>
  <?php
       $IDdemandeur=$data['IDdemandeur'];
	   $sql2 = mysql_query("SELECT nom FROM users1 where ID='$IDdemandeur'");
	   $demandeur=mysql_result($sql2,0);
  ?>
   <div class="form-group">
   <label>Demande</label>
   <div class="form-inline">
    <input type="text" class="form-control" value="<?php echo $data['dateD'] ;?>" Readonly>                     
    <input type="text" class="form-control" value="<?php echo $demandeur ;?>" Readonly>                     
   </div>
  </div>
  <?php
       $IDvalidateur=$data['IDvalidateur'];	
       if($IDvalidateur!=""){	   
	     $sql2 = mysql_query("SELECT nom FROM users1 where ID='$IDvalidateur'");
	     $validateur=mysql_result($sql2,0);
	   }else{
	     $validateur="";
	   }
  ?>
  <div class="form-group">
   <label>Validation</label>
   <div class="form-inline">
    <input type="text" class="form-control" value="<?php echo $data['dateV'] ;?>" Readonly>                     
    <input type="text" class="form-control" value="<?php echo $validateur ;?>" Readonly>                     
   </div>
  </div>
  <?php
       $IDmag=$data['IDoperateur'];	
       if($IDmag!=""){	   
	     $sql2 = mysql_query("SELECT nom FROM users1 where ID='$IDmag'");
	     $magazigner=mysql_result($sql2,0);
	   }else{
	     $magazigner="";
	   }
  ?>
  <div class="form-group">
   <label>Traitement</label>
   <div class="form-inline">
    <input type="text" class="form-control" value="<?php echo $data['dateS'] ;?>" Readonly>                     
    <input type="text" class="form-control" value="<?php echo $magazigner ;?>" Readonly>                     
   </div>
  </div>
</div>



	
</div><!--div 12 -->	
<div  class="col-lg-12"><!--div 12 -->	
  <div  class="col-lg-6"><!--div 12 -->	
    <div class="panel panel-default">
        <div class="panel-heading"> Liste des demandes</div>
        <div class="panel-body">
			<?php
			    $sql3 = mysql_query("SELECT * FROM bande_relance_items where IDrelance='$IDrelance'");
	            while($data3=mysql_fetch_array($sql3)){
				    echo '<div class="form-group">
					  <div class="form-inline">
					    <label>Article: </label>
						<input type="text" class="form-control" value='.$data3['IDitem'].'  Readonly>
						<input type="text" class="form-control" value='.$data3['qty'].'  Readonly>  
					  </div>
					  </div>';
				}
				
            ?>			
		</div>	
        <?php
		if(($stat=="A") && ($role=="LOG" || $role=="ADM")){
				   echo "<div class=\"panel-footer\"><input type=\"button\"  onclick=relance_confirme('".$IDrelance."'); value=\"Confirmer >> \" class=\"btn btn-primary\">
				   <input type=\"button\"  onclick=relance_refuse('".$IDrelance."'); value=\"Refuser >> \" class=\"btn btn-danger\"></div>";
				  
				}
        ?>		
	</div>
  </div>
  <?php
    if($stat=="T" || $stat=="CT" ){
	    echo '<div  class="col-lg-6">	   
          <div class="panel panel-default">
             <div class="panel-heading"> Liste des demandes</div>
             <div class="panel-body">';
			
	    $sql4 = mysql_query("SELECT * FROM sortie_items where IDbande='$IDrelance' and typeS='RL'");
	            while($data4=mysql_fetch_array($sql4)){
				    echo '<div class="form-group">
					  <div class="form-inline">
					    <label>Paquet : </label>
						<input type="text" class="form-control" value='.$data4['IDpaquet'].'  Readonly>
						<input type="text" class="form-control" value='.$data4['qte'].'  Readonly>  
					  </div>
					  </div>';
				}
	}
	if(($stat=="T" ) && ($role=="CTRL" || $role=="ADM")){
		echo "<div class=\"panel-footer\"><input type=\"button\"  onclick=confirm_sortieRL('".$IDrelance."'); value=\"Confirmer >> \" class=\"btn btn-primary\">
				   </div></div>";
	}else{
        echo '</div></div>';
    }	
	mysql_close();			
   ?>			

</div>






</div> 

</form>
</div> 
 


</div> <!--row-->
    </div>

                    </div>
                    </div>

               
             
     

</body>

</html>