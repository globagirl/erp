 <?php
include('../connexion/connexionDB.php');
$item=@$_POST['item'];
$cl_four=@$_POST['cl_four'];
$valeur=@$_POST['val'];
$date1=@$_POST['date1'];
$date2=@$_POST['date2'];

if($item==""){
 $op="NOT LIKE";
}else{
 $op="LIKE";
}
if($cl_four=="client"){
 if($date1 == "" && $date2 == ""){
   $req= "SELECT * FROM update_prices_product where item $op '$item' and client = '$valeur' ";

 }else{
   $req= "SELECT * FROM update_prices_product where item $op '$item' and dateM >= '$date1' and dateM <= '$date2' and client = '$valeur'";

 }
}else{
  if($date1 == "" && $date2 == ""){
   $req= "SELECT * FROM update_prices_item where item $op '$item' and four = '$valeur'  ";

 }else{
   $req= "SELECT * FROM update_prices_item where item $op '$item' and four ='$valeur'  and dateM >= '$date1' and dateM < '$date2'";

 }
}



  echo'<br><br><hr><div class="table-responsive">
<table class="table table-fixed results" id="table3">
<thead style="width:100%">

			<tr>
               <th style="width:19.8%;height:60px" >Item</th>
				<th style="width:14.8%;height:60px" >Date modification</th>
				<th style="width:14.8%;height:60px" >Ancien prix</th>
				<th style="width:14.8%;height:60px" >Nouveau prix</th>
				<th style="width:34.8%;height:60px" >Note</th>



            </tr>
          </thead>
		   <tbody id="tbody2" style="width:100%">

  </tr>';



  $r=mysql_query($req) or die(mysql_error());
   while($data=mysql_fetch_array($r))
    {
    echo'<tr><td style="width:20%;height:60px" >'.$data['item'].'</td>
    <td style="width:15%;height:60px" >'.$data['dateM'].'</td>
    <td style="width:15%;height:60px" >'.$data['ancien_prix'].'</td>
    <td style="width:15%;height:60px" >'.$data['nouveau_prix'].'</td>
     <td style="width:35%;height:60px" >'.$data['description'].'</td>
    </tr>';


    }


  echo '</tbody></table>';

//echo($val);

  ?>
