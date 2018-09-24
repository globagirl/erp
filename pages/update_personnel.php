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
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />



<title>
Update Personel
</title>
<script>

//Ajout Nouvelle zone TEL
function addTel(){
var i=document.getElementById('nbr').value;
i++;
var T="tel"+i;
var P="P"+i;
$('#telZ').append(' <div id='+T+'><input type="text" size=20  name='+T+' placeholder='+T+'> <input type="text" size=20  name='+P+' placeholder="Parent"></div>');
document.getElementById('nbr').value=i;
}
///DELTE TEL
function deleteTel(){	
var i=document.getElementById('nbr').value;   
if(i>1){
	var D="#tel"+i;
	$(D).remove();
	i--;
	document.getElementById('nbr').value=i;
     }
}
//Ajout Nouvelle zone Note
function addNote(){
var i=document.getElementById('nbr2').value;
i++;
var T="note"+i;
$('#noteZ').append(' <div id='+T+'><textarea  cols=40 rows=3  name='+T+' placeholder='+T+'></textarea></div>');
document.getElementById('nbr2').value=i;
}
///DELTE TEL
function deleteNote(){	
var i=document.getElementById('nbr2').value;   
if(i>0){
	var D="#note"+i;
	$(D).remove();
	i--;
	document.getElementById('nbr2').value=i;
     }
}
//Ajout diplome
function addDiplome(){
j= document.getElementById('nbr3').value;
j++;
var dip="diplome"+j;
var A="dipA"+j;
$('#diP').append('<div id='+dip+'><br><textarea cols="30" rows="2" name='+dip+' ></textarea> <br> <input type="text" size=8  name='+A+' placeholder="Année"></div>');
document.getElementById('nbr3').value=j;
}
///DELTE diplome
function deleteDiplome(){	
j= document.getElementById('nbr3').value;  
var D1="#diplome"+j; 

if(j>1){

	
	
	$(D1).remove();
	j--;
	document.getElementById('nbr3').value=j;
     }
	 
	
}
//verifier tt les champs 
function verifier(){
var val=document.getElementById("mat").value;
var val1=document.getElementById("ncin").value;
var val2=document.getElementById("nom").value;
var val4=document.getElementById("dateN").value;
var val5=document.getElementById("ad1").value;
//var val6=document.getElementById("tel1").value;
var val8=document.getElementById("salaire").value;
var liste1 = document.getElementById("contrat");
var val3 = liste1.options[liste1.selectedIndex].value;	 
var liste2 = document.getElementById("cat");
var cat = liste2.options[liste2.selectedIndex].value;

 if(val==""){
	alert("Ajouter un matricule SVP !!");
	document.getElementById('mat').style.backgroundColor='pink'; 
}else if(val1==""){
    alert("Donnez LE NCIN du personnel  SVP !!");
	document.getElementById('ncin').style.backgroundColor='pink';
}else if(val2==""){
	alert("Donnez le nom SVP !!");
    document.getElementById('nom').style.backgroundColor='pink'; 
}else if(val4==""){
	alert("Donnez la date naissance SVP!!");
	document.getElementById('dateN').style.backgroundColor='pink'; 
}else if(val5==""){
	alert("Donnez une adresse SVP !!");
	document.getElementById('ad1').style.backgroundColor='pink'; 
}else  if(val3=="s"){
	alert("Type contrat ?!! ");
			  //document.getElementById('contrat').style.backgroundColor='pink'; 
}else  if(cat=="s"){
			  alert("Catégorie personnel ?!! ");
			  //document.getElementById('cat').style.backgroundColor='pink'; 
}else if(val8==""){
			  alert("Le salaire brut SVP !!");
			  document.getElementById('salaire').style.backgroundColor='pink'; 
}else{
	document.forms['form1'].submit(); 
}

}
//
function changePage(){
	document.location.href="../pages/consult_personnel.php";
}	

