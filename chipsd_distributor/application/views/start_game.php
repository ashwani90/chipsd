<style type="text/css">
	.nav.ace-nav{height:5%!important;}
</style>
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
								Start A Game
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									overview &amp; stats
								</small>
							</h1>
						</div><!-- /.page-header -->

                        <div class="row">
							<div class="col-xs-12">
                        <form action="<?php echo base_url(); ?>Distributor/save_game" method="post" enctype="multipart/form-data">

                        <div class="col-xs-10" style="margin:10px;">
                            <div class="form-group">

										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Game Name </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" placeholder="Game Name" class="col-xs-10 col-sm-5" name="game_name"/>
										</div>
									</div>
                                    </div>


                                    <div class="col-xs-10" style="margin:10px;">
                                    <div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Table Name </label>

										<div class="col-sm-9">
                      <input type="text" id="form-field-1" placeholder="Table Name" class="col-xs-10 col-sm-5" name="table_name"/>
										</div>
									</div>

                                    </div>
                                    <div class="col-xs-10" style="margin:10px;">
                                    <div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Select Players </label>

										<div class="col-sm-9">
                      <?php foreach($tables as $table){
                        ?>
                        <div class="col-md-6">
                        <input type='checkbox' name='players[]' value='<?php echo $table['client_id']; ?>'><?php echo $table['client_name']; ?><br>
                        </div>
											<?php } ?>
												</div>

									</div>
                                    </div>
                                        <div class='col-md-8' style="margin:10px;">
                                    <div class="text-center">
                                    <input type="submit" name="add_game" class="btn btn-primary" value="Start Game">
                                    </div>
                                    </div>
                            </div>
                            </div>

    <?php include('admin/footer.php'); ?>
