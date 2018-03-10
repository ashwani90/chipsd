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
						<p style="color:red;font-size:25px;"><?php
						if(isset($errors)){
						echo $errors;} ?></p>
                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
											<thead>
												<tr>
													
													<th>Name</th>
													<th>Email</th>
													<th>Image</th>
													<th>Balance</th>
													<th>Clients</th>
													
													<th>Report</th>
													<th>Deposit</th>
													<th>Withdraw</th>
													<th>Reset</th>
													
												</tr>
											</thead>
											<tfoot>
												<tr>
													
													<th>Name</th>
													<th>Email</th>
													<th>Image</th>
													<th>Balance</th>
													<th>Clients</th>
													
													<th>Report</th>
													<th>Deposit</th>
													<th>Withdraw</th>
													<th>Reset</th>
													
												</tr>
											</tfoot>
											<tbody>
                                            <?php foreach($dists as $dist){ ?>
                                                <tr>
                                                
                                                <td><?php echo $dist['dist_name']; ?></td>
                                                <td><?php echo $dist['dist_email']; ?></td>
                                                <td><img src="<?php echo base_url(); ?><?php echo 'uploads/'.$dist['dist_image']; ?>" height="50px" width="150px" ></td>
                                                <td><?php echo $dist['dist_balance']; ?></td>
												<!-- <td><?php //echo $dist['dist_clients']; ?></td> -->
												<td><a class="btn btn-warning" href='<?php echo base_url(); ?>Admin/see_clients/<?php echo $dist['dist_id']; ?>'>C</a></td>
												
                                                <!-- <td><a class="btn btn-primary" href='<?php echo base_url(); ?>Admin/give_coins/<?php echo $dist['dist_id']; ?>'><i class="fa fa-dot-circle-o" aria-hidden="true"></i></a></td> -->
												<td><a class="btn btn-success" href='<?php echo base_url(); ?>Admin/see_transactions/<?php echo $dist['dist_id']; ?>'>R</i></a></td>
												<td><a class="btn btn-danger" href='<?php echo base_url(); ?>Admin/add_coins_dist/<?php echo $dist['dist_id']; ?>'>D</a></td>
												<td><a class="btn btn-warning" href='<?php echo base_url(); ?>Admin/take_coins/<?php echo $dist['dist_id']; ?>'>W</a></td>
                                                <td><a class="btn btn-danger" href='<?php echo base_url(); ?>Admin/reset_password/<?php echo $dist['dist_id']; ?>'>R/P</a></td>
                                                 </tr>
                                            <?php } ?>
												
                                                
                                               
											
                                            </tbody>
                        

    <?php include('footer.php'); ?>