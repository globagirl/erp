<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="../css/style.css"/> 
<script src="jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="theme/dist/css/sb-admin2.css" rel="stylesheet">
<script src="theme/dist/js/sb-admin-2.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="bootstrap/js/bootbox.min.js"></script>
<link href="theme/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="theme/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
 <script src="theme/bower_components/metisMenu/dist/metisMenu.min.js"></script>


    <title>STARZ ELECS ERP</title>
	<script>
function connexion(){
var pswd = document.getElementById("pswd").value;
var login = document.getElementById("login").value;
$.ajax({
        type: 'POST',
        data: 'login='+login+'&pswd='+pswd,
        url: 'php/login.php',
        success: function(data) {
        if(data==0){
		 $("#pswdDIV").removeClass("has-error");
		 $("#loginDIV").addClass("has-error");
		}else if(data==1){
		$("#loginDIV").removeClass("has-error");
		$("#pswdDIV").addClass("has-error");
		}else{
		$(window).attr('location',data)
		}
		//alert (data);
       }});
	  
}

</script>
</head>

<body>

    <div class="container">
        <div class="row">
		<br><br><br><br><br>
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                   
                    <div class="panel-body">
                        <form role="form" name="form" method="post" action="/php/login.php">
                            <fieldset>
							    <div class="col-md-4 col-md-offset-2">
								

                                <img src="image/logo.jpg"  alt="STARZ"  width="160" height="90"  />
                                 <br><br><br>
								</div>
                                <div class="form-group " id="loginDIV">
								    
                                    <input class="form-control" name="login" id="login" placeholder="Login" type="text" autofocus>
                                </div>
                                <div class="form-group" id="pswdDIV">
								      
                                    <input class="form-control" name="pswd" id="pswd" type="password" placeholder="password">
                                </div>
                                
                                <!-- Change this to a button or input when using this as a form -->
                               <input  type="button" value="Login" class="btn btn-lg btn-success btn-block" onClick="connexion();">
                           

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

 

</body>

</html>
