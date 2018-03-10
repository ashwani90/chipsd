
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
													<th class="detail-col">Transaction No</th>
													<th>Giver</th>
													<th>Reciever</th>
													<th>Chips</th>
													<th>Table Number</th>
													<th>Type</th>
													
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
                                            <th class="detail-col">Transaction No</th>
                                            <th>Giver</th>
                                            <th>Reciever</th>
                                            <th>Chips</th>
											<th>Table Number</th>
											<th>Type</th>
											
												</tr>
											</tfoot>
											<tbody>
                                            <?php 
                                            $i=1;
                                            foreach($transactions as $transact){
                                                
                                                ?>
                                                <tr>
                                                <td class="center">
														<label class="pos-rel">
															<input type="checkbox" class="ace" />
															<span class="lbl"></span>
														</label>
                                                        </td>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $transact['transaction_reciever']; ?></td>
                                                <td><?php echo $transact['transaction_giver']; ?></td>
                                                <td><?php echo $transact['chips_amount']; ?></td>
												<td>
												<?php
												$table_name=$transact['table_no'];
												echo $table_name; 
												?>
												</td>
												<td>
												<?php
                                                $tra_type=$transact['c_to_d'];
                                                switch($tra_type)
                                                {
                                                    case '0':
                                                    echo "Given To distributor";
                                                    break;
                                                    case '1':
                                                    echo 'Given to Client';
                                                    break;
                                                    case '2':
                                                    echo "Admin Gave to client";
                                                    break;
                                                    case '3':
                                                    echo 'Admin gave to distributor';
                                                    break;

                                                }
												 
												?>
												</td>
												
                                               </tr>
                                            <?php 
                                        $i++;
                                        } ?>
												
                                                
                                               
											
                                            </tbody>
                        

    <?php include('admin/footer.php'); ?>