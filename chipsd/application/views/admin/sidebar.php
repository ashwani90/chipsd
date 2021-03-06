<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar                  responsive                    ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>

				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						<button class="btn btn-success">
							<i class="ace-icon fa fa-signal"></i>
						</button>

						<button class="btn btn-info">
							<i class="ace-icon fa fa-pencil"></i>
						</button>

						<button class="btn btn-warning">
							<i class="ace-icon fa fa-users"></i>
						</button>

						<button class="btn btn-danger">
							<i class="ace-icon fa fa-cogs"></i>
						</button>
					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
				</div><!-- /.sidebar-shortcuts -->

				<ul class="nav nav-list">
					<li class="active">
						<a href="<?php echo base_url(); ?>Admin/show_dashboard/">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Dashboard </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="<?php echo base_url(); ?>Admin/show_add_dist_form/">
							<i class="menu-icon fa fa-user"></i>
							<span class="menu-text"> Add Distributor </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="<?php echo base_url(); ?>Admin/show_distributors/">
							<i class="menu-icon fa fa-users"></i>
							<span class="menu-text"> All Distributors </span>
						</a>

						<b class="arrow"></b>
					</li>
					
					<!-- <li class="">
						<a href="<?php //echo base_url(); ?>Admin/get_client/">
							<i class="menu-icon fa fa-users"></i>
							<span class="menu-text"> All Clients </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="<?php //echo base_url(); ?>Admin/get_bets/">
							<i class="menu-icon fa fa-users"></i>
							<span class="menu-text"> All Client Bets </span>
						</a>

						<b class="arrow"></b>
					</li> -->
					<li class="">
						<a href="<?php echo base_url(); ?>Admin/every_transaction/">
							<i class="menu-icon fa fa-users"></i>
							<span class="menu-text"> Own Transactions </span>
						</a>

						<b class="arrow"></b>
					</li>
                    <li class="">
						<a href="<?php echo base_url(); ?>Admin/show_requests/">
							<i class="menu-icon fa fa-users"></i>
							<span class="menu-text"> See Requests </span>
						</a>

						<b class="arrow"></b>
					</li>
				</ul><!-- /.nav-list -->

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>