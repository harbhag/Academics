<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js">
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Question Paper Templates</title>
</head>

<body>
<script>
$(document).ready(function() {
    var t = $('#example').DataTable( {
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "order": [[ 1, 'asc' ],[ 2, 'asc' ],[ 3, 'asc' ]],
		"iDisplayLength": 50
    } );
 
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
} );
</script>

<?php
//include("/var/www/protected/access.php");
echo "<div class='container-fluid'>";
echo "<br/>";
echo "<center><h2>Download Question Paper Templates below</h2></center>";
echo "<br/><br/>";

$dirname = "download/";

$dir = opendir($dirname);

$count = 1;
echo "<center>

<table id='example' class='table table-bordered table-striped' cellspacing='0' width='82%'>
<thead><tr>
<th>Sr. No.</th>
<th>Course</th>
<th>Semester</th>
<th>Numerical / Programming / Design / Drawing / Problem Solving Content</th>
<th>Download File</th></tr></thead>

<tbody>";
while(false != ($file = readdir($dir)))
{
    if(($file != ".") and ($file != ".."))
    {
		$filename = $file;
		
		
		if (strpos($filename, 'B.Tech.') !== false) {
			$course = 'B.Tech.';
		}
		
		if (strpos($filename, 'M.Tech.') !== false) {
			$course = 'M.Tech.';
		}
		
		if (strpos($filename, 'MBA') !== false) {
			$course = 'MBA';
		}
		
		if (strpos($filename, 'MCA') !== false) {
			$course = 'MCA';
		}
		
		preg_match_all('!\d+!', $filename, $matches);
		//print_r($matches);
		
		$semester = '';
		
		foreach($matches as $sem) {
			foreach ($sem as $s) {
				//echo $s."<br/>";
				if($s==1) {
					$semester .= '1,2,';
				}
				if($s==2) {
					$semester .= '3,4,';
				}
				if($s==3) {
					$semester .= '5,6,';
				}
				if($s==4) {
					$semester .= '7,8';
				}
				
				if($s>=10){
					$percentage = $s;
				}
			}
		}
		

		/*
		if($count%2==0) {
			echo "<tr class='pure-table-odd'><td>";
		}
		else {
			echo "<tr><td>";
		}
		*/
		
		echo "<tr><td>";
		
		echo $count.".";
		
		echo "</td><td>";
		
		echo $course;
		
		echo "</td><td>";
		
		if($semester==''){
			$semester='ALL';
		}
		
		echo $semester;
		
		echo "</td><td>";
		
		echo $percentage."%";
		
		echo "</td><td>";
		
		echo "<a style='text-decoration: none;' href='$dirname$file'><span style='color:blue;font-weight:;font-size:18px'>Download</a><span>";
		
		echo "</td></tr>";
		$count++;
		
		unset($matches);
		unset($sem);
		$percentage = 0;

    }
}

echo "</tbody></table></center>";

?>
<br/>
<br/>
<div/>
<!--<a href="http://gndec.ac.in/71fdbdb03bf7770d721829e4f2856dc0/index.php?logout=1"><span style='color:red;font-weight:bold;font-size:20px'>Logout</span></a>
-->
</body>
</html>

