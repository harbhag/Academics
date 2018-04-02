<div class="modal hide" id="aggregate_attendance_form<?php echo $count; ?>">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">Close</button>
    <?php show_label('important','Select below the Date.'); ?>
  </div>
  <div class="modal-body">
		
     <form action='' method='post'>
    <fieldset>
      <div id="legend" class="">
        <legend class="">Attendance Record</legend>
      </div>
    <div class="control-group">
			<label class="control-label">From Start of Semester to End of Semester</label>
		 <!--<div class="input-append date" id="dp" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
				<input class="span2" size="16" id='start_date<?php echo $count; ?>' type="text" name="start_date" value="<?php echo date('Y-m-d'); ?>" readonly>
				<span class="add-on"><i class="icon-calendar"></i></span>
			  </div>

			  <label class="control-label">End Date</label>
		 <div class="input-append date" id="dp" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
				<input class="span2" size="16" id='end_date<?php echo $count; ?>' type="text" name="end_date" value="<?php echo date('Y-m-d'); ?>" readonly>
				<span class="add-on"><i class="icon-calendar"></i></span>
			  </div>-->

			   <label class="control-label">Total Lectures</label>
                
          <input class="input-xlarge" size="16" id="total_lectures<?php echo $count; ?>" type="text" name="total_lectures">
          <script>
							var total_lectures<?php echo $count; ?> = new LiveValidation('total_lectures<?php echo $count; ?>',{ validMessage: 'ok', wait: 500});
							total_lectures<?php echo $count; ?>.add(Validate.Presence,{failureMessage:'X'});
							total_lectures<?php echo $count; ?>.add(Validate.Format,{pattern: /^[0-9]+$/, failureMessage:'X'});
					</script>

          <!--<label class="control-label">Remarks</label>
                
         <input class="input-xlarge" size="16" type="text" name="overall_remarks">-->
          
        
       <input type='hidden' name='teacher_mark_aggregate_attendance_form_student' />
            <div class="form-actions">
              <button type="submit" class="btn btn-primary btn-danger" onclick="return compare_dates(<?php echo $count; ?>)">Proceed</button>
            </div>
      </form>

    </fieldset>

					
   
  </div>
</div>
