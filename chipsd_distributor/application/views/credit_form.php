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
								Dashboard
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									overview &amp; stats
								</small>
							</h1>
						</div><!-- /.page-header -->

                        <div class="row">
							<div class="col-xs-12">
								<p style="color:red;margin-left:100px;font-size:20px;"><b><?php echo "Your balance is ".$balance." chips."; ?></b></p>
                                <p style="color:green;margin-left:100px;font-size:20px;"><b><?php echo "Client's balance is ".$client_balance." chips."; ?></b></p>
                        <form action="<?php echo base_url(); ?>Distributor/withdraw_coins_client/" method="post">
                        <div class="col-xs-10" style="margin:10px;">
                            <div class="form-group">
                                        <input type="hidden" name="client_id" value="<?php echo $dists['client_id']; ?>">
                                    
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Client Name </label>
                                
										<div class="col-sm-9">
											<input type="text" id="form-field-1" value="<?php echo $dists['client_name']; ?>" class="col-xs-10 col-sm-5" name="client_name" readonly/>
										</div>
									</div>
                                    </div>
                                    
                                    
                                    <div class="col-xs-10" style="margin:10px;">
                                    <div class="form-group">

										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Chips To add </label>

										<div class="col-sm-9">
											<input type="number" id="form-field-1" placeholder="" class="col-xs-10 col-sm-5" name="client_add"/>
										</div>
									</div>
                                    </div>

                                    <div class='col-md-8' style="margin:10px;">
                                    
                                        <div class="col-md-4 text-center">
                                    <input type="submit" name="sub_chips" class="btn btn-primary" value="Take Coins">
                                    </div>
                                    </div>
                                    </form>
                                    </div>
                                    </div>





                                            </tbody>


    <?php include('admin/footer.php'); ?>
