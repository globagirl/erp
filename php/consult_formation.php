 <?php
 include('../connexion/connexionDB.php');
    $nomF = $_POST['nomF'];	
  $req2= mysql_query("SELECT * FROM formation_starz where nomF='$nomF'");
  $data2=@mysql_fetch_array($req2);
  echo '
  <div class="row">
  <div class="col-lg-12">
  <div class="col-lg-10">
  <br>
  <h4><b>'.$data2['descF'].'</b> </h4>
  <h4> <b>Trainer 1 : </b>'.$data2['formateur1'].'</h4> 
  <h4><b> Trainer 2 : </b>'.$data2['formateur2'].'</h4>
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
		 
		    $nomF=$data2['nomF'];

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
 
  
  
  ';
  
  ?>