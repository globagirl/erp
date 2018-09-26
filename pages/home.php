<?php
//<link href="../theme/bower_components/font-awesome/css/font-awesomet.css" rel="stylesheet" type="text/css">
//<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
session_start ();
if( !isset($_SESSION["role"]) )
{
    header('Location: ../index.php');
    exit();
}
else
{
    $role=$_SESSION['role'];
    $userID=$_SESSION['userID'];
    include('../connexion/connexionDB.php');include('../connexion/connexionDB.php');
}
?>
<html>
<head>
    <title>Home</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    <link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="../theme/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <script src="../jquery/jquery-latest.min.js"></script>
    <script type='text/javascript' src='../jquery/menu_jquery.js'></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../bootstrap/js/bootbox.min.js"></script>
    <script src="../include/scripts/consult_bande_sortie.js"></script>
    <script>
        //Affiche Notification
        $(document).ready(function()
        {
            setInterval(function(){
                $('#listeM').load('../php/affiche_message.php')
            }, 50000);
        });
        //delete Notification
        function deleteN(noteID)
        {
            $.ajax({
                type: 'POST',
                data : 'IDnote=' + noteID,
                url: '../php/notification.php',
                success: function(data) {

                    if(data=="msg")
                    {
                        var x="#"+noteID;
                        $(x).remove();
                    }
                    else
                    {
                        $(location).attr('href',data);
                    }
                    //alert(data);
                }
            });
        }
        //Re-afficher les anciens  Notification
        function reAffiche(){
            $.ajax({
                type: 'POST',
                url: '../php/ancien_notification.php',
                success: function(data) {
                    $('#notePane').html(data);
                }
            });
        }
        //Marquer tt comme lu
        function deleteAll(){
            $.ajax({
                type: 'POST',
                url: '../php/deleteAll_notification.php',
                success: function(data) {
                    $('#notePane').html(data);
                }
            });
        }
        //Update mot de passe
        function updatePass(){
            var login=$('#login').val();
            var passe1=$('#passe1').val();
            var passe2=$('#passe2').val();
            $.ajax({
                type: 'POST',
                data : 'login=' + login+'&passe1=' +passe1+'&passe2=' + passe2,
                url: '../php/update_user.php',
                success: function(data) {
                    alert(data);
                    $('#login').val("");
                    $('#passe1').val("");
                    $('#passe2').val("");
                }
            });
        }
        //Envoi Message
        function envoiMsg(){
            var msg=$('#msg').val();
            var fil= $('#myfile').val();
            var des=$('#D').find('option:selected').val();

            if(fil==""){
                $.ajax({
                    type: 'POST',
                    data : 'des=' + des+'&msg=' +msg,
                    url: '../php/message.php',
                    success: function(data) {
                        if(data !="1")
                        { alert(data); }
                        else
                        { $('#msg').val(""); }
                    }
                });
            }
            else
            {
                document.forms['form1'].submit();
            }
        }
        //
        function liste_unpaid(){
            $.ajax({
                type: 'POST',

                url: '../php/liste_unpaid.php',
                success: function(data)
                {
                    bootbox.alert (data);
                }
            });
        }
        //
        function noteAffiche(){
            $.ajax({
                type: 'POST',
                url: '../php/affiche_notification.php',
                success: function(data)
                {
                    bootbox.alert (data);
                }
            });
        }
        function liste_NotShipped(){
            $.ajax({
                type: 'POST',
                url: '../php/liste_notShipped.php',
                success: function(data)
                {
                    bootbox.alert (data);
                }
            });
        }
        //
        function demande_conge(){
            $.ajax({
                type: 'POST',
                url: '../php/demande_conge_note.php',
                success: function(data)
                {
                    bootbox.alert (data);
                }
            });
        }
        //
        function deletePO(PO){
            if(confirm("Voulez vous vraiment supprimer cette PO !")== true){
                $.ajax({
                    type: 'POST',
                    data:'PO=' + PO,
                    url: '../php/delete_commande.php',
                    success: function(data)
                    {
                        document.getElementById(PO).disabled = true;
                    }
                });
            }
        }
        //Confirmation congé
        function confirm_conge(IDC){
            bootbox.confirm("Voulez vous vraiment confirmer cette demande !", function(result){
                if(result){
                    $.ajax({
                        type: 'POST',
                        data:'IDC=' + IDC,
                        url: '../php/confirm_conge.php',
                        success: function(data) {
                            if(data=='0')
                            {
                                bootbox.alert("Cet personnel a dépassé le plafond des congés !!");
                            }
                            else
                            {
                                bootbox.hideAll();
                                demande_conge();
                                $("#page-wrapper").load(location.href + " #page-wrapper");
                            }
                        }
                    });
                }
            });
        }
        ////
        function refuse_conge(IDC){
            bootbox.confirm("Voulez vous vraiment refuser cette demande !", function(result){
                if(result){
                    $.ajax({
                        type: 'POST',
                        data:'IDC=' + IDC,
                        url: '../php/refuse_conge.php',
                        success: function(data) {
                            bootbox.hideAll();
                            demande_conge();
                            $("#page-wrapper").load(location.href + " #page-wrapper");
                        }
                    });
                }
            });
        }
        //
        function chartQTY(){
            $.ajax({
                type: 'POST',
                url: '../pChart/graphe_qty.php',
                success: function(data)
                {
                    $("#chartQ").html(data);
                }
            });
        }
        //
        function chartPAY(){
            $.ajax({
                type: 'POST',
                url: '../pChart/graphe_pay.php',
                success: function(data)
                {
                    $("#chartP").html(data);
                }
            });
        }
        //
        function chartAverage(){
            $.ajax({
                type: 'POST',
                url: '../pChart/graphe_average.php',
                success: function(data)
                {
                    $("#chartAv").html(data);
                }
            });
        }
        //Transaction confirmation finance
        function listeTrans(){
            $.ajax({
                type: 'POST',
                url: '../php/verification_transaction.php',
                success: function(data)
                {
                    $("#tbody2").html(data);
                }
            });
        }
        //
        function chekTrans(IDtrans){
            bootbox.confirm("Voulez vous vraiment confirmer la transaction !", function(result){
                if(result){
                    $.ajax({
                        type: 'POST',
                        data:'IDtrans=' + IDtrans,
                        url: '../php/validation_transaction.php',
                        success: function(data)
                        {
                            listeTrans();
                        }
                    });
                }else{
                    document.getElementById(IDtrans).checked=false;
                }
            });
        }
        //
        function historique_trans(){
            $.ajax({
                type: 'POST',
                url: '../php/historique_conf_trans.php',
                success: function(data)
                {
                    bootbox.alert(data);
                }
            });
        }

        ////Transaction client confirmation finance
        /*function listeTransC(){
            $.ajax({
                type: 'POST',
                url: '../php/verification_transactionC.php',
                success: function(data) {
               $("#tbody3").html(data);
            }});
        }//*/
        //


        /*
        function relanceConf(){
            $.ajax({
                type: 'POST',
                url: '../php/verification_tran.php',
                success: function(data) {
               $("#tbody2").html(data);
            }});
        }//*/

        //Consult relance info
        function afficheInfo(ID){
            $.ajax({
                type: 'POST',
                data:'IDrelance='+ID,
                url: '../pages/consult_relance_info.php',
                success: function(data)
                {
                    document.location.href="../pages/consult_relance_info.php";
                }
            });
        }

        //Consult sortie relance info
        function afficheInfoRL(ID){
            $.ajax({
                type: 'POST',
                data:'IDrelance='+ID,
                url: '../php/consult_sortieRL_info.php',
                success: function(data) {
                    bootbox.alert(data);
                }
            });
        }
        //Consult sortie info
        function confirm_sortieRL(ID){
            $.ajax({
                type: 'POST',
                data:'IDrelance='+ID,
                url: '../php/confirm_bandeRL_sortie.php',
                success: function(data)
                {
                    bootbox.hideAll();
                    location.reload();
                }
            });
        }
        //Consult retour stock info
        function afficheInfoRT(ID,T){
            var stat="N";
            $.ajax({
                type: 'POST',
                data:'IDretour='+ID+'&typeR='+T+'&statut='+stat,
                url: '../php/consult_retour_info.php',
                success: function(data)
                {
                    bootbox.alert(data);
                }
            });
        }
        ////affiche retourinfo
        function confirmRT(idRT,T){
            if(confirm("Voulez vous vraiment confirmer cet bande de retour ?!")){
                $.ajax({
                    type: 'POST',
                    data:'IDretour='+idRT+'&typeR='+T,
                    url: '../php/confirm_bande_retour.php',
                    success: function(data) {
                        bootbox.hideAll();
                        location.reload();
                    }
                });
            }
        }
    </script>
