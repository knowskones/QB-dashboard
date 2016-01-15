<?php
include  'conf.php';
include  $path.'php/util.php';
include 'functions.php';
include 'services.php';
error_reporting(E_ALL);
$username = getUser();
?>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <!--<link rel="shortcut icon" href="../images/favicon.png" type="image/png">-->

  <title>Your Seedbox Dashboard</title>

  <link rel="stylesheet" href="lib/jquery-ui/jquery-ui.css">
  <link rel="stylesheet" href="lib/Hover/hover.css">
  <link rel="stylesheet" href="lib/jquery-toggles/toggles-full.css">
  <link rel="stylesheet" href="lib/font-awesome/font-awesome.css">
  <link rel="stylesheet" href="lib/ionicons/css/ionicons.css">
  <link rel="stylesheet" href="skins/quick.css">

  <script src="lib/modernizr/modernizr.js"></script>
  <script src="lib/jquery/jquery.js"></script>
  <script type="text/javascript" src="lib/flot/jquery.flot.js"></script>
  <script type="text/javascript" src="lib/flot/jquery.flot.time.js"></script>
  <script type="text/javascript" src="lib/flot/jquery.flot.resize.js"></script>
  <script type="text/javascript" src="lib/flot/jquery.flot.canvas.js"></script>
  <script id="source" language="javascript" type="text/javascript"> 
  $(document).ready(function() { 
      var options = { 
          lines: { show: true }, 
          border: { show: true },
          points: { show: true }, 
          xaxis: { mode: "time" } 
      }; 
      var data = []; 
      var placeholder = $("#placeholder"); 
      $.plot(placeholder, data, options); 
      var iteration = 0; 
      function fetchData() { 
          ++iteration; 
          function onDataReceived(series) { 
              // we get all the data in one go, if we only got partial 
              // data, we could merge it with what we already got 
              data = [ series ]; 
              $.plot($("#placeholder"), data, options); 
              fetchData(); 
          } 
          $.ajax({ 
              url: "data.php", 
              method: 'GET', 
              dataType: 'json', 
              success: onDataReceived 
          }); 
      } 
      setTimeout(fetchData, 1000); 
  }); 
  </script> 

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="../lib/html5shiv/html5shiv.js"></script>
  <script src="../lib/respond/respond.src.js"></script>
  <![endif]-->

</head>

<body>

<header>
  <div class="headerpanel">

    <div class="logopanel">
      <h2><a href="#"><img src="/img/logo.png" alt="Quick Box Seedbox" class="logo-image" height="50" /></a></h2>
    </div><!-- logopanel -->

    <div class="headerbar">

      <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>

      <div class="header-right">
        <ul class="headermenu">
          <li>
            <div class="btn-group">
              <button type="button" class="btn btn-logged">
                <span style="font-size:18px;"><?php echo "$username"; ?></span>
              </button>
            </div>
          </li>
        </ul>
      </div><!-- header-right -->
    </div><!-- headerbar -->
  </div><!-- header-->
</header>

