<?php


include 'compatibility.php';

function valid_admin_password($user,$password)
{
  $db_host="";
  $db_user="";
  $db_password="";
  $db_name="";
  $db_prefix="";
  $db_table_users="";
  $db_field_user_name="";
  $db_field_user_password="";
  
  include "../config.php";
  include "db.php";
  $db = mysql_connect($db_host, $db_user, $db_password) or die("An error occured during database connection");
  mysql_select_db($db_name,$db) or die("An error occured during database selection");;
  $sql="SELECT * FROM ".$db_prefix.$db_table_users." WHERE ".$db_field_user_name."='".$user."'";	
  $req = mysql_query($sql);
  $data = mysql_fetch_assoc($req);
  return ($data[$db_field_user_password] == md5( $password));
}

function create_config_db($db_host,$db_name,$db_user,$db_password,$db_prefix,$admin_user,$admin_pass)
{
	$db_table_composition="";
  $db_field_composition_order="";
  $db_field_cocktail_id="";
  $db_field_ingredient_id="";
  $db_field_ingredient_proportion="";
  $db_table_ingredients="";
  $db_field_ingredient_name="";
  $db_table_names="";
  $db_field_cocktail_name="";
  $db_field_comment="";
  $db_field_image="";
  $db_field_cocktail_eval="";
  $db_table_users="";
  $db_field_user_id="";
  $db_field_user_name="";
  $db_field_user_password="";
  $db_table_comments="";
  $db_field_comment_id="";
  $db_field_comment_date="";
  $db_field_comment_nickname="";
  $db_field_comment_text="";
  
  include "db.php";
  $db = mysql_connect($db_host, $db_user, $db_password) or die("An error occured during database connection");
  mysql_select_db($db_name,$db) or die("An error occured during database selection");;
  
  $sql1="CREATE TABLE `".$db_prefix.$db_table_composition."` ( `".$db_field_composition_order."` smallint(5) unsigned NOT NULL auto_increment ,".
                                                              "`".$db_field_cocktail_id."` smallint(5) unsigned NOT NULL ,".
															  "`".$db_field_ingredient_id."` smallint(5) unsigned NOT NULL ,".
															  "`".$db_field_ingredient_proportion."` varchar(50)  NOT NULL ,".
															  "PRIMARY KEY  (`".$db_field_composition_order."`)) ";
													  
  $sql2="CREATE TABLE `".$db_prefix.$db_table_ingredients."` ( `".$db_field_ingredient_id."` smallint(5) unsigned NOT NULL auto_increment,".
                                                              "`".$db_field_ingredient_name."` varchar(50) NOT NULL,".
                                                              "PRIMARY KEY  (`".$db_field_ingredient_id."`) ) ";
		
  $sql3="CREATE TABLE `".$db_prefix.$db_table_names."` ( `".$db_field_cocktail_id."` smallint(5) unsigned NOT NULL auto_increment,".
                                                        "`".$db_field_cocktail_name."` varchar(50) NOT NULL,".
														"`".$db_field_comment."` varchar(200), ".
                                                        "`".$db_field_image."` varchar(50),".
														"`".$db_field_cocktail_eval."` varchar(1),".
														" PRIMARY KEY  (`".$db_field_cocktail_id."`) ) ";
  
  $sql4="CREATE TABLE `".$db_prefix.$db_table_users."` ( `".$db_field_user_id."` smallint(5) unsigned NOT NULL auto_increment,".
                                                    "    `".$db_field_user_name."` varchar(20)  NOT NULL,".
													"    `".$db_field_user_password."` varchar(255),".
													"    PRIMARY KEY  (`".$db_field_user_id."`) ) ";

  $sql5="INSERT INTO ".$db_prefix.$db_table_users." (".$db_field_user_name.", ".$db_field_user_password.")  VALUES ('".$admin_user."','".md5($admin_pass)."');";

  $sql6="CREATE TABLE `".$db_prefix.$db_table_comments."` ( `".$db_field_comment_id."` smallint(5) NOT NULL auto_increment, ".
                                                           "`".$db_field_cocktail_id."` smallint(5) NOT NULL, ".
														   "`".$db_field_comment_date."` varchar(20) NULL, ".
														   "`".$db_field_comment_nickname."` varchar(20), ".
														   "`".$db_field_comment_text."` varchar(255) NOT NULL, ".
														   "PRIMARY KEY (`".$db_field_comment_id."`))";
													
  $req = mysql_query($sql1) or die("An error occured during database creation :".$sql1);
  $req = mysql_query($sql2) or die("An error occured during database creation :".$sql2);
  $req = mysql_query($sql3) or die("An error occured during database creation :".$sql3);
  $req = mysql_query($sql4) or die("An error occured during database creation :".$sql4);
  $req = mysql_query($sql5) or die("An error occured during database creation :".$sql5);  
  $req = mysql_query($sql6) or die("An error occured during database creation :".$sql6);    
  return true;	
}


function create_config_file($db_host,$db_name,$db_user,$db_password,$db_prefix,$install_dir,$language)
{	
	$fp = fopen ("../config.php", "w") or die("Impossible to create file");
  fwrite($fp,"<?php\n");
	fwrite($fp,"\$db_host='".$db_host."';\n");
	fwrite($fp,"\$db_name='".$db_name."';\n");
	fwrite($fp,"\$db_user='".$db_user."';\n");
	fwrite($fp,"\$db_password='".$db_password."';\n");
	fwrite($fp,"\$db_prefix='".$db_prefix."';\n");
	fwrite($fp,"\$install_dir='".$install_dir."';\n");
	fwrite($fp,"\$language='".$language."';\n");
  fwrite($fp,"?>\n");
  fclose($fp);
	return true;
}	

function create_config($db_host,$db_name,$db_user,$db_password,$db_prefix,$install_dir,$admin_user,$admin_pass,$language)
{
  create_config_db($db_host,$db_name,$db_user,$db_password,$db_prefix,$admin_user,$admin_pass);
  create_config_file($db_host,$db_name,$db_user,$db_password,$db_prefix,$install_dir,$language);

  return true;
}

?>