<?php
function afficher_mb() //début
{
	$dbh = init_connexion();//On initialise la connexion via la fonction init_connexion() de BDD/connexion_bdd.php
	$req = 'SELECT * FROM Employe where type_Employe=2'; // on récupère toutes les informations de la table Employe avec comme type d'employé "2"
	$prep = $dbh->prepare($req);// On prépare la requête
	$resultat = $prep->execute(array());// On execute la requête préparée
	$resultat = $prep->fetchAll();// Le fetchALL permet de retourner un tableau contenant les colonnes de la table Employe
	return $resultat;
} //fin
function Valider_Etat_Formation($etat, $formation, $id_employe)//début
{
	$dbh = init_connexion();
	$req = "UPDATE `Selectionner` SET `etat` = :etat WHERE `Selectionner`.`id_Employe` = :id_employe AND `Selectionner`.`id_Formation` = :id_formation;";
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id_employe' => $id_employe, 'id_formation' => $formation, 'etat' => $etat));
		if ($etat=="Refusé")//Si le manager refuse la formation, le coût en crédit de celle ci est rendu
		//et la formation est replacée dans la liste des formations
		{
			$req1="UPDATE Employe inner join Selectionner on Employe.id_Employe=Selectionner.id_Employe inner join Formation on Selectionner.id_Formation=Formation.id_Formation SET Employe.credit = Employe.credit+Formation.credit WHERE `Employe`.`id_Employe` = :id_employe and Formation.id_Formation=:id_formation;
			DELETE FROM `Selectionner` WHERE `Selectionner`.`id_Employe` = :id_employe and `Selectionner`.`id_Formation`=:id_formation;";
			$prep1=$dbh->prepare($req1);
			$resultat1=$prep1->execute(array('id_employe' => $id_employe, 'id_formation' => $formation));
		}
}//fin
?>