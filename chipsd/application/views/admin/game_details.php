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
														Player Name
													</th>
													<th>Player Type</th>
													<th class="detail-col">Chips Won</th>
                                                    <th>Chips Lost</th>
													<th>Result</th>
													<th>Status</th>
													
                                                   
												</tr>
											</thead>

											<tbody>
                                            <?php foreach($got_game_detail['game_details'] as $dist){ ?>
                                                <tr>
                                                
												<td class="center">
												<?php
												$tra_id=$dist['player_name'];
												$tra=explode(',',$tra_id);
												
												if(count($tra)>1){
													$tra_id=$tra[0];
													$type="Distributor";
												}else{
													$type="Client";
												}
												echo $tra_id;
												?>
                                                        
                                                        </td>
												<td><?php echo $type; ?></td>
                                                <td><?php echo $dist['chips_won']; ?></td>
                                                <td><?php echo $dist['chips_lost']; ?></td>
                                                <td>
                                               <?php $total=$dist['total_chips'];
                                               if($total > 0){
                                                   $status=1;
                                                   echo "Won ".$total." chips";
                                               }else{
                                                   $status=0;
                                                   echo "Lost ".$total." chips";
                                               }
                                                 ?>
                                                
                                                <td><?php 
                                                if($status==1){
													echo "<img src='".base_url()."uploads/cross.png'>";
												}else{
													echo "<img src='".base_url()."uploads/tick.png'>";
												}
                                                ?></td>
                                                </tr>
                                            <?php } ?>
												
                                                
                                               
											
                                            </tbody>
                        

    <?php include('footer.php'); ?>