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
                        <table id="simple-table" class="table  table-bordered table-hover">
											<thead>
												<tr>
													<th>S No.</th>
													<th>Client Name</th>
													<th>Amount</th>
													<th>Prize</th>
													
                                                </tr>
											</thead>
											<tfoot>
												<tr>
                                                
                                            <th>S No.</th>
                                            <th>Client Name</th>
													<th>Amount</th>
                                                    <th>Prize</th>
                                                    
													
												</tr>
											</tfoot>
											<tbody>
                                            <?php
                                            $i=1;
                                            foreach($withs as $transact){

                                                ?>
                                                <tr>
                                               
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $transact['client_name']; ?></td>
                                                <td><?php echo $transact['amount']; ?></td>
                                                <td><?php echo $transact['prize']; ?></td>
                                                
                                               </tr>
                                            <?php
                                        $i++;
                                        } ?>




                                            </tbody>


    <?php include('admin/footer.php'); ?>
