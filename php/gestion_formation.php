<?php
include_once 'test.php';
EstConnecte();
if(Estmanager())
{
include '../boot_css/header_man.php';
}
else include '../boot_css/header.php';
$credit=CreditEmploye();
$mb=afficher_mb();
?>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<title>Gestion des formations</title>
</head>
<body style="background:#E8E7E7">
<div class="alert alert-primary d-flex justify-content-between" role="alert">
<?php echo '<div>Connecté en tant que'."  ".$_SESSION['Prenom_Employe']." ".$_SESSION['nom_Employe']."</div>"
		   ;?>
	<div>Il vous reste <?echo $credit['credit'];?> crédits</div>
</div>
<div class="card">
  	<div class="card-header">
  		<h2 class="text-center">Liste des Employés</h2>

  	</div>
  <div class="d-flex card-body">
		<div class="container-fluid">
			<div class="row d-flex">
				<div class="d-flex col-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
					<div class="table-responsive">
						<table class="table table-bordered table-xl" >

							<thread>
								<tr>
									<th scope="col" class="text-center">Prénom</th>
									<th scope="col" class="text-center">Nom</th>
									<th scope="col" class="text-center">Gestion des formations</th>
				
        
								<tr>
							</thread>
						<tbody>
<?php
foreach	($mb as $membres)
{	echo "<tr>";
	echo "<th scope=\"row\" class=\"text-center\">".$membres['Prenom_Employe']."
		  </th>";
	echo "<th scope=\"row\" class=\"text-center\">".$membres['nom_Employe']."
		  </th>";
	echo "<th scope=\"row\" class=\"text-center\">Gestion
		  </th>";
	echo "</tr>";
	
}

?>
</tbody>
		</table >
	</div>
</div>
</body>