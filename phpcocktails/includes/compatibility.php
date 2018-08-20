<?php


/*
 * Created on 31 janv. 2006
 *
 * Function to make code compatible between PHP4 and PHP5
 * 
 */

function http_post($id)
{
	$retour="";
	if (isset ($HTTP_POST_VARS[$id]))
	{
		$retour=$HTTP_POST_VARS[$id];
	}
	else	
	if (isset ($_POST[$id]))
	{
		$retour=$_POST[$id];		
	}	
	return $retour;
}

function http_get($id)
{
	$retour="";
	if (isset ($HTTP_GET_VARS[$id]))
	{
		$retour=$HTTP_GET_VARS[$id];
	}
	else
	if (isset ($_GET[$id]))
	{
		$retour=$_GET[$id];
	}
	return $retour;
}

?>



