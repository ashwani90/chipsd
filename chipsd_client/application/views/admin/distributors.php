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
                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th class="center">
														<label class="pos-rel">
															<input type="checkbox" class="ace" />
															<span class="lbl"></span>
														</label>
													</th>
													<th class="detail-col">Name</th>
													<th>Email</th>
													<th>Image</th>
													<th>Chips</th>
                                                    <th>Balance</th>
													<th>Clients</th>
													
													<th>Coins</th>
													<th>Trans</th>
													<th>Delete</th>
													<th>Zero</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th class="center">
														<label class="pos-rel">
															<input type="checkbox" class="ace" />
															<span class="lbl"></span>
														</label>
													</th>
													<th class="detail-col">Name</th>
													<th>Email</th>
													<th>Image</th>
													<th>Chips</th>
                                                    <th>Balance</th>
													<th>Clients</th>
													
													<th>Coins</th>
													<th>Trans</th>
													<th>Delete</th>
													<th>Zero</th>
												</tr>
											</tfoot>
											<tbody>
                                            <?php foreach($dists as $dist){ ?>
                                                <tr>
                                                <td class="center">
														<label class="pos-rel">
															<input type="checkbox" class="ace" />
															<span class="lbl"></span>
														</label>
                                                        </td>
                                                <td><?php echo $dist['dist_name']; ?></td>
                                                <td><?php echo $dist['dist_email']; ?></td>
                                                <td><img src="<?php echo base_url(); ?><?php echo 'uploads/'.$dist['dist_image']; ?>" height="50px" width="150px" ></td>
                                                <td><?php echo $dist['dist_chips']; ?></td>
                                                <td><?php echo $dist['dist_balance']; ?></td>
												<td><?php echo $dist['dist_clients']; ?></td>
												
                                                <td><a class="btn btn-primary" href='<?php echo base_url(); ?>Admin/give_coins/<?php echo $dist['dist_id']; ?>'><i class="fa fa-dot-circle-o" aria-hidden="true"></i></a></td>
												<td><a class="btn btn-success" href='<?php echo base_url(); ?>Admin/see_transactions/<?php echo $dist['dist_id']; ?>'><i class="fa fa-money" aria-hidden="true"></i></a></td>
												<td><a class="btn btn-danger" href='<?php echo base_url(); ?>Admin/remove_dist/<?php echo $dist['dist_id']; ?>'><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
												<td><a class="btn btn-warning" href='<?php echo base_url(); ?>Admin/make_chips_zero/<?php echo $dist['dist_id']; ?>'><i class="fa fa-circle-o-notch" aria-hidden="true"></i></a></td>
                                                </tr>
                                            <?php } ?>
												
                                                
                                               
											
                                            </tbody>
                        

    <?php include('footer.php'); ?>