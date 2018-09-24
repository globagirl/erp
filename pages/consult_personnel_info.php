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
<link href="../theme/dist/css/timeline.css" rel="stylesheet">
<script src="../bootstrap/js/bootstrap.min.js"></script>
<link href="../theme/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="../theme/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
<script src="../theme/bower_components/metisMenu/dist/metisMenu.min.js"></script>
<title>Personnel information</title>
<script> 
function afficheTT() {

//Affichage de tt 
var listItem = $('.results tbody').children('tr');
var jobCount = $('.results tbody').children('tr').length;
	 
for (var iter = 1; iter <= jobCount; iter++) {

 var nIter1="."+iter;
 $(nIter1).attr('visible','true');
}
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
function changePage(){
	document.location.href="../pages/consult_personnel.php";
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
}
elseif($role=="GRH"){
include('../menu/menuGRH.php');	
}elseif($role=="DIR"){
include('../menu/menuDirecteur.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>


<div class="container">

<?php
include('../connexion/connexionDB.php');
if(isset($_POST['mat'])){
$mat=$_POST['mat'];
$_SESSION['mat']=$mat;	
}
else{
	$mat=$_SESSION['mat'];
	$sql1 = mysql_query("SELECT * FROM personnel_info where matricule='$mat'");
	$data1=mysql_fetch_array($sql1);

}
?>

<div id="page-wrapper">
<div class="row">
<div class="col-md-12">
    <h1 class="page-header"><?php echo $data1['nom']; ?> <img src="../image/change.png" onclick="changePage();" style="float:right;cursor:pointer;" alt="Print" width="60" height="50"  /></h1>
</div>


<div class="col-md-12" id="ALLfiles"> 
<form  id="form1" name="form1">						  
 <br><br>
<div  id="divRel">
  <ul class="nav nav-tabs">
        <li class="active" onClick="afficheTT();"><a href="#inf" data-toggle="tab">Information generale</a></li>
        <li onClick="afficheTT();"><a href="#salaire" data-toggle="tab">Salaire</a></li>
        <li onClick="afficheTT();"><a href="#contrat" data-toggle="tab" >Contrat</a></li>
        <li onClick="afficheTT();"><a href="#avance" data-toggle="tab" >Avance</a></li>
        <li onClick="afficheTT();"><a href="#conge" data-toggle="tab" >Congé</a></li>
        <li onClick="afficheTT();"><a href="#mise" data-toggle="tab" >Mise a pied</a></li>
        <li onClick="afficheTT();"><a href="#retard" data-toggle="tab" >Retard</a></li>
        <li onClick="afficheTT();"><a href="#absence" data-toggle="tab" >Absence</a></li>
        <li onClick="afficheTT();"><a href="#pointage" data-toggle="tab" >Pointage</a></li>                               
        <li onClick="afficheTT();"><a href="#historique" data-toggle="tab" >Historique</a></li>                               
  </ul>
<div class="tab-content">
 <!--inf-->
<div class="tab-pane fade in active" id="inf" onClick="afficheTT();">
<br><br>
<div class="row">
<div class="col-md-12">

<div class="col-md-6">
  <?php
  $sql2 = mysql_query("SELECT newMat FROM personnel_doublep where mat='$mat'");
  $DP=@mysql_result($sql2,0);
   if($DP != ""){ 
   $DPA="Double pointage :".$DP;
   }else{
   $DPA="Pas de double pointage ";
   }
   ?>
  <div class="form-group">
  <label>Matricule</label>
  <input type="text" class="form-control" id="mat"  value="<?php echo $mat ?>" Readonly>  
  <p class="help-block"><?php echo $DPA ; ?> </p>  
  </div> 
  <div class="form-group">
  <label>NCIN</label>
  <input type="text" class="form-control"   value="<?php echo $data1['NCIN'] ?>" Readonly>                     
  </div>
  <div class="form-group">
  <label>Date naissance</label>
  <input type="text" class="form-control" value="<?php echo $data1['dateN'] ?>" Readonly>                     
  </div>
  
  <div class="form-group">
  <label>Adresse</label>
  <input type="text" class="form-control" value="<?php echo $data1['adresse1'] ?>" Readonly>                     
  </div>

   <div class="form-group">
  <label>Tel</label>
  <?php
  $sql2 = mysql_query("SELECT * FROM personnel_tel where matricule='$mat'");
   while($data2=mysql_fetch_array($sql2)){
   echo '
  <input type="text" class="form-control"  value='.$data2['tel'].' Readonly>                     
  <p class="help-block">'.$data2['proprietor'].'</p>';
   
  }
   ?>
  </div> 
  <div class="form-group">
  <label>Diplome</label>
  <?php
  $sql22 = mysql_query("SELECT * FROM personnel_diplome where matricule='$mat'");
  $diplomes="";
   while($data22=@mysql_fetch_array($sql22)){
   $dip=$data22['diplome'];   
   echo ' <textarea class="form-control" Readonly>';
   if($dip !=""){
   echo $data22['annee'].':'.$data22['diplome'];
   }
   echo '</textarea>';
   }
  
   ?>
  </div> 

</div> 

<div class="col-md-6">
  <div class="form-group">
  <center>
  <img src="<?php echo $data1['imgP']; ?>" alt="user" style="width:120px;height:100px;" id="imgP">
  </center>
  <br>
  </div> 
  <div class="form-group">
  <label>Etat</label>
  <input type="text" class="form-control" value="<?php echo $data1['etat'] ?>" Readonly>                     
  </div>
  <div class="form-group">
  <label>Catégorie</label>
  <input type="text" class="form-control" value="<?php echo $data1['category'] ?>" Readonly>                     
  </div>
  
  <div class="form-group">
  <label>Salaire brut</label>
  <input type="text" class="form-control" value="<?php echo $data1['salaire'] ?>" Readonly> 
  <p class="help-block">Type salaire:<?php  $typeS=$data1['typeS'];
  if($typeS=="V"){ 
   echo "Variable";
  }else{
   echo "Fixe";
  }
   ?></p> 
  </div>

<div class="form-group">
  <label>Note</label>
  <?php
  $sql221 = mysql_query("SELECT * FROM personnel_note where matricule='$mat'");
  
   while($data221=@mysql_fetch_array($sql221)){
   $note=$data221['note'];
   echo ' <textarea class="form-control" rows="4" Readonly>';
   if($note != ""){
   echo $data221['dateN'].': '.$data221['note'];
   }
   echo '</textarea>';
   }
   ?>
</div> 
</div>
	
</div><!--row -->	


 </div> 
 </div> 

 <!--Salaire-->
<div class="tab-pane fade" id="salaire" >
<div class="table-responsive">
<br><br>

 <div class="pull-left col-md-4">		
          <input type="text" class="search form-control"  placeholder="Search " id="search2" onkeyup="mySearch('search2')">
	
 </div>

		 

<br>
<br>
<br>
<br>
 <div class="col-md-12">	
<table class="table table-fixed results tabScroll">
<thead style="width:100%">
          
			<tr>
               <th style="width:15%;height:60px">Mois</th>
				<th style="width:11.2%;height:60px">Salaire de base</th>
				<th style="width:11.2%;height:60px">Total minutes</th>
				<th style="width:11.2%;height:60px">Salaire</th>
				<th style="width:11.2%;height:60px">Total avance</th>			  
				<th style="width:11.3%;height:60px">Mise a pied</th>			  
				<th style="width:8.4%;height:60px">Retards</th>			  
				<th style="width:15%;height:60px">NET</th>			  
            </tr>
          </thead>
		   <tbody style="width:100%">
		   <?php
		  
	
$x=0;
	$req1= mysql_query("SELECT * FROM personnel_salaire where matricule='$mat'");

   while($a1=@mysql_fetch_array($req1))
    {
    $x++;
	echo('<tr class='.$x.'>
	<td style="width:15.4%;height:60px">'.$a1['mois'].'</td>
	<td style="width:11.4%;height:60px">'.$a1['salaire_base'].'</td>
	<td style="width:11.4%;height:60px">'.$a1['nbm_travail'].'</td>
	<td style="width:11.4%;height:60px">'.$a1['salaireB'].'</td>
	<td style="width:11.4%;height:60px">'.$a1['total_avance'].'</td>
	<td style="width:11.4%;height:60px">'.$a1['total_mise'].'</td>
	<td style="width:8.4%;height:60px">'.$a1['nbr_retard'].'</td>
	<td style="width:15.4%;height:60px">'.$a1['salaireA'].'</td>
	
	</tr>');
	}

 

		   
		   ?>

           </tbody>
 </table>   
 </div> 
 </div> 
 </div>  
 
 <!--Contrat-->
<div class="tab-pane fade" id="contrat">
<div class="table-responsive">
<br><br>


 	
<?php
$req2=mysql_query("SELECT * FROM personnel_contrat where matricule='$mat'");
$nbrC=@mysql_num_rows($req2);
if($nbrC>0){
echo " <div class=\"pull-left col-md-4\">		
<input type=\"text\" class=\"search form-control\" id=\"search3\" placeholder=\"Search\" onkeyup=mySearch('search3')>	
</div>";
echo '<br><br><br><br>
<div class="col-md-12">
<table class="table table-fixed results tabScroll">
<thead style="width:100%">
          
			<tr>
               <th style="width:24.5%;height:30px">N° contrat</th>
				<th style="width:19.5%;height:30px">date debut</th>
				<th style="width:19.5%;height:30px">Date fin </th>			  
				<th style="width:19.8%;height:30px">Type</th>			  
				<th style="width:14.8%;height:30px">Etat</th>			  
            </tr>
          </thead>
<tbody  style="width:100%">'; 
while($a2=@mysql_fetch_array($req2))
    {
    $x++;	
	echo('<tr class='.$x.'>
	<td style="width:25%;height:60px">'.$a2['numContrat'].'</td>
	<td  style="width:20%;height:60px">'.$a2['dateD'].'</td>
	<td  style="width:20%;height:60px">'.$a2['dateF'].'</td>
	<td  style="width:20%;height:60px">'.$a2['typeContrat'].'</td>
	<td  style="width:15%;height:60px">'.$a2['etat'].'</td>');
	
	}
	echo '</tbody> </table></div>  ';
} else{
 echo '<div class="col-md-12"><h3> Non Contractuel </h3><br><br><br><br><br><br><br><br></div>';
}
 ?>

 </div> 
 </div> 
 
 <!--Avance-->
<div class="tab-pane fade" id="avance">
<div class="table-responsive">
<br>
<br>

 <div class="pull-left col-md-4">		
          <input type="text" class="search form-control" id="search4" placeholder="Search " onkeyup="mySearch('search4')">
	
 </div>

<br>
<br>
<br>
<br>
 <div class="col-md-12">	
<table class="table table-fixed results tabScroll">
<thead style="width:100%">
          
			<tr>
               <th style="width:29.5%;height:30px">Mois</th>
				<th style="width:29.5%;height:30px">Date</th>
				<th style="width:29.5%;height:30px">Montant</th>			  
				<th style="width:5%;height:30px"></th>			  
				<th style="width:5%;height:30px"></th>			  
            </tr>
          </thead>
<tbody  style="width:100%" class="tbodyScroll">
		   <?php
		  
	

	$req3= mysql_query("SELECT * FROM personnel_avance where matricule='$mat'");
	
   while($a3=@mysql_fetch_object($req3))
    {
    $dateA = $a3->dateA;
    $montant = $a3->montant;
    $mois= strtotime($dateA);
    $mois= strftime("%B",$mois);
	$x++;
	
	echo('<tr class='.$x.'><td style="width:30%;height:60px">'.$mois.'</td>
	<td  style="width:30%;height:60px">'.$dateA.'</td>
	<td style="width:30%;height:60px">'.$montant.'</td>
	
	');
	
	}

 

		   
		   ?>

           </tbody>
 </table>   
 </div> 
 </div> 
 </div>  
 
 <!--Congé-->
<div class="tab-pane fade" id="conge">
<div class="table-responsive">
<br>

 <div class="pull-left col-md-4">	
<br>
<input type="text" class="search form-control" id="search5" placeholder="Search " onkeyup="mySearch('search5')">
	
 </div> 
 <div class="pull-right col-md-4">	
 <br>
 <?php
 $jourJ=date("Y-m-d");
 $jourJ=strtotime($jourJ);
 $year = strftime("%Y",$jourJ);
 $reqCA= mysql_query("SELECT sum(nbrH) FROM personnel_conge where matricule='$mat' and dateD LIKE '$year-%'");
 $conge_acc=mysql_result($reqCA,0); 
 $conge_res=168-$conge_acc;
 $conge_res=$conge_res/8;
 $conge_acc=$conge_acc/8;
 
 ?>
<p> <b>Année : </b><?php echo $year; ?></p>
<p> <b>Total Congé accumulé : </b><?php echo $conge_acc ; ?> Jours</p>
<p><b> Total Congé restant :</b><?php echo $conge_res; ?>  Jours </p> <br>

	
 </div>



 <div class="col-md-12">
<br>
<br>
<br>
<table class="table table-fixed results tabScroll">
<thead style="width:100%">
          
			<tr>
               <th style="width:19.5%;height:60px">Mois</th>
				<th style="width:19.5%;height:60px">Date debut</th>
				<th style="width:19.5%;height:60px">Date fin</th>			  
				<th style="width:9.5%;height:60px">Nbr jours</th>			  
				<th style="width:29.8%;height:60px">Type </th>			  
            </tr>
          </thead>
		   <tbody  style="width:100%">
		   <?php
		  
	

	$req4= mysql_query("SELECT * FROM personnel_conge where matricule='$mat' order by dateD DESC");
	
   while($a4=@mysql_fetch_array($req4))
    {
    $dateD = $a4['dateD'];
    $mois= strtotime($dateD);
    $mois= strftime("%B",$mois);
	$x++;
	$nbrH=$a4['nbrH'];
	$nbrJ=$nbrH/8;
	echo('<tr class='.$x.'>
	<td style="width:20%;height:60px">'.$mois.'</td>
	<td  style="width:20%;height:60px">'.$dateD.'</td>
	<td style="width:20%;height:60px">'.$a4['dateF'].'</td>
	<td style="width:10%;height:60px">'.$nbrJ.'</td>
	<td style="width:30%;height:60px">'.$a4['typeC'].'</td>
	
	');
	}


 

		   
		   ?>

           </tbody>
 </table>   
 </div> 
 </div> 
 </div>  
 
 <!--Mise a pied -->
<div class="tab-pane fade" id="mise">
<div class="table-responsive">
<br>
<br>

 <div class="pull-left col-md-4">		
          <input type="text" class="search form-control" id="search6" placeholder="Search " onkeyup="mySearch('search6')">
	
 </div>

<br>
<br>
<br>
<br>
 <div class="col-md-12">	
<table class="table table-fixed results tabScroll">
<thead style="width:100%">
          
			<tr>
               <th style="width:19.5%;height:60px">Mois</th>
				<th style="width:19.5%;height:60px">Date </th>
				<th style="width:19.5%;height:60px">Montant</th>				  
				<th style="width:39.8%;height:60px">Raison</th>			  
            </tr>
 </thead>
		   <tbody  style="width:100%">
		   <?php

	

	$req5= mysql_query("SELECT * FROM personnel_mise where matricule='$mat'");
	
   while($a5=@mysql_fetch_array($req5))
    {
    $mois = $a5['mois'];
    $mois = $mois.'-01';
	$mois= strtotime($mois);
    $mois= strftime("%B",$mois);
	$x++;
	
	echo('<tr class='.$x.'>
	<td style="width:20%;height:60px">'.$mois.'</td>
	<td  style="width:20%;height:60px">'.$a5['dateM'].'</td>
	<td style="width:20%;height:60px">'.$a5['montant'].'</td>
	<td style="width:40%;height:60px">'.$a5['raison'].'</td>
	
	
	');
	}

 

		   
		   ?>

           </tbody>
 </table>   
 </div> 
 </div> 
 </div>  
 
 <!--retard-->
<div class="tab-pane fade" id="retard">
<div class="table-responsive">
<br>
<br>

 <div class="pull-left col-md-4">		
          <input type="text" class="search form-control" id="search7" placeholder="Search " onkeyup="mySearch('search7')">
 </div>

<br>
<br>
<br>
<br>
<div class="col-md-12">	
<table class="table table-fixed results tabScroll">
<tbody  style="width:100%">
<?php
		 
	

	$req6= mysql_query("SELECT mois,nbr_retard FROM personnel_salaire where matricule='$mat'");
	
   while($a6=@mysql_fetch_object($req6))
    {
    $mois = $a6->mois;
    $nbrR = $a6->nbr_retard;
	$mois2 = $mois.'-01';
	$mois2= strtotime($mois2);
    $mois2= strftime("%B",$mois2);

	$x++;
	
	echo('<tr class='.$x.'><td style="width:50%;height:60px"><b>Mois : '.$mois.'</b></td>
	<td  style="width:50%;height:60px"><b>Total retard: '.$nbrR.'</b></td></tr>');
	if($nbrR>0){
	$req7= mysql_query("SELECT * FROM personnel_pointage where matricule='$mat' and dateP like '$mois%' and etat='R' ");
	while($a7=@mysql_fetch_array($req7)){
	$x++;
	echo('<tr class='.$x.'><td style="width:50%;height:40px">Date : '.$a7['dateP'].'</b></td>
	<td  style="width:50%;height:40px">Heure debut: '.$a7['heureD'].'</b></td></tr>');
	}
	}

 }
 ?>

</tbody>
 </table>   
 </div> 
 </div> 
 </div> 
 <!--Absence -->
 
 <div class="tab-pane fade" id="absence">
<div class="table-responsive">
<br>
<br>

 <div class="pull-left col-md-4">		
          <input type="text" class="search form-control" id="search8" placeholder="Search" onkeyup="mySearch('search8')">
	
 </div>

<br>
<br>
<br>
<br>
<div class="col-md-12">	
<table class="table table-fixed results tabScroll">
<thead style="width:100%">
          
			<tr>
               <th style="width:31%;height:60px">Date</th>
               <th style="width:21%;height:60px">NBR heure</th>
				<th style="width:42%;height:60px">Etat </th>
								  
							  
            </tr>
</thead>
<tbody  style="width:100%">
<?php
$req6= mysql_query("SELECT * FROM personnel_absence where matricule='$mat'");	
while($a6=@mysql_fetch_array($req6))
{

echo ('<tr class='.$x.'>
               <td style="width:32%;height:40px">'.$a6['dateD'].'</td>
				<td style="width:22%;height:40px">'.$a6['nbrH'].' </td>
				<td style="width:45.5%;height:40px">'.$a6['Etat'].'</td>				  
							  
    </tr>');


}

?>

 </tbody>
 </table>   
 </div> 
 </div> 
 </div> 

 <!--Pointage-->
<div class="tab-pane fade" id="pointage">
<div class="table-responsive">
<br>
<br>
<div class="col-md-4 pull-left" >
		
          <input type="text" class="search form-control" id="search9" placeholder="Search " onkeyup="mySearch('search9')">
	
 
</div>
<br>
<br>
<br>
<br>
 <div class="col-md-12">	
<table class="table table-fixed results tabScroll">
<thead style="width:100%">
          
			<tr>
               <th style="width:16.5%;height:60px">Date</th>
				<th style="width:15.5%;height:60px">Heure debut</th>
				<th style="width:15.5%;height:60px">Heure Fin</th>			  
				<th style="width:11.5%;height:60px">Total en minute</th>			  
				<th style="width:11.5%;height:60px">Total retard(mn)</th>			  
				<th style="width:11.5%;height:60px">Soustraction </th>			  
				<th style="width:11.5%;height:60px">Total</th>			  
						  
            </tr>
          </thead>
<tbody  style="width:100%">
		   <?php
		 
	

	$req5= mysql_query("SELECT * FROM personnel_pointage where matricule='$mat'");
	
   while($a5=@mysql_fetch_array($req5))
    {
   
	$x++;
	$aX=$a5['totalMF'];
	$bX=$a5['totalM'];
	$ab=$bX-$aX;
	echo('<tr class='.$x.'>
	<td style="width:17%;height:40px">'.$a5['dateP'].'</td>
	<td style="width:16%;height:40px">'.$a5['heureD'].'</td>
	<td style="width:16%;height:40px">'.$a5['heureF'].'</td>
	<td style="width:12%;height:40px">'.$a5['totalM'].'</td>
	<td style="width:12%;height:40px">'.$a5['retard'].'</td>
	<td style="width:12%;height:40px">'.$ab.'</td>
	<td style="width:12%;height:40px">'.$a5['totalMF'].'</td>
	
	');
	
	}

 

		   
		   ?>

           </tbody>
 </table>   
 </div> 
 </div> 
 </div> 
  <!--Pointage-->
<!--histrique-->

<div class="tab-pane fade" id="historique">
<div class="panel panel-default">
    <div class="panel-body">
    <div class="table-responsive">
	    <ul class="timeline">
            <li>
               
				    <?php
					    $req6= mysql_query("SELECT * FROM personnel_datee where matricule='$mat' order by dateH ASC");
						while($a6=@mysql_fetch_array($req6)){
				            $statut=$a6['statut'];
							if($statut=='E'){
							    echo ' <li><div class="timeline-badge info"><i class="fa fa-smile-o"></i></div>
                                <div class="timeline-panel">
								<div class="timeline-heading">
                                <p><strong class="text-muted">Date entrée: </strong></p>
                                <p><strong class="text-muted"><i class="fa fa-clock-o"></i> '.$a6['dateH'].'</strong></p>
                                </div>
                                </div>
                                </li>';
							}else{
							echo ' <li class="timeline-inverted"><div class="timeline-badge danger"><i class="fa fa-frown-o"></i></div>
                                <div class="timeline-panel">
								<div class="timeline-heading">
                                
                                <p><strong class="text-muted">Date sortie: </strong></p>
                                <p><strong class="text-muted"><i class="fa fa-clock-o"></i> '.$a6['dateH'].'</strong></p>
                                </div>
                                </div>
                                </li>';
							}
                        }
					?>
				</ul>                  
    </div>
</div> <!--end-->
</div> 
</div> 
</div> 
</div> 
</form>
</div> 
 


</div> <!--row-->
    </div>

                    </div>
                    </div>
                    </div>
               
             
     

</body>
<?php
mysql_close();
?>
</html>