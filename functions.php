<?php

function searchCompetitions(){
	/*En attendant que le manager soit mis en place -->
	$bddCompetitions = new competitionManager();
    $competition = $bddCompetitions->isOpenCompetition();
    */
    $competition = 1;
    return $competition;
}

/*******/

function removeNULL($var)
{
    // retourne lorsque l'entrée est différente de NULL
    if($var !== NULL)
    	return $var;
}

function getActionPage($view, $action){
	$path = explode('.', $view); 
	return '"'.trim(str_replace('views', '', $path[0]), '/').'/'.$action.'"';
}

function ourOwnPassHash($pass){
	return password_hash($pass, PASSWORD_DEFAULT);
}

function ourOwnPassVerify($received, $model){
	return (password_verify($received, $model));
}

function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function cleanTimedOutSession(){
	if(isset($_SESSION['timeout']) && $_SESSION['timeout'] < time()){
		session_destroy();		
	}
	session_start();
	session_regenerate_id();
}