<section>

  <div class="leftpanel">
    <div class="leftpanelinner">

      <ul class="nav nav-tabs nav-justified nav-sidebar">
        <li class="tooltips active" data-toggle="tooltip" title="Main Menu" data-placement="bottom"><a data-toggle="tab" data-target="#mainmenu"><i class="tooltips fa fa-ellipsis-h"></i></a></li>
        <li class="tooltips" data-toggle="tooltip" title="Help" data-placement="bottom"><a data-toggle="tab" data-target="#help"><i class="tooltips fa fa-question-circle"></i></a></li>
        <li class="tooltips" data-toggle="tooltip" title="Found a bug? Report it here!" data-placement="bottom"><a href="https://github.com/JMSDOnline/quick-box/issues" target="_blank"><i class="fa fa-warning"></i></a></li>
      </ul>

      <div class="tab-content">

        <!-- ################# MAIN MENU ################### -->

        <div class="tab-pane active" id="mainmenu">
          <h5 class="sidebar-title">Main Menu</h5>
          <ul class="nav nav-pills nav-stacked nav-quirk">
            <li class="active"><a href="index.php"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
            <li><a href="/rutorrent" target="_blank"><i class="fa fa-puzzle-piece"></i> <span>ruTorrent</span></a></li>
            <?php if (file_exists('.plex')) { echo "<li><a href=\"$plexURL\" target=\"_blank\"><i class=\"fa fa-play\"></i> <span>Plex</span></a></li>"; } ?>
            <li class="nav-parent nav-active">
              <a href=""><i class="fa fa-cube"></i> <span>Downloads</span></a>
              <ul class="children">
                <li><a href="/<?php echo "$username"; ?>.downloads" target="_blank">ruTorrent</a></a></li>
              </ul>
            </li>
            <li><a href="?reload=true"><i class="fa fa-refresh"></i> <span>Reload Dashboard</span></a></li>
          </ul>
        </div><!-- tab pane -->

        <div class="tab-pane" id="help">
          <!--div class="sidebar-btn-wrapper">
            <a href="#" class="btn btn-danger btn-block">testing-I-Am-Hidden</a>
          </div-->

          <h5 class="sidebar-title">Quick Tips</h5>
          <ul class="nav nav-pills nav-stacked nav-quirk nav-mail">
            <li style="padding: 7px"><span style="font-size: 12px; color:#eee">createSeedboxUser</span><br/>
            <small>Type this command in ssh to create a new seedbox user on your server.</small></li>
            <li style="padding: 7px"><span style="font-size: 12px; color:#eee">deleteSeedboxUser</span>
            <br/>
            <small>Type this command in ssh to delete a seedbox user on your server. You will need to enter the users account name, you will be prompted.</small></li>
            <li style="padding: 7px"><span style="font-size: 12px; color:#eee">setdisk</span><br/>
            <small>During the install of your seedbox, a quota system was arranged. Type in the above command to allocate space to a users account.</small></li>
            <li style="padding: 7px"><span style="font-size: 12px; color:#eee">reload</span><br/>
            <small>Type this command in ssh to reload all services on your seedbox. These services include rTorrent and IRSSI.</small></li>
            <li style="padding: 7px"><span style="font-size: 12px; color:#eee">restartSeedbox</span><br/>
            <small>Type this command in ssh to restart your seedbox services, ie; rTorrent and IRSSI.</small></li>
          </ul>
        </div><!-- tab-pane -->

      </div><!-- tab-content -->

    </div><!-- leftpanelinner -->
  </div><!-- leftpanel -->

  <div class="mainpanel">

    <!--<div class="pageheader">
      <h2><i class="fa fa-home"></i> Dashboard</h2>
    </div>-->

    <div class="contentpanel">

      <div class="row">
        <div class="col-sm-8 col-md-8 dash-left">
          <div class="col-sm-7 col-md-7">
            <div class="panel panel-default list-announcement">
              <div class="panel-heading">
                <h4 class="panel-title">Service Status</h4>
              </div>
              <div class="panel-body">
                <ul class="list-unstyled mb20">
                  <li>
                    <?php echo "$rval"; ?>
                  </li>
                  <li>
                    <?php echo "$ival"; ?>
                  </li>
                  <li>
                    <?php echo "$bval"; ?>
                  </li>
                  <li>
                    <?php echo "$pval"; ?>
                  </li>
                </ul>
              </div>
              <div class="panel-footer"></div>
            </div>
          </div>
          <div class="col-sm-5 col-md-5">
            <div class="panel panel-default list-announcement">
              <div class="panel-heading">
                <h4 class="panel-title">Service Controller</h4>
              </div>
              <div class="panel-body">
                <ul class="list-unstyled mb20">
                  <li>
                    <?php echo "$notready"; ?>
                  </li>
                  <li>
                    <?php echo "$notready"; ?>
                  </li>
                  <li>
                    <?php echo "$notready"; ?>
                  </li>
                  <li>
                    <?php echo "$notready"; ?>
                  </li>
                </ul>
              </div>
              <div class="panel-footer"></div>
            </div>
          </div>

          <!--div class="row">
            <div class="col-sm-12 col-md-12">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">Graph</h4>
                </div>
                <div class="panel-body text-center">
                    <div id="snd_result"></div>
                    <canvas id="snd_graph" height="100" width="500"></canvas>
                    <br><br>
                    <div id="rec_result"></div>
                    <canvas id="rec_graph" height="100" width="500"></canvas>
                    </div>
              </div>
            </div>
          </div-->
        </div><!-- col-md-8 -->

        <div class="col-md-4 col-lg-4 dash-right">
          <div class="row">
            <div class="col-sm-4 col-md-12 col-lg-6">
              <div class="panel panel-inverse">
                <div class="panel-heading">
                  <h4 class="panel-title">System Info</h4>
                </div>
                <div class="panel-body">
                  <p class="nomargin">Your IP: <span style="font-weight: 700; position: absolute; left: 90px;"><?php echo $_SERVER["REMOTE_ADDR"];; ?></span></p>
                  <p class="nomargin">Uptime: <span style="font-weight: 700; position: absolute; left: 90px;"><?php echo "$uptime"; ?></span></p>
                  <p class="nomargin">Load: <span style="font-weight: 700; position: absolute; left: 90px;"><?php echo "$load[0]"; ?></span></p>
                  <div class="row">
             
                  </div>
                  <hr />
                </div>
              </div><!-- col-md-12 -->
            
            </div><!-- row -->

          </div><!-- col-md-4 -->

        </div>
      </div><!-- row -->


      <div class="row">
        <div class="col-sm-8 col-md-8">
          <div class="panel panel-inverse">
            <div class="panel-heading">
              <h4 class="panel-title">Bandwidth Data</h4>
            </div>
            <div class="panel-body text-center">
              <div id="placeholder" style="width:100%;height:200px;"></div> 
            </div>
            <div class="row panel-footer panel-statistics mt10">
              <div class="col-sm-6">
                <div class="panel panel-success-full panel-updates">
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-xs-7 col-lg-8">
                        <h4 class="panel-title text-success">Data Sent</h4>
                        <h3><div id="snd_result"></div></h3>
                        <p>This is your upload speed</p>
                      </div>
                      <div class="col-xs-5 col-lg-4 text-right">
                        <i class="fa fa-cloud-upload" style="font-size: 90px"></i>
                      </div>
                    </div>
                  </div>
                </div><!-- panel -->
              </div><!-- col-sm-6 -->

              <div class="col-sm-6">
                <div class="panel panel-primary-full panel-updates">
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-xs-7 col-lg-8">
                        <h4 class="panel-title text-success">Data Received</h4>
                        <h3><div id="rec_result"></div></h3>
                        <p style="color: #fff">This is your download speed</p>
                      </div>
                      <div class="col-xs-5 col-lg-4 text-right">
                        <i class="fa fa-cloud-download" style="font-size: 90px"></i>
                      </div>
                    </div>
                  </div>
                </div><!-- panel -->
              </div><!-- col-sm-6 -->

            </div>
          </div>
        </div>

        <div class="col-md-4 col-lg-4 dash-right">
          <div class="row">
            <div class="col-sm-4 col-md-12 col-lg-6">
              <div class="panel panel-inverse">
                <div class="panel-heading">
                  <h4 class="panel-title">Your Disk Status</h4>
                </div>
                <div class="panel-body">
                  <p class="nomargin">Free: <span style="font-weight: 700; position: absolute; left: 70px;"><?php echo "$dffree"; ?></span></p>
                  <p class="nomargin">Used: <span style="font-weight: 700; position: absolute; left: 70px;"><?php echo "$dfused"; ?></span></p>
                  <p class="nomargin">Size: <span style="font-weight: 700; position: absolute; left: 70px;"><?php echo "$dftotal"; ?></span></p>
                  <div class="row">
                    <div class="col-xs-7 col-lg-8">
                      <!--h4 class="panel-title text-success">Disk Space</h4-->
                      <h3>Disk Space</h3>
                      <div class="progress">
                        <?php
                          if ($perused < "70") { $diskcolor="progress-bar-success"; }
                          if ($perused > "70") { $diskcolor="progress-bar-warning"; }
                          if ($perused > "90") { $diskcolor="progress-bar-danger"; }
                        ?>
                        <div style="width:<?php echo "$perused"; ?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo "$perused"; ?>" role="progressbar" class="progress-bar <?php echo $diskcolor ?>">
                          <span class="sr-only"><?php echo "$perused"; ?>% Used</span>
                        </div>
                      </div>
                      <p style="font-size:10px">You have used <?php echo "$perused"; ?>% of your total disk space</p>
                    </div>
                    <div class="col-xs-5 col-lg-4 text-right">
                        <?php
                          if ($perused < "70") { $dialcolor="dial-success"; }
                          if ($perused > "70") { $dialcolor="dial-warning"; }
                          if ($perused > "90") { $dialcolor="dial-danger"; }
                        ?>
                      <input type="text" value="<?php echo "$perused"; ?>%" class="<?php echo $dialcolor ?>">
                    </div>
                  </div>
                  <hr />
                  <h4>Torrents in rtorrent</h4>
                  <p class="nomargin">There are <b><?php echo "$rtorrents"; ?></b> torrents loaded.</p>
                </div>
              </div><!-- col-md-12 -->
            
            </div><!-- row -->

          </div><!-- col-md-4 -->

        </div>

      </div>

    </div><!-- contentpanel -->

  </div><!-- mainpanel -->

