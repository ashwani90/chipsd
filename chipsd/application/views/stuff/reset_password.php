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
						
                        <div class="row">
							<div class="col-xs-12">
                        <form action="<?php echo base_url(); ?>Admin/reset_pass/<?php echo $dist['dist_id']; ?>" method="post">
                        <div class="col-xs-10" style="margin:10px;">
                            <div class="form-group">
                            
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Enter new password </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1"  class="col-xs-10 col-sm-5" name="dist_pass" />
										</div>
									</div>
                                    </div>
                                    
                                    <div class='col-md-8' style="margin:10px;">
                                    <div class="col-md-4 text-center">
                                    <input type="submit" name="reset" class="btn btn-primary" value="Reset Password">
                                    </div>
									
                                    </div>
                                    </form>
                                    </div>
                                    </div>

												
                                                
                                               
											
                                            </tbody>
                        
