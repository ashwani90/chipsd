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

                        <form action="<?php echo base_url(); ?>Distributor/confirm_transaction" method="post" enctype="multipart/form-data">

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
                                    <script>
                                    function get_clients(val)
                                    {
                                      var xmlhttp;
                                      if (window.XMLHttpRequest) {
                                          xmlhttp = new XMLHttpRequest();
                                          } else {
                                            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                                          }
                                          xmlhttp.onreadystatechange = function() {
                                            if (this.readyState == 4 && this.status == 200) {
                                                var data = this.responseText;
																								var data_json=JSON.parse(data);
																								var i=0;
																								var string="";

																								var table_no=data_json.table_no[0].table_no;

																								document.getElementById('table').value=table_no;
																								while(i<data_json.clients.length)
																								{
																									string+='<div class="col-md-6">';
																									string+='<option value="'+data_json.clients[i].client_id+'">';
																								string+=data_json.clients[i].client_name;
																								string+='</option></div>';
																								i++;
																							}
																							 document.getElementById('clients').innerHTML=string;
                                              }
                                              };
                                                xmlhttp.open("GET", "<?php echo base_url(); ?>Distributor/get_clients_of_game/"+val, true);
                                                xmlhttp.send();
                                    }
                                    </script>
                                    <div class="col-xs-10" style="margin:10px;">
                                        <div class="form-group">

            										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Select Client</label>

                                <div class="col-sm-9" >
																	<select class="col-xs-10 col-sm-5" name="client_name" id="clients">
																		</select>
            												</div>

            									</div>
                                                </div>

                                    <div class="col-xs-10" style="margin:10px;">
                                    <div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Chips Amount </label>

										<div class="col-sm-9">
                      <input type="number" id="form-field-1" placeholder="Chips Amount" class="col-xs-10 col-sm-5" name="chips_amount"/>
										</div>
									</div>

                                    </div>

																		<div class="col-xs-10" style="margin:10px;">
                                    <div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Table Number </label>

										<div class="col-sm-9">
                      <input type="text" id="table" placeholder="Table Number" class="col-xs-10 col-sm-5" name="table_number" readonly/>
										</div>
									</div>

                                    </div>

																		<div class="col-xs-6" style="margin:10px;">
                                    <div class="form-group alert alert-info">
																			<input type="radio" name="payment_to" value="0" style="margin:10px;" checked>Chips to distributor
																			<input type="radio" name="payment_to" value="1" style="margin:10px;">Chips to clients
									</div>

                                    </div>


                                        <div class='col-md-8' style="margin:10px;">
                                    <div class="text-center">
                                    <input type="submit" name="make_transaction" class="btn btn-primary" value="Make Transaction">
                                    </div>
                                    </div>
                            </div>
                            </div>

    <?php include('admin/footer.php'); ?>