</section>

<!--script src="js/graph.js"></script-->
<script src="js/script.js"></script>

<script src="lib/jquery-ui/jquery-ui.js"></script>
<script src="lib/bootstrap/js/bootstrap.js"></script>
<script src="lib/jquery-toggles/toggles.js"></script>
<script src="lib/jquery-knob/jquery.knob.js"></script>

<script src="js/quirk.js"></script>
<!--script src="js/charts.js"></script-->

<script>
$(function() {

  // Toggles
  $('.toggle-en').toggles({
    on: true,
    height: 26
  });

  $('.toggle-dis').toggles({
    on: false,
    height: 26
  });

});
</script>
<script type="text/javascript">
$(function() {

  // Knob
  $('.dial-success').knob({
    readOnly: true,
    width: '70px',
    bgColor: '#E7E9EE',
    fgColor: '#4daf7c',
    inputColor: '#262B36'
  });

  $('.dial-warning').knob({
    readOnly: true,
    width: '70px',
    bgColor: '#E7E9EE',
    fgColor: '#e6ad5c',
    inputColor: '#262B36'
  });

  $('.dial-danger').knob({
    readOnly: true,
    width: '70px',
    bgColor: '#E7E9EE',
    fgColor: '#D9534F',
    inputColor: '#262B36'
  });

  $('.dial-info').knob({
    readOnly: true,
    width: '70px',
    bgColor: '#66BAC4',
    fgColor: '#fff',
    inputColor: '#fff'
  });

});
</script>
</body>
</html>