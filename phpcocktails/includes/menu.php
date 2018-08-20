<script type="text/javascript">
m1 = new Image (112,30);
m1_w = new Image (112,30);
m2 = new Image (112,20);
m2_w = new Image (112,20);
m3 = new Image (112,30);
m3_w = new Image (112,30);
m4 = new Image (112,30);
m4_w = new Image (112,30);
m1.src="<?php echo $install_dir ?>/imgs/<?php echo $language ?>/list.png";
m1_w.src="<?php echo $install_dir ?>/imgs/<?php echo $language ?>/list_dark.png";
m2.src="<?php echo $install_dir ?>/imgs/<?php echo $language ?>/shaker.png";
m2_w.src="<?php echo $install_dir ?>/imgs/<?php echo $language ?>/shaker_dark.png";
m3.src="<?php echo $install_dir ?>/imgs/<?php echo $language ?>/admin.png";
m3_w.src="<?php echo $install_dir ?>/imgs/<?php echo $language ?>/admin_dark.png";
m4.src="<?php echo $install_dir ?>/imgs/<?php echo $language ?>/about.png";
m4_w.src="<?php echo $install_dir ?>/imgs/<?php echo $language ?>/about_dark.png";
</script>

    <table class="menu">
	  <tr>
	    <td>
		  <a href="<?php echo $install_dir ?>/index.php" onmouseover="list.src=m1.src" onmouseout="list.src=m1_w.src" >
		    <img src="<?php echo $install_dir ?>/imgs/<?php echo $language ?>/list_dark.png" border="0" name="list" alt="list">
		  </a>
       </td>
	  </tr>
	  <tr>
	    <td>
		  <a href="<?php echo $install_dir ?>/shaker.php" onmouseover="shaker.src=m2.src" onmouseout="shaker.src=m2_w.src" >		
		    <img src="<?php echo $install_dir ?>/imgs/<?php echo $language ?>/shaker_dark.png" border="0" name="shaker" alt="shaker">
		  </a>		
		</td>
      </tr>
	  <tr>
	    <td>
		  <a href="<?php echo $install_dir ?>/admin/admin_cocktails.php" onmouseover="admin.src=m3.src" onmouseout="admin.src=m3_w.src" >				
		    <img src="<?php echo $install_dir ?>/imgs/<?php echo $language ?>/admin_dark.png" border="0" name="admin" alt="admin">
		  </a>			
		</td>
		</tr>
		<tr>	  
		<td>
		  <a href="<?php echo $install_dir ?>/about.php" onmouseover="about.src=m4.src" onmouseout="about.src=m4_w.src" >				
		    <img src="<?php echo $install_dir ?>/imgs/<?php echo $language ?>/about_dark.png" border="0" name="about" alt="about">
		  </a>			
		</td>	 
	  </tr>
    </table>