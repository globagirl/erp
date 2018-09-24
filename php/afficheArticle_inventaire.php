<?php
    include('../connexion/connexionDB.php');
    $dateI = $_POST['dateI'];
    $article = $_POST['article'];
	  include('../include/functions/consult_stock_functions.php');
		$req= mysql_query("SELECT stock FROM article1 where code_article='$article'");
		$stockSys=@mysql_result($req,0);
		$stockAnt=stock_ant($article,$dateI,$stockSys);
		
  
	  echo '<div class="form-group">
              <label> Stock Systéme avant inventaire </label>
              <input type="text" class="form-control" id="stockSys" name="stockSys" value='.$stockAnt.' Readonly>
          </div>
					<div class="form-group">
              <label> Stock Systéme pour l\'insant </label>
              <input type="text" class="form-control" value='.$stockSys.' Readonly>
         </div>';
	echo '<div class="form-group">
                <label> Stock Réel </label>
                <div class="form-group form-inline">
                    <input type="text" class="form-control" id="stockR" name="stockR" >
                    <input type="button" onclick="ajoutArticleS();" class="btn btn-primary" Value=">>">
                </div>
        </div>';
                             
	
  mysql_close();
?>