</head>
<body>
<?php
if($role=="ADM") {
    echo '<body onLoad="chartQTY();chartPAY();chartAverage();listeTrans()">';
}
elseif($role=="FIN") {
    echo '<body onLoad="listeTrans();listeTransC()">';
}
elseif($role=="DIR") {
    echo '<body onLoad="chartQTY();chartPAY();chartAverage()">';
}
else{
    echo '<body>';
}
?>

<div id="entete">
    <div id="logo"></div>
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
        elseif($role=="DIR"){
            include('../menu/menuDirecteur.php');
        }
        elseif($role=="COM"){
            include('../menu/menuCommercial.php');
        }
        elseif($role=="FIN"){
            include('../menu/menuFinance.php');
        }
        elseif($role=="FIN2"){
            include('../menu/menuFin2.php');
        }
        elseif($role=="CONS"){
            include('../menu/menuConsommable.php');
        }
        elseif($role=="PRD"){
            include('../menu/menuProduction.php');
        }
        elseif($role=="MAG"){
            include('../menu/menuMagazin.php');
        }
        elseif($role=="MAG2"){
            include('../menu/menuMagazin2.php');
        }
        elseif($role=="EXP"){
            include('../menu/menuExpedition.php');
        }
        elseif($role=="GRH"){
            include('../menu/menuGRH.php');
        }
        elseif($role=="CTRL"){
            include('../menu/menuCTRL.php');
        }
        elseif($role=="QLT"){
            include('../menu/menuQualite.php');
        }
        elseif($role=="UPM3"){
            include('../menu/menuUPM3.php');
        }
        else{
            header('Location: ../deny.php');
        }
        ?>
    </div>
    <?php
    $date = date("d F Y");
    $heure = date("H:i");
    ?>
    <div id='contenu'>
        <?php
        if($role=="ADM"){
            include('../home/homeADM.php');
        }
        else if($role=="LOG"){
            include('../home/homeLOG.php');
        }
        else if($role=="GRH"){
            include('../home/homeGRH.php');
        }
        else if($role=="DIR"){
            include('../home/homeDIR.php');
        }
        else if($role=="COM"){
            include('../home/homeCOM.php');
        }
        else if($role=="FIN"){
            include('../home/homeFIN.php');
        }
        else if($role=="CTRL"){
            include('../home/homeCTRL.php');
        }
        else if($role=="MAG"){
            include('../home/homeMAG.php');
        }
        else if($role=="QLT"){
            include('../home/homeQLT.php');
        }
        else{
            include('../home/homeALL.php');
        }
        ?>
    </div>
</div>
<?php mysql_close(); ?>
</body>
</html>