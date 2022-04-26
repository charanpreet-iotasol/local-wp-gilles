<?php  /** * Template Name:Multiple-Pin */
get_header(); ?>

<div id="map" style="width:100%; height: 450px; margin:auto;" ></div>
    <script>
        function initMap() { 
       
            var locations = [
                ['<strong>Laser Battle IPOH</strong> <br/>' + 'IPOH Parade<br/>' + 'Jalan Sultan, Abdul Jalil<br/>' + 'Ipoh Perak<br/>' + 'PH: +60 5-255 9887 ', -33.718234, 150.363181, 3],
                ['<strong>Laser Battle (JOHOR)</strong> <br/>' + 'Johor Bahru <br/>' + 'PH: +60 7-207 0179',-31.56391, 147.154312, 2],
                ['<strong>Charanpreet Singh</strong> <br/>' + 'Chann <br/>' + 'PH: +96 5-332 0275', 30.9010 , 75.8573 ]
            ];
            
            window.map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
            });
            
            var infowindow = new google.maps.InfoWindow();
            var bounds = new google.maps.LatLngBounds();
            for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map
                });
                bounds.extend(marker.position);
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infowindow.setContent(locations[i][0]);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            }
            map.fitBounds(bounds);
            var listener = google.maps.event.addListener(map, "idle", function() {
                map.setZoom(5);
                google.maps.event.removeListener(listener);
            });
        }
        function loadScript() {
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyABzMXJcUHuggxOokrDbkH11IcG98laXjY&callback=initMap';
            document.body.appendChild(script);
        }
        window.onload = loadScript;
    </script> 
<?php get_footer(); ?>


