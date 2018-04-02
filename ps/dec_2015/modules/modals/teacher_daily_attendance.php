<div class="modal hide" id="myModalDailyAttendance<?php echo $count; ?>">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">Close</button>
    <?php 
    
    show_label('important','Select below Period and Time'); 
    echo "<br/>";
   // show_label('info','Competent Authority has allowed marking of 30-01-2014 attendance today (31-01-2014)'); 
    
    $current_time = date('H:i:s');
    
    //$period_no_sql = mysql_query("SELECT period_no FROM period_time WHERE attendance_time_start<='".$current_time."' AND shift='".$shift."' AND full_part_time='".$full_part_time."'") or die(mysql_error());
    
     $allowed_date = mysql_query("SELECT attendance_date FROM attendance_allowed_date WHERE 
     allowed_till_date>='".date('Y-m-d')."' AND 
     allowed_till_time>='".date('H:i:s')."'") or die(mysql_error());
   
    
    ?>
  </div>
  <div class="modal-body">
      
    <fieldset>
      <div id="legend" class="">
        <legend class="">Daily Attendance</legend>
      </div>
    <div class="control-group">
                        
                        
     <!--This from here -->
      <label class="control-label">Date</label>
		 <div class="input-append date" id="dp<?php echo rand(); ?>" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
				<input class="span2" size="16" type="text" name="attendance_date" value="<?php echo date('Y-m-d'); ?>" readonly>
				<span class="add-on"><i class="icon-calendar"></i>
			  </div>
			  
	
		<!--to here is used to show calendar -->	  
			  


			  
			 <!--This from here -->

			
			<!--  
			
          <label class="control-label">Date</label>
          <div class="controls">
            <select class="input-xlarge" name='attendance_date'>
              <option value='<?php echo date('Y-m-d'); ?>'><?php echo date('Y-m-d'); ?></option>
             <?php
			//	while($date = mysql_fetch_assoc($allowed_date)) {
			//		echo "<option value='".$date['attendance_date']."'>".$date['attendance_date']."</option>";
					
			//	}
			//	if($_SESSION['username']=='harbhag') {
					
				//	echo "<option value='2015-11-03'>2015-11-03</option>";
					
			//	}
			?>
            </select>
          </div>
         -->
          
          <!--to here is used to show date in dropdown -->	  


          <!-- Select Basic -->
          <label class="control-label">Period</label>
          <div class="controls">
            <select class="input-xlarge" name='attendance_period' id='attendance_period'>
							
							<?php
							for($i=1;$i<=11;$i++) {
								echo "<option value='".$i."'>".$i."</option>";
							}
							?>
            </select>
          </div>
          
          
          <label class="control-label">Select Default Option</label>
          <div class="controls">
            <select class="input-xlarge" name='default_attandance'>
              <option value='Present'>Present</option>
              <option value='Absent'>Absent</option>
            </select>
          </div>

        
	<!--
    <div class="control-group">

         
          <label class="control-label">Start Time</label>
          <div class="controls">
            <select class="input-xlarge" name='start_time'>
              <option value='8:00 AM'>8:00 AM</option>
              <option value='8:30 AM'>8:30 AM</option>
              <option value='9:00 AM'>9:00 AM</option>
              <option value='9:30 AM'>9:30 AM</option>
              <option value='10:00 AM'>10:00 AM</option>
              <option value='10:30 AM'>10:30 AM</option>
              <option value='11:00 AM'>11:00 AM</option>
              <option value='11:30 AM'>11:30 AM</option>
              <option value='12:00 PM'>12:00 PM</option>
              <option value='12:30 PM'>12:30 PM</option>
              <option value='01:00 PM'>01:00 PM</option>
              <option value='01:30 PM'>01:30 PM</option>
              <option value='02:00 PM'>02:00 PM</option>
              <option value='02:30 PM'>02:30 PM</option>
              <option value='03:00 PM'>03:00 PM</option>
              <option value='03:30 PM'>03:30 PM</option>
              <option value='04:00 PM'>04:00 PM</option>
              <option value='04:30 PM'>04:30 PM</option>
              <option value='05:00 PM'>05:00 PM</option>
              <option value='05:30 PM'>05:30 PM</option>
              <option value='06:00 PM'>06:00 PM</option>
              <option value='06:30 PM'>06:30 PM</option>
              <option value='07:00 PM'>07:00 PM</option>
              
            </select>
          </div>

        </div>

    <div class="control-group">

         
          <label class="control-label">End Time</label>
          <div class="controls">
            <select class="input-xlarge" name='end_time'>
              <option value='8:00 AM'>8:00 AM</option>
              <option value='8:30 AM'>8:30 AM</option>
              <option value='9:00 AM'>9:00 AM</option>
              <option value='9:30 AM'>9:30 AM</option>
              <option value='10:00 AM'>10:00 AM</option>
              <option value='10:30 AM'>10:30 AM</option>
              <option value='11:00 AM'>11:00 AM</option>
              <option value='11:30 AM'>11:30 AM</option>
              <option value='12:00 PM'>12:00 PM</option>
              <option value='12:30 PM'>12:30 PM</option>
              <option value='01:00 PM'>01:00 PM</option>
              <option value='01:30 PM'>01:30 PM</option>
              <option value='02:00 PM'>02:00 PM</option>
              <option value='02:30 PM'>02:30 PM</option>
              <option value='03:00 PM'>03:00 PM</option>
              <option value='03:30 PM'>03:30 PM</option>
              <option value='04:00 PM'>04:00 PM</option>
              <option value='04:30 PM'>04:30 PM</option>
              <option value='05:00 PM'>05:00 PM</option>
              <option value='05:30 PM'>05:30 PM</option>
              <option value='06:00 PM'>06:00 PM</option>
              <option value='06:30 PM'>06:30 PM</option>
              <option value='07:00 PM'>07:00 PM</option>
            </select>
          </div>

        </div>
-->

        <label class="control-label">Topics/Experiments Covered</label>
                
         <input class="input-xlarge" size="16" type="text" name="topics_covered" id="topics_covered">
         <script>
				var topics_covered = new LiveValidation('topics_covered',{ validMessage: 'ok', wait: 500});
				topics_covered.add(Validate.Presence);
				topics_covered.add( Validate.Length, { minimum: 5 } );

		</script>

        


        <!--<label class="control-label">Remarks</label>
                
                                <input class="input-xlarge" size="16" type="text" name="overall_remarks">

                          </div>-->
        
       
            <div class="form-actions">
              <button type="submit" class="btn btn-primary btn-danger" onclick="return confirm_action('Make sure that all the entries are correct before proceeding.')">Proceed</button>
            </div>
      

    </fieldset>

                                        
   
  </div>
</div>
