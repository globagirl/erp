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
Add new page
</title>

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
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<div class="container col-md-12" >
<div id="page-wrapper">
<div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">Documontation pages</h1>
                </div>
                <!-- /.col-md-12 -->
</div>


<div class="row">
<div class="col-md-12" >
<div class="panel panel-default">
<div class="panel-heading"> Add new page </div>
<div class="panel-body" >
<form role="form" method="post" name="form1" id="form1" action="../php/ajout_formation.php">
	 
    <div class="row">

     <div class="col-md-6">
                                
        <div class="form-group">
		
        <label>Page</label>	
        <input name="page" id="page" class="form-control" placeholder="nom_page/dossier">
       
	    
        </div> 
								
		<div class="form-group">
		
        <label>Description</label>	
        <textarea class="form-control" id="desc" name="desc" rows="3" > </textarea>    
	
        </div>
    
        
        <div class="form-group">
		
        <label>Type</label>	
         <select name="typeP" id="typeP" onChange="desactiveModule();" class="form-control">
             <option value="P">Primary</option>	
             <option value="S">Secondary</option>	
                                           
        </select>  
	
        </div>
		<div class="form-group">
		
        <label>Module</label>
        <div class="form-inline">		
        <select name="module" id="module" onChange="afficheZone();" class="form-control">
             <option value="a">This modules concern primary pages ONLY ...</option>	
             <?php
             include('../connexion/connexionDB.php');			 
	         $sql = "SELECT * FROM doc_module";
             $res = mysql_query($sql) or exit(mysql_error());
              while($data=mysql_fetch_array($res)) {
               echo '<option value="'.$data["id_module"].'">'.$data["id_module"].'</option><br/>'; 
               }
			 ?>	                              
        </select>
           
	    <input type="submit" class="btn btn-default green" value="+"> 	
        </div> 
        </div> 
       
        <div class="panel panel-default">
           <div class="panel-heading"> Functionality </div>
		   <div class="panel-body" id="fn">
		   <div class="form-group">
		      <textarea class="form-control" id="FN1" name="FN1"  placeholder="Functionality N°1 "></textarea> 
           </div>
		   </div>
		   <div class="panel-footer">           
				<input type="button" onClick="addFN();" class="btn btn-default" value="+" >
				<input type="button" onClick="deleteFN();" class="btn btn-default" value="-" >                             
           </div>
	    </div> 
	   
        <div class="panel panel-default">
           <div class="panel-heading"> Page link </div>
		   <div class="panel-body" id="PL" >
		   <div class="form-group">
		      <textarea class="form-control" id="PL1" name="PL1"  placeholder="Page link N°1 "></textarea> 
           </div>
		   </div>
		   <div class="panel-footer">           
				<input type="button" onClick="addPL();" class="btn btn-default" value="+" >
				<input type="button" onClick="deletePL();" class="btn btn-default" value="-" >                             
           </div>
		</div>
      		
			
   		
        </div>
		
        <div class="col-md-6">
       
		<div class="col-md-12">
		<div class="panel panel-default ">
           <div class="panel-heading"> Users </div>
		   <div class="panel-body" id="US" >
		   <select name="US1" id="US1"  class="form-control">
             <option value="a">Select...</option>	
             <?php			 
	         $sql2 = mysql_query("SELECT * FROM user1");
            
              while($data2=mysql_fetch_array($sql2)) {
			  $nom=$data2['nom'];
			  if($nom=="X"){
               echo '<option value="'.$data2["ID"].'">'.$data2["login"].'</option><br/>'; 
			  }else{
			   echo '<option value="'.$data2["ID"].'">'.$data2["nom"].'</option><br/>'; 
              }			  
			   
               }
			 ?>	                              
        </select>
		   </div>
		   <div class="panel-footer">           
				<input type="button" onClick="addUser();" class="btn btn-default" value="+" >
				<input type="button" onClick="deleteUser();" class="btn btn-default" value="-" >                             
           </div>
		</div> 
		</div> 
		
		
		<div class="col-md-12">
		<div class="panel panel-default">
           <div class="panel-heading"> Recommendations </div>
		   <div class="panel-body" >
		   </div>
		</div> 
		</div> 
		
		<div class="col-md-12">
        <div class="panel panel-default">
           <div class="panel-heading"> Bugs</div>
		   <div class="panel-body" >
		   </div>
		</div> 
		</div> 
		<div class="col-md-12">
		<div class="panel panel-default">
           <div class="panel-heading"> Diagrams </div>
		   <div class="panel-body" >
		   </div>
		</div> 
		</div> 
		<div class="col-md-12">
		<input type="submit" class="btn btn-default blue" value="ADD >>"> 		
		</div> 
		</div> 
	</div> <!-- fin row -->

	




</form>



</div>
</div>
</div>
</div>
</div>

</div>

<!--fin -->



</div>


</div>
</body>

</html>