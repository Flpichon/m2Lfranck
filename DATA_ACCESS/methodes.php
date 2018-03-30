<!-- début du fichier methodes.php
<?php
include(dirname(__FILE__) . "/../BDD/connexion_bdd.php");
// Ici, toutes les methodes concernant l'utilisation des fonctionnalitées de la gestion de formation
// de la Maison des ligues sont présentées.

//function afficher_mb() : cette fonction renvoi toutes les informations concernant les employés
// n'étant pas manager 

function afficher_mb() //début
{
	$dbh = init_connexion();//On initialise la connexion via la fonction init_connexion() de BDD/connexion_bdd.php
	$req = 'SELECT * FROM Employe where type_Employe=2'; // on récupère toutes les informations de la table Employe avec comme type d'employé "2"
	$prep = $dbh->prepare($req);// On prépare la requête
	$resultat = $prep->execute(array());// On execute la requête préparée
	$resultat = $prep->fetchAll();// Le fetchALL permet de retourner un tableau contenant les colonnes de la table Employe
	return $resultat;
} //fin

//Cette fonction permet de vérifier si un utilisateur est présent dans la base de données, avec comme paramètres le Pseudo de l'Employe
// et son mot de passe crypté via la fonction md5.
function recherche_utilisateur($Pseudo, $mdp)//début
{
	$dbh = init_connexion();
	$req = "select Pseudo,mdp,id_Employe,Prenom_Employe,nom_Employe,credit,type_Employe from Employe inner join Type_Employe on Employe.type_Employe=Type_Employe.id_Type_Employe where Pseudo= :pseudo and mdp= md5(:mdp)";
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('pseudo' => $Pseudo,'mdp' => $mdp));
			if ($resultat) 
			{
				$resultat = $prep->fetch();
			}
	$dbh = null;
	return $resultat;
}//fin

//Cette fonction a pour but de récupérer les informations contenues dans le formulaire de connexion et de les utiliser
// afin de connecter ou non celui ci
function connexion_utilisateur()//début
{
	$resultat = false;//On initialise la variable $resultat à false
	if ($_POST['Pseudo'] and $_POST['mdp']) // On vérifie si le Pseudo et le mot de passe ont bien été renseignés
	{
		$employe = recherche_utilisateur($_POST['Pseudo'], $_POST['mdp']);// On fait appelle à la fonction recherche_utilisateur($pseudo,$mdp) et on retourne le resultat (true ou false) dans la variable $employe
		if ($employe) //si $employe est true on créé une session et on lui attribut des variables de sessions
		{
			session_start();
			$_SESSION['id_Employe'] = $employe['id_Employe'];// variable retournant l'id de l'employé
			$_SESSION['Prenom_Employe'] = $employe['Prenom_Employe'];// variable retournant le Prénom de l'employé
			$_SESSION['nom_Employe'] = $employe['nom_Employe'];// variable retournant le Nom de l'employé
			$_SESSION['creditfo'][] = "";// variable retournant le crédit des formations proposées
			$_SESSION['credit'] = $employe['credit'];// variable retournant le crédit de l'employé sélectionné
			$_SESSION['type_Employe'] = $employe['type_Employe'];// variable retournant le type de l'employé
			$resultat = true;//si la session est créée, $resultat passe à true
		}

	}
	return $resultat;//On retourne la valeur de $resultat afin de savoir si l'utilisateur est connecté

}//fin
//vérifie si une session existe, et démarre une session dans le cas contraire
function DemarrerSession()//début
{
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
}//fin
//Cette fonction permet de vérifier si une session liée à un employé est en cours, sinon redirige vers la page de connexion
function EstConnecte()//début
{
	DemarrerSession();
	if (!isset($_SESSION['id_Employe'])) 
	{
		header('location: ../page_connexion.php');//redirection vers la page de connexion
		exit;
	}
}//fin

