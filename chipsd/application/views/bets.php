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
                        <table id="simple-table" class="table  table-bordered table-hover">
											<thead>
												<tr>
													<th class="center">
														<label class="pos-rel">
															<input type="checkbox" class="ace" />
															<span class="lbl"></span>
														</label>
													</th>
													<th class="detail-col">Amount</th>
													<th>Client Name</th>
													<th>Game Name</th>
                                                    <th>Winner</th>
                                                    <th>Declare Winner</th>
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
                                            <th class="detail-col">Amount</th>
                                            <th>Client Name</th>
                                            <th>Game Name</th>
                                            <th>Winner</th>
											<th>Declare Winner</th>
											</tr>
											</tfoot>
											<tbody>
                                            <?php
                                            $i=1;
                                            foreach($bets as $transact){

                                                ?>
                                                <tr>
                                                <td class="center">
														<label class="pos-rel">
															<input type="checkbox" class="ace" />
															<span class="lbl"></span>
														</label>
                                                        </td>
                                                
                                                <td><?php echo $transact['amount']; ?></td>
                                                <td><?php echo $transact['client_name']; ?></td>
                                                <td><?php echo $transact['game_name']; ?></td>
                                                <td><?php 
                                                 $winner=$transact['winner']; 
                                                 switch($winner)
                                                 {
                                                     case 0:
                                                     $data='Game is on';
                                                     break;
                                                     case 1:
                                                     $data='Admin Won';
                                                     break;
                                                     case 2:
                                                     $data='Client Won';
                                                     break;
                                                 }
                                                 echo $data;
                                                 ?></td>
												 <td><?php if($winner==0){?> <a href="<?php echo base_url(); ?>/Admin/declare_winner/<?php echo $transact['game_id']; ?>/<?php echo $transact['bet_id']; ?>" class="btn btn-success">Declare Winner</a><?php } ?></td>
												</tr>
                                            <?php
                                        $i++;
                                        } ?>




                                            </tbody>


    <?php include('admin/footer.php'); ?>
