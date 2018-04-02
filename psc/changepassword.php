<?php


echo "<br/><br/><center><span style='color:#bd362f;font-weight:bold;font-size:20px'>Change Password</span><br/><br/></center>";
	

		echo "<table class='table'>
			<center>
			<form method='post' action=''>
			
		
			<input type='text'  placeholder='Current Password'   name='current' id='current' />
			
				
			<br/><input type='password' placeholder='New Password'   name='new' id='new' />
			
			
			<input type='hidden' name='changepassword' value='changepassword' />
			<br/><button type='submit' name='submit' id='submit' class='btn btn-primary btn-large btn-info' onclick='return empty_username(\"new\",\"Please enter New Password!!\");'>Change Password</button>
			
		</form>

		</center>";


	
?>
