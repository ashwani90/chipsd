
<style type="text/css">
	.nav.ace-nav{height:5%!important;}
</style>
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
         </ul>
         <!-- /.breadcrumb -->
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
         </div>
         <!-- /.page-header -->
         <!-- here goes tiles -->
         <div class="col-md-3">
            <a class="info-tiles tiles-inverse has-footer" href="#">
               <div class="tiles-heading">
                  <div class="pull-left">All Clients</div>
                  <div class="pull-right">
                     <div id="tileorders" class="sparkline-block">
                        <canvas width="39" height="13" style="display: inline-block; width: 39px; height: 13px; vertical-align: top;"></canvas>
                     </div>
                  </div>
               </div>
               <div class="tiles-body">
                  <div class="text-center"><?php echo $clients; ?></div>
               </div>
            </a>
         </div>
         <div class="col-md-3">
            <a class="info-tiles tiles-green has-footer" href="#">
               <div class="tiles-heading">
                  <div class="pull-left">Active Clients</div>
                  <div class="pull-right">
                     <div id="tilerevenues" class="sparkline-block">
                        <canvas width="40" height="13" style="display: inline-block; width: 40px; height: 13px; vertical-align: top;"></canvas>
                     </div>
                  </div>
               </div>
               <div class="tiles-body">
                  <div class="text-center"><?php echo $ac_clients; ?></div>
               </div>
            </a>
         </div>
         
        
         <!-- here goes tiles -->
         <!-- second line-->
         <div class="col-md-3">
            <a class="info-tiles tiles-inverse has-footer" href="#">
               <div class="tiles-heading">
                  <div class="pull-left">Chips Balance</div>
                  <div class="pull-right">
                     <div id="tileorders" class="sparkline-block">
                        <canvas width="39" height="13" style="display: inline-block; width: 39px; height: 13px; vertical-align: top;"></canvas>
                     </div>
                  </div>
               </div>
               <div class="tiles-body">
                  <div class="text-center"><?php echo $balance; ?></div>
               </div>
            </a>
         </div>
         <!-- second line-->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.page-content -->
<!--</div>
</div>--><!-- /.main-content -->
<?php include('footer.php'); ?>