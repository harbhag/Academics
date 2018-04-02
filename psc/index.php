<?
include_once('../psc_header.php');

echo "<div class='container'>";
//require('navigator.php');


session_start();

/*
if(isset($_SESSION['username'])) {
	require('navigator.php');
}
*/

if(isset($_POST['logout'])) {
	
	session_destroy();
	require("login.php");
	
}

elseif(isset($_POST['changepassword'])) {
	
	if(isset($_POST['new'])) {
		
		$chk_current = mysql_query("SELECT * FROM mtech_external_thesis_examiner WHERE username='".$_SESSION['username']."' AND password='".md5($_POST['current'])."'") or die(mysql_error());
		
		if(mysql_num_rows($chk_current)==0) {
			
			require('navigator.php');
			echo "<br/><br/><center><span style='color:#faa732;font-weight:bold;font-size:20px'>Wrong Current Password entered, Try Again !!</span><br/><br/></center>";
			require("changepassword.php");
			exit();
			
		}
		else {
			
			require('navigator.php');
			mysql_query("UPDATE mtech_external_thesis_examiner SET password='".md5($_POST['new'])."' WHERE username='".$_SESSION['username']."'") or die(mysql_error());
			echo "<br/><br/><center><span style='color:#bd362f;font-weight:bold;font-size:20px'>Password Successfully Changed</span><br/><br/></center>";
			
			mysql_query("UPDATE mtech_external_thesis_examiner SET otp='".$secure_code."' WHERE username = '".$_SESSION['username']."'") or die(mysql_error());
	
			$sql = mysql_query("SELECT * FROM mtech_external_thesis_examiner WHERE username = '".$_SESSION['username']."'") or die(mysql_error());
			$email = mysql_fetch_assoc($sql);
			
			   
			$body = "Your new password for Theory Question Paper Setter Portal, GNDEC is ".$_POST['new']."";
			
			
			
			$url="http://103.27.87.89/send.php?usr=1995&pwd=123456&ph=".$email['mobile_no']."&sndr=GNELDH&text=".urlencode($body)."";
			$agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_VERBOSE, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, $agent);
			curl_setopt($ch, CURLOPT_URL,$url);
			$result=curl_exec($ch);
				
			exit();
			
		}
		
	}
	
	require('navigator.php');
	
	echo "<br/><br/>";
	//require("user_details.php");
	
	require("changepassword.php");
	
}

elseif(isset($_POST['edit'])) {
	
	require('navigator.php');
	
	echo "<br/><br/>";
	require("user_details.php");
	
	require("subjects.php");
	
}


elseif(isset($_POST['consent_submitted'])) {
	
	
	require('navigator.php');
	
	echo "<br/><br/>";
	require("user_details.php");
	
	require("add_paper_setter.php");
	
}


elseif(isset($_POST['iagree'])) {
	
	require('navigator.php');
	
	echo "<br/><br/>";
	require("user_details.php");
			
	$pm_sql = mysql_query("SELECT * FROM popup_notices WHERE usertype LIKE 'psc' AND valid_till>='".date("Y-m-d")."' AND published='Y' ORDER BY priority DESC") or die(mysql_error());
			
	if(mysql_num_rows($pm_sql)!=0) {
		include_once("popup_notice_modal.php");
	}
			
			
			
	$chk_consent = mysql_query("SELECT * FROM paper_setter_consent WHERE teacher_username='".$_SESSION['username']."'")  or die(mysql_error());
	if(mysql_num_rows($chk_consent)==0) {
				
		require("subjects.php");
				
	}
	else {
				
		require("add_paper_setter.php");
				
	}
	
}

elseif(isset($_POST['login']))
{
	
	if(isset($_POST['otp_check'])) {
		
		
		$chk_otp = mysql_query("SELECT * FROM mtech_external_thesis_examiner WHERE username='".$_SESSION['username']."' AND otp='".$_POST['otp']."'") or die(mysql_error());
		
		if(mysql_num_rows($chk_otp)==1) {
			
			
			$_SESSION['otp_check']='1';
			include_once("acceptance.php");
			
		}
		else {
			
			echo "<br/><br/><center><span style='color:#faa732;font-weight:bold;font-size:20px'>Wrong OTP !!</span><br/><br/></center>";
			$_POST['auth1']=1;
			require("login.php");
			
		}
	}
	
	else {
		$chk_user = mysql_query("SELECT * FROM mtech_external_thesis_examiner WHERE username='".$_POST['username']."' AND user_status='1'") or die(mysql_error());
		//$chk_user = mysql_query("SELECT * FROM mtech_external_thesis_examiner WHERE username='".$_POST['username']."'") or die(mysql_error());
		
		if(mysql_num_rows($chk_user)==0) {
			
			echo "<br/><br/><center><span style='color:#faa732;font-weight:bold;font-size:20px'>User ".$_SESSION['username']." is not ACTIVE in Panel. Please contact coegndec@gmail.com</span><br/><br/></center>";
			require("login.php");
			exit();
			
		}
		
		require("authenticate.php");
		
		if($auth=="Fail") {
			
			echo "<br/><br/><center><span style='color:#faa732;font-weight:bold;font-size:20px'>Invalid User or Password !!</span><br/><br/></center>";
			
			require("login.php");
			
		}
		
	}
	
}



elseif(isset($_SESSION['username']) && $_SESSION['otp_check']='1') {
	
	require('navigator.php');
	
	echo "<br/><br/>";
	require("user_details.php");
	
	$chk_consent = mysql_query("SELECT * FROM paper_setter_consent WHERE teacher_username='".$_SESSION['username']."'")  or die(mysql_error());
	if(mysql_num_rows($chk_consent)==0) {
				
		require("subjects.php");
				
	}
	else {
				
		require("add_paper_setter.php");
				
	}
	
}

else{
	
	session_destroy();
	require("login.php");

}

echo "</div>";

?>
