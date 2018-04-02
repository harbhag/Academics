<?php
$userid = fetch_resource_db('users',array('username'),array($_SESSION['username']),'resource_array_value','users_id');

//$ccode = fetch_resource_db('branch_code',array('users_id'),array($userid),'resource_array_value','course_code');
//$bcode = fetch_resource_db('branch_code',array('users_id'),array($userid),'resource_array_value','branch_code');

$ccode_sql = mysql_query("SELECT course_code FROM branch_code WHERE users_id='".$userid."'") or die(mysql_error());
$bcode_sql = mysql_query("SELECT branch_code FROM branch_code WHERE users_id='".$userid."'") or die(mysql_error());


$fccode = array();
$fbcode = array();

while($row = mysql_fetch_assoc($ccode_sql)) {
	$cc = $row['course_code'];
	$fccode[] = "'$cc'";
}

while($row = mysql_fetch_assoc($bcode_sql)) {
	$bc = $row['branch_code'];
	$fbcode[] = "'$bc'";
}

$lock_status = mysql_query("SELECT * FROM detainee_list WHERE detained_by='".$_SESSION['username']."' AND locked='Y' AND cleared_status='N' AND theory_practical='T'");

if(mysql_num_rows($lock_status)!=0) {
	show_label('important','Detainee List already locked by you');
	exit();
}

$ffccode = implode(",",$fccode);
$ffbcode =implode(",",$fbcode);

$branch = mysql_query("SELECT distinct branch_code,course_code FROM branch_code WHERE
branch_code IN ($ffbcode) AND 
course_code IN ($ffccode) ORDER BY course_code ASC") or die(mysql_error());

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
      <option value='1'>1</option>
      <option value='2'>2</option>
      <option value='3'>3</option>
      <option value='4'>4</option>
      <option value='5'>5</option>
      <option value='6'>6</option>
      <option value='7'>7</option>
      <option value='8'>8</option>
    </select>
  </div>
</div>


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
      <option value='May'>May</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label">Exam Year</label>
  <div class="controls">
    <select id="exam_year" name="exam_year" class="input-xlarge">
      <option value='2014'>2014</option>
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
