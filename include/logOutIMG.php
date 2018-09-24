<br>
<div id="flotP">
<a  href="logOut.php"><img src="../image/logOut.png" alt="Log Out" width="50" height="50" title="Déconnexion"> </a>
</div>
</div>
<!--Notification -->
<script src="../jquery/jquery-latest.min.js"></script>
<script>
$(document).ready(function(){

setInterval(function(){
$('#Xnote').load('../php/affiche_Xnotification.php')
}, 50000);

setInterval(function(){
$('#XnoteID').load('../php/affiche_Xnotification.php')
}, 50000);

});
</script>