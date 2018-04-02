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
						<i class="icon-folder-close"></i>Control Panel<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">			
					
					<li>
					<form method="POST" action="" accept-charset="UTF-8">  
					<input type='hidden' name='time_table_subject_allotment' value='time_table_subject_allotment' />
					<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Time Table Subject Allotement</button>
					</form>
					</li>
				
				
								<li>
					<form method="POST" action="" accept-charset="UTF-8">  
					<input type='hidden' name='time_table_subject_list' value='time_table_subject_list'/>                               
					<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Time Table Subject Alloted List</button>
					</form>
					</li>
					
				<li>
					<form method="POST" action="" accept-charset="UTF-8">  
					<input type='hidden' name='student_section_group_allotment' value='student_section_group_allotment' />
					<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i> Student Section/Group Allotement</button>
					</form>
					</li> 
					
					<li>
					<form method="POST" action="" accept-charset="UTF-8">  
					<input type='hidden' name='student_elective_subject_allotment' value='student_elective_subject_allotment' />
					<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i> Student Elective Subject Allotement</button>
					</form>
					</li> 
			
					<li>
					<form method="POST" action="" accept-charset="UTF-8">  
					<input type='hidden' name='fee_pending_report_form' value='fee_pending_report_form'/>                     
					<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Fee Pending Report</button>
					</form>
					</li>	
					<li>
					<form method="POST" action="" accept-charset="UTF-8">  
					<input type='hidden' name='student_summary_list_form' value='student_summary_list_form'/>                     
					<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Student Summary List</button>
					</form>
					</li>	
					
					<li>
					<form method="POST" action="" accept-charset="UTF-8">  
					<input type='hidden' name='unlock_sessional_marks' value='unlock_sessional_marks'/>                     
					<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Unlock Sessional Marks</button>
					</form>
					</li>	
					
					
					
					<li>
					<form method="POST" action="" accept-charset="UTF-8">  
					<input type='hidden' name='unlock_consolidated_reports' value='unlock_consolidated_reports'/>                     
					<button type="submit" name="submit" class="btn btn-danger" data-toggle='modal' href='#unlock_consolidated_report'><i class="icon-file icon-white"></i>Unlock Consolidated Report</button>
					</form>
					</li>	
					
					
					</ul>
				
				</div>
				
				<?php include('modules/modals/academic_incharge/unlock_consolidated_report.php'); ?>
					
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
						<input type='hidden' name='academic_inchange_generate_attendance_summary_sheet_form' value='academic_inchange_generate_attendance_summary_sheet_form' />                  
						<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Generate Summary Sheet</button>
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
