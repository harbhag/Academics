<div class="modal hide" id="question_paper_panel">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">Close</button>
    
      <form action='' method='post'>
					  <input type='hidden' name='question_paper_panel_report' />
					  <button type="submit" class="btn btn-primary btn-danger">Generate Final Report</button></form>                           
    
    <?php show_label('important','Select below Details for Add/Delete data'); ?>
  </div>
  <div class="modal-body">

<?php
$userid = fetch_resource_db('users',array('username'),array($_SESSION['username']),'resource_array_value','users_id');

//$ccode = fetch_resource_db('branch_code',array('users_id'),array($userid),'resource_array_value','course_code');
//$bcode = fetch_resource_db('branch_code',array('users_id'),array($userid),'resource_array_value','branch_code');

$ccode_sql = mysql_query("SELECT show_course_code FROM users WHERE username='".$_SESSION['username']."' and usertype='hod'") or die(mysql_error());
$bcode_sql = mysql_query("SELECT show_branch_code FROM users WHERE username='".$_SESSION['username']."' and usertype='hod'") or die(mysql_error());
$sem_sql = mysql_query("SELECT show_semester FROM users WHERE username='".$_SESSION['username']."' and usertype='hod'") or die(mysql_error());

$scheme_code = mysql_query("SELECT distinct scheme_code FROM  scheme_master order by scheme_code ASC ;") or die(mysql_error());


$fccode = array();
$fbcode = array();
$fsem = array();

while($row = mysql_fetch_assoc($ccode_sql)) {
	$cc = $row['show_course_code'];
	$fccode[] = $cc;
}

while($row = mysql_fetch_assoc($bcode_sql)) {
	$bc = $row['show_branch_code'];
	$fbcode[] = $bc;
}

while($row = mysql_fetch_assoc($sem_sql)) {
	$sem = $row['show_semester'];
	$fsem[] = $sem;
}

//$lock_status = mysql_query("SELECT * FROM detainee_list WHERE detained_by='".$_SESSION['username']."' AND locked='Y' AND cleared_status='N' AND theory_practical='P'");

//if(mysql_num_rows($lock_status)!=0) {
	//show_label('important','Detainee List already locked by you');
	//exit();
//}

$ffccode = implode(",",$fccode);
$ffbcode =implode(",",$fbcode);
$ffsem =implode(",",$fsem);

$branch_codes_sql = mysql_query("SELECT show_branch_code,show_course_code,show_semester FROM users WHERE username='".$_SESSION['username']."' and usertype='hod'") or die(mysql_error());

$branch_codes = mysql_fetch_assoc($branch_codes_sql);


if($branch_codes['show_branch_code']=='ALL' && $branch_codes['show_course_code']!='ALL') {
	$branch = mysql_query("SELECT distinct branch_code,course_code FROM scheme_master WHERE 
	course_code IN ($ffccode)
	ORDER BY course_code ASC ;") or die(mysql_error());
}
elseif($branch_codes['show_branch_code']=='ALL' && $branch_codes['show_course_code']=='ALL') {
	$branch = mysql_query("SELECT distinct branch_code,course_code FROM scheme_master ORDER BY course_code ASC") or die(mysql_error());
}
else 
{
	$branch = mysql_query("SELECT distinct branch_code,course_code FROM scheme_master WHERE 
	branch_code IN ($ffbcode) ORDER BY course_code ASC ;") or die(mysql_error());
}

if($branch_codes['show_semester']=='ALL') {
	$semester = mysql_query("SELECT distinct semester FROM scheme_master ORDER BY semester ASC; ") or die(mysql_error());
}
else 
{
	$semester = mysql_query("SELECT distinct semester FROM scheme_master WHERE semester IN ($ffsem) ORDER BY semester ASC") or die(mysql_error());
}

?>
 <form action='' method='post'>
    <fieldset>
    <div class="control-group">
			<label class="control-label">Program</label>
    <select id="course_branch" name="course_branch" class="input-xlarge">
		<?php
		while($row = mysql_fetch_assoc($branch)) {
			if($row['branch_code']=='' or is_null($row['branch_code'])) {
				continue;
			}
		
			
			$course_name = fetch_resource_db('course_code',array('course_code'),array($row['course_code']),'resource_array_value','course_name');
			$branch_name = fetch_resource_db('branch_code',array('branch_code'),array($row['branch_code']),'resource_array_value','branch_name');
			echo "<option value='".$row['course_code'].",".$row['branch_code']."'>".$course_name."(".$branch_name.")</option>";
		}
		?>
    </select>

  <label class="control-label">Semester</label>
    <select id="semester" name="semester" class="input-medium">
		<?php
		while($row = mysql_fetch_assoc($semester)) {
			if($row['semester']=='' or is_null($row['semester'])) {
				continue;
			}
			echo "<option value='".$row['semester']."'>".$row['semester']."</option>";
		}
		?>
    </select>


<!-- Select Basic -->
  <label class="control-label">Theory/Practical</label>
    <select id="theory_practical" name="theory_practical" class="input-medium">
      <option value='T'>Theory</option>
    </select>



  <label class="control-label">Select AICTE/RC</label>
    <select id="aicte_rc" name="aicte_rc" class="input-medium">
      <option value='AICTE'>AICTE</option>
      <option value='RC'>RC</option>
    </select>


<!-- Select Basic -->
  <label class="control-label">Select Full / Part Time</label>
    <select id="full_part_time" name="full_part_time" class="input-medium">
      <option value='Full Time'>Full Time</option>
      <option value='Part Time'>Part Time</option>
    </select>




<!-- Select Basic -->
  <label class="control-label">Scheme Code </label>
    <select id="scheme_code" name="scheme_code" class="input-medium">
		<?php
		while($row = mysql_fetch_assoc($scheme_code)) {
			if($row['scheme_code']=='' or is_null($row['scheme_code'])) {
				continue;
			}
			echo "<option value='".$row['scheme_code']."'>".$row['scheme_code']."</option>";
		}
		?>
    </select>

  <input type='hidden' name='question_paper_panel' />
            <div class="form-actions">
              <button type="submit" class="btn btn-primary btn-danger">Proceed</button>
  </div></fieldset></form> 
              
            
           


<!-- Button -->

</div>
</div>



