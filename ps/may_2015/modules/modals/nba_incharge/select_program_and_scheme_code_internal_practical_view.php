<div class="modal hide" id="select_program_and_scheme_code_internal_practical_view">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">Close</button>
    <?php show_label('important','Select below Detail.'); ?>
  </div>
  <div class="modal-body">
<?php
$scheme_code = mysql_query("SELECT DISTINCT scheme_code FROM scheme_master where full_part_time='Full Time' and course_code='1'; ");
$branch_codes_sql = mysql_query("SELECT show_branch_code,show_course_code,show_semester FROM users WHERE username='".$_SESSION['username']."'") or die(mysql_error());
$branch_codes = mysql_fetch_assoc($branch_codes_sql);
	
	if($branch_codes['show_branch_code']=='ALL' && $branch_codes['show_course_code']!='ALL') {
	$branch = mysql_query("SELECT distinct branch_code,course_code FROM scheme_master WHERE 
	course_code IN (".$branch_codes['show_course_code'].")
	ORDER BY course_code ASC ;") or die(mysql_error());
	}
	elseif($branch_codes['show_branch_code']=='ALL' && $branch_codes['show_course_code']=='ALL') {
	$branch = mysql_query("SELECT distinct branch_code,course_code FROM scheme_master ORDER BY course_code ASC") or die(mysql_error());
	}
	else 
	{
	$branch = mysql_query("SELECT distinct branch_code,course_code FROM scheme_master WHERE 
	branch_code IN (".$branch_codes['show_branch_code'].") ORDER BY course_code ASC ;") or die(mysql_error());
	}

	if($branch_codes['show_semester']=='ALL') {
	$semester = mysql_query("SELECT distinct semester FROM scheme_master ORDER BY semester ASC; ") or die(mysql_error());
	}
	else 
	{
	$semester = mysql_query("SELECT distinct semester FROM scheme_master WHERE
	semester IN (".$branch_codes['show_semester'].") ORDER BY semester ASC") or die(mysql_error());
	}
?>

     <form action='' method='post'>
    <fieldset>
      <div id="legend" class="">
        <legend class="">Select Below Details</legend>
      </div>
    <div class="control-group">
			<label class="control-label">Program</label>
		
		<?
		echo "<select name='course_branch' id='course_branch' class='input-xlarge'>";
			while($row = mysql_fetch_assoc($branch)) {
						if($row['branch_code']=='' or is_null($row['branch_code'])) {
							continue;
						}
						$course_name = fetch_resource_db('course_code',array('course_code'),array($row['course_code']),'resource_array_value','course_name');
						$branch_name = fetch_resource_db('branch_code',array('branch_code'),array($row['branch_code']),'resource_array_value','branch_name');
						echo "<option value='".$row['course_code'].",".$row['branch_code']."'>".$course_name."(".$branch_name.")</option>";
					}
					echo "
					</select>";?>
					<label class="control-label">Semester</label>
					<? echo "<select name='semester' id='semester' class='input-medium'>";
          while($row = mysql_fetch_assoc($semester)) {
						if($row['semester']=='' or is_null($row['semester'])) {
							continue;
						}
						echo "<option value='".$row['semester']."'>".$row['semester']."</option>";
					}
					echo "</select>"?>
					<label class="control-label">Scheme Code</label>
					<? echo " <select name='scheme_code' id='scheme_code' class='input-medium'>";
          while($row = mysql_fetch_assoc($scheme_code)) {
						if($row['scheme_code']=='' or is_null($row['scheme_code'])) {
							continue;
						}
						echo "<option value='".$row['scheme_code']."'>".$row['scheme_code']."</option>";
					}
					echo "</select>"; ?>

       <input type='hidden' name='view_internal_practical_co_que_mapping_subject_code'  value=='asdfasd'/>
            <div class="form-actions">
              <button type="submit" class="btn btn-primary btn-danger">Proceed</button>
            </div>
      </form>

    </fieldset>
  </div>
</div>

