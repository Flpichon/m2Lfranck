<?php
include_once '../DATA_ACCESS/methodes.php';
include_once '../DATA_ACCESS/DA_Employe.php';
include_once '../DATA_ACCESS/DA_Formation.php';
EstConnecte();

if(Estmanager())
{
include '../boot_css/header_man.php';
}
else include '../boot_css/header.php';
$info = info_Employe($_SESSION['id_Employe']);
$sup=Superieur_Employe();
?>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<title>Informations personnelles</title>
</head>

    <body style="background:#E8E7E7">
    <div class="row">
    <div class="d-flex col-12 justify-content-center">
    <div class="card d-flex justify-content-center" style="width: 18rem; margin-top:5%">
  <div class="card-header text-center">
   Vos informations personnelles
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">Prenom : <?php echo $info["Prenom_Employe"] ?></li>
    <li class="list-group-item">Nom : <?php echo $info["nom_Employe"] ?></li>
    <li class="list-group-item">Pseudo : <?php echo $info["Pseudo"] ?></li>
    <li class="list-group-item">Date de naissance : <?php echo AfficherDate($info["date_naissance"]) ?></li>
    <li class="list-group-item">E-mail : <?php if($info["mail"] == true) echo $info["mail"]; else echo "Non renseigné" ?></li>
    <li class="list-group-item">Superieur : <?php echo $sup[0] ?> </li>
  </ul>
</div>
</div>
</div>
    
    
    </body>