//Personnel actif
function actifP(){
var val=document.getElementById("mat").value;
 if(confirm("Ce personnel sera actif de nouveau , Voulez vous terminer ?!")){
 var matNV = prompt("Entrer un nouveau matricule SVP ",val);
 
$.ajax({
        type: 'POST',
        data:'mat='+val+'&matNV='+matNV,
        url: '../php/update_personnel_actif.php',
        success: function(data) {        
        //location.reload();
        document.location.href="../pages/consult_personnel.php";	
       }});
}
}
//Personel inactif 
function inactifP(){
var val=document.getElementById("mat").value;
 if(confirm("Ce personnel sera inactif  , Voulez vous terminer ?!")){
$.ajax({
        type: 'POST',
        data:'mat='+val,
        url: '../php/update_personnel_inactif.php',
        success: function(data) {
        alert("Nouveau matricule : "+data);
		//location.reload();
		document.location.href="../pages/consult_personnel.php";	
       }});
}
}

/////////
function fileChange(){
var x = document.getElementById("fileP"); 
var fReader = new FileReader();
fReader.readAsDataURL(x.files[0]);
fReader.onloadend = function(event){
var img = document.getElementById("imgP");

img.src = event.target.result;
}
//alert(x);
}
//ajout formation
function addFS(){

var x=document.getElementById('nbr4').value;
x++;

var fs="FS"+x;
var Zfs="ZFS"+x;
var M="mFS"+x;

$('#divFS').append('<div id='+Zfs+'> <br><select name='+fs+' id='+fs+' style="width:150px" onFocus=listeFormation("'+fs+'");><option value="s">Select ...</option></select></div>');
document.getElementById('nbr4').value=x;

}

///DELTE FS

function deleteFS(){
var x=document.getElementById('nbr4').value;

if(x>1){
	var D="#ZFS"+x;
	$(D).remove();
	x--;
	document.getElementById('nbr4').value=x;
     }

}

////
function listeFormation(zone){
 var z="#"+zone;
 $.ajax({
			url: '../php/listeFormation.php',
			type: 'POST',			
			success:function(data){
		   $(z).html(data);
}});
}
</script>
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


<BR>
<p class="there">Update Personnel</p>




<br>

<!-- end --> 
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
<br>
<p style="float:right">

<img src="../image/change.png" onclick="changePage();" alt="Print" style="cursor:pointer;" width="60" height="50"  />
</p>

<form method="POST"  id="form1" name="form1" action="../php/update_personnel.php" enctype="multipart/form-data">


