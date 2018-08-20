<?php
  session_start();
  include '../config.php';
  include '../languages/'.$language.'.php';  
?>
<html>

<head>
  <meta name="generator" content=
  "HTML Tidy for Linux/x86 (vers 1st September 2004), see www.w3.org">
  <link href="../css/phpcocktails.css" type="text/css" rel="stylesheet">

  <title><?php print $LANG["admin"] ?></title>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="100%">
<tr>
  <td colspan="3" align="center"><img src="../imgs/logo2.png"  alt="phpcocktails"></td>
</tr>
<tr>
  <td width="150" rowspan="3" valign="top">
<?php include '../includes/menu.php'; ?>
  </td>
  <td valign="top" colspan="2">


<?php
  include '../includes/functions.php';
  include '../includes/db.php';
  $composition=false;
  $fichier="";
  $action=http_post('action');

  if ($action=="logout")
  {
    $_SESSION['admin']="false";
  }  
  
  if ($_SESSION['admin']!="true")
  {
  ?>
  Please <a href="identification.php">Login</a>
  <script>window.location="identification.php";</script>
  <?php
  }
  else
  {

  $db = mysql_connect($db_host, $db_user, $db_password);
  mysql_select_db($db_name,$db);
  
  if ($action=="img_add")
  {
    $uploaddir = '../images/';
    $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
    if (filesize($_FILES['userfile']['tmp_name'])==0) unlink($_FILES['userfile']['tmp_name']);
	else move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile); 
	
  }
  if ($action=="img_delete")
  {
    unlink('../images/'.http_post('img_name'));
  }
  if ($action=="add")
  {
    $sql = "INSERT INTO ".$db_prefix.$db_table_names." (".$db_field_cocktail_name.", ".$db_field_comment.", ".
	       $db_field_image.", ".$db_field_cocktail_eval.")  VALUES ('".
	http_post('nom_cocktail')."','".addslashes(http_post('commentaire'))."','".http_post('image')."','".http_post('eval')."')";
    $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());   
  }
  if ($action=="delete")
  {
    $sql = "DELETE FROM ".$db_prefix.$db_table_names." WHERE ".$db_field_cocktail_id."=".http_post('id_cocktail');
    $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());   
  }
  if ($action=="modify")
  {
    $sql = "UPDATE ".$db_prefix.$db_table_names." SET ".$db_field_cocktail_name."='".http_post('nom_cocktail').
	       "', ".$db_field_comment."='".http_post('commentaire')."',".$db_field_image."='".http_post('image').
		   "', ".$db_field_cocktail_eval."='".http_post('eval').
		   "' WHERE ".$db_field_cocktail_id."=".http_post('id_cocktail');
    $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());   
  }
  
  if ($action=="add_ingredient")
  {
    $sql = "INSERT INTO ".$db_prefix.$db_table_ingredients." (".$db_field_ingredient_name.")  VALUES ('".
	addslashes(http_post('nom_ingredient'))."')";
    $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());   
  }
  if ($action=="delete_ingredient")
  {
    $sql = "DELETE FROM ".$db_prefix.$db_table_ingredients." WHERE ".$db_field_ingredient_id."=".http_post('id_ingredient');
    $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());   
  }
  if ($action=="modify_ingredient")
  {
    $sql = "UPDATE ".$db_prefix.$db_table_ingredients." SET ".$db_field_ingredient_name."='".addslashes(http_post('nom_ingredient')).
		   "' WHERE ".$db_field_ingredient_id."=".http_post('id_ingredient');
    $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());   
  }
  
  if ($action=="composition")
  {
    $composition=true;
  }
  
  if ($action=="del_composant")
  {
    $sql = "DELETE FROM ".$db_prefix.$db_table_composition." WHERE ".$db_field_composition_order."='".http_post('ordre')."'";
    $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error()); 
    $composition=true;
  }
  
  if ($action=="add_composant")
  {
    $sql = "INSERT INTO ".$db_prefix.$db_table_composition." (".$db_field_cocktail_id.", ".$db_field_ingredient_id.", ".$db_field_ingredient_proportion.")  VALUES ('".
	http_post('id_cocktail')."','".
	http_post('id_ingredient')."','".	
	http_post('proportion_ingredient')."')";
    $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());   
    $composition=true;
  }
  
  if ($composition)
  {
?>

<h2><?php print $LANG["admin"] ?></h2>
<table>
<?php
  $sql0 = 'SELECT '.$db_field_ingredient_id.', '.$db_field_ingredient_name.' FROM '.$db_prefix.$db_table_ingredients.' ORDER BY '.$db_field_ingredient_name;
  $req0 = mysql_query($sql0) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());  
  
  $sql = "SELECT ".$db_field_cocktail_id.", ".$db_field_cocktail_name.", ".$db_field_comment.", ".
         $db_field_image." FROM ".$db_prefix.$db_table_names." WHERE ".$db_field_cocktail_id."='".http_post('id_cocktail')."'";
  $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  $data = mysql_fetch_assoc($req);
  
	  $sql1 = 'SELECT a.'.$db_field_composition_order.',a.'.$db_field_cocktail_id.', a.'.
	          $db_field_ingredient_id.', a.'.$db_field_ingredient_proportion.', b.'.
			  $db_field_ingredient_id.', b.'.$db_field_ingredient_name.' FROM '.
			  $db_prefix.$db_table_composition.' a, '.$db_prefix.$db_table_ingredients.' b '.
			  'WHERE a.'.$db_field_ingredient_id.'=b.'.$db_field_ingredient_id.' AND a.'.
			  $db_field_cocktail_id.'='.http_post('id_cocktail').
			  ' ORDER BY a.'.$db_field_composition_order;
			  
	  $req1 = mysql_query($sql1) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
	  echo '    <tr>';
	  echo '      <td class="image"><img src=../images/'.$data[$db_field_image].'></td>';
	  echo '      <td valign="top"><h2>'.$data[$db_field_cocktail_name].'</h2><br>';
	  echo '        <table border="1">';
	  echo '          <tr><td>Proportion</td><td>Ingrédient</td><td>Action</td></tr>';	  
	  while ($data1 = mysql_fetch_assoc($req1))
	  {
	    echo '    <form action="admin_cocktails.php" method="post">';
		echo '    <input type="hidden" name="action">';
        echo '    <input type="hidden" name="id_cocktail" value="'.http_post('id_cocktail').'">';		
	    echo '          <tr><td>'.$data1[$db_field_ingredient_proportion].'</td><td>'.$data1[$db_field_ingredient_name].'</td>';
		echo '              <td>';
		echo '              <input name="ordre" type="hidden" value="'.$data1[$db_field_composition_order].'">';
		echo '              <input type="button" value="'.$LANG["delete"].'" onclick="javascript:action.value=\'del_composant\';submit();"></td></tr></form>';		
	  }
	  echo '    <form action="admin_cocktails.php" method="post">';	
	  echo '    <input type="hidden" name="action">';	  
      echo '    <input type="hidden" name="id_cocktail" value="'.http_post('id_cocktail').'">';	  
	  echo '          <tr><td><input type="text" name="proportion_ingredient"></td>';
	  echo '          <td><select name="id_ingredient">';
	  while ($data0 = mysql_fetch_assoc($req0))
	  {
	    echo '            <option value="'.$data0[$db_field_ingredient_id].'">'.$data0[$db_field_ingredient_name].'</option>';
	  }	  
	  echo '          </select></td><td><input type="button" value="'.$LANG["add"].'" onclick="javascript:action.value=\'add_composant\';submit();"></td></tr></form>';
