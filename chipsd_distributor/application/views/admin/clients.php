<style type="text/css">
	.nav.ace-nav{height:5%!important;}
</style>
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
                        <table id="simple-table" class="table  table-bordered table-hover">
											<thead>
												<tr>
													<th class="center">
														Status
													</th>
													<th class="detail-col">Client Name</th>
                                                    <th>Client Email</th>
													<th>Client Image</th>
													<th>Client Balance</th>
													<th>Report</th>
													<th>Deposit</th>
													<th>Withdraw</th>
													<th>Reset</th>
                                                    
												</tr>
											</thead>

											<tbody>
                                            <?php foreach($dists as $dist){ ?>
                                                <tr>

												<td class="center">
												<?php
												$tra_id=$dist['client_status1'];
												if($tra_id==0){
													echo "<img src='".base_url()."uploads/cross.png'>";
												}else{
													echo "<img src='".base_url()."uploads/tick.png'>";
												}
												?>

                                                        </td>
                                                <td><?php echo $dist['client_name']; ?></td>
                                                <td><?php echo $dist['client_email']; ?></td>

                                                <td><img src="<?php echo base_url(); ?><?php echo 'uploads/'.$dist['client_image']; ?>" height="50px" width="150px" ></td>
                                                    <td>
                                                <?php echo $dist['client_balance']; ?></td>
                                                <td><a class="btn btn-success" href='<?php echo base_url(); ?>Distributor/get_client_transactions/<?php echo $dist['client_id']; ?>'>R</i></a></td>
												<td><a class="btn btn-danger" href='<?php echo base_url(); ?>Distributor/deposit_form/<?php echo $dist['client_id']; ?>'>D</a></td>
												<td><a class="btn btn-warning" href='<?php echo base_url(); ?>Distributor/withdraw_form/<?php echo $dist['client_id']; ?>'>W</a></td>
                                                <td><a class="btn btn-danger" href='<?php echo base_url(); ?>Distributor/reset_password/<?php echo $dist['client_id']; ?>'>R/P</a></td>
												</tr>
                                            <?php } ?>




                                            </tbody>


    <?php include('footer.php'); ?>
