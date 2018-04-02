<div class="navbar">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href=""  name="top">Home</a>
				
				<div class="btn-group pull-left">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-folder-close"></i>Subject Allotment <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">			
					<?php// if($_SESSION['usertype']=='cea') { ?> 
					
					<li>
					<form method="POST" action="" accept-charset="UTF-8">  
					<input type='hidden' name='allot_subject' value='allot_subject' />                               
					<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i> Allot Subject To Faculty</button>
					</form>
					</li>
					<? //} ?>
				<!--<ul class='nav'><li class="divider-vertical"></li></ul>-->
					</ul>
				</div>
				
				<!--<ul class='nav'><li class="divider-vertical"></li></ul>

				<div class="btn-group pull-left">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-folder-close"></i>Tasks <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8">  
						<input type='hidden' name='upload_internals' value='internal' />                  
						<input type='hidden' name='regular_reappear' value='Regular' />                  
						<button type="submit" name="submit" class="btn btn-danger" data-toggle='modal' href='#select_report_type'><i class="icon-file icon-white"></i>Attendance Report</button>
						</form>
						</li>
						
						
						<!--<li>
						<form method="POST" action="" accept-charset="UTF-8">  
						<input type='hidden' name='select_internal_marks_csv_file' value='internal' />                  
						<input type='hidden' name='regular_reappear' value='Regular' />                  
						<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Select File to Upload</button>
						</form>
						</li>-->
					<!--
					</ul>
				</div>-->
				<?php include('modules/modals/course_admins/select_report_type.php'); ?>
				


				<ul class='nav'><li class="divider-vertical"></li></ul>
				
				<div class="btn-group pull-left">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-folder-close"></i>Control Panel <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">

						<li>
						<form method="POST" action="" accept-charset="UTF-8">  
						<input type='hidden' name='internal_external_strength' value='internal_external_strength' />
						<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Internal/External Filled Strength</button>
						</form>
						</li>
						
						
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8">  
						<input type='hidden' name='unlock_exam_form' value='student_exam_form_status' />
						<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Unlock Exam Form(Reappear)</button>
						</form>
						</li>
						
						
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8">  
						<input type='hidden' name='add_student_detainee_list_theory_form' value='add_student_detainee_list_form' />
						<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Add student to Detainee List (Theory)</button>
						</form>
						</li>
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8">  
						<input type='hidden' name='add_student_detainee_list_practical_form' value='add_student_detainee_list_form' />
						<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Add student to Detainee List (Practical)</button>
						</form>
						</li>
						
						
					
						<li>
						<form method="POST" action="" accept-charset="UTF-8">  
						<input type='hidden' name='view_detainee_list_form' value='view_detainee_list_form' />
						<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>View Detainee/Cleared List</button>
						</form>
						</li>
					
					
					</ul>
				</div>
				

				<ul class='nav'><li class="divider-vertical"></li></ul>
				
				<div class="btn-group pull-left">
					<a class="btn" href="files/docs/instruction_admin.pdf" target="_blank">
						<i class="icon-file icon-reverse"></i>Instruction Sheet
					</a>
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
