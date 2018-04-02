<div class="modal hide" id="select_exam_month_year<?php echo $count; ?>">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">Close</button>
    <?php show_label('important','Select Exam Month/Year'); ?>
  </div>
  <div class="modal-body">
    
      
    <fieldset>
      <div id="legend" class="">
        <legend class="">Exam Month/Year</legend>
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

        </div>
        
       
            <div class="form-actions">
							<input type='hidden' name='clear_student_detainee_list' />
              <button type="submit" class="btn btn-primary btn-danger">Proceed</button>
            </div>
      

    </fieldset>

                                        
   
  </div>
</div>
