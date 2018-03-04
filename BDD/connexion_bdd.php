<?php
/** Ici on effectue la connexion à la base de donnée et on retourne un PDO (PHP Data Object)**/
	function init_connexion()
	{
		$user = 'u668252900_flp';
		$host = 'mysql.hostinger.com';
		$dbname = 'u668252900_m2l';
		$mdp= 'franck1412';
		$pdo=new PDO('mysql:host='.$host.';dbname='.$dbname,$user,$mdp, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'))
            or die ("Problème de connexion à la base de donnée");
        //retourne une connection à la base de donnée
		return $pdo;
		
	
		
	}
	