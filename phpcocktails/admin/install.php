<html>
  <head>
    <title>phpcocktail: installation</title>
	<link href="../css/phpcocktails.css" type="text/css" rel="stylesheet">
  </head>
  <body>
  <center>
  <img src="../imgs/logo2.png" alt="phpcocktails">
  <br>
  
<?php
  include '../includes/functions.php';
  $action=http_post('action');
  if ($action=="install")
  {
    if (http_post('admin_pass')!=http_post('admin_pass_again'))
	{
	?>
	<h1>The typed passwords are different !!</h1>
	<?php
	}
	else
	{
	  if (create_config(http_post('db_host'),
	                    http_post('db_name'),
					   					http_post('db_user'),
					   					http_post('db_password'),
					   					http_post('db_prefix'),
					   					http_post('install_dir'),
					   					http_post('admin_user'),
					   					http_post('admin_pass'),
					   					http_post('language'))) {
			include '../config.php'; 
	?> 
	<h1>Installation complete</h1>
	Please remove <?php echo $install_dir."admin/install.php" ?>
	<br><br>
	Go to <a href="<?php echo $install_dir."/index.php" ?>">phpcocktails</a>
	<?php }
	}
  }
  else
  {
?>
  
  <h1>Installation</h1>
  <form action="install.php" method="post">
  <table border="1">
    <tr>
      <td>DB Host</td>
      <td><input type="text" name="db_host" value=""></td>
    </tr> 
    <tr>
      <td>DB Name</td>
      <td><input type="text" name="db_name" value=""></td>
    </tr>    
    <tr>
      <td>DB User</td>
      <td><input type="text" name="db_user" value=""></td>
    </tr>
    <tr>
      <td>DB Password</td>
      <td><input type="password" name="db_password" value=""></td>
    </tr>
    <tr>
      <td>DB Prefix</td>
      <td><input type="text" name="db_prefix" value="phpcocktails_"></td>
    </tr>
    <tr>
      <td>Install Directory</td>
      <td><input type="text" name="install_dir" value="<?php echo rtrim(dirname($HTTP_SERVER_VARS["SCRIPT_NAME"]),"/admin") ?>"></td>
    </tr>
    <tr>
      <td>admin user</td>
      <td><input type="text" name="admin_user" value=""></td>
    </tr>
    <tr>
      <td>admin password</td>
      <td><input type="password" name="admin_pass" value=""></td>
    </tr>	
    <tr>
      <td>admin password (retype)</td>
      <td><input type="password" name="admin_pass_again" value=""></td>
    </tr>	
	<tr>
	  <td>Language</td>
	    <td><select name="language">
<?php
if ($handle = opendir("../languages"))
{ 
  while (false !== ($fichier = readdir($handle))) 
  { 
    if ($fichier != "." && $fichier != "..") 
    { 
      list ($debut,$ext)=explode(".php",$fichier);
      echo "<option>".$debut."</option>";
    } 
  } 
  closedir($handle); 
}	  
?>
        </select>
      </td>
	</tr>
	
	
    <tr>
	  <input type="hidden" name="action" value="install">
      <td colspan="2" align="center"><input type="submit"></td>
    </tr>
  </table>
  </form>
<?php
  }
?>  
  </center>
  </body>
</html>