?>
        </table></td>
    </tr>
</table>
<a href="admin_cocktails.php"><?php print $LANG["back_to_admin"] ?></a>

<?php  
  }
  else
  {
?>
  <h2><?php print $LANG["admin"] ?></h2>
  <h3><?php print $LANG["list"] ?></h3>
  <table border="1">
  <tr>
    <td><?php print $LANG["name"] ?></td>
    <td><?php print $LANG["comment"] ?></td>
    <td><?php print $LANG["image"] ?></td>
	  <td><?php print $LANG["evaluation"] ?></td>
    <td><?php print $LANG["action"] ?></td>
  </tr>

<?php
// on crée la requête SQL
$sql = 'SELECT '.$db_field_cocktail_id.', '.$db_field_cocktail_name.', '.$db_field_comment.', '.
       $db_field_image.', '.$db_field_cocktail_eval.' FROM '.$db_prefix.$db_table_names.' ORDER BY '.$db_field_cocktail_name;

// on envoie la requête
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

// on fait une boucle qui va faire un tour pour chaque enregistrement
while($data = mysql_fetch_assoc($req))
    {
	  echo '    <form action="admin_cocktails.php" method="post">';
	  echo '    <input type="hidden" name="action">';
	  echo '    <input type="hidden" name="id_cocktail" value="'.$data[$db_field_cocktail_id].'">';
	  echo '    <tr>';
	  echo '      <td><input type="text" size="15" name="nom_cocktail" value="'.$data[$db_field_cocktail_name].'"></td>';
	  echo '      <td><input type="text" size="30" name="commentaire" value="'.$data[$db_field_comment].'"></td>';
	  echo '      <td><input type="text" size="15" name="image" value="'.$data[$db_field_image].'"></td>';
	  echo '      <td><input type="text" size="1"  name="eval" value="'.$data[$db_field_cocktail_eval].'"></td>';	
	  echo '			</td>';  
	  echo '      <td><input type="button" value="'.$LANG["modify"].'" onclick="javascript:action.value=\'modify\';submit();">';
	  echo '          <input type="button" value="'.$LANG["delete"].'" onclick="javascript:action.value=\'delete\';submit();">';
	  echo '          <input type="button" value="composition" onclick="javascript:action.value=\'composition\';submit();"></td>';
	  echo '    </tr>';
	  echo '    </form>';
	}
?> 
  <tr>
    <form action="admin_cocktails.php" method="post">
    <input type="hidden" name="action">
      <td><input type="text" size="15" name="nom_cocktail"></td>
      <td><input type="text" size="30" name="commentaire"></td>
      <td><input type="text" size="15" name="image"></td>
      <td>
        <select name="eval">
          <option>N</option>
          <option>0</option>
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          <option>5</option>
        </select>
      </td>
      <td><input type="button" value="<?php print $LANG["add"] ?>" onclick="javascript:action.value='add';submit();"></td>
	</form>
  </tr>
  </table>
</td>
</tr>
<tr>

<td valign="top">
  
  <h3><?php print $LANG["ingredient_list"] ?></h3>
  <table border="1">
  <tr>
    <td><?php print $LANG["name"] ?></td>
    <td><?php print $LANG["action"] ?></td>	
  </tr>
  
<?php
// on crée la requête SQL
$sql = 'SELECT '.$db_field_ingredient_id.', '.$db_field_ingredient_name.' FROM '.$db_prefix.$db_table_ingredients.
       ' ORDER BY '.$db_field_ingredient_name;

// on envoie la requête
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

// on fait une boucle qui va faire un tour pour chaque enregistrement
while($data = mysql_fetch_assoc($req))
    {
	  echo '    <form action="admin_cocktails.php" method="post">';
	  echo '    <input type="hidden" name="action">';
	  echo '    <input type="hidden" name="id_ingredient" value="'.$data[$db_field_ingredient_id].'"';
	  echo '    <tr>';
	  echo '      <td><input type="text" name="nom_ingredient" value="'.$data[$db_field_ingredient_name].'"></td>';
	  echo '      <td><input type="button" value="'.$LANG["modify"].'" onclick="javascript:action.value=\'modify_ingredient\';submit();">';
	  echo '          <input type="button" value="'.$LANG["delete"].'" onclick="javascript:action.value=\'delete_ingredient\';submit();">';
	  echo '    </tr>';
	  echo '    </form>';
	}

// on ferme la connexion à mysql
mysql_close();
?>   
  <tr>
    <form action="admin_cocktails.php" method="post">
    <input type="hidden" name="action">	
      <td><input type="text" name="nom_ingredient"></td>
	  <td><input type="button" value="<?php print $LANG["add"] ?>" onclick="javascript:action.value='add_ingredient';submit();"></td>
	</form>
  </tr>
  </table>
  </td>


<td valign="top">
  
  
  <h3><?php print $LANG["list_images"] ?></h3>
  <table border="1">
  <tr>
    <td><?php print $LANG["name"] ?></td>
    <td><?php print $LANG["action"] ?></td>	
  </tr>
<?php
if ($handle = opendir("../images"))
{ 
  $nb_images=0;
  while (false !== ($file = readdir($handle))) 
  { 
    if ($file != "." && $file != "..") 
    { 
      $image_list[$nb_images++]=$file;
    } 
  } 
  closedir($handle); 
  if ($nb_images>0) sort($image_list);
  for ($i=0;$i<$nb_images;$i++) 
  {
	echo '<form action="admin_cocktails.php" method="post">';
	echo '<input type="hidden" name="action">';
	echo '<input type="hidden" name="img_name" value="'.$image_list[$i].'">';	
    echo '  <tr><td><a href="../images/'.$image_list[$i].'" target=images>'.$image_list[$i].'</a></td><td>';
	echo '  <input type="button" value="'.$LANG["delete"].'" onclick="javascript:action.value=\'img_delete\';submit();"></td></tr>';
	echo '</form>';
  }
}
?>
  <form enctype="multipart/form-data" action="admin_cocktails.php" method="post">
  <input type="hidden" name="action">
  <tr>
    <td>
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <input name="userfile" type="file" />
  </td>
    <td>
	  <input type="button" value="<?php print $LANG["add"] ?>" onclick="javascript:action.value='img_add';submit();">
    </td>	
  </tr>
  </form>
  </table>

</td>
  

  
  </tr>
<?php } ?>
  <tr>
    <td colspan="2">
      <br>
      <form action="admin_cocktails.php" method="post">
        <input type="hidden" name="action">	
        <input type="button" value="<?php print $LANG["logout"] ?>" onclick="javascript:action.value='logout';submit();">
      </form>
<?php } ?>	  
	</td>
  </tr>
  </table>
</body>
</html>
