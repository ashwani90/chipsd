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

						<div class="nav-search" id="nav-search">
							<form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="ace-icon fa fa-search nav-search-icon"></i>
								</span>
							</form>
						</div><!-- /.nav-search -->
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
                        

                        <form action="<?php echo base_url(); ?>Admin/add_winner/<?php echo $game_id.'/'.$bet_id; ?>" method="post" enctype="multipart/form-data">
                        
                        <div class="col-xs-10" style="margin:10px;">
                            <div class="form-group">
                            
										<label class="col-sm-3 control-label no-padding-right"> Select Winner </label>

										<div class="col-sm-9">
                                        <input type="radio" name="winner" value='2'>Client
                                        <input type="radio" name="winner" value='1'>Admin
											</div>
									</div>
                                    </div>
                                    <div class='col-md-8' style="margin:10px;">
                                    <div class="text-center">
                                    <input type="submit" name="declare_winner" class="btn btn-primary" value="Declare Winner">
                                    </div>
                                    </div>
                                    </form>


    <?php include('admin/footer.php'); ?>
