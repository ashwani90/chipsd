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
														Status
													</th>
													<th class="detail-col">Client Name</th>
                                                    <th>Client Email</th>
													<th>Client Image</th>
													<th>Client Balance</th>
                                                    
                                                    <th>See Transactions</th>
                                                    <th>All Games</th>
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
                                                
                                                <td><?php echo $dist['client_balance']; ?></td>
												

												<td><a class="btn btn-success" href='<?php echo base_url(); ?>Admin/see_transactions_client/<?php echo $dist['client_id']; ?>'><i class="fa fa-money" aria-hidden="true"></i></a></td>
                                               
                                                <td><a class="btn btn-primary" href='<?php echo base_url(); ?>Admin/get_game_details/<?php echo $dist['client_id']; ?>'>G</a></td>
                                                 </tr>
                                            <?php } ?>
												
                                                
                                               
											
                                            </tbody>
                        

    <?php include('footer.php'); ?>