<?php
include 'test.php';
include 'liste_formations.php';



$dbh=init_connexion();
	$req='INSERT INTO `Selectionner` (`id_Employe`, `id_Formation`, `etat`) VALUES (\':id\', \':formation\', \'en cours\')';
	$prep=$dbh->prepare($req);
	$resultat=$prep->execute(array('id' => $_SESSION['id_Employe'],'formation'=> $mb['id_Formation'] ));
	$resultat=$prep->fetchAll();
    return $resultat;


?>