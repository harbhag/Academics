<div class="modal hide" id="analysis_sessional_marks<?php echo $count; ?>">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">Close</button>
    <?php show_label('important','Select Sessional No.'); ?>
  </div>
  <div class="modal-body">
    
<?
$lock_data_sql_1="select * from sessionals_locks  WHERE
		course_code='".$course_code."' AND branch_code='".$branch_code."' AND
		shift='".$shift."' AND	m_code='".$m_code."' AND
		ssection='".$ssection."' AND semester='".$semester."' AND
		teacher_username='".$_SESSION['username']."' AND subject_code='".$subject_code."' AND
		aicte_rc='".$aicte_rc."' AND full_part_time='".$full_part_time."' AND backup='0' AND sessional_no='1';";
$lock_data_1 = mysql_query($lock_data_sql_1) or die(mysql_error());

$lock_data_sql_2="select * from sessionals_locks  WHERE
		course_code='".$course_code."' AND branch_code='".$branch_code."' AND
		shift='".$shift."' AND	m_code='".$m_code."' AND
		ssection='".$ssection."' AND semester='".$semester."' AND
		teacher_username='".$_SESSION['username']."' AND subject_code='".$subject_code."' AND
		aicte_rc='".$aicte_rc."' AND full_part_time='".$full_part_time."' AND backup='0' AND sessional_no='2';";
$lock_data_2 = mysql_query($lock_data_sql_2) or die(mysql_error());
$lock_data_sql_3="select * from sessionals_locks  WHERE
		course_code='".$course_code."' AND branch_code='".$branch_code."' AND
		shift='".$shift."' AND	m_code='".$m_code."' AND
		ssection='".$ssection."' AND semester='".$semester."' AND
		teacher_username='".$_SESSION['username']."' AND subject_code='".$subject_code."' AND
		aicte_rc='".$aicte_rc."' AND full_part_time='".$full_part_time."' AND backup='0' AND sessional_no='3';";
$lock_data_3 = mysql_query($lock_data_sql_3) or die(mysql_error());
#echo $lock_data_sql_1;
	
?> 
    <fieldset>
      <div id="legend" class="">
        <legend class="">Sessional No.</legend>
      </div>
    <div class="control-group">
          <!-- Select Basic -->
          <label class="control-label">Sessional No.</label>
          <div class="controls">
            <select class="input-xlarge" name='sessional_no'>

<? 
	$row_lock = mysql_fetch_assoc($lock_data_1);
	$row_lock_2 = mysql_fetch_assoc($lock_data_2);
	$row_lock_3 = mysql_fetch_assoc($lock_data_3);
	if ($row_lock['sessional_lock_status']=='1' AND $row_lock_2['sessional_lock_status']!='1' AND $row_lock_3['sessional_lock_status']!='1')
	{
		echo "<option value='1'>1</option>";
	}
	elseif ($row_lock['sessional_lock_status']=='1' AND $row_lock_2['sessional_lock_status']=='1' AND $row_lock_3['sessional_lock_status']!='1')
		{
			echo "<option value='1'>1</option><option value='2'>2</option>";
		}
	elseif ($row_lock['sessional_lock_status']=='1' AND  $row_lock_2['sessional_lock_status']=='1' AND  $row_lock_3['sessional_lock_status']=='1')
		{
			echo "<option value='1'>1</option><option value='2'>2</option><option value='3'>3</option>";
		}
	else
	{
		echo "You need to lock Sessional Marks";
	}
	?>
      </select>
          </div>
        


        <!--<label class="control-label">Remarks</label>
                
            <input class="input-xlarge" type="text" name="overall_remarks">-->

        </div>
        
       
            <div class="form-actions">
				<input type="hidden" name="analysis_sessional_marks">
              <button type="submit" class="btn btn-primary btn-danger" >Proceed</button>
            </div>
      

    </fieldset>

                                        
   
  </div>
</div>
