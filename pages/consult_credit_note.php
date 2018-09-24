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
<title>
Credit note STARZ
</title>
<SCRIPT>

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

function excelCredit(){
	document.form1.action="../php/excel_commandeItems.php";
    document.form1.submit();
}
</SCRIPT>
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
}

elseif($role=="LOG"){
include('../menu/menuLogistique.php');
}
elseif($role=="COM"){
include('../menu/menuCommercial.php');	
}elseif($role=="FIN"){
include('../menu/menuFinance.php');
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>


   <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Credit note STARZ </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>


<form  id="form1" name="form1" method="POST">
<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
          Consult credit notes
 </div>
 <div class="panel-body" >
 <?php
include('../connexion/connexionDB.php');

?>
<div class="row">
          <div class="col-lg-12" >

		  <div class="pull-left col-lg-4">



          <input type="text" class="search form-control"  placeholder="Search " id="search" name="search" onkeyup="mySearch()">

          </div>


 <div class="pull-right col-lg-1">
<img src="../image/excel.png" onclick="excelCommande();" alt="Excel" style="cursor:pointer;" width="60" height="50"  /></p>
 </div>

 </div>



  <br><br>
  <br><br>






<div class="table-responsive col-lg-12" id="divRel">
<table class="table table-fixed table-bordered results" id="table3">
<thead style="width:100%">

			<tr>

				<th style="width:19.7%;height:60px" class="degraD2">Credit note</th>
				<th style="width:19.7%;height:60px" class="degraD2">Original invoice</th>
				<th style="width:13.7%;height:60px" class="degraD2">Amount</th>
				<th style="width:24.7%;height:60px" class="degraD2">Client / Supplier</th>
				<th style="width:11.8%;height:60px" class="degraD2">Date</th>
				<th style="width:8.9%;height:60px" class="degraD2">Statut</th>

            </tr>
          </thead>
		   <tbody id="tbody2" style="width:100%">
<?php
   $x=0;


   $req= mysql_query("SELECT * FROM credit_note_starz order by dateCN DESC");

   while($data=@mysql_fetch_array($req))
    {
	$x++;

	echo('<tr id='.$x.'>
	<td style="width:20%;height:40px;text-align:center" class="tdTab">'.$data['idCN'].'</td>
	<td  style="width:20%;height:40px;text-align:center">'.$data['IDfact'].'</td>
	<td  style="width:14%;height:40px;text-align:center">'.$data['amount'].'</td>
	<td style="width:25%;height:40px;text-align:center">'.$data['supplier'].'</td>

	<td style="width:12%;height:40px;text-align:center">'.$data['dateCN'].'</td>
	<td style="width:9%;height:40px;text-align:center">'.$data['statut'].'</td>

	');


	}
?>

        </tbody>
 </table>
 </div>





 </div>
 </div>

</div>
</div>
</div>

	</div>
	 </form>
    </div>

                    </div>
                    </div>
                    </div>
</body>

</html>
