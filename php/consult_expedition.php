 <?php
    include('../connexion/connexionDB.php');
    $valeur=$_POST['valeur'];
    $recherche=$_POST['recherche'];
    $tab=array();
    echo '<div class="row"><div  class="col-md-8">';
    //Liste d'expedition trouvée
    
    echo '<div class="table-responsive" id="divRel">
               
											    <table  class="table table-fixed  results" id="table3">
												    <thead style="width:100%">
                <tr><th style="width:99.9%;height:40px"> Commande expédié</th></tr>
			               <tr>
                  <th style="width:24.8%;height:40px" >PO</th>
                  <th style="width:19.8%;height:40px" >Product</th>
                  <th style="width:14.8%;height:40px" >QTY</th>
                  <th style="width:19.9%;height:40px" >Date exp</th>
                  <th style="width:19.9%;height:40px" >Creation</th>
		                </tr>
												    </thead>
													<tbody id="tbody2" style="width:100%">';
             $req= "SELECT * FROM expedition where $recherche='$valeur'";
             $r=mysql_query($req) or die(mysql_error());
             $tot=0;
             while($a=mysql_fetch_array($r)){
              
               $OF =$a['OF'];
               $tab[]=$OF;
               $req1= mysql_query("SELECT produit,qte FROM ordre_fabrication1 where OF='$OF'");
               $data1=@mysql_fetch_array($req1);
               $qte=$data1['qte'];
               $tot=$tot+$qte;
               echo('<tr>
                    <td  style="width:25%;height:40px;">'.$a['PO'].'</td>
                    <td  style="width:20%;height:40px;">'.$data1['produit'].'</td>
                    <td style="width:15%;height:40px;">'.$data1['qte'].'</td>
                    <td style="width:20%;height:40px;">'.$a['date_exp'].'</td>
                    <td style="width:20%;height:40px;">'.$a['date_crea'].'</td></tr> ');
             }
             $x=@mysql_num_rows($r);
             echo '<tr>
             <td style="width:100%;height:40px;"><b>Total commande: '.$x.'</b></td>             
             </tr>
             <tr>
             <td style="width:100%;height:40px;"><b>Total qty: '.$tot.'</b></td>             
             </tr>
             </tbody> </table></div></div>';
             
             //Affichage des commande non éxpédié
              echo '<div  class="col-md-4">';
              echo '<div class="table-responsive">
               
											    <table  class="table table-fixed  results" id="table2">
												    <thead style="width:100%">
                <tr><th style="width:99.9%;height:40px"> Commande non expédié </th></tr>
			               <tr>
                  <th style="width:44.8%;height:40px" >PO</th>                 
                  <th style="width:24.8%;height:40px" >QTY</th>
                  <th style="width:29.9%;height:40px" >Date exp</th>                 
		                </tr>
												    </thead>
													<tbody id="tbody2" style="width:100%">';
             $vals=implode(",",$tab);
           
             if($recherche=="date_exp"){
              $sql= mysql_query("SELECT PO,qte,date_exped_conf FROM ordre_fabrication1 where OF NOT IN ($vals) and date_exped_conf='$valeur'");
             }else if($recherche == "PO"){
               $sql=mysql_query("SELECT PO,qte,date_exped_conf FROM ordre_fabrication1 where OF NOT IN ($vals) and PO='$valeur'");
             }else{
               $sql=mysql_query("");
             }
             
             //$s=@mysql_query($sql) or die(mysql_error());
             $tot2=0;
             while($data=@mysql_fetch_array($sql)){
              $tot2=$tot2+$data['qte'];
              
               echo('<tr>
                    <td  style="width:45%;height:40px;">'.$data['PO'].'</td>             
                    <td style="width:25%;height:40px;">'.$data['qte'].'</td>
                    <td style="width:30%;height:40px;">'.$data['date_exped_conf'].'</td></tr> ');
             }
             $x2=@mysql_num_rows($sql);
             echo '<tr>
             <td style="width:100%;height:40px;"><b>Total commande: '.$x2.'</b></td>             
             </tr>
             <tr>
             <td style="width:100%;height:40px;"><b>Total qty: '.$tot2.'</b></td>             
             </tr>
             </tbody> </table></div></div></div>';
             mysql_close();


  ?>