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
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
<script src="../theme/dist/js/sb-admin-2.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/bootbox.min.js"></script>
<link href="../theme/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="../theme/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
 <script src="../theme/bower_components/metisMenu/dist/metisMenu.min.js"></script>
<script src="../JScolor/jscolor.js"></script>

<title>
Training list
</title>
<SCRIPT> 
function deleteFile(f,t){


 if(confirm("Voulez-vous vraiment supprimer ce fichier?")){

 $.ajax({
          type: 'POST',
          data : 'F=' + f +'&T=' + t,
          url: '../php/delete_file.php',
          success: function(data) {
		     	
	       $("#divRel").load(location.href + " #divRel");
           }});
		   
 }
 }
	

//
function afficheTT(val) {

$.ajax({
          type: 'POST',
          data : 'nomF=' + val,
          url: '../php/consult_formation.php',
          success: function(data) {
          $("#tabX").html(data);
		  }
		  });
 }  	
	 //
function mySearch(S) {


var listItem = $('.results tbody').children('tr');
var jobCount = $('.results tbody').children('tr').length;
 S="#"+S;
var searchTerm = $(S).val();
searchTerm=searchTerm.toUpperCase();

	 
for (var iter = 1; iter <= jobCount; iter++) {

 var nIter1="."+iter;
 var val=$(nIter1).html();
 val=val.toUpperCase();
   if (val.indexOf(searchTerm) >= 0){
   $(nIter1).attr('visible','true');
   }else{
   $(nIter1).attr('visible','false');
   }
}
} 
     //
 
      //
     function pop_up(url){
     window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=500,height=900,directories=no,location=no') 
     } 
	
///

</SCRIPT> 
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
}
elseif($role=="LOG"){
include('../menu/menuLogistique.php');	
}elseif($role=="GRH"){
include('../menu/menuGRH.php');		
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>


<div class="container">


   <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Training List</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>



<div class="row">
 <div class="col-lg-12" >

 <?php 
include('../connexion/connexionDB.php');

?>
 <div class="row">
 <div class="col-lg-12" id="ALLfiles"> 
 <form  id="form1" name="form1">						  
  <br><br>	
                             
                         
							


<div class="col-lg-12" id="divRel">
  <ul class="nav nav-tabs">
  <?php
  $req= mysql_query("SELECT * FROM formation_starz");
  $y=0;
  while($data=@mysql_fetch_array($req)){
  $y++;
  if($y==1){
  $desc=$data['descF'];
  $nomF=$data['nomF'];
  $f1=$data['formateur1'];
  $f2=$data['formateur2'];
   echo "<li class=\"active\" onClick=afficheTT('".$data['nomF']."');><a href=\"#".$data['nomF']."\" data-toggle=\"tab\">".$data['nomF']."</a></li>";
  }else{
  echo "<li onClick=afficheTT('".$data['nomF']."');><a href=\"#".$data['nomF']."\" data-toggle=\"tab\">".$data['nomF']."</a></li>";
  }
  }
  ?>
                               
                             
                               
  </ul>
<div class="tab-content">


 <?php
  
  echo '<div class="tab-pane fade in active" id="tabX">
  <div class="row">
  <div class="col-lg-12">
  <div class="col-lg-10">
  <br>
  <h4><b>'.$desc.'</b> </h4>
  <h4> <b>Trainer 1 : </b>'.$f1.'</h4> 
  <h4><b> Trainer 2 : </b>'.$f2.'</h4>
  <br><br>
  </div>
  </div>
 
  
 
  <div class="table-responsive col-lg-12">

 <div class="col-lg-12">	
<table class="table table-fixed results tabScroll">
<thead style="width:100%">
          
			<tr>
               <th style="width:29.7%;height:40px" >Matricule</th>
				<th style="width:29.7%;height:40px">NCIN</th>
				<th style="width:29.7%;height:40px">Nom & prenom</th>			  
						  
            </tr>
          </thead>
		   <tbody  style="width:100%">';
		 
		    

	$req1= mysql_query("SELECT * FROM personnel_starz_formation where Formation='$nomF'");
	$x=0;
   while($a1=@mysql_fetch_array($req1))
    {
    $mat=$a1['matricule'];
	$x++;
	$req3= mysql_query("SELECT * FROM personnel_info where matricule='$mat'");
	$a3=@mysql_fetch_array($req3);
	echo('<tr class='.$x.'><td style="width:30%;height:40px">'.$a1['matricule'].'</td>
	<td  style="width:30%;height:40px">'.$a3['NCIN'].'</td>
	<td style="width:30%;height:40px">'.$a3['nom'].'</td>
	
	</tr>');
	}


        echo '   </tbody>
 </table>   
 </div> 
 </div> 
 </div> 
 </div> 
 
  
  
  ';
  
  ?>


 </div> 
 </div> 
 </form>
 </div> 
 </div> 
 
</div> 

</div> <!--row-->
    </div>

                    </div>
                    </div>
                    </div>
               
             
     

</body>

</html>