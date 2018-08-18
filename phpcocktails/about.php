<?php
/*
 * Created on 28 mars 2006
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
  	session_start();
  	include 'config.php';
  	include 'includes/functions.php';
  	include 'languages/'.$language.'.php';
    include 'includes/db.php';
?>

<html>

<head>
  <meta name="generator" content=
  "HTML Tidy for Linux/x86 (vers 1st September 2004), see www.w3.org">
  <link href="css/phpcocktails.css" type="text/css" rel="stylesheet">

  <title><?php print $LANG["about"] ?></title>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="100%">
<tr>
  <td colspan="2" align="center"><img src="imgs/logo2.png"></td>
</tr>
<tr>
  <td width="150" valign="top">
<?php
include 'includes/menu.php';
?>
  </td>
  <td valign="top">
    <h2><?php print $LANG["about"] ?></h2>
    <table border="1" cellpadding="10">
      <tr>
        <td><?php print $LANG["version"] ?></td><td>1.0</td>
      </tr>
      <tr>
        <td><?php print $LANG["nb_cocktails"] ?></td><td>
<?php 
$db = mysql_connect($db_host, $db_user, $db_password);
mysql_select_db($db_name,$db);
$sql = 'SELECT COUNT(*) FROM '.$db_prefix.$db_table_names;
$res = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$i = mysql_fetch_array($res);
echo $i[0];
?>
        </td>
      </tr>
      <tr>
        <td><?php print $LANG["author"] ?></td><td>Sébastien Colas</td>
      </tr>
      <tr>
        <td><?php print $LANG["mail"] ?></td><td><a href="mailto:phpcocktails@free.fr">phpcocktails@free.fr</a></td>
      </tr>       
  </td>
</tr>
</table>
</body>


</body>
</html>
