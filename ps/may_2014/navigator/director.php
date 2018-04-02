<div class="navbar">
  <div class="navbar-inner">
    <div class="container-fluid">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <a class="brand" href="" name="top">Home</a>

      <div class="btn-group pull-left">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
          <i class="icon-folder-close"></i>Control Panel <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">

        
          <li>
            <form method="POST" action="" accept-charset="UTF-8">  
              <input type='hidden' name='fee_pending_summary' value='fee_pending_summary' />                  
              <button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Fee Pending Summary</button>
            </form>
          </li>
        
          <li>
            <form method="POST" action="" accept-charset="UTF-8">  
              <input type='hidden' name='hostel_record_summary' value='hostel_record_summary' />                  
              <button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Hostel Summary</button>
            </form>
          </li>
          <li>
            <form method="POST" action="" accept-charset="UTF-8">  
              <input type='hidden' name='student_summary' value='student_summary' />                  
              <button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Student Summary</button>
            </form>
          </li>
          
          
        </ul>
      </div>
		<ul class='nav'><li class="divider-vertical"></li></ul>
		<div class="btn-group pull-left">

		<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
			<i class="icon-folder-close"></i>Attendance <span class="caret"></span>
		</a>
		<ul class="dropdown-menu">
		  <li>
            <form method="POST" action="" accept-charset="UTF-8">  
              <input type='hidden' name='director_view_daily_attandance_form' value='director_view_daily_attandance_form' />                  
              <button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>View Daily Attendance Details</button>
            </form>
          </li>
		<li>
		<form method="POST" action="" accept-charset="UTF-8">  
		<input type='hidden' name='held_periods_detail' value='held_periods_detail'/>    
		<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Held Periods Detail</button>
		</form>
		</li>		
		<li>
		<form method="POST" action="" accept-charset="UTF-8">  
		<input type='hidden' name='view_student_attendance' value='view_student_attendance'/>    
		<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>View Student Attendance</button>
		</form>
		</li>				
		 </ul> 
       </div>
       
		<ul class='nav'><li class="divider-vertical"></li></ul>
				<div class="btn-group pull-left">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-folder-close"></i>Results <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
					<li>
					<form method="POST" action="" accept-charset="UTF-8">  
					<input type='hidden' name='result_analysis_list' value='result_analysis_list'/>                     
					<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Result Analysis End Semeter Exam</button>
					</form>
					</li>			
				</ul>			
			
      </ul>
	</div>
	<ul class='nav'><li class="divider-vertical"></li></ul>
	<div class="btn-group pull-left">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-folder-close"></i>Outcome Based Education <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li>
						<form method="POST" action="" accept-charset="UTF-8">
							<input type='hidden' name='vision_mission_peo_po' value='vision_mission_peo_po' />          
						<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Vision, Misson, PEO's,PO's</button>
						</form>
					</li>
						<li>
						<form method="POST" action="" accept-charset="UTF-8">
							<input type='hidden' name='education_faq' value='education_faq' />          
						<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i> FAQ </button>
						</form>
						</li>
						
					</ul>
				</div>
      <ul class='nav'><li class="divider-vertical"></li></ul>

      <div class="btn-group pull-right">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
          <i class="icon-user"></i><?php echo $_SESSION['fullname']; ?> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li>
            <form method="POST" action="http://ldap.gndec.ac.in" accept-charset="UTF-8" target='_blank'>          
              <button type="submit" name="submit" class="btn btn-block btn-danger"><i class="icon-wrench icon-white"></i> Change Password</button>
            </form>
          </li>
          <li>
            <form method="POST" action="" accept-charset="UTF-8">
              <input type='hidden' name='logmeout' value='logmeout' />          
              <button type="submit" name="submit" class="btn btn-block btn-danger"><i class="icon-off icon-white"></i> Logout</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
    <!--/.nav-collapse -->
  </div>
  <!--/.container-fluid -->
</div>
<!--/.navbar-inner -->
</div>
<!--/.navbar -->
<!--
<ul class="dropdown-menu">
				<li>
						<form method="POST" action="" accept-charset="UTF-8">
							<input type='hidden' name='vision_mission_peo_po' value='vision_mission_peo_po' />          
						<button type="submit" name="submit" class="btn btn-block btn-danger"><i class="icon-file icon-white"></i>Vision, Misson, PEO's,PO's</button>
						</form>
					</li>
					</ul>
				-->
