<?php include('header.php'); ?>
	<?php include('navbar.php'); ?>
	<?php include('sidebar.php'); ?>
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

                        <div class="row">
							<div class="col-xs-12">
                        <form action="<?php echo base_url(); ?>Admin/add_coins_client" method="post">
                        <div class="col-xs-10" style="margin:10px;">
                            <div class="form-group">
                            
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Client Name </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" value="<?php echo $dists['client_name']; ?>" class="col-xs-10 col-sm-5" name="client_name" readonly/>
										</div>
									</div>
                                    </div>
                                    <input type="hidden" name="client_id" value="<?php echo $dists['client_id']; ?>">
                                    
                                    <input type="hidden" name="client_total" value="<?php echo $dists['client_total_chips']; ?>">
                                    <div class="col-xs-10" style="margin:10px;">
                                    <div class="form-group">
                            
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Chips To add </label>

										<div class="col-sm-9">
											<input type="number" id="form-field-1" placeholder="" class="col-xs-10 col-sm-5" name="client_add"/>
										</div>
									</div>
                                    </div>

                                    <div class='col-md-8' style="margin:10px;">
                                    <div class="text-center">
                                    <input type="submit" name="add_chips" class="btn btn-primary" value="Give Coins">
                                    </div>
                                    </div>
                                    </form>
                                    </div>
                                    </div>

												
                                                
                                               
											
                                            </tbody>
                        

    <?php include('footer.php'); ?>