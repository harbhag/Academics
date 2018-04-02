<?php
require("Mail.php");
	
function generate_secure_code() {
	
	$secure_code = rand(111111, 999999);
	
	mysql_query("UPDATE mtech_external_thesis_examiner SET otp='".$secure_code."' WHERE username = '".$_SESSION['username']."'") or die(mysql_error());
	
	$sql = mysql_query("SELECT * FROM mtech_external_thesis_examiner WHERE username = '".$_SESSION['username']."'") or die(mysql_error());
	$email = mysql_fetch_assoc($sql);
	
	   
    $mailer_user = "gndec.examautomation@gmail.com";
	$mailer_password = "GNDECexam2012";
	$host = "ssl://smtp.gmail.com";
	$port = "465";
    $sender_name = "GNDEC Exam Automation";
    $to = "<".$email['email'].">";
    $from = $sender_name."<".$mailer_user.">";
	$subject = "GNDEC 2-Way Authentication OTP";
	$body = "".$secure_code." is your OTP for Theory Question Paper Setter Portal, GNDEC. If you are not the correct recipient of this message or in case you have any queries, please contact Dr. Akshay Girdhar at coegndec@gmail.com or 8283840043";
	
	
	
	$url="http://103.27.87.89/send.php?usr=1995&pwd=123456&ph=".$email['mobile_no']."&sndr=GNELDH&text=".urlencode($body)."";
	$agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_VERBOSE, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
	curl_setopt($ch, CURLOPT_URL,$url);
	$result=curl_exec($ch);
		
	$headers = array ('From' => $from,
          'To' => $to,
          'Subject' => $subject);
			$smtp = Mail::factory('smtp',
          array ('host' => $host,
            'port' => $port,
            'auth' => true,
            'username' => $mailer_user,
            'password' => $mailer_password));

        $mail = $smtp->send($to, $headers, $body);

        if (PEAR::isError($mail)) {
          echo("<p>" . $mail->getMessage() . "</p>");
         } else {
          return $secure_code;
         }
}




$chk_internal = mysql_query("SELECT * FROM users WHERE username='".$_POST['username']."'") or die(mysql_error());

if(mysql_num_rows($chk_internal)!=0) {
	
	
	$server = "ldap.gndec.ac.in";
	$dn = "ou=people,dc=example,dc=com";
	
	$user_data = mysql_fetch_assoc($chk_internal);

	error_reporting(0);
	ldap_connect($server);
	$con = ldap_connect($server);
	ldap_set_option($con, LDAP_OPT_PROTOCOL_VERSION, 3);
	if (ldap_bind($con, "uid=".$_POST['username'].",ou=people,dc=example,dc=com",$_POST['password']) === false) {
	   session_destroy();
	   $auth="Fail";
	}
	else {
		//$auth="Pass";
		
		$_SESSION['username']=$_POST['username'];
		$_SESSION['fullname']=$user_data['prefix']." ".$user_data['name'];
		$_SESSION['ie']='I';
		
		generate_secure_code();
		$_POST['auth1']=1;
		require("login.php");
	}
}

else {
	
	$chk_user = mysql_query("SELECT * FROM mtech_external_thesis_examiner WHERE username='".$_POST['username']."' AND password='".md5($_POST['password'])."'") or die(mysql_error());
	if(mysql_num_rows($chk_user)!=1) {
		
		$auth="Fail";
		
	}
	else {
		//$auth="Pass";
		
		$user_data = mysql_fetch_assoc($chk_user);
		
		$_SESSION['username']=$_POST['username'];
		$_SESSION['fullname']=$user_data['prefix_name']." ".$user_data['name'];
		$_SESSION['ie']='E';
		
		generate_secure_code();
		$_POST['auth1']=1;
		require("login.php");
	}
	
	
}


?>