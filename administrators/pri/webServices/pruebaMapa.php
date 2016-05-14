<!DOCTYPE html>
<html>
  <head> <title>Simple Map</title>
    <meta charset="utf-8">
    <style> *{font-family:sans-serif;}
                h1 {margin: 150px 0 30px 0; text-align:center; }
                #lienzoMapa {width:800px; height:600px; margin: 0 auto; border: 5px solid; }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function(){

      var map;
      function initialize() {
        var mapOptions = {
          zoom: 4,
          center: new google.maps.LatLng(9.814103, -83.118708)
        };
        map = new google.maps.Map(document.getElementById('lienzoMapa'), mapOptions);
      }
       initialize();

      var btnMap = document.getElementById('btnMap');
      btnMap.addEventListener('click', function(){
        initialize();
      });

    });
    </script>
  </head>
  <body>
  <h1>Utiliza el mapa</h1>
    <button id="btnMap">BtnMap</button>
    <div id="lienzoMapa" ></div>
  </body>
</html>