//Cette fonction retourne l'heure la date selon un format définit.
function AfficherDuJour()//début
{
	setlocale(LC_TIME, 'fr_FR.UTF8');
	date_default_timezone_set('Europe/Paris');
//setlocale(LC_TIME, 'fr_FR');
//setlocale(LC_TIME, 'fr');
//setlocale(LC_TIME, 'fra_fra');
//return strftime('%Y-%m-%d %H:%M:%S'); 
	return strftime('Il est %Hh%M et nous sommes le %d/%m/%Y');
}//fin

//permet d'afficher une date (entrée en paramètre) selon un format définit
function AfficherDate($date)//début
{
	$phpdate = strtotime($date);
	return date('d-m-Y', $phpdate);
}//fin

//Cette fonction va renvoyer les informations relatives aux formations choisies par le salarié (etat : en attente, validé ou en cours)
function Afficher_formations_actuelles_encours()//début
{
	$dbh = init_connexion();
	$req = 'SELECT titre_Formation,description_forma,date_Formation,duree_Formation,nom_Prestataire
	 FROM Prestataire 
	 inner join Formation 
	 on Prestataire.id_Prestataire=Formation.id_Prestataire 
	 inner join Selectionner 
	 on Formation.id_Formation = Selectionner.id_Formation 
	 inner join Employe on Selectionner.id_Employe=Employe.id_Employe 
	 where Employe.id_Employe =:id 
	 and (etat="en cours" or etat="en attente" or etat="validé") 
	 and (duree_Formation+ date_Formation)>CURDATE()';// On selectionne les formations avec les différents états et on s'assure que la date de formation correspond bien
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $_SESSION['id_Employe']));
	$resultat = $prep->fetchAll();
	return $resultat;
}//fin

function Afficher_formations_Employés($id)
{
	$dbh = init_connexion();
	$req = 'SELECT titre_Formation,description_forma,date_Formation,duree_Formation,nom_Prestataire,Formation.id_Formation FROM Prestataire inner join Formation on Prestataire.id_Prestataire=Formation.id_Prestataire inner join Selectionner on Formation.id_Formation = Selectionner.id_Formation inner join Employe on Selectionner.id_Employe=Employe.id_Employe where Employe.id_Employe =:id and (etat="en cours" or etat="en attente" or etat="validé") and (duree_Formation+ date_Formation)>CURDATE()';
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $id));

	$resultat = $prep->fetchAll();


	return $resultat;
}
//Cette fonction Permet de retourner toutes les informations necessaires liées aux formations de la table formation
//L'id de la formation
//Le titre de la formation
//La description de la formation
//La date de la formation
//La durée de la formation
//Le prestataire proposant la formation
//Le nombre de crédit associé à la formation
function Afficher_formations()
{
	$dbh = init_connexion();
	$req = 'SELECT id_Formation,titre_Formation,description_forma,date_Formation,duree_Formation,nom_Prestataire,credit FROM Prestataire inner join Formation on Prestataire.id_Prestataire=Formation.id_Prestataire where date_Formation>CURDATE()';
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array());

	$resultat = $prep->fetchAll();


	return $resultat;
}

