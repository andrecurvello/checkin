<?php

define('PASSWORD','AXlABo01Tk');

if($_GET["password"] == PASSWORD) { 
    $lat = $_GET["lat"];
    $long = $_GET["long"];
    $accuracy = $_GET["accuracy"];
    $message = $_GET["message"];

    $json = array(
        "refresh" => strftime("%Hh%M %d/%m/%Y"),
        "gps_lat" => $lat,
        "gps_long" => $long,
        "accuracy" => $accuracy,
        "message" => $message,
    );

    $fp = fopen('./data/data.txt', 'w');
    fwrite($fp, json_encode($json));
    fclose($fp);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CheckIn</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
  <script type="text/javascript" src="js/gmaps.js"></script>

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <style>
            body{
              padding-top: 30px;
            }
            #map{
              display: block;
              width:  500px;
              height: 350px;
              
              -moz-box-shadow: 0px 5px 20px #ccc;
              -webkit-box-shadow: 0px 5px 20px #ccc;
              box-shadow: 0px 5px 20px #ccc;
            }
            #map.large{
              height:500px;
            }

            .overlay{
              display:block;
              text-align:left;
              color:#fff;
              font-size:60px;
              line-height:80px;
              opacity:0.8;
              background:#4477aa;
              border:solid 3px #336699;
              border-radius:4px;
              box-shadow:2px 2px 10px #333;
              text-shadow:1px 1px 1px #666;
              padding:0 4px;
            }

            .overlay_arrow{
              left:50%;
              margin-left:-16px;
              width:0;
              height:0;
              position:absolute;
            }
            .overlay_arrow.above{
              bottom:-15px;
              border-left:16px solid transparent;
              border-right:16px solid transparent;
              border-top:16px solid #336699;
            }
            .overlay_arrow.below{
              top:-15px;
              border-left:16px solid transparent;
              border-right:16px solid transparent;
              border-bottom:16px solid #336699;
            }
    </style>

  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">CheckIn</a>
          <div class="nav-collapse collapse">
          </div>
        </div>
      </div>
    </div>

    <div class="container">

        <?php
            $fp = fopen('./data/data.txt', 'r');
            $json = json_decode(fread($fp,filesize('./data/dashboard.txt')));
            fclose($fp);
        ?>


        <div class="row">
            <div class="span4">
                <p>Message: <?php echo $json->{'message'} ?> (<?php echo $json->{'refresh'} ?>)</h2></p>
            </div>
        </div>


        <div class="row">
            <div class="span6">
                      <div id="map"></div>
                 </div>
           </div>
        </div>


    </div> 

  <script type="text/javascript">
    var map;
    $(document).ready(function(){
        map = new GMaps({
            el: '#map',
            zoom: 12,
            lat: <?php echo $json->{'gps_lat'} ?>,
            lng: <?php echo $json->{'gps_long'} ?>,
        });
        map.addMarker({
            lat: <?php echo $json->{'gps_lat'}  ?>,
            lng: <?php echo $json->{'gps_long'} ?>,
        });
        map.drawCircle({
            lat: <?php echo $json->{'gps_lat'}  ?>,
            lng: <?php echo $json->{'gps_long'} ?>,
            radius: <?php echo $json->{'accuracy'} ?>,
            fillColor: '#AA0000',
            strokeColor: '#AA0000',
            strokeOpacity: 0.6,
            strokeWeight: 2
        });
    });
  </script>

  </body>
</html>
