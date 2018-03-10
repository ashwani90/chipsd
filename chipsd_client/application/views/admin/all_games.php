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
													<th class="detail-col">Game Name</th>
                                                    <th>Table Number</th>
													<th>Players</th>
													<th>Distributors</th>
													<th>Game Details</th>
                                                   
												</tr>
											</thead>

											<tbody>
                                            <?php foreach($games['game_details'] as $dist){ ?>
                                                <tr>
                                                
												<td class="center">
												<?php
												$tra_id=$dist['game_status'];
												if($tra_id==1){
													echo "<img src='".base_url()."uploads/cross.png'>";
												}else{
													echo "<img src='".base_url()."uploads/tick.png'>";
												}
												?>
                                                        
                                                        </td>
                                                <td><?php echo $dist['game_name']; ?></td>
                                                <td><?php echo $dist['table_no']; ?></td>
                                                <td>
                                               <?php foreach($dist['player_details'] as $player){
                                                   echo '<ul>';
                                                   echo '<li>';
                                                   echo $player['player_name'];
                                                   echo '</li></ul>';
                                                   
                                                } ?>
                                                <td>
                                                <td><?php echo $dist['distributor']; ?></td>
                                                <td><a class="btn btn-primary" href='<?php echo base_url(); ?>Admin/get_game_details/<?php echo $dist['game_id']; ?>'>See Game Details</a></td>
                                                </tr>
                                            <?php } ?>
												
                                                
                                               
											
                                            </tbody>
                        

    <?php include('footer.php'); ?>