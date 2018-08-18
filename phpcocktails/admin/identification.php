<?php
  session_start();
  include '../config.php';
  include '../languages/'.$language.'.php';
  include '../includes/functions.php';  
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
  <td colspan="2" align="center"><img src="../imgs/logo2.png"></td>
</tr>
<tr>
  <td width="150" valign="top">
<?php
include '../includes/menu.php';
?>
  </td>
  <td valign="top">
<?php
  $action=http_post('action');
  
  if ($action=="ident")
  { 
	if (valid_admin_password(http_post('user'),http_post('pass')))
    {
	  $_SESSION['admin']="true";
	?>
	  <?php print $LANG["login_succed"] ?> <a href="admin_cocktails.php"><?php print $LANG["admin"] ?></a>.
	  <script>window.location="admin_cocktails.php";</script>
	<?php
      
    }
	else
	{
	echo $data['password'];
	?>
	  <h2><?php print $LANG["login_failed"] ?></h2>
	<?php	
	}
  }
  else
  {

?>
    <h2><?php print $LANG["admin"] ?></h2>
	<h2><?php print $LANG["identification"] ?></h2>
	<form action="identification.php" method="post">
	<input type="hidden" name="action">
	<table>
	  <tr>
	    <td><?php print $LANG["login"] ?></td>
	    <td><input type="text" name="user"></td>
	  </tr>
	  <tr>
	    <td><?php print $LANG["password"] ?></td>
	    <td><input type="password" name="pass"></td>
	  </tr>	  
	  <tr>
	    <td colspan="2" align="right"><input type="button" value="<?php print $LANG["submit"] ?>" onclick="javascript:action.value='ident';submit();"></td>
	  </tr>
	</table>
	</form>
<?php } ?>	
  </td>
</tr>
</table>
</body>
</html>