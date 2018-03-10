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
														Date
													</th>
													<th>Amount</th>
													<th>Winner</th>
                                                    <th>Description</th>
													</tr>
											</thead>

											<tbody>
                                            <?php foreach($games as $dist){ ?>
                                                <tr>
                                                <td>
												<?php
												$date=$dist['date'];
												$another_date=new DateTime($date);
												$mydate=$another_date->format('M d Y');
												echo $mydate;
												?>
												</td>
												<td class="center">
												<?php
												echo $dist['amount'];
												
												?></td>
												<td><?php $winner=$dist['winner'];
														if($winner==0){
															echo "Admin Won";
														}else{
															echo "You Won";
														}
												?></td>
                                                <td><?php if($winner==0){
													"Admin Won the bet";
												}else{
													"Distributor won the bet";
												} ?></td>
                                                
                                                </tr>
                                            <?php } ?>
												
                                                
                                               
											
                                            </tbody>
                        

    <?php include('footer.php'); ?>