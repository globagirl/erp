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
            Add Staff
        </title>
        <script>
            var i=1;
            //var j=1;
            //Ajout Nouvelle zone TEL
            function addTel(){
                i++;
                var T="tel"+i;
                var P="P"+i;
                $('#telZ').append(' <div id='+T+'><input type="text" size=20  name='+T+' placeholder='+T+'>  <input type="text" size=20  name='+P+' placeholder="Parent"></div>');
                document.getElementById('nbr').value=i;
            }
            //Ajout Nouveau diplome
            function addDiplome(){
                j= document.getElementById('nbr2').value;
                j++;
                var dip="diplome"+j;
                var A="dipA"+j;
                $('#dip').append('<div id='+dip+'><br><textarea cols="30" rows="2" name='+dip+' ></textarea> <br> <input type="text" size=8  name='+A+' placeholder="Year"></div>');
                document.getElementById('nbr2').value=j;
            }
            //Ajout Nouveau Formation par starz
            function addFS(){
                var x=document.getElementById('nbr3').value;
                x++;
                var fs="FS"+x;
                var Zfs="ZFS"+x;
                var M="mFS"+x;
                var dd="dateDF"+x;
                var df="dateFF"+x;
                $('#divFS').append('<div id='+Zfs+'> <br><span class="custom-dropdown custom-dropdown--white custom-dropdown--small"><select '+fs+' id='+fs+' style="width:150px" onFocus=listeFormation("'+fs+'"); class="custom-dropdown__select custom-dropdown__select--white"><option value="s">Select ...</option></select></span></div>');
                document.getElementById('nbr3').value=x;
            }
            ///DELTE diplome
            function deleteDiplome(){
                j= document.getElementById('nbr2').value;
                var D1="#diplome"+j;
                if(j>1){
                    $(D1).remove();
                    j--;
                    document.getElementById('nbr2').value=j;
                }
            }
            ///DELTE TEL
            function deleteTel(){
                if(i>1){
                    var D="#tel"+i;
                    $(D).remove();
                    i--;
                    document.getElementById('nbr').value=i;
                }
            }
            ///DELTE FS
            function deleteFS(){
                var x=document.getElementById('nbr3').value;
                if(x>1){
                    var D="#ZFS"+x;
                    $(D).remove();
                    x--;
                    document.getElementById('nbr3').value=x;
                }
            }
            //verifier tt les champs
            function verifier(){
                var val=document.getElementById("mat").value;
                var val1=document.getElementById("ncin").value;
                var val2=document.getElementById("nom").value;
                var val21=document.getElementById("prenom").value;
                var val4=document.getElementById("dateN").value;
                var dateE=document.getElementById("dateE").value;
                var val5=document.getElementById("ad1").value;
                var val6=document.getElementById("tel1").value;
                var val8=document.getElementById("salaire").value;
                var liste1 = document.getElementById("contrat");
                var val3 = liste1.options[liste1.selectedIndex].value;
                var liste2 = document.getElementById("cat");
                var cat = liste2.options[liste2.selectedIndex].value;
                if(val==""){
                    alert("PLZ Add Registration Number !!");
                    document.getElementById('mat').style.backgroundColor='pink';
                }
                /*else if(val1==""){
                    alert("Donnez LE NCIN du personnel  SVP !!");
                    document.getElementById('ncin').style.backgroundColor='pink';
                }*/
                else if(val2==""){
                    alert("PLZ Enter Name !!");
                    document.getElementById('nom').style.backgroundColor='pink';
                }else if(val21==""){
                    alert("PLZ Enter First Name !!");
                    document.getElementById('prenom').style.backgroundColor='pink';
                }/* else if(val4==""){
	alert("Donnez la date naissance SVP!!");
	document.getElementById('dateN').style.backgroundColor='pink'; 
}*/
                /* else if(val5==""){
                    alert("Donnez une adresse SVP !!");
                    document.getElementById('ad1').style.backgroundColor='pink';
                }*/
                /*else if(val6==""){
                    alert("Donnez un numéro de téléphone SVP !!");
                    document.getElementById('tel1').style.backgroundColor='pink';
                }*/
                else if(val3=="s"){
                    alert("PLZ Select Contract Type !! ");
                    document.getElementById('contrat').style.backgroundColor='pink';
                }else  if(cat=="s"){
                    alert("PLZ Select Category !! ");
                    document.getElementById('cat').style.backgroundColor='pink';
                }else if(val8==""){
                    alert("PLZ enter gross salary!!");
                    document.getElementById('salaire').style.backgroundColor='pink';
                } else if(dateE==""){
                    alert("PLZ Enter Date !!");
                    document.getElementById('dateE').style.backgroundColor='pink';
                }
                else {
                    document.getElementById('nbr').value=i;
                    document.forms['form1'].submit();
                }
            }
            ///Insertion image personnel
            function fileChange(){
                var x = document.getElementById("fileP");
                var fReader = new FileReader();
                fReader.readAsDataURL(x.files[0]);
                fReader.onloadend = function(event){
                    var img = document.getElementById("imgP");
                    img.src = event.target.result;
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
            //Vérification de l'existance du matricule
            function verifierM(){
                var M=document.getElementById("mat").value;
                $.ajax({
                    type: 'POST',
                    data : 'D=' + M,
                    url: '../php/verif_doubleP.php',
                    success: function(data) {
                        if(data==1){
                            alert("Registration Number Already Exist !!");
                            document.getElementById("mat").value="";
                        }
                    }});
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
            <BR>
            <p class="there">Add Staff</p>
            <br>
            <!-- end -->
            <?php
            include('../connexion/connexionDB.php');
            ?>
            <br>
            <hr>
            <form method="post"  id="form1" action="../php/ajout_personnel.php" enctype="multipart/form-data">
                <TABLE >

                    <TR>
                        <Th>Registration Number: </Th>
                        <TD><input type="text" id="mat" name="mat" SIZE="20" onBlur="verifierM();"></TD>
                        <td colspan=2 rowspan=4>
                            <center><img src="../image/profil/image_user.png" alt="user" style="width:120px;height:100px;" id="imgP"></center>
                        </td>
                    </TR>
                    <TR>
                        <Th>Name & Last Name: </Th>
                        <TD>
                            <input type="text" id="prenom" name="prenom" SIZE="20" placeholder="Last Name">
                            <input type="text" id="nom" name="nom" SIZE="20" placeholder="Name">
                        </TD>
                    </TR>
                    <TR>
                        <Th>ID Card N°: </Th>
                        <TD ><input type="text" id="ncin" name="ncin" SIZE="20"></TD>
                    </tr>
                    <tr>
                        <Th>Registration CNSS N° : </Th>
                        <TD ><input type="text" id="cnss" name="cnss" SIZE="20"></TD>
                    </tr><tr>
                        <Th>Birthday Date: </Th>
                        <TD ><input type="date" id="dateN" name="dateN" SIZE="20"></TD>
                        <td colspan=2>
                            <center><input type="file" multiple="multiple" name="fileP" id="fileP"  onChange="fileChange();"/></center>
                        </td>
                    </TR>
                    <TR>
                        <Th  >Address 1: </Th>
                        <TD ><textarea cols=30 rows=2 name="ad1" id="ad1" placeholder="Address ... "></textarea></TD>
                        <Th  >Address 2: </Th>
                        <TD ><textarea cols=30 rows=2 name="ad2" id="ad2" placeholder="Address ... "></textarea></TD>
                    </TR>
                    <TR>
                        <Th  >TEL : </Th>
                        <TD id="telZ"><input type="text" id="tel1" name="tel1" SIZE="20" placeholder="tel1">
                            <input type="text" id="P1" name="P1" SIZE="20" value="Personnel" READONLY>
                            <input type="button" onclick="addTel();" value="+" >
                            <input type="button" onclick="deleteTel();" value="-" >
                            <input type="text" id="nbr" name="nbr" SIZE="2" value="1" HIDDEN>
                        </TD>
                        <Th  >E-mail : </Th>
                        <TD ><input type="text" id="mail" name="mail" SIZE="30" placeholder="exemple@exp.com">
                    </TR>
                    <tr>
                        <Th  >Diplomat & Training: </Th>
                        <TD ><div id="dip"><textarea cols=30 rows=2 name="diplome1" id="diplome1" placeholder="Diplomat ... "></textarea>
                                <br>
                                <input type="text" name="dipA1" id="dipA1"  size="8" placeholder="Year">
                            </div>
                            <br>
                            <input type="button" onclick="addDiplome();" value="+" >
                            <input type="button" onclick="deleteDiplome();" value="-" >
                            <input type="text" id="nbr2" name="nbr2"  value="1" HIDDEN>
                        </TD>
                        <Th  >STARZ Training: </Th>
                        <TD >
                            <div id="divFS">
                                 <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
                                    <select name="FS1" id="FS1" style="width:150px" onFocus="listeFormation('FS1');" class="custom-dropdown__select custom-dropdown__select--white">
                                        <option value="s">Select ...</option>
                                    </select>
                                </span>
                            </div>
                            <br>
                            <input type="button" onclick="addFS();" value="+" >
                            <input type="button" onclick="deleteFS();" value="-" >
                            <input type="text" id="nbr3" name="nbr3"  value="1" HIDDEN>
                        </TD>
                    </TR>
                    <tr>
                        <TH>Contract: </TH>
                        <TD>
                            <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
                            <select name="contrat" id="contrat"  class="custom-dropdown__select custom-dropdown__select--white">
                                <option value="s">---Selct---</option>
                                <option value="SIVP">SIVP</option>
                                <option value="CDI">CDI</option>
                                <option value="CDD">CDD</option>
                                <option value="Contrat apprentit">Apprentice Contract</option>
                                <option value="Non contractuel">Not contractual</option>
                            </select>
			                </span>
                        </TD>
                        <TH >Category: </TH>
                        <td >
                              <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
                                    <select name="cat" id="cat"  class="custom-dropdown__select custom-dropdown__select--white">
                                        <option value="s">--Select---</option>
                                        <option value="Ouvrier">Operative</option>
                                        <option value="Apprentit">Apprentice</option>
                                        <option value="Saisonier">Seasonal</option>
                                        <option value="Stagiaire">Trainee</option>
                                        <option value="Technicien">Technician</option>
                                        <option value="Technicien supérieur">Senior Technician</option>
                                        <option value="Ingénieur">Engineer</option>
                                        <option value="Cadre">Cadre</option>
                                    </select>
                             </span>
                        </td></tr>
                    <tr>
                        <Th  >Gross Salary: </Th>
                        <TD><input type="text" id="salaire" name="salaire" SIZE="20">
                            <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
                                <select name="typeS" id="typeS"  class="custom-dropdown__select custom-dropdown__select--white">
                                    <option value="V">Variable</option>
                                    <option value="F">Fix</option>
                                </select>
                            </span>
                        </TD>
                        <Th  >Entry Date:</Th><td>
                            <input type="date" id="dateE" name="dateE" SIZE="20">
                        </TD>
                    </TR>
                    <tr>
                        <Th  >Accumulated leave:</Th><td colspan=3>
                            <input type="text" id="conge" name="conge" SIZE="20" placeholder="Hours N°">
                        </TD>
                    </TR>
                    <tr>
                        <Th  >Note: </Th>
                        <TD colspan="3"><textarea cols=30 rows=4 name="note" id="note" placeholder="Commentaries ..."></textarea><br>
                        </td>
                    </tr>
                    <tr><td></td><td colspan=3>
                            <input type= "file" name="cv[]"  multiple>
                        </TD>
                    </TR>

                    <td ></td><td colspan=3> <input type="button" id="submitbutton" onclick="verifier()" value="Add >>"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    </body>
    </html>
<?PHP
if(!empty($_GET['status']))
{
    $status = $_GET['status'];
    if  ($status=="sent")
    {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Employee added successfully\');</SCRIPT>';
        //header('Location: ../pages/ajout_fact.php');
    } else if ($status=="fail")
    {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Fail !! PLZ try again\');</SCRIPT>';}
}
?>