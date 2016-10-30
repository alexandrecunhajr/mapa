<html>
<?php
$regiao_posicao=file_get_contents("http://127.0.0.1/regiao.php");

?>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"> </script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="https://googlemaps.github.io/js-marker-clusterer/src/markerclusterer.js"></script>
<script type="text/javascript">
$(document).ready(function(){


    var regiao_posicao=<?php echo $regiao_posicao;?>;
    

    window.onload = function () {
        LoadMap();
    }
     var mapOptions = {
            center: new google.maps.LatLng('-10.192865', '-52.641719'),
            zoom: 4,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);

    function LoadMap() {
       
        var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
 
        var markers = [];
        for(var c=0;c<regiao_posicao.length;c++){
            var regiao=regiao_posicao[c].regiao;
            var desc_regiao=regiao_posicao[c].desc_regiao;
            var latitude=regiao_posicao[c].latitude;
            var longitude=regiao_posicao[c].longitude;
            var myLatlng = new google.maps.LatLng(latitude, longitude);
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: desc_regiao,
                label:regiao
            });
      
            //Attach click event to the marker.
            (function (marker, data) {
                google.maps.event.addListener(marker, "click", function (e) {
                     var regiao=this.label;
                     var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
                     mapa_distrito(regiao,map);
                       
                            // var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
                });
            })(marker, regiao_posicao);
        }

        ////////////////////
        google.maps.event.addDomListener(map,'zoom_changed', function() {
          var zoom =  map.getZoom();
        });
    }

    function mapa_distrito(regiao,map){
        $.ajax({
                            type      : 'post',
                 
                            url       : 'distrito_posicao.php',
                 
                            data      : 'nome='+regiao,
                 
                            dataType  : 'json',
                 
                            success : function(txt){
                          
                             ////////////////
                                for(var c=0;c<txt.length;c++){
                                    var distrito=txt[c].distrito;
                                    var desc_distrito=txt[c].desc_distrito;
                                    var latitude=txt[c].latitude;
                                    var longitude=txt[c].longitude;

                                
                                    var myLatlng = new google.maps.LatLng(longitude, latitude);
                                    var marker = new google.maps.Marker({
                                        position: myLatlng,
                                        map: map,
                                        title: desc_distrito,
                                        label:distrito
                                    });
                                    (function (marker,data) {
                                        var distrito=data[c].distrito;
                                        google.maps.event.addListener(marker, "click", function (e) {
                                          
                                          var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
                                          mapa_lojas(distrito,map);

                                         
                                        });
                                    }) (marker, txt);

                                }
                                /////////////////
                            }
        });
    }

    function mapa_lojas(distrito,map){
        $.ajax({
                            type      : 'post',
                 
                            url       : 'loja_posicao.php',
                 
                            data      : 'nome='+distrito,
                 
                            dataType  : 'json',
                 
                            success : function(txt){
                            var markers = [];
                             ////////////////
                                for(var c=0;c<txt.length;c++){
                                    var loja=txt[c].loja;
                                    var latitude=txt[c].latitude;
                                    var longitude=txt[c].longitude;

                                  console.log(loja);
                                    var myLatlng = new google.maps.LatLng(latitude, longitude);
                                    var marker = new google.maps.Marker({
                                        position: myLatlng,
                                        map: map,
                                        title: loja,
                                        label:loja
                                    });
                                    markers.push(marker);
                                    /*(marker, txt);*/

                                }
                                //console.log(markers);
                             //   var markerCluster = new MarkerClusterer(map, markers);
                                var markerCluster = new MarkerClusterer(map, markers, {imagePath: 'https://googlemaps.github.io/js-marker-clusterer/images/m'});


                                /////////////////
                            }
        });
    }

    
});
</script>
</head>
<body>
<div id="dvMap" style="width: 1000px; height: 600px">
</div>
</body>
</html>
