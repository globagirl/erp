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
    <title>Product</title>
    <script>
        var i=1;
        ////////////////////////LISTE LIKE GOOGLE :) /////////////
        function autoComplete(c,l){
            var zoneC="#"+c;
            var zoneL="#"+l;
            var min_length =3;
            var keyword = $(zoneC).val();
            if (keyword.length >= min_length) {

                $.ajax({
                    url: '../php/auto_liste_article.php',
                    type: 'POST',
                    data: "val="+keyword+"&Z="+zoneC,
                    success:function(data){
                        $(zoneL).show();
                        $(zoneL).html(data);
                    }});
            }else {
                $(zoneL).hide();
            }
        }
        //
        function hideListe(l) {

            var zoneL="#"+l;
            $(zoneL).hide();
        }
        //
        function choixListe(p,z) {
            $(z).val(p);
        }
        ////////////////////////////////////FIN///////////////
        ///////ajout component
        function addA(){
            var TRF="#TR"+i;
            i++;
            var T="TR"+i;
            var C="C"+i;
            var Q="Q"+i;
            var listeC="listeC"+i;
            $(TRF).after('<div class="col-lg-12" id='+T+'><div class="form-group well"><label>Composant '+i+'</label><div class="form-inline"><input type="text" size="20" name='+C+' id='+C+'placeholder="Code composant" class="form-control" onKeyup=autoComplete("'+C+'","'+listeC+'") onFocus=autoComplete("'+C+'","'+listeC+'")  onBlur=hideListe("'+listeC+'")><input type="text" size="4" name='+Q+' id='+Q+' class="form-control" placeholder="QTY"></div><div class="divAuto"><ul id='+listeC+' ></ul></div></div> </div>');
            document.getElementById('nbr').value=i;
        }
        /////delete zone
        function deleteA(){
            if(i>1){
                var D="#TR"+i;
                $(D).remove();
                i--;
                document.getElementById('nbr').value=i;
            }

        }
        ////POP_UP
        function pop_up(url){
            window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1076,height=768,directories=no,location=no')
        }
        //afficher Taille du lot selon longueur
        function verifierL(){
            var val=document.getElementById('long').value;
            $.ajax({
                type: 'POST',
                data: "long="+val,
                url: '../php/verifierLongProduit.php',
                success: function(R) {
                    if(R=="0"){
                        bootbox.alert("Length does'nt exist, PLZ add it !!");
                        document.getElementById('long').style.backgroundColor='pink';
                    }else{
                        var x = R.indexOf("|");
                        var nbr=R.substr(0,x);
                        var l=R.length;
                        var lot=R.substr(x+1,l);
                        document.getElementById("nbr_box").value=nbr;
                        document.getElementById("tlots").value=lot;
                    }
                }});
        }
        //
        function verif_produit(){
            var val=document.getElementById('code_produit').value;
            $.ajax({
                type: 'POST',
                data: "prd="+val,
                url: '../php/verifier_produit.php',
                success: function(R) {
                    if(R=="1"){
                        bootbox.alert("Product Already Exist !!");
                    }
                }});
        }
        ///affichage longueur selon CAT
        /*function afficheL(){
                var cat =document.getElementById('cat').value;
                if((cat=="PCB")||(cat=="Others")){
                document.getElementById('long').disabled=true;
                document.getElementById('tlots').disabled=true;
                document.getElementById('nbr_box').disabled=true;
                document.getElementById('add1').disabled=true;
                }else{
                document.getElementById('long').disabled=false;
                document.getElementById('tlots').disabled=false;
                document.getElementById('nbr_box').disabled=false;
                document.getElementById('add1').disabled=false;
                }
          }*/

        //Liste catégorie
        function catListe(){
            $.ajax({
                type: 'POST',
                url: '../php/listeCatProduit.php',
                success: function(data) {
                    $('#cat').html(data);
                }});
        }
        //
        function verifier(){
            var prd=document.getElementById("produit").value;
            var IDprd=document.getElementById("code_produit").value;
            var desc=document.getElementById("desc").value;
            var cat = document.getElementById("cat").value;
            var long=document.getElementById("long").value;
            var poids=document.getElementById("poids").value;
            var rev=document.getElementById("rev").value;
            var Drev=document.getElementById("Drev").value;
            var prixU=document.getElementById("prixU").value;
            if(prd==""){
                alert("PLZ Enter the Product Code !!");
            }else  if(IDprd==""){
                alert("PLZ Enter the Product Code !!");
            }else if(desc==""){
                alert("PLZ Enter the Product Description !!");

            }else if(cat=="s"){
                alert("PLZ Select Category !!");
            }else if(long==""){
                alert("PLZ Enter the Product Length !!");

            }else if(poids==0 || poids==""){
                alert("Donnez le poids en Kg par métre   SVP !!");

            } else if(rev=="" || Drev==""){
                alert("Vérifier vos révisions SVP !!");
            } else  if(prixU==0 || prixU==""){
                alert("Vérifier le prix unitaire   SVP !!");

            } else {
                document.getElementById('nbr').value=i;
                document.forms['form1'].submit();
            }
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

        elseif($role=="COM"){
            include('../menu/menuCommercial.php');
        }
        else{
            header('Location: ../deny.php');
        }
        ?>
    </div>
    <div id='contenu'>
        <div class="container" >
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Produit </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12" >
                        <div class="panel panel-default">
                            <div class="panel-heading">Ajout nouveau produit </div>
                            <div class="panel-body" >
                                <form method="post"  id="form1" name="form1" action="../php/ajout_produit.php">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Famille produit </label>
                                                <input type="text" name="produit" id="produit" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Code produit </label>
                                                <input type="text" name="code_produit" id="code_produit" class="form-control" onblur="verif_produit()">
                                            </div>
                                            <div class="form-group">
                                                <label>Description </label>
                                                <textarea name="desc" id="desc" class="form-control"> </textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Catégorie </label>
                                                <select type="text" name="cat" id="cat" class="form-control" OnFocus="catListe();">
                                                    <option value="s">Sélectionnez..</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Longueur</label>
                                                <div class="form-inline">
                                                    <input type="text" name="long" id="long" class="form-control" placeholder="Longueur" onBlur="verifierL();">
                                                    <input type="text" name="tlots" id="tlots" class="form-control" placeholder="Taille du lot">
                                                    <input type="text" name="nbr_box" id="nbr_box" class="form-control" placeholder="Nbr cable par box">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Poids du cable </label>
                                                <input type="text" name="poids" id="poids" class="form-control" placeholder="Poids en KG par métre">
                                            </div>
                                            <div class="form-group">
                                                <label>Révision</label>
                                                <div class="form-inline">
                                                    <input type="text" name="rev" id="rev" class="form-control" placeholder="Révision">
                                                    <input type="text" name="Drev" id="Drev" class="form-control" placeholder="Draw revision">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Prix unitaire</label>
                                                <div class="form-inline">
                                                    <input type="text" name="prixU" id="prixU" class="form-control">
                                                    <select type="text" name="devise" id="devise" class="form-control" onclick="catListe();">
                                                        <option value="EUR">EUR</option>
                                                        <option value="USD">USD</option>
                                                        <option value="TND">TND</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 " id="TR1" >
                                            <div class="form-group well">
                                                <label>Composant 1</label>
                                                <div class="form-inline">
                                                    <input type="text" name="C1" id="C1" class="form-control" placeholder="Code composant"  onKeyup="autoComplete('C1','listeC1');" onFocus="autoComplete('C1','listeC1')"  onBlur="hideListe('listeC1');">
                                                    <input type="text" name="Q1" id="Q1" class="form-control" placeholder="QTY">
                                                    <input type="button" onclick="addA()" class="btn btn-success" value="+">
                                                    <input type="button" onclick="deleteA();" class="btn btn-danger" value="-">
                                                    <input type="text" name="nbr" id="nbr" size="2" Hidden>
                                                    <div class="divAuto"><ul id="listeC1" ></ul></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12" >
                                            <div class="form-group">
                                                <input type="button" OnClick="verifier();" class="btn btn-primary" value="Ajouter >> ">
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
