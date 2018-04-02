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
						<i class="icon-folder-close"></i>Assessment <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						
			<!--			
						<li>
						<form method="POST" action="" accept-charset="UTF-8">  
						<input type='hidden' name='upload_internals' value='internal' />                  
						<input type='hidden' name='regular_reappear' value='Regular' />                  
						<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i> Control Panel (Regular)</button>
						</form>
						</li>
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8">  
						<input type='hidden' name='upload_internals' value='internal' />                  
						<input type='hidden' name='regular_reappear' value='Reappear' />                  
						<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i> Control Panel (Reappear)</button>
						</form>
						</li>
						-->
					<li>
						<form method="POST" action="" accept-charset="UTF-8">  
						<input type='hidden' name='sessionals_module' value='internal' />                                  
						<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Sessionals</button>
						</form>
						</li>
						
						
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8">  
						<input type='hidden' name='assignments_module' value='internal' />                                  
						<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Assignments</button>
						</form>
						</li>
						
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8">  
						<input type='hidden' name='internal_practical_module' value='internal' />                                  
						<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Internal Practical</button>
						</form>
						</li>
						
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8">  
						<input type='hidden' name='attendance_marks_module' value='internal' />                                  
						<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Attendance Marks</button>
						</form>
						</li>
						
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8">  
						<input type='hidden' name='consolidated_report_theory_form' value='internal' />                                  
						<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Consolidated Report</button>
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
						<input type='hidden' name='teacher_mark_daily_attendance_theory_form' value='teacher_mark_daily_attendance_theory_form' />                  
						<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Mark Attendance (Theory)</button>
						</form>
						</li>
						
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8">                 
						<input type='hidden' name='teacher_mark_daily_attendance_form' value='teacher_mark_daily_attendance_form' />                  
						<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Mark Attendance (Practical)</button>
						</form>
						</li>
						
						
						
					<!--	
						<li>
						<form method="POST" action="" accept-charset="UTF-8">                 
						<input type='hidden' name='teacher_mark_daily_attendance_form' value='teacher_mark_daily_attendance_form' />                  
						<button type="submit" name="submit" class="btn btn-danger" data-toggle='modal' href='#select_attendance_date'><i class="icon-file icon-white"></i>Updated Daily Attendance</button>
						</form>
						</li>
						-->
						
						<!--
						<li>
						<form method="POST" action="" accept-charset="UTF-8">                 
						<input type='hidden' name='teacher_view_aggregate_attendance_record_theory' value='teacher_view_aggregate_attendance_record_theory' />                  
						<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Aggregate Attendance Record(Theory)</button>
						</form>
						</li>
						-->
						
					
						<!--
						<li>
						<form method="POST" action="" accept-charset="UTF-8">                 
						<input type='hidden' name='teacher_view_aggregate_attendance_record' value='teacher_view_aggregate_attendance_record' />                  
						<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Aggregate Attendance Record(Practical)</button>
						</form>
						</li>
						-->
						
					
					</ul>
				</div>
				
				<?php include('modules/modals/teacher/select_attendance_date.php'); ?>
				
				<?php //include('modules/modals/teacher/teacher_aggregate_attendance_subject.php'); ?>
				
				
				
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
						
						
						<!--
						<li>
						<form method="POST" action="" accept-charset="UTF-8"> 
						<button type="submit" name="submit" class="btn btn-danger" data-toggle='modal' href='#co_po_mapping'><i class="icon-file icon-white"></i>View CO PO Mapping</button> 
						</form>
						</li>
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8"> 
						<button type="submit" name="submit" class="btn btn-danger" data-toggle='modal' href='#po_peo_mapping'><i class="icon-file icon-white"></i>View PO PEO Mapping</button> 
						</form>
						</li>
											
						
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8">  
						<button type="submit" name="submit" class="btn btn-danger" data-toggle='modal' href='#select_program_and_scheme_code_sessional_view'><i class="icon-file icon-white"></i>View Questions/CO Mapping (Sessionals)</button>
						</form>
						</li>
						
					
						
						<form method="POST" action="" accept-charset="UTF-8">  
						<button type="submit" name="submit" class="btn btn-danger" data-toggle='modal' href='#select_program_and_scheme_code_assignment_view'><i class="icon-file icon-white"></i>View Questions/CO Mapping (Assignment)</button>
						</form>
						</li>
						
						
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8">  
						<button type="submit" name="submit" class="btn btn-danger" data-toggle='modal' href='#select_program_and_scheme_code_internal_practical_view'><i class="icon-file icon-white"></i>View Questions/CO Mapping (Internal Practical)</button>
						</form>
						</li>
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8"> 
						<button type="submit" name="submit" class="btn btn-danger" data-toggle='modal' href='#calculate_attainment_course_outcomes'><i class="icon-file icon-white"></i>View Attainment (Course Outcomes)</button> 
						</form>
						</li>
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8"> 
						<button type="submit" name="submit" class="btn btn-danger" data-toggle='modal' href='#calculate_attainment_subjectwise'><i class="icon-file icon-white"></i>View Attainment (Subject Wise)</button> 
						</form>
						</li>
						-->
						
						
					
					
						<li>
						<form method="POST" action="" accept-charset="UTF-8">
							<input type='hidden' name='education_faq' value='education_faq' />          
						<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i> FAQ </button>
						</form>
						</li>
						
					</ul>
				</div>
				
				
				
				
				
				
				
				
				
				
				
				<?php include('modules/modals/nba_incharge/select_program_and_scheme_code_sessional_view.php'); ?>
				<?php include('modules/modals/nba_incharge/select_program_and_scheme_code_assignment_view.php'); ?>
				<?php include('modules/modals/nba_incharge/select_program_and_scheme_code_internal_practical_view.php'); ?>
				<?php include('modules/modals/nba_incharge/po_peo_mapping.php'); ?>
				<?php include('modules/modals/nba_incharge/co_po_mapping.php'); ?>
				
				<?php include('modules/modals/nba_incharge/calculate_attainment_subjectwise.php'); ?>
				<?php include('modules/modals/nba_incharge/calculate_attainment_course_outcomes.php'); ?>
				
				
				
				
				
				
				
				
				
							
				
				
				<ul class='nav'><li class="divider-vertical"></li></ul>
				
				<div class="btn-group pull-right">
					<span style='font-size:15px;font-weight:bold'>(<?php echo date("d/m/Y g:i a"); ?>)</span>
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
