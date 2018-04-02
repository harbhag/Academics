<div class="modal hide" id="upload_sessional_marks<?php echo $count; ?>">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">Close</button>
    <?php show_label('important','Select Sessional Details'); ?>
  </div>
  <div class="modal-body">
    
      
    <fieldset>
      <div id="legend" class="">
        <legend class="">Sessional Detail</legend>
      </div>
    <div class="control-group">
                        <label class="control-label">Date of Sessionals (YYYY-MM-DD)</label>
		 <select class="input-xlarge" name='sessional_date'>
              
              <? $mst_dates_sql=mysql_query("select * from mst_dates where display_status='Y'");
             while($mst_dates_results=mysql_fetch_assoc($mst_dates_sql)) 
              {
				  echo "<option value='".$mst_dates_results['mst_date']."'>".$mst_dates_results['mst_date']."</option>";
				}
			?>
            </select>
			  </div>
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
?> 

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
		echo "<option value='2'>2</option>
              <option value='3'>3</option>";
	}
	elseif ($row_lock['sessional_lock_status']=='1' AND $row_lock_2['sessional_lock_status']=='1' AND $row_lock_3['sessional_lock_status']!='1')
		{
			echo "<option value='3'>3</option>";
		}
	elseif ($row_lock['sessional_lock_status']=='1' AND  $row_lock_2['sessional_lock_status']=='1' AND  $row_lock_3['sessional_lock_status']=='1')
		{
			echo "";
		}
	else
	{

		echo " <option value='1'>1</option><option value='2'>2</option><option value='3'>3</option>";
	}
	?>

            </select>
          </div>
        


        <!--<label class="control-label">Remarks</label>
                
            <input class="input-xlarge" type="text" name="overall_remarks">-->

        </div>
        
       
            <div class="form-actions">
				<input type="hidden" name="upload_sessional_marks_form_students">
              <button type="submit" class="btn btn-primary btn-danger" onclick="return confirm_action('Make sure that all the entries are correct before proceeding.')">Proceed</button>
            </div>
      

    </fieldset>

                                        
   
  </div>
</div>
