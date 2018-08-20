<?php

  if (!file_exists('config.php'))
  {
?>

<html>

<head>
  <meta name="generator" content=
  "HTML Tidy for Linux/x86 (vers 1st September 2004), see www.w3.org">
  <link href="css/phpcocktails.css" type="text/css" rel="stylesheet">

  <title>phpcocktails</title>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="100%">
<tr>
  <td colspan="2" align="center"><img src="imgs/logo2.png" alt="phpcocktails"></td>
</tr>
<tr>
  <td><h1>Sorry phpcocktails is not yet installed</h1></td>
</tr>
</table>
</body>
</html>

<?php
  }
  else
  {

  	session_start();
  	include 'config.php';
  	include 'includes/functions.php';
  	include 'languages/'.$language.'.php';

?>
<html>

<head>
  <meta name="generator" content=
  "HTML Tidy for Linux/x86 (vers 1st September 2004), see www.w3.org">
  <link href="css/phpcocktails.css" type="text/css" rel="stylesheet">

  <title><?php print $LANG["list"] ?></title>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="100%">
<tr>
  <td colspan="2" align="center"><img src="imgs/logo2.png" alt="phpcocktails"></td>
</tr>
<tr>
  <td width="150" valign="top">
<?php include 'includes/menu.php'; ?>
  </td>
  <td valign="top">
  <table class="liste" width="100%">
  <tr>
    <td colspan="2"><h2><?php print $LANG["list"] ?></h2></td>
  </tr>  

<?php
$id=http_get('id');
$action=http_post('action');

include 'includes/db.php';
$db = mysql_connect($db_host, $db_user, $db_password);
mysql_select_db($db_name,$db);

if ($action=="delete_comment")
{
    $sql = "DELETE FROM ".$db_prefix.$db_table_comments." WHERE ".$db_field_comment_id.'='.http_post('comment_id');
    $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());   
}
if ($action=="add_comment")
{
    $sql = "INSERT INTO ".$db_prefix.$db_table_comments." (".$db_field_comment_date.", ".
												       $db_field_comment_nickname.", ".
												       $db_field_comment_text.", ".
												       $db_field_cocktail_id.")  VALUES ('".
	date('d/m/Y H:i')."','".http_post('nickname')."','".addslashes(http_post('comment'))."', '".$id."')";
    $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());   

}

$sql = 'SELECT '.$db_field_cocktail_id.', '.$db_field_cocktail_name.', '.
       $db_field_comment.', '.$db_field_image.', '.$db_field_cocktail_eval .' FROM '.$db_prefix.$db_table_names;
if ($id=="") $sql.=' ORDER BY '.$db_field_cocktail_name;
else         $sql.=' WHERE '.$db_field_cocktail_id.'='.$id;

$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

while($data = mysql_fetch_assoc($req))
    {
	  $sql1 = 'SELECT a.'.$db_field_cocktail_id.', a.'.$db_field_ingredient_id.
	          ', a.'.$db_field_ingredient_proportion.', b.'.$db_field_ingredient_id.
			  ', b.'.$db_field_ingredient_name.
              ' FROM '.$db_prefix.$db_table_composition.' a, '.$db_prefix.$db_table_ingredients.' b '.
			  'WHERE a.'.$db_field_ingredient_id.'=b.'.$db_field_ingredient_id.
			  ' AND a.'.$db_field_cocktail_id.'='.$data[$db_field_cocktail_id];
			  
	  $req1 = mysql_query($sql1) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
	  echo '    <tr>';
	  echo '      <td class="img_cocktail" width="202">';
	  echo '<a href="index.php';
	  if ($id=="") echo '?id='.$data[$db_field_cocktail_id];
	  echo '"><img src=images/'.$data[$db_field_image].'></a></td>';
	  echo '      <td valign="top"><h2>'.$data[$db_field_cocktail_name].'<img src="imgs/coeur_'.$data[$db_field_cocktail_eval].'.png"></h2>';	  
	  echo '        <ul>';
	  while ($data1 = mysql_fetch_assoc($req1))
	  {
	    echo '          <li>'.$data1[$db_field_ingredient_proportion].' '.$data1[$db_field_ingredient_name].'</li>';
	  }
	  echo '        </ul>';
	  echo '        '.$data[$db_field_comment].'</td>';
	  echo "    </tr>";
	}
	
	if ($id!="")
	{
?>
	  <tr>
	    <td colspan="2">
		  <table border="1" width="100%">
		    
<?php			
$sql = 'SELECT * FROM '.$db_prefix.$db_table_comments.' WHERE '.$db_field_cocktail_id.'='.$id.' ORDER BY '.$db_field_comment_id;

$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

while($data = mysql_fetch_assoc($req))
{
  echo '<tr><td>';
  echo '<h4>'.$data[$db_field_comment_nickname].' <i>('.$data[$db_field_comment_date].')</i></h4>'.$data[$db_field_comment_text];
  if (isset($_SESSION['admin']))
  if ($_SESSION['admin']=="true") echo '<br><br><form action="index.php?id='.$id.'" method="post"><input type="hidden" name="action" value="delete_comment"><input type="hidden" name="comment_id" value="'.$data[$db_field_comment_id].'"><input type="button" value="'.$LANG["delete"].'" onclick="javascript:submit();"></form>';		
  echo '</td></tr>';
}			
?>			
			
			<tr>
			  <td>
			    <h4><?php print $LANG["add_comment"]?>:</h4>
				<form action="index.php?id=<?php echo $id ?>" method="post">
				<input type="hidden" name="action" value="add_comment">
				<table>
				  <tr>
				    <td valign="top"><?php print $LANG["nick"];?>:</td><td><input type="text" name="nickname" size="12"></td>
				  </tr>
				  <tr>
				    <td valign="top"><?php print $LANG["comment"] ?>:</td><td rowspan="2"><textarea name="comment" rows="4" cols="80"></textarea></td>
				  </tr>
				  <tr>
				    <td><input type="button" value="<?php print $LANG["submit"] ?>" onclick="javascript:submit();">
					</td>
				  </tr>
				</table>
				</form>
			  </td>
			</tr>
			
		  </table>
		</td>
	  </tr>
<?php	
	}
	
mysql_close();
?> 
  </table>
  </td>
  </table>

</body>
</html>

<?php } ?>
