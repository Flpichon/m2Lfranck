<?php

include_once 'DATA_ACCESS/DA_Employe.php';
include 'boot_css/headeravantco.php';




?>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js/co.js"></script>
<title>Connexion</title>
</head>
<body style="background:#E8E7E7">

<div class="container " style="margin-top:10%;">
<div class="row justify-content-center ">
<div class="card bg-light border-info mb-3" style="border-width:thin;">
  <div class="card-header text-center text-white bg-info">
    <span style="font-size:20px;">Vous connecter</span>
  </div>
  <div class="card-body text-center">
  	<form method="post" action="page_connexion.php"  style=" margin-bot:-4%;">
		  <div class="form-group ">
			<!--<label for="Pseudo" class="form-control-lg">Pseudo</label>-->
			<input type="text" class="form-control form-control-lg border-info " id="Pseudo" name="Pseudo" aria-describedby="emailHelp" placeholder="Pseudo" required>
		 </div>
		  <div class="form-group">
			<!--<label for="mdp" class="form-control-lg">Mot de Passe</label>-->
			<input type="Password" class="form-control form-control-lg border-info" id="mdp" name="mdp" placeholder="Mot de passe" required>
		  </div>
		<div class="form-group text-center">
		  <button type="submit" class="btn btn-info form-control-lg" value="OK" name="co" style="margin-top:4%;">Se connecter</button>
		</div>
	</form>
</div>
	
</div>

  </div>
</div>


</body>
<?php


if(isset($_POST['co']))
{
if ($_POST['co'] ) 
	{
		if (connexion_utilisateur())
		{	
			
			header('Location: index.php'); 
			
		}
		else
		{
			echo '<div class="alert alert-danger text-center" role="alert">Echec de la connexion : votre pseudo ou votre mot de passe est incorrect.</div>';
		}
   
	}
}

	
	?>


 

