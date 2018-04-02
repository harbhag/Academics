 <?php 
$course_branch = explode(',',$_POST['course_branch']);
$program_cos_subject_code = mysql_query("SELECT distinct subject_code,scheme_code  from program_cos where backup='0'  and branch_code='".$course_branch['1']."'; ");

show_label('info','Course Outcome(CO) And Program Outcome(PO) Mapping Report');
echo "<br/><table  class='table table-bordered  table-condensed container '><tr><th>Course</th><th>Course Outcomes</th><th>a</th><th>b</th><th>c</th><th>d</th><th>e</th><th>f</th><th>g</th><th>h</th><th>i</th><th>j</th><th>k</th><th>l</th></tr>";
while($row = mysql_fetch_assoc($program_cos_subject_code)) 
{
	$program_cos_co = mysql_query("SELECT distinct co_number,co_statement  from program_cos where backup='0'  and branch_code='".$course_branch['1']."' and subject_code='".$row['subject_code']."'; ");
	#$row_co = mysql_fetch_assoc($program_cos_co)
	$rs = (mysql_num_rows($program_cos_co))+(1);
	
	echo "<tr><td rowspan='".$rs."'>".$row['subject_code']."</td> </tr>";
	while($row_co = mysql_fetch_assoc($program_cos_co)) 
	{ 
		echo "<tr><td>CO ".$row_co['co_number'].": ".$row_co['co_statement']."</td>";
		$program_cos_co_po = mysql_query("SELECT * from program_cos pc, program_outcomes po where pc.backup='0'  and pc.branch_code='".$course_branch['1']."' and pc.subject_code='".$row['subject_code']."' and pc.co_number='".$row_co['co_number']."' and pc.program_outcome_id=po.id and po.po_num='a'; ");
		$row_po_a = mysql_fetch_assoc($program_cos_co_po);
		echo "<td>".$row_po_a['correlation_po']."</td>";
		
		$program_cos_co_po = mysql_query("SELECT * from program_cos pc, program_outcomes po where pc.backup='0'  and pc.branch_code='".$course_branch['1']."' and pc.subject_code='".$row['subject_code']."' and pc.co_number='".$row_co['co_number']."' and pc.program_outcome_id=po.id and po.po_num='b'; ");
		$row_po_b = mysql_fetch_assoc($program_cos_co_po);
		echo "<td>".$row_po_b['correlation_po']."</td>";

		$program_cos_co_po = mysql_query("SELECT * from program_cos pc, program_outcomes po where pc.backup='0'  and pc.branch_code='".$course_branch['1']."' and pc.subject_code='".$row['subject_code']."' and pc.co_number='".$row_co['co_number']."' and pc.program_outcome_id=po.id and po.po_num='c'; ");
		$row_po_c = mysql_fetch_assoc($program_cos_co_po);
		echo "<td>".$row_po_c['correlation_po']."</td>";
			
		$program_cos_co_po = mysql_query("SELECT * from program_cos pc, program_outcomes po where pc.backup='0'  and pc.branch_code='".$course_branch['1']."' and pc.subject_code='".$row['subject_code']."' and pc.co_number='".$row_co['co_number']."' and pc.program_outcome_id=po.id and po.po_num='d'; ");
		$row_po_d = mysql_fetch_assoc($program_cos_co_po);
		echo "<td>".$row_po_d['correlation_po']."</td>";
		$program_cos_co_po = mysql_query("SELECT * from program_cos pc, program_outcomes po where pc.backup='0'  and pc.branch_code='".$course_branch['1']."' and pc.subject_code='".$row['subject_code']."' and pc.co_number='".$row_co['co_number']."' and pc.program_outcome_id=po.id and po.po_num='e'; ");
		$row_po_e = mysql_fetch_assoc($program_cos_co_po);
		echo "<td>".$row_po_e['correlation_po']."</td>";
		
		$program_cos_co_po = mysql_query("SELECT * from program_cos pc, program_outcomes po where pc.backup='0'  and pc.branch_code='".$course_branch['1']."' and pc.subject_code='".$row['subject_code']."' and pc.co_number='".$row_co['co_number']."' and pc.program_outcome_id=po.id and po.po_num='f'; ");
		$row_po_f = mysql_fetch_assoc($program_cos_co_po);
		echo "<td>".$row_po_f['correlation_po']."</td>";
		
		$program_cos_co_po = mysql_query("SELECT * from program_cos pc, program_outcomes po where pc.backup='0'  and pc.branch_code='".$course_branch['1']."' and pc.subject_code='".$row['subject_code']."' and pc.co_number='".$row_co['co_number']."' and pc.program_outcome_id=po.id and po.po_num='g'; ");
		$row_po_g = mysql_fetch_assoc($program_cos_co_po);
		echo "<td>".$row_po_g['correlation_po']."</td>";
		
		$program_cos_co_po = mysql_query("SELECT * from program_cos pc, program_outcomes po where pc.backup='0'  and pc.branch_code='".$course_branch['1']."' and pc.subject_code='".$row['subject_code']."' and pc.co_number='".$row_co['co_number']."' and pc.program_outcome_id=po.id and po.po_num='h'; ");
		$row_po_h = mysql_fetch_assoc($program_cos_co_po);
		echo "<td>".$row_po_h['correlation_po']."</td>";
		
		$program_cos_co_po = mysql_query("SELECT * from program_cos pc, program_outcomes po where pc.backup='0'  and pc.branch_code='".$course_branch['1']."' and pc.subject_code='".$row['subject_code']."' and pc.co_number='".$row_co['co_number']."' and pc.program_outcome_id=po.id and po.po_num='i'; ");
		$row_po_i = mysql_fetch_assoc($program_cos_co_po);
		echo "<td>".$row_po_i['correlation_po']."</td>";
			
		
		$program_cos_co_po = mysql_query("SELECT * from program_cos pc, program_outcomes po where pc.backup='0'  and pc.branch_code='".$course_branch['1']."' and pc.subject_code='".$row['subject_code']."' and pc.co_number='".$row_co['co_number']."' and pc.program_outcome_id=po.id and po.po_num='j'; ");
		$row_po_j = mysql_fetch_assoc($program_cos_co_po);
		echo "<td>".$row_po_j['correlation_po']."</td>";
			
		
		$program_cos_co_po = mysql_query("SELECT * from program_cos pc, program_outcomes po where pc.backup='0'  and pc.branch_code='".$course_branch['1']."' and pc.subject_code='".$row['subject_code']."' and pc.co_number='".$row_co['co_number']."' and pc.program_outcome_id=po.id and po.po_num='k'; ");
		$row_po_k = mysql_fetch_assoc($program_cos_co_po);
		echo "<td>".$row_po_k['correlation_po']."</td>";
			
		
		$program_cos_co_po = mysql_query("SELECT * from program_cos pc, program_outcomes po where pc.backup='0'  and pc.branch_code='".$course_branch['1']."' and pc.subject_code='".$row['subject_code']."' and pc.co_number='".$row_co['co_number']."' and pc.program_outcome_id=po.id and po.po_num='l'; ");
		$row_po_l = mysql_fetch_assoc($program_cos_co_po);
		echo "<td>".$row_po_l['correlation_po']."</td>";
			
		echo  "</tr>";
	}
}
?>
