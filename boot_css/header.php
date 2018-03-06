<?php include '../php/test.php';?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
  <link rel="shortcut icon" type="image/x-icon" href="../image/logofranck.png" />
  
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #3E5282;">
  <a class="navbar-brand" href="#"><div class="row">
        <div class="col">
    <img src="../image/logofranck.png" width="100" height="100" class="d-inline-block align-center" alt=""></div>
  </div>
    </div></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class=" btn btn-outline-light" href="../index.php" style="margin-right:2%;margin-top:1%;">Formations en cours <?php echo $_SESSION['type_Employe'] ?>
 <span class="sr-only">(current)</span></a>
      <a class=" btn btn-outline-light" href="../php/liste_formations.php" style="margin-right:2%;margin-top:1%;">Liste des formations<span class="sr-only">(current)</span></a>

      <div class="dropdown" style="margin-right:2%;margin-top:1%; ">
  <button class="btn btn-outline-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Mon compte
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" ">
  <a class=" dropdown-item " href="#" style="margin-right:2%;margin-top:1%; ">Informations personnelles<span class="sr-only">(current)</span></a>
  <a class="dropdown-item " href="#" style="margin-right:2%;margin-top:1%;">Historique des formations<span class="sr-only">(current)</span></a>
  <a class="dropdown-item " href="../php/deco.php" style="margin-right:2%;margin-top:1%;color:#fd402b;">Déconnexion<span class="sr-only">(current)</span></a>
  </div>
</div>
 </div>     
      
    </div>



  
</nav>





  
</body>