<TABLE > 

		<TR> 
			<Th>Matricule: </Th> 
			<TD ><input type="text" id="mat" name="mat" SIZE="20" value="<?php echo $data1['matricule']; ?>"></TD>
            <td colspan=2 rowspan=4> 
			<center><img src="<?php echo $data1['imgP']; ?>" alt="user" style="width:120px;height:100px;" id="imgP"></center>
			</td>
		</TR> 	
		<TR> 
		
		
			<Th>Nom & Prenom: </Th> 
			<TD><input type="text" id="nom" name="nom" SIZE="30" value="<?php echo $data1['nom']; ?>"></TD> 
				
		</TR> 
		<TR> 
			<Th>NCIN: </Th> 
			<TD ><input type="text" id="ncin" name="ncin" SIZE="20" value="<?php echo $data1['NCIN']; ?>"></TD> 
			
			</tr>
			<TR> 
			<Th>Matricule CNSS: </Th> 
			<TD ><input type="text" id="cnss" name="cnss" SIZE="20" value="<?php echo $data1['CNSS']; ?>" placeholder="Matricule CNSS"></TD> 
			
			</tr>
			<tr>
			<Th>Date naissance: </Th> 
			<TD ><input type="date" id="dateN" name="dateN" SIZE="20" value="<?php echo $data1['dateN']; ?>"></TD> 
		 <td colspan=2><center><input type="file" multiple="multiple" name="fileP" id="fileP"  onChange="fileChange();"/></center> </td>
			
						
		</TR> 
        <TR> 
			<Th  >Adresse: </Th> 
			<TD ><textarea cols=30 rows=2 name="ad1" id="ad1" ><?php echo $data1['adresse1']; ?></textarea>
			<textarea cols=30 rows=2 name="ad2" id="ad2"><?php echo $data1['adresse2']; ?>
			
			</textarea></TD>
			<?php	
			
	        $sqlE = mysql_query("SELECT max(dateH) FROM personnel_datee where matricule='$mat' and statut='E'");
			$nbr=mysql_num_rows($sqlE);
			$nbr=$nbr-1;
			$dateE=mysql_result($sqlE,$nbr);
           ?>
			<Th  >Date entrée: </Th> 
			<TD ><input type="date" id="dateE" name="dateE" SIZE="20"  value="<?php echo $dateE ?>">	</textarea></TD> 
						
		</TR> 
		<TR> 
			<Th  >TEL : </Th> 
			<TD>
			<div id="telZ">
			<?php	
			$x=0;
	        $sql2 = mysql_query("SELECT * FROM personnel_tel where matricule='$mat'");
	        while($data2=mysql_fetch_array($sql2)){
			$x++;
			$n="tel".$x;
			$P="P".$x;
			echo '<div id='.$n.'><input type="text" value='.$data2['tel'].' name='.$n.' id='.$n.' > <input type="text" size=20  name='.$P.' value='.$data2['proprietor'].'><br></div>';	
			
	        }
            ?>
			</div>
			<input type="text" id="nbr" name="nbr" SIZE="2" value="<?php echo $x ; ?>" HIDDEN>
			<input type="button" onclick="addTel();" value="+" >
			<input type="button" onclick="deleteTel();" value="-" >
			
			</TD> 
			<Th  >E-mail : </Th> 
			<TD ><input type="text" id="mail" name="mail" SIZE="30"  value="<?php echo $data1['mail']; ?>">		
		</TR> 
		<tr>
  	<Th  >Diplome & formation: </Th> 
			<TD>
			<?php
		    $j=0;
	
	        $sql4 = mysql_query("SELECT * FROM personnel_diplome where matricule='$mat'");
	        while($data4=mysql_fetch_array($sql4)){
			$j++;
			$d="diplome".$j;
			$a="dipA".$j;
			echo '<div id='.$d.'><textarea cols=30 rows=2 name='.$d.'  placeholder="Diplome ... ">'.$data4['diplome'].'</textarea> 
			<br>
			<input type="text" name='.$a.'  size="8" value='.$data4['annee'].'>
			
			</div>';
		
			
	        }
            ?>
			<div id="diP"></div>
			<input type="button" onclick="addDiplome();" value="+" >
			<input type="button" onclick="deleteDiplome();" value="-" >
			<input type="text" id="nbr3" name="nbr3"  value="<?php echo $j ; ?>" HIDDEN>
		
			</td>
		
		<Th  >Starz training: </Th> 
		<td>
		<div id="divFS">
			
			<?php
		    $f=0;	
	        $sql5 = mysql_query("SELECT * FROM personnel_starz_formation where matricule='$mat'");
	        while($data5=mysql_fetch_array($sql5)){
			$f++;
			$FS="FS".$f;
			$ZFS="ZFS".$f;
			echo "<div id=\"".$ZFS."\">
			 
			<select name=".$FS." id=".$FS." style=\"width:150px\" onFocus=listeFormation('".$FS."');>			
			<option selected value=\"".$data5['Formation']."\">".$data5['Formation']."</option>
		
			</select>
			
		    </div>
			<br>
			";
				
	        }
            ?>
			</div>
			
			<input type="button" onclick="addFS();" value="+" >
			<input type="button" onclick="deleteFS();" value="-" >
			<input type="text" id="nbr4" name="nbr4"  value="<?php echo $f; ?>" HIDDEN >
			</td>			
		</TR> 
		<tr>
            <TH>Contrat: </TH> 
            <TD> <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			<select name="contrat" id="contrat"  class="custom-dropdown__select custom-dropdown__select--white">
			
			<option  value="<?php echo $data1['contrat']; ?>"> <?php echo $data1['contrat']; ?></option>
			<option value="SIVP">SIVP</option>
			<option value="CDI">CDI</option>
            <option value="CDD">CDD</option>
			<option value="Contrat apprentit">Contrat apprentit</option>
            <option value="Non contractuel">Non contractuel</option>	
			
			</select>
			</span></TD> 

