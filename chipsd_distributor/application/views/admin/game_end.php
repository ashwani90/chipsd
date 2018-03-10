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
								Make Transaction
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									overview &amp; stats
								</small>
							</h1>
						</div><!-- /.page-header -->

                        <div class="row">
													<p style="color:red;margin-top:20px;margin-left:50px;font-size:18px;"><?php if(isset($errors))
													{
														echo $errors;
													}
													 ?></p>
							<div class="col-xs-12">

                        <form action="<?php echo base_url(); ?>Distributor/save_game_status" method="post" enctype="multipart/form-data">

                        <div class="col-xs-10" style="margin:10px;">
                            <div class="form-group">

										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Select Game </label>

                    <div class="col-sm-9">
                      <select class="col-xs-10 col-sm-5" onchange="get_clients(this.value);" name="game_id">
                      <?php foreach($games as $game)
											{
                        ?>
                        <div class="col-md-6">
                          <option value="<?php echo $game['game_id']; ?>"><?php echo $game['game_name']; ?></option>

                        </div>
											<?php
										 }
										 ?>
                    </select>
												</div>
									</div>
                                    </div>

                                        <div class='col-md-8' style="margin:10px;">
                                    <div class="text-center">
                                    <input type="submit" name="finish_game" class="btn btn-primary" value="Finish Game">
                                    </div>
                                    </div>
                            </div>
                            </div>

    <?php include('footer.php'); ?>
