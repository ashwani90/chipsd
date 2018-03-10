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

						
						<p style="color:green;margin-left:100px;font-size:20px;"><?php echo "Balance : ".$balance." chips.";
							?></p>
						
                        <table id="simple-table" class="table  table-bordered table-hover">
											<thead>	
												<tr>
												<th>Date</th>
												<th>Client Name</th> 
												<th>Credit</th>
												<th>Debit</th>
												<th>Total</th>
												<th>Description</th>
												</tr>
											</thead>
											<tfoot>
											<tr>
											<th>Date</th>
											<th>Client Name</th> 
											<th>Credit</th>
											<th>Debit</th>
                                            <th>Total</th>
                                            <th>Description</th>
                                            
											</tr>
											</tfoot>
											<tbody>
                                            <?php
                                           
                                            foreach($transactions as $transact){

                                                ?>
                                                <tr>
												<td>
												<?php
												$date=$transact['trans_date'];
												$another_date=new DateTime($date);
												$mydate=$another_date->format('M d Y');
												echo $mydate;
												?>
												</td>
												<td><?php echo $client_name; ?></td>
												<?php
												$type=$transact['trans_type'];
												if($type==0){
													$op="-";
												}else{
													$op="+";
												} ?>		
                                                <td><?php if($op=="+"){echo $op."".$transact['amount'];} ?></td>
												<td><?php if($op=="-"){echo $op."".$transact['amount'];} ?></td>
                                                <td><?php echo $transact['total']; ?></td>
                                                <td><?php echo $transact['descrip']; ?></td>
                                                
												
												</tr>
                                            <?php
                                       
                                        } ?>




                                            </tbody>


    <?php include('admin/footer.php'); ?>