// Cette fonction permet de vérifier si une formation (définie par son titre) a été séléctionné par l'employé (défini par son id)
// en attente / validé / en cours / refusé
function formation_ok2($forma)
{
	$dbh = init_connexion();
	$req = 'SELECT titre_Formation FROM Prestataire inner join Formation on Prestataire.id_Prestataire=Formation.id_Prestataire inner join Selectionner on Formation.id_Formation = Selectionner.id_Formation inner join Employe on Selectionner.id_Employe=Employe.id_Employe where Employe.id_Employe =:id and (etat="en cours" or etat="en attente" or etat="validé" or etat="refusé") and (date_Formation+duree_Formation)>CURDATE() and titre_Formation=:formation';
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $_SESSION['id_Employe'], 'formation' => $forma));
	$resultat = $prep->fetchAll();

	if ($resultat) return true;
	else return;
}
//Même fonction que précédement,mais les etats diffèrent
//validé / en cours / refusé
function formation_etat_ok($forma, $id)
{

	$dbh = init_connexion();
	$req = 'SELECT titre_Formation FROM Prestataire inner join Formation on Prestataire.id_Prestataire=Formation.id_Prestataire inner join Selectionner on Formation.id_Formation = Selectionner.id_Formation inner join Employe on Selectionner.id_Employe=Employe.id_Employe where Employe.id_Employe =:id and (etat="en cours" or etat="validé" or etat="refusé") and (date_Formation+duree_Formation)>CURDATE() and titre_Formation=:formation';
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $id, 'formation' => $forma));
	$resultat = $prep->fetchAll();

	if ($resultat) return true;
	else return;
}
//Cette fonction permet de retourner vraie si la formation (selectionnée par son id) est en attente et faux si elle ne l'est pas
function formation_etat_attente($id)
{

	$dbh = init_connexion();
	$req = 'SELECT titre_Formation FROM Prestataire inner join Formation on Prestataire.id_Prestataire=Formation.id_Prestataire inner join Selectionner on Formation.id_Formation = Selectionner.id_Formation inner join Employe on Selectionner.id_Employe=Employe.id_Employe where Employe.id_Employe =:id and (etat="en attente") and (date_Formation+duree_Formation)>CURDATE()';
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $id));
	$resultat = $prep->fetchAll();

	if ($resultat) return true;
	else return;
}
//Cette fonction permet d'ajouter une formation dans la table "selectionner", en plus de déduire du nombre de crédit total de l'employé,
//le coût de la formation 
//Si l'employé est un manager, le statut de la formation passera à "validé"
//Sinon elle passera à "en attente"
function ajout($format)//début
{
	$dbh = init_connexion();
	if (Estmanager()) 
	{
		$req = 'INSERT INTO `Selectionner` (`id_Employe`, `id_Formation`, `etat`) VALUES (:id, :forma, "validé");
	UPDATE Employe inner join Selectionner on Employe.id_Employe=Selectionner.id_Employe inner join Formation on Selectionner.id_Formation=Formation.id_Formation SET Employe.credit = Employe.credit-Formation.credit WHERE `Employe`.`id_Employe` = :id and Formation.id_Formation=:forma;';
	} 
	else 
	{
		$req = 'INSERT INTO `Selectionner` (`id_Employe`, `id_Formation`, `etat`) VALUES (:id, :forma, "en attente");
	UPDATE Employe inner join Selectionner on Employe.id_Employe=Selectionner.id_Employe inner join Formation on Selectionner.id_Formation=Formation.id_Formation SET Employe.credit = Employe.credit-Formation.credit WHERE `Employe`.`id_Employe` = :id and Formation.id_Formation=:forma;';
	}
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $_SESSION['id_Employe'], 'forma' => $format));
	$dbh = null;
}//fin
//Cette fonction permet de retourner le total de crédit de l'employé connecté
function CreditEmploye()//début
{
	$dbh = init_connexion();
	$req = 'SELECT `credit` from Employe where id_Employe=:id';
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $_SESSION['id_Employe']));
	$resultat = $prep->fetch();
	return $resultat;
}//fin

function reseter()

{
	$dbh = init_connexion();
	$req = 'UPDATE Employe SET credit = 3000 WHERE Employe.id_Employe = :id;
	DELETE FROM `Selectionner` WHERE `Selectionner`.`id_Employe` = :id;';
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $_SESSION['id_Employe']));
	$dbh = null;
	echo 'Vos formations et vos crédits ont bien été réinitialisés';
	header('Refresh:1;url= ../index.php');


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

//Cette fonction permet de valider ou non une formation par le manager d'une équipe
// Les 3 paramètres sont :
// l'etat selectionné par le manager ("refusé" ou "validé")
// l'id de la formation correspondante
// l'id de l'employé ayant fait la demande de formation
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
<!--fin du fichier php-->

