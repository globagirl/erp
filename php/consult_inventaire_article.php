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
function mySearch() {
var searchTerm = $(".search").val();
searchTerm=searchTerm.toUpperCase();
var listItem = $('.results tbody').children('tr'); 
var jobCount = $('.results tbody').children('tr').length;
	 
 for (var iter = 1; iter <= jobCount; iter++) {

 var nIter1="#"+iter;
 var val=$(nIter1).html();
 val=val.toUpperCase();
 if (val.indexOf(searchTerm) >= 0){
 $(nIter1).attr('visible','true');
 }else{
 $(nIter1).attr('visible','false');
  }
 }
}
function changePage(){
	document.location.href="../pages/consult_inventaire.php";
}
function excelInventaire(){
		document.form1.action="../php/excel_inventaire.php";
    document.form1.submit(); 
	
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
if(isset($_POST['IDinventaire'])){
$IDinventaire=$_POST['IDinventaire'];
$_SESSION['IDinventaire']=$IDinventaire;	
}
else{
	$IDinventaire=$_SESSION['IDinventaire'];
}
?>

<div id="page-wrapper">
<div class="row">
<form  id="form1" name="form1" method="POST">
<div class="col-lg-12">
    <input type="text" class="form-control" name="IDinventaire" id="IDinventaire"value="<?php echo $IDinventaire; ?> " READONLY>
	<br><br>
</div>




<div class="row">
	  <div class="col-lg-12" >
		  
		  <div class="pull-left col-lg-4">	
       <input type="text" class="search form-control"  placeholder="Search " id="search" name="search" onkeyup="mySearch();">
	     <br><br>
      </div>
			<div class="col-lg-4">
			</div>
			<div class="col-lg-1">	
				<img src="../image/change.png" onclick="changePage();" style="float:right;cursor:pointer;"  width="50" height="50"  />
			</div>
			<div class="col-lg-1">	
				<img src="../image/excel.png" onclick="excelInventaire();" style="float:right;cursor:pointer;"  width="50" height="50"  />
			</div>
			
			

 </div>
<div class="col-lg-12">
 
<div class="table-responsive col-lg-12" id="divRel">
<table class="table table-fixed  results" id="table3">
<thead style="width:100%">
          
			<tr>
               
				<th style="width:24.7%">Code article</th>
				<th style="width:24.5%">Stock réel</th>			  
				<th style="width:24.5%">Stock systéme</th>					  
				<th style="width:24.7%">date entrée</th>			  
						  
		
						  
            </tr>
          </thead>
		   <tbody id="tbody2" style="width:100%">
<?php
  $x=0;
	$sql = mysql_query("SELECT * FROM inventaire_items where IDinventaire='$IDinventaire'");
	while($data=@mysql_fetch_array($sql)){
	$x++;   	
	echo('<tr id='.$x.'>
	<td style="width:25%">'.$data['IDarticle'].'</td>
	<td  style="width:25%">'.$data['stockReel'].'</td>
	<td  style="width:25%">'.$data['stockSys'].'</td>
	<td  style="width:25%">'.$data['dateE'].'</td></tr>

	');
	
	
	}
	mysql_close();
?>

        </tbody>
 </table>   
 </div> 
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