<TH >Catégorie: </TH> 
<td >

  <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			<select name="cat" id="cat"  class="custom-dropdown__select custom-dropdown__select--white">
			
			<option  value="<?php echo $data1['category']; ?>"> <?php echo $data1['category']; ?></option>
			<option value="Ouvrier">Ouvrier</option>
			<option value="Apprentit">Apprentit</option>
			<option value="Saisonier">Saisonier</option>
			<option value="Stagiaire">Stagiaire</option>
			<option value="Technicien">Technicien</option>
			<option value="Ingénieur">Ingénieur</option>
			<option value="Cadre">Cadre</option>
			</select>
	 </span>	
</td></tr>
<tr>
           <th>Salaire Brut: </th> 
			<TD><input type="text" id="salaire" name="salaire" SIZE="20"  value="<?php echo $data1['salaire']; ?>">
			<?php $typeS=$data1['typeS'];
            if($typeS=="V"){
			$typeS="Variable";
			}else{
			$typeS="Fixe";
			}
			?>
			<span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			<select name="typeS" id="typeS"  class="custom-dropdown__select custom-dropdown__select--white">
			
			<option value="<?php echo $data1['typeS']; ?>"><?php echo $typeS; ?></option>
			<option value="V">Variable</option>
			<option value="F">Fixe</option>
           
			
			</select>
			</span>
			
			
			
			</TD> 

           			
            <Th  >Salaire intermédiaire:</Th><td>
			<input type="text" id="salaireI" name="salaireI" SIZE="20"  value="<?php echo  $data1['salaireI'] ?>">			
		   </TR> 
		<tr>
			<th >Note: </th> 
			<td colspan="3">
			<?php
	        $nbrNote=0;
	        $sql3 = mysql_query("SELECT * FROM personnel_note where matricule='$mat'");
	        while($data3=mysql_fetch_array($sql3)){
			    if($data3['note'] != ""){
		            $nbrNote++;
					$note="note".$nbrNote;
					$noteS="noteS".$nbrNote;
			        echo '<small>'.$data3['dateN'].'</small>:<br><textarea cols=40 rows=3 name='.$note.' id='.$note.' placeholder="Commentaire ...">'.$data3['note'].'</textarea><input value='.$data3['idPN'].' name='.$noteS.' hidden> <br>';
		        }
	        }
            ?>
			<div id="noteZ">
			</div>
			<input type="text" id="nbr2" name="nbr2" SIZE="2" value="<?php echo $nbrNote;?>" HIDDEN>
			<input type="button" onclick="addNote();" value="+" >
			<input type="button" onclick="deleteNote();" value="-" >
		
			</td>
			</tr>
			<tr><td></td>
			<td colspan=3>
			<?php
		
	
	        $sql4 = mysql_query("SELECT * FROM personnel_cv where matricule='$mat'");
	        while($data4=mysql_fetch_array($sql4)){
			echo"<a href=\"".$data4['dataF']."\" target=\"_blank\"><img src=\"../image/viewFile2.png\" alt=\"view\" width=\"35\" height=\"30\"></a>";
		
			
	        }
            ?>
			<br><br>
			<input type= "file" name="cv[]"  multiple>
			</TD> 
						
		</TR> 
		
<td ></td><td colspan=2> <input type="button" id="submitbutton" onclick="verifier();" value="Update >>">
</td>
<?php 
              if ($data1['etat']=="inactif"){
			   echo '<td> <img src="../image/actif.png" onclick="actifP();" alt="Print" style="cursor:pointer;" width="60" height="50"  /></td>	';
              }else{
			  echo '<td> <img src="../image/inactif.png" onclick="inactifP();" alt="Print" style="cursor:pointer;" width="60" height="50"  /></td>	';
			  }
            			  
			?>


</tr>
</table>

<?php
mysql_close();
?>
		


 
</form>


</div>
</div>
</body>

</html>