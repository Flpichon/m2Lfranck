<!-- début du fichier methodes.php
<?php
include_once(dirname(__FILE__) . "/../BDD/connexion_bdd.php");


function Afficher_formations_Employés($id)
{
	$dbh = init_connexion();
	$req = 'SELECT titre_Formation,description_forma,date_Formation,duree_Formation,nom_Prestataire,Formation.id_Formation FROM Prestataire inner join Formation on Prestataire.id_Prestataire=Formation.id_Prestataire inner join Selectionner on Formation.id_Formation = Selectionner.id_Formation inner join Employe on Selectionner.id_Employe=Employe.id_Employe where Employe.id_Employe =:id and (etat="en cours" or etat="en attente" or etat="validé") and (duree_Formation+ date_Formation)>CURDATE()';
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $id));

	$resultat = $prep->fetchAll();


	return $resultat;
}



function reseter()

{
	$dbh = init_connexion();
	$req = 'UPDATE Employe SET credit = 3000 WHERE Employe.id_Employe = :id;
	DELETE FROM `Selectionner` WHERE `Selectionner`.`id_Employe` = :id;';
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $_SESSION['id_Employe']));
	$dbh = null;
	echo 'Vos formations et vos crédits ont bien été réinitialisés';
	header('Refresh:1;url= /m2Lfranck/index.php');


}

//vérifie si l'utilisateur qui se connecte est manager. Permet de changer le Header.
function Estmanager()//fin
{
	$dbh = init_connexion();
	$req = "SELECT id_Type_Employe from Type_Employe inner join Employe on Type_Employe.id_Type_Employe=Employe.id_Employe where id_Employe = :id and id_type_Employe=1";
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $_SESSION['id_Employe']));
	$resultat = $prep->fetch();
		if ($resultat) 
		return true;
		else 
		return false;
}//fin

?>
<!--fin du fichier php-->

