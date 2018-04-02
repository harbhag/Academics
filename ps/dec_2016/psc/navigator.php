
<div class="navbar">
	<div class="navbar-inner">
		
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
					<form method="POST" action="http://exam.gndec.ac.in/psc/acceptance_letter.pdf" target='_blank' accept-charset="UTF-8">                      
					<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Acceptance Letter</button>
					</form>
					</li>

					<li>
					<form method="POST" action="http://exam.gndec.ac.in/psc/outcomes.pdf" target='_blank' accept-charset="UTF-8">                      
					<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Generic Learning Outcomes</button>
					</form>
					</li>	
					
					<li>
					<form method="POST" action="http://exam.gndec.ac.in/qptemplates" target='_blank' accept-charset="UTF-8">                      
					<button type="submit" name="submit" class="btn btn-danger"><i class="icon-file icon-white"></i>Question Paper Templates</button>
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
						<form method="POST" action="" accept-charset="UTF-8">     
						<input type='hidden' name='changepassword' value='changepassword' />						
						<button type="submit" name="submit" class="btn btn-block btn-danger"><i class="icon-wrench icon-white"></i> Change Password</button>
						</form>
						</li>
						<li>
						<form method="POST" action="" accept-charset="UTF-8">
						<input type='hidden' name='logout' value='logout' />          
						<button type="submit" name="submit" class="btn btn-block btn-danger"><i class="icon-off icon-white"></i> Logout</button>
						</form>
						</li>
					</ul>
				</div>
			</div>
			<!--/.nav-collapse -->
		
		<!--/.container-fluid -->
	</div>
	<!--/.navbar-inner -->
</div>
<!--/.navbar -->
