<div class="modal hide" id="upload_assignments_marks<?php echo $count; ?>">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">Close</button>
    <?php show_label('important','Select Assignment Details'); ?>
  </div>
  <div class="modal-body">
    
      
    <fieldset>
      <div id="legend" class="">
        <legend class="">Assignment Marks</legend>
      </div>
    
    
    
     <div class="control-group">
			<label class="control-label">Assignment Date</label>
		 <div class="input-append date" id="dp<?php echo rand(); ?>" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
				<input class="span2" size="16" type="text" name="assignment_date" value="<?php echo date('Y-m-d'); ?>" readonly>
				<span class="add-on"><i class="icon-calendar"></i></span>
			  </div>
			  


          <!-- Select Basic -->
          <label class="control-label">Assignment No.</label>
          <div class="controls">
            <select class="input-xlarge" name='assignment_no'>
              <option value='1'>1</option>
              <option value='2'>2</option>
              <option value='3'>3</option>
            </select>
          </div>
          
           <!--<input class="input-xlarge" type="hidden" name="assignment_no" value="1">
           <input class="input-xlarge" type="hidden" name="assignment_date" value="2013-04-27">-->
          
          <!--
          <label class="control-label">Max Marks</label>
                
            <input class="input-xlarge" type="text" name="assignment_max_marks" value="10" readonly>
            -->
            
            
            <label class="control-label">Assignment Topic</label>
                
            <input class="input-xlarge" type="text" name="assignment_topic" id="assignment_topic">
            <script>
								var assignment_topic = new LiveValidation('assignment_topic',{ validMessage: 'ok', wait: 500});
								assignment_topic.add(Validate.Presence);
						</script>
        
        
        
        </div>
        
       
            <div class="form-actions">
				<input type="hidden" name="upload_assignment_marks_form_students">
              <button type="submit" class="btn btn-primary btn-danger" onclick="return confirm_action('Make sure that all the entries are correct before proceeding.')">Proceed</button>
            </div>
      

    </fieldset>

                                        
   
  </div>
</div>
