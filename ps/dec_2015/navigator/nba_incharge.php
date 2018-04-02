<div class="navbar">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<?php include('modules/modals/teacher/select_attendance_date.php'); ?>
			<a class="brand" href=""  name="top">Home</a>
				
				<ul class='nav'><li class="divider-vertical"></li></ul>
				
				<div class="btn-group pull-left">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-folder-close"></i>Add Mapping <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8">  
						<button type="submit" name="submit" class="btn btn-danger" data-toggle='modal' href='#add_peo_po_mapping'><i class="icon-file icon-white"></i>Add PEO/PO Mapping</button>
						</form>
						</li>
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8">  
						<button type="submit" name="submit" class="btn btn-danger" data-toggle='modal' href='#add_course_outcomes'><i class="icon-file icon-white"></i>Add Course Outcomes</button>
						</form>
						</li>
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8">  
						<button type="submit" name="submit" class="btn btn-danger" data-toggle='modal' href='#select_program_and_scheme_code_sessional'><i class="icon-file icon-white"></i>Add Questions/CO Mapping (Sessionals)</button>
						</form>
						</li>
						
					
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8">  
						<button type="submit" name="submit" class="btn btn-danger" data-toggle='modal' href='#select_program_and_scheme_code_assignment'><i class="icon-file icon-white"></i>Add Questions/CO Mapping (Assignment)</button>
						</form>
						</li>
						
					
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8">  
						<button type="submit" name="submit" class="btn btn-danger" data-toggle='modal' href='#select_program_and_scheme_code_internal_practical'><i class="icon-file icon-white"></i>Add Questions/CO Mapping (Internal Practical)</button>
						</form>
						</li>
						
						
						
			
					
					</ul>
				</div>
				
				
				
				
				
				<ul class='nav'><li class="divider-vertical"></li></ul>
				
				<div class="btn-group pull-left">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-folder-close"></i>View Mapping<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						
					
						
						
						
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
						<button type="submit" name="submit" class="btn btn-danger" data-toggle='modal' href='#co_po_mapping'><i class="icon-file icon-white"></i>View CO PO Mapping</button> 
						</form>
						</li>
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8"> 
						<button type="submit" name="submit" class="btn btn-danger" data-toggle='modal' href='#po_peo_mapping'><i class="icon-file icon-white"></i>View PO PEO Mapping</button> 
						</form>
						</li>
					
					</ul>
				</div>
				
				
				
				
				
				<ul class='nav'><li class="divider-vertical"></li></ul>
				
				<div class="btn-group pull-left">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-folder-close"></i>Attainment<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8"> 
						<button type="submit" name="submit" class="btn btn-danger" data-toggle='modal' href='#nba_calculate_attainment_complete'><i class="icon-file icon-white"></i>Calculate Attainment</button> 
						</form>
						</li>
						
						<?php if($_SESSION['username']=='cea') { ?>
						<li>
						<form method="POST" action="" accept-charset="UTF-8"> 
						<input type='hidden' name='view_combined_attainment_form' value='view_combined_attainment' />
						<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i> View Combined Attainment</button>
						</form>
						</li>
						<?php } ?>
						
						
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
						
						
						
						<li>
						<form method="POST" action="" accept-charset="UTF-8"> 
						<button type="submit" name="submit" class="btn btn-danger" data-toggle='modal' href='#calculate_attainment'><i class="icon-file icon-white"></i>View Attainment (Complete)</button> 
						</form>
						</li>
						
						
					
					</ul>
				</div>
				
				
				
				
				<?php include('modules/modals/nba_incharge/add_course_outcomes.php'); ?>
				<?php include('modules/modals/nba_incharge/po_peo_mapping.php'); ?>
				<?php include('modules/modals/nba_incharge/add_peo_po_mapping.php'); ?>
				<?php include('modules/modals/nba_incharge/co_po_mapping.php'); ?>
				<?php include('modules/modals/nba_incharge/select_program_and_scheme_code_sessional.php'); ?>
				<?php include('modules/modals/nba_incharge/select_program_and_scheme_code_sessional_view.php'); ?>
				
				<?php include('modules/modals/nba_incharge/select_program_and_scheme_code_assignment.php'); ?>
				<?php include('modules/modals/nba_incharge/select_program_and_scheme_code_assignment_view.php'); ?>
				
				<?php include('modules/modals/nba_incharge/select_program_and_scheme_code_internal_practical.php'); ?>
				<?php include('modules/modals/nba_incharge/select_program_and_scheme_code_internal_practical_view.php'); ?>
				
				<?php include('modules/modals/nba_incharge/calculate_attainment.php'); ?>
				<?php include('modules/modals/nba_incharge/calculate_attainment_subjectwise.php'); ?>
				<?php include('modules/modals/nba_incharge/calculate_attainment_course_outcomes.php'); ?>
				<?php include('modules/modals/nba_incharge/nba_calculate_attainment_complete.php'); ?>
				
				
				
				
				
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
