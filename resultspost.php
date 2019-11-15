<?php

$conn = mysqli_connect('mysql.hostinger.es', 'u915505518_steve', 'steve77', 'u915505518_aptee');

if (mysqli_connect_errno()) {
    printf("Falló la conexión: %s\n", mysqli_connect_error());
    exit();
}


$location = $_POST['location'];

if (!$location)
    {
    header('Location: index.php');
}

$latlng1 = mysqli_query($conn, "SELECT lat, lng FROM apteekit WHERE nimi like '%$location%' OR osoite like '%$location%' OR postinumero like '%$location%' OR kaupunki like '%$location%' limit 1 ");
  

if (mysqli_num_rows($latlng1)==0){
   
     echo "<script>
                alert('result 0, try again!');
                window.location= 'index.php'
             </script>";
}

$result = mysqli_query($conn, "SELECT DISTINCT * FROM apteekit WHERE nimi like '%$location%' OR osoite like '%$location%' OR postinumero like '%$location%' OR kaupunki like '%$location%'");


$latlng = mysqli_fetch_row($latlng1);
                        
$lat = $latlng[0]; 
$lng = $latlng[1]; 

mysqli_free_result($latlng1);

?>

    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"></script>
        <script src="https://fonts.googleapis.com/css?family=Libre+Baskerville:400,700"></script>


        <style>
            @import url("https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
            @import url('https://fonts.googleapis.com/css?family=Libre+Baskerville:400,700');

            h2 {
                float: left;
                width: 100%;
                color: #fff;
                margin-bottom: 35px;
                font-size: 14px;
                position: relartive;
                z-index: 3;
                margin-top: 30px
            }

            h2 span {
                font-family: 'arial;
                display: block;
                font-size: 23px;
                text-transform: none;
                margin-bottom: 20px;
                margin-top: 30px;
                font-weight: 700
            }

            h2 a {
                color: #fff;
                font-weight: bold;
            }

            body {
                background: #24C6DC;
                /* fallback for old browsers */
                background: -webkit-linear-gradient(to bottom, #f4511e, #24C6DC);
                /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(to bottom, #f4511e, #24C6DC);
                /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            }

            .head {
                float: left;
                width: 100%;
            }

            .search-box {
                width: 95%;
                margin: 0 auto 40px;
                box-shadow: 20px 20px 0 rgba(0, 0, 0, 0.2);
            }

            .listing-block {
                background: #1B3857;
                height: 500px;
                padding-top: 20px;
                overflow-y: scroll;
            }

            .media {
                background: #fff;
                position: relative;
                margin-bottom: 17px;
            }

            .media img {
                width: 200px;
                margin: 0;
                height: 136px;
            }

            .media-body {
                border: 1px solid #f4511e;
                height: 150px;
            }

            .media .name {
                float: left;
                width: 100%;
                font-size: 18px;
                font-weight: 600;
                color: #4765AB;
                margin-top: 8px;
            }

            .media .name small {
                display: block;
                font-size: 15px;
                color: #232323;
            }

            .media .stats {
                float: left;
                width: 100%;
                margin-top: 10px;
            }

            .media .stats span {
                float: left;
                margin-right: 10px;
                font-size: 15px;
            }

            .media .stats span i {
                margin-right: 7px;
                color: #4765AB;
            }

            .media .address {
                float: left;
                width: 100%;
                font-size: 14px;
                margin-top: 5px;
                color: #888;
            }

            .media .fav-box {
                position: absolute;
                right: 10px;
                font-size: 20px;
                top: 4px;
                color: #E74C3C;
            }

            .map-box {
                background-color: #A3CCFF;
            }

        </style>


    </head>

    <body>
        <section class="head">
            <div class="container">
                <h2 class="text-center"><span>The results for pharmacies in <u><big><font style="text-transform: capitalize;"><?php echo $location; ?></font></big></u> are:</span></h2>
            </div>
        </section>
        <div class="clearfix"></div>
        <section class="search-box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 listing-block">

                        <?php
						
         while($row = mysqli_fetch_row($result)) { 
        
                ?>
                            <!--empieza el bloque-->

                            <div class="media">
                                <form action="resultspost.php" method="post">
                                    <input type="hidden" name="lat" value="<?php print_r($row[2]); ?>">
                                    <input type="hidden" name="lng" value="<?php print_r($row[3]); ?>">
                                    <input type="hidden" name="location" value="<?php print($location); ?>">

                                    <div class="fav-box"><button type="submit" class="btn btn-danger"><i class="fa fa-map-marker fa-2x" aria-hidden="true" ></i></button>
                                    </div>
                                </form>
                                <div class="media-body pl-3">
                                    <div class="name">
                                        <?php echo $row[1]; ?>
                                    </div>
                                    <div class="stats">
                                        <span><i class="fa fa-clock-o fa-spin"></i><?php echo $row[4]; ?></span><br>
                                        <span><i class="fa fa-building"></i><?php echo $row[5]; ?>,&nbsp;
                                        <?php echo $row[6]; ?>&nbsp;<?php echo $row[7]; ?> </span><br>
                                        <span><i class="fa fa-phone"></i><?php echo $row[8]; ?></span><br>
                                        <span><i class="fa fa-globe fa-spin"></i><a href="<?php echo $row[9]; ?>">
                                        <?php echo $row[9]; ?></a></span>
                                    </div>
                                </div>

                            </div>


                            <?php
                                                   
                 }						   
      
            mysqli_free_result($result);
               mysqli_close($conn);         
                        
            ?>

                    </div>


                    <div class="col-md-6 map-box mx-0 px-0">
                        <div id="googleMap" style="height:495px;width:100%;"></div>
                        <?php 
                  if (isset($_POST['lat'])) {
					
					$lat = $_POST['lat'];
					}
				   
                  if (isset($_POST['lng'])) {
			
					$lng = $_POST['lng'];
					}

				   
           
                  ?>

                        <script>
                            function myMap() {
                                var lat = '<?php print($lat); ?>';
                                var lng = '<?php print($lng); ?>';
                                var myCenter = new google.maps.LatLng(lat, lng);
                                var mapProp = {
                                    center: myCenter,
                                    zoom: 15,
                                    scrollwheel: false,
                                    draggable: false,
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                };
                                var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
                                var marker = new google.maps.Marker({
                                    position: myCenter
                                });
                                marker.setMap(map);
                            }

                            document.write(lat)

                        </script>
                        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBH1wWN7XEpJX6fuBfkw2HI04812JwtS0&callback=myMap"></script>
                    </div>
                </div>
            </div>
        </section>
        <div class="container text-center">
            <a href="index.php" class="btn btn-danger active" role="button" aria-disabled="true">Search again!</a>
        </div>


    </body>

    </html>
