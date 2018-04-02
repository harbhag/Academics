<?php



	
if($_POST['auth1']!=1) {
	echo "<br/><br/><center><span style='color:#bd362f;font-weight:bold;font-size:20px'>Theory Question Paper Setter Portal</span><br/><br/></center>";
		echo "<table class='table'>
			<center>
			<form method='post' action=''>
			
		
			<input type='text'  placeholder='Username'   name='username' id='username' />
			
				
			<br/><input type='password' placeholder='Password'   name='password' id='password' />
			
			
			<input type='hidden' name='login' value='login' />
			<br/><button type='submit' name='submit' id='submit' class='btn btn-primary btn-large btn-info' onclick='return empty_username(\"username\",\"Please enter Username!!\");' >Login</button>
			
		</form>

		</center>";
}

else {
	
	echo "<br/><br/><center><span style='color:blue;font-weight:bold;font-size:15px'>Enter One Time Password (OTP) as received in your email as well as mobile number.</span><br/><br/></center>";
	
	echo "<table class='table'>
			<center>
			<form method='post' action=''>
			
			<input type='text'  placeholder='Enter OTP'   name='otp' id='otp' />
			
			<input type='hidden' name='login' value='login' />
			<input type='hidden' name='otp_check' value='otp_check' />
			<br/><button type='submit' name='submit' id='submit' class='btn btn-primary btn-large btn-info'>Login</button>
			
		</form>

		</center>";
	
}
	
?>
