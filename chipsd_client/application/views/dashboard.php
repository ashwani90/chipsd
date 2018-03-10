

	<?php include('admin/header.php'); ?>
	<?php include('admin/navbar.php'); ?>
	<?php include('admin/sidebar.php'); ?>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="#">Home</a>
							</li>
							<li class="active">Dashboard</li>
						</ul><!-- /.breadcrumb -->


					</div>

					<div class="page-content">

						<div class="page-header">
							<h1>
								Dashboard
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									overview &amp; stats
								</small>
							</h1>
						</div><!-- /.page-header -->
		<!-- header starts from here -->
		 
		<div class="col-md-3">
        	<a class="info-tiles tiles-green has-footer" href="#">
			    <div class="tiles-heading">
			        <div class="pull-left">Won Chips</div>
			        <div class="pull-right">
			        	<div id="tilerevenues" class="sparkline-block"><canvas width="40" height="13" style="display: inline-block; width: 40px; height: 13px; vertical-align: top;"></canvas></div>
			        </div>
			    </div>
			    <div class="tiles-body">
			        <div class="text-center"><?php if($won_chips==null){
						$won_chips=0;
					} echo $won_chips; ?></div>
			    </div>

			</a>
    	</div>
			<div class="col-md-3">
        	<a class="info-tiles tiles-blue has-footer" href="#">
			    <div class="tiles-heading">
			        <div class="pull-left">Lost Chips</div>
			        <div class="pull-right">
			        	<div id="tiletickets" class="sparkline-block"><canvas width="13" height="13" style="display: inline-block; width: 13px; height: 13px; vertical-align: top;"></canvas></div>
			        </div>
			    </div>
			    <div class="tiles-body">
			        <div class="text-center"><?php if($lost_chips==null){
						$lost_chips=0;
					} echo $lost_chips; ?></div>
			    </div>

			</a>
    	</div>
			<div class="col-md-3">
				 <a class="info-tiles tiles-midnightblue has-footer" href="#">
				 <div class="tiles-heading">
						 <div class="pull-left">Final tally</div>
						 <div class="pull-right">
							 <div id="tilemembers" class="sparkline-block"><canvas width="39" height="13" style="display: inline-block; width: 39px; height: 13px; vertical-align: top;"></canvas></div>
						 </div>
				 </div>
				 <div class="tiles-body">
						 <div class="text-center"><?php echo $final_tally; ?></div>
				 </div>

		 </a>
		 </div>
							<!-- here goes tiles -->
							<!-- second line-->
							 <div class="col-md-3">
				<a class="info-tiles tiles-inverse has-footer" href="#">
					<div class="tiles-heading">
						<div class="pull-left">Balance</div>
						<div class="pull-right">
							<div id="tileorders" class="sparkline-block"><canvas width="39" height="13" style="display: inline-block; width: 39px; height: 13px; vertical-align: top;"></canvas></div>
						</div>
				</div>
				<div class="tiles-body">
						<div class="text-center"><?php echo $balance; ?></div>
				</div>

		</a>
		</div> 
		

		<!-- header starts from here -->

					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<?php include('admin/footer.php'); ?>
