<?php
$userid = fetch_resource_db('users',array('username'),array($_SESSION['username']),'resource_array_value','users_id');

//$ccode = fetch_resource_db('branch_code',array('users_id'),array($userid),'resource_array_value','course_code');
//$bcode = fetch_resource_db('branch_code',array('users_id'),array($userid),'resource_array_value','branch_code');

$ccode_sql = mysql_query("SELECT show_course_code FROM users WHERE username='".$_SESSION['username']."' and usertype='course_admins'") or die(mysql_error());
$bcode_sql = mysql_query("SELECT show_branch_code FROM users WHERE username='".$_SESSION['username']."' and usertype='course_admins'") or die(mysql_error());
$sem_sql = mysql_query("SELECT show_semester FROM users WHERE username='".$_SESSION['username']."' and usertype='course_admins'") or die(mysql_error());


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

if(isset($_POST['add_student_detainee_list_practical_form'])) {
	$lock_status = mysql_query("SELECT * FROM detainee_list WHERE detained_by='".$_SESSION['username']."' AND locked='Y' AND cleared_status='N' AND theory_practical='P'");
}
else {
	
	$lock_status = mysql_query("SELECT * FROM detainee_list WHERE detained_by='".$_SESSION['username']."' AND locked='Y' AND cleared_status='N' AND theory_practical='T'");

}


if(mysql_num_rows($lock_status)!=0) {
	show_label('important','Detainee List already locked by you');
	exit();
}

$ffccode = implode(",",$fccode);
$ffbcode =implode(",",$fbcode);
$ffsem =implode(",",$fsem);

$branch_codes_sql = mysql_query("SELECT show_branch_code,show_course_code,show_semester FROM users WHERE username='".$_SESSION['username']."' and usertype='course_admins'") or die(mysql_error());

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
	$semester = mysql_query("SELECT distinct semester FROM scheme_master WHERE
	semester IN ($ffsem) ORDER BY semester ASC") or die(mysql_error());
}


?>


<div id='form'>
<form class="form-horizontal" action='' method='post'>
<fieldset>

<!-- Form Name -->
<legend>Please Fill Details Below</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label">University Roll No</label>
  <div class="controls">
    <input id="university_roll_no" name="university_roll_no" placeholder="University Roll No" class="input-xlarge" required="" type="text">
    
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label">Class</label>
  <div class="controls">
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
  </div>
</div>


<!-- Select Basic -->
<div class="control-group">
  <label class="control-label">Semester</label>
  <div class="controls">
    <select id="semester" name="semester" class="input-xlarge">
		<?php
		while($row = mysql_fetch_assoc($semester)) {
			if($row['semester']=='' or is_null($row['semester'])) {
				continue;
			}
			echo "<option value='".$row['semester']."'>".$row['semester']."</option>";
		}
		?>
    </select>
  </div>
</div>


<?php

if(isset($_POST['add_student_detainee_list_practical_form'])) { ?>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label">Theory/Practical</label>
  <div class="controls">
    <select id="theory_practical" name="theory_practical" class="input-xlarge">
      <option value='P'>P</option>
    </select>
  </div>
</div>

<?php }

else { 
	
?>
<!-- Select Basic -->
<div class="control-group">
  <label class="control-label">Theory/Practical</label>
  <div class="controls">
    <select id="theory_practical" name="theory_practical" class="input-xlarge">
      <option value='T'>T</option>
      <!--<option value='P'>P</option>-->
    </select>
  </div>
</div>

<?php } ?>


<!-- Select Basic -->
<div class="control-group">
  <label class="control-label">Select</label>
  <div class="controls">
    <select id="aicte_rc" name="aicte_rc" class="input-xlarge">
      <option value='AICTE'>AICTE</option>
      <option value='RC'>RC</option>
    </select>
  </div>
</div>


<!-- Select Basic -->
<div class="control-group">
  <label class="control-label">Select</label>
  <div class="controls">
    <select id="ft_pt" name="ft_pt" class="input-xlarge">
      <option value='Full Time'>Full Time</option>
      <option value='Part Time'>Part Time</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label">Exam Month</label>
  <div class="controls">
    <select id="exam_month" name="exam_month" class="input-xlarge">
   <!--   <option value='May'>May</option>-->
      <option value='Dec'>Dec</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label">Exam Year</label>
  <div class="controls">
    <select id="exam_year" name="exam_year" class="input-xlarge">
      <option value='2015'>2015</option>
    </select>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label">Subject</label>
  <div class="controls">
    <input id="subjects" name="subjects" placeholder="Subject Code" class="input-xlarge" required="" type="text">
    <p class="help-block">Tip: For multiple entries use comma (,)</p>
  </div>
</div>

<!-- Button -->
<div class="control-group">
  <label class="control-label"></label>
  <div class="controls">
    <button type='submit' id="submit" name="submit" class="btn btn-danger btn-large">Proceed</button>
  </div>
</div>
<input type='hidden' name='add_student_detainee_list_subjects' value='' />
</fieldset>
</form>
</div>
