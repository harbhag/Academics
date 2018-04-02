<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <title>Exam Portal</title>
    <link type="text/css" href="css/harbhag.css" rel="stylesheet" />
    <link type="text/css" href="css/bootstrap.css" rel="stylesheet" />
    <link type="text/css" href="css/bootstrap-responsive.css" rel="stylesheet" />
    <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/harbhag.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="js/livevalidation_standalone.js"></script>
		<link rel="stylesheet" type="text/css" href="css/consolidated_common.css" />
		<link href="css/datepicker.css" rel="stylesheet">
		<link rel="shortcut icon" href="img/gne.ico" type="image/x-icon" />
		<script src="js/mousetrap.js"></script>
		<script src="js/sorttable.js"></script>

		<script>
    // map multiple combinations to the same callback
    Mousetrap.bind(['command+p', 'ctrl+p'], function() {
        return false;
    });
</script>

<script>
		$(function(){
			
			$('.date').each(function(){
    $(this).datepicker();
});
		});
	</script>
</head>
