<?php
session_start ();
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
?>
<html>

<head>
<meta charset="utf-8" />
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<title>
Cable UPM 3
</title>
<SCRIPT LANGUAGE="javascript"> 


            function myF1()
              {

               var qtei=document.getElementById("qte_e");
               qtei.innerHTML="";
               var x=document.getElementById("qte_e").value; 
 
                    if((x=="") || (x<0) || (!x.match(/^(0|[1-9][0-9]*)$/)))   
                     {  
                       qtei.value="saisi incorrect";
                       qtei.style.background="#DB5776";
                      return false;
                     }
                    else
                     {
                    return true;  
                     }
               }
			   


            function myF2()
              {

               var qtei=document.getElementById("qte_s");
               qtei.innerHTML="";
               var x=document.getElementById("qte_s").value; 
 
                    if((x=="") || (x<0) || (!x.match(/^(0|[1-9][0-9]*)$/)))   
                     {  
                       qtei.value="saisi incorrect";
                       qtei.style.background="#DB5776";
                      return false;
                     }
                    else
                     {
                    return true;  
					document.getElementById("N_D").value = document.getElementById("qte_e").value - document.getElementById("qte_s").value;
                     }
					 			   		   
			   
			   			   
               }
			
				function calc()
			{
                     
					document.getElementById("N_D").value = document.getElementById("qte_e").value - document.getElementById("qte_s").value;
                     }
			   


             function a1(status)
                {
             status=!status;
			 document.pro_decoup.qd1.disabled=status;
			 
                }
		  	  
                

             function a2(status)
                {
             status=!status;			
			 document.pro_decoup.qd2.disabled=status;
                }
		  
		  
		  
		  
			   function del1()
                   {
                  document.forms['pro_decoup'].qte_e.value="";
                  document.forms['pro_decoup'].qte_e.style.background="#FFFFFF";;
                   }
		     
			 
			 
			   function del2()
                   {
                  document.forms['pro_decoup'].qte_s.value="";
                  document.forms['pro_decoup'].qte_s.style.background="#FFFFFF";;
                   }
		      
			               
      document.form1 = function onLoadDo()
	  {
 var enterpressed = onLoadDo()? onLoadDo().which == 13: window.event.keyCode == 13;
 if (enterpressed){
 	document.form1.submit();
 	return false;
 }
}

			   
			   
		      </SCRIPT> 
</head>

<body onload="a1(false),a2(false),onLoadDo()">

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
elseif($role=="UPM-CRI"){
include('../menu/menuUPM_CRI.php');	
}
elseif($role=="PRD"){
include('../menu/menuProduction.php');	
}elseif($role=="UPM3"){
include('../menu/menuUPM3.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>
<p class="there"> Crimping > END </p>
<br>

<!-- end --> 


<form method="post" action="../php/upm_crimping.php">


		  <?php 
		  include('../connexion/connexionDB.php');
						  $numA=$_SESSION['IDupmCRI'];
						  $sql33 = mysql_query("SELECT * FROM upm_crimping where id_cri='$numA'");
                          $data2=mysql_fetch_array($sql33);
                          $plan=$data2['plan'];
                          $qtE=$data2['qte_e'];
						  $dateD=$data2['date_debut'];
						  
						  echo("<table><TR><th>Plan: </th>
<td> <input  type=\"text\" size=\"15\" id=\"plan\" value=\"".$plan."\"/  READONLY></td>
<Th Wcode_articleTH=150 HEIGHT=30  >Quantité entrée :</Th>
<td><input  type=\"text\" size=\"10\" id=\"qte_e\" value=\"".$data2['qte_e']."\"/ READONLY></td>
<Th Wcode_articleTH=150 HEIGHT=30  > Debut :</Th>
<td><input  type=\"text\" size=\"20\" id=\"dateD\" value=\"".$dateD."\"/ READONLY></td></tr>
</table>");
mysql_close();
						  ?>

		
		<table>
		<TR>
                            <Th > Quantity Out: </Th> 
                            <Td ><input type="text" name="q_sor" id="qte_s" SIZE="8" onblur="myF2(),calc()" onFocus="del2()" ></Td>
						
		 
                           <TH>Nombre de REBUT:</TH> 
                           <Td ><input type="Nombre" name="q_reb" ID="N_D" SIZE="4" readonly></Td>
					  
        </TR> 		
	
        </TR> 

		             <!-- ligne 7 du tableau-->
		
       
		
		
                        <!-- ligne 8 du tableau-->
      
                         <TH colspan=4> Type de REBUT :</TH> 
                         
         <tr>
		 <td> <input type="checkbox" name="option1"  id="lgn" onclick="a1(this.checked)" > Wire seal missing <br> </td>
                         <td colspan=3 ><input type="text" name="ws_missing" id= "qd1" SIZE="8" MAXLENGTH="2"> </td>
						 
                         
         </tr>
		 
		 
         <tr>
						 <td> <input type="checkbox" name="option2" id="denud" onclick="a2(this.checked)" > stripping missing </td>
                         <td colspan=3><input type="text" name="strip_miss" id= "qd2" SIZE="8" MAXLENGTH="8">  </td>
						 
                         
         </tr>
		 <tr>
						 <td> <input type="checkbox" name="option2" id="denud" onclick="a2(this.checked)" > Length of stripping </td>
                         <td colspan=3><input type="text" name="strip_length" id= "qd2" SIZE="8" MAXLENGTH="8">  </td>
						
                         
         </tr>
        <tr>
						 <td> <input type="checkbox" name="option2" id="denud" onclick="a2(this.checked)" > Position of wire seal </td>
                         <td colspan=3><input type="text" name="ws_pos" id= "qd2" SIZE="8" MAXLENGTH="8">  </td>
						 
                         
         </tr>
		   <tr>
						 <td> <input type="checkbox" name="option2" id="denud" onclick="a2(this.checked)" > Wire seal aspect</td>
                         <td colspan=3><input type="text" name="ws_aspect" id= "qd2" SIZE="8" MAXLENGTH="8">  </td>
					
                         
         </tr>
		   <tr>
						 <td> <input type="checkbox" name="option2" id="denud" onclick="a2(this.checked)" > Contact aspect</td>
                         <td colspan=3><input type="text" name="contact_aspect" id= "qd2" SIZE="8" MAXLENGTH="8">  </td>
					
                         
         </tr>
		 <tr>
						 <td> <input type="checkbox" name="option2" id="denud" onclick="a2(this.checked)" >Other </td>
                         <td colspan=3><input type="text" name="other" id= "qd2" SIZE="8" MAXLENGTH="8">  </td>
						
                         
         </tr>
		 
    
  
     
  
<tr><td></td><td colspan=3><input type="submit" id="submitbutton"></td></tr>
  
  
  
  
  
  
 </TABLE>  
 
 
   

</form>
  </div>

</div>

</body>

</html>



 
 



