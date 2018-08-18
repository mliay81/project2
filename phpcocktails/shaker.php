<?php
include 'config.php';
include 'includes/db.php';
include 'includes/functions.php';
include 'languages/'.$language.'.php';
?>

<html>

<head>
  <meta name="generator" content=
  "HTML Tidy for Linux/x86 (vers 1st September 2004), see www.w3.org">
  <link href="css/phpcocktails.css" type="text/css" rel="stylesheet">

  <title><?php print $LANG["shaker"]; ?></title>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="100%">
<tr>
  <td colspan="2" align="center"><img src="imgs/logo2.png"  alt="phpcocktails"></td>
</tr>
<tr>
  <td width="150" valign="top">
<?php
include 'includes/menu.php';

$db = mysql_connect($db_host, $db_user, $db_password);
mysql_select_db($db_name,$db);

  $sql = 'SELECT '.$db_field_ingredient_id.', '.$db_field_ingredient_name.' FROM '.$db_prefix.$db_table_ingredients.' ORDER BY '.$db_field_ingredient_name;
  $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

  $nb=0;
  while($data = mysql_fetch_assoc($req))
  {
    $ingredient_name[$nb]=$data[$db_field_ingredient_name];
	$ingredient_id[$nb]=  $data[$db_field_ingredient_id];
    $nb++;
  }
  
  $nb_lines=$nb/4;

$affiche_result=false;
$action=http_post('action');

$cmpt=0;
if ($action=="search_by_ingredient")
{
  $affiche_result=true;
  for ($i=0;$i<$nb;$i++)
  {
    if (http_post('id_'.$ingredient_id[$i])!="")
	{
	  $ingredient_list[$cmpt]=$ingredient_id[$i];
	  $cmpt++;
	}
  }
  $caract_av='a';
  $caract='b';
  
  $sql_begin = 'SELECT a.'.$db_field_cocktail_name.', a.'.$db_field_cocktail_id.' FROM '.$db_prefix.$db_table_names.' a,';
  $sql_end = ' WHERE ';
  for ($i=0;$i<$cmpt;$i++)
  {
      if ($i!=0) $sql_begin .=', ';
	  $sql_begin .= $db_prefix.$db_table_composition.' '.$caract;
	  if ($i!=0) $sql_end .= ' AND ';
	  $sql_end .= $caract_av.'.'.$db_field_cocktail_id.'='.$caract.'.'.$db_field_cocktail_id.' AND '
	  .$caract.'.'.$db_field_ingredient_id.'='.$ingredient_list[$i];
	  $caract++;
	  $caract_av++;
  }
   
  $sql=$sql_begin.$sql_end;
  if ($cmpt!=0) $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
}

if ($action=="search_by_name")
{
  $affiche_result=true;
	
  $type=http_post('type');
	
  if ($type=="1")
	$sql = 'SELECT * FROM '.$db_prefix.$db_table_names.
	       ' WHERE '.$db_field_cocktail_name.' LIKE \''.http_post('word').'%\' ORDER BY '.$db_field_cocktail_name;
  else
  if ($type=="2")
	$sql = 'SELECT * FROM '.$db_prefix.$db_table_names.
	       ' WHERE '.$db_field_cocktail_name.' LIKE \'%'.http_post('word').'\' ORDER BY '.$db_field_cocktail_name;
  else
	$sql = 'SELECT * FROM '.$db_prefix.$db_table_names.
	       ' WHERE '.$db_field_cocktail_name.' LIKE \'%'.http_post('word').'%\' ORDER BY '.$db_field_cocktail_name;
		   
  $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error()); 
}

?>
  </td>
  <td valign="top">
    <h2><?php print $LANG["shaker"]; ?></h2>
<?php
  if ($affiche_result)
  {
?>
	<h3><?php print $LANG["results"]; ?></h3>
	<ul>
<?php  
    $nb_result=0;
	while ($data = mysql_fetch_assoc($req))
	{
	  $nb_result++;
	  echo '<li><a href="'.$install_dir.'/index.php?id='.$data[$db_field_cocktail_id].'">'.$data[$db_field_cocktail_name].'</a>';
	  $sql1 = 'SELECT a.'.$db_field_cocktail_id.', a.'.$db_field_ingredient_id.', a.'.$db_field_ingredient_proportion.', b.'.$db_field_ingredient_id.', b.'.$db_field_ingredient_name.' '.
              'FROM '.$db_prefix.$db_table_composition.' a, '.$db_prefix.$db_table_ingredients.' b '.
			  'WHERE a.'.$db_field_ingredient_id.'=b.'.$db_field_ingredient_id.' AND a.'.$db_field_cocktail_id.'='.$data[$db_field_cocktail_id];
      $req1 = mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
	  echo ' (';
	  $nb_ingredients=0;
	  while ($data1 = mysql_fetch_assoc($req1))
	  {
	    if ($nb_ingredients!=0) echo ', ';
	    echo $data1[$db_field_ingredient_name];
		$nb_ingredients++;
	  }	  
	  echo ')</li>';
	}
	
	if ($nb_result==0) echo "</ul>".$LANG["no_result"]."<ul>";
  }
?>	
    </ul>
	<h3><?php print $LANG["search_name"]; ?></h3>
	<table>
	  <form action="shaker.php" method="post">
	  <input type="hidden" name="action">
	  <tr>
	    <td><input type="radio" name="type" value="0" checked></td>
	    <td><?php print $LANG["search_containing"]; ?></td>
		<td>
		  <input type="text" name="word">
		</td>
		<td>
		  <input type="button" value="<?php print $LANG["search"]; ?>" onclick="javascript:action.value='search_by_name';submit();">
		</td>
	  </tr>
	  <tr>
	    <td><input type="radio" name="type" value="1"></td>
		<td><?php print $LANG["search_commencing"]; ?></td>
	  </tr>
	  <tr>
	    <td><input type="radio" name="type" value="2"></td>
		<td><?php print $LANG["search_finishing"]; ?></td>
	  </tr>	  
	  </form>
	</table>
	
	<h3><?php print $LANG["search_ingredient"]; ?></h3>
	<form action="shaker.php" method="post">
	
	  <input type="hidden" name="action" value="search_by_ingredient">
	  <table border="1">
	    <tr>
<?php


$cmpt=0;
for($i=0;$i<4;$i++)
{
  echo '<td valign="top" width="20%"><table>';
  for ($j=0;$j<$nb_lines;$j++)
  {
    if (isset ($ingredient_id[$cmpt]))
    if ($ingredient_id[$cmpt]!='')
	  echo '<tr><td><input type="checkbox" name="id_'.$ingredient_id[$cmpt].'"> '.$ingredient_name[$cmpt].'</td></tr>';
	$cmpt++;
  }
  echo '</table></td>';
}	
?>
      </tr>
    </table>
	<br>
	<input type="button" value="<?php print $LANG["search"]; ?>" onclick="javascript:submit();">  
	</form>
	</td>
  </table>

</body>
</html>