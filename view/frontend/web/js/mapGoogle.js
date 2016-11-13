/**
 * Copyright © 2016 Fastgento. All rights reserved.
 * See COPYING.txt for license details.
 */
/*jshint jquery:true*/
define(["jquery",
        "mage/translate",
        "jquery/ui"
], function ($, $t) {
    "use strict"

    $.widget('mage.mapGoogle',{
        options: {
            mapCanvas: '#map'
        },

        /**
         * Create map widget
         *
         * @returns {exports.Map}
         * @private
         */
        _create: function() {
            var mapOptions, googleMap;
            $(this.options.mapCanvas).height(this.options.height);
            $(this.options.mapCanvas).width(this.options.width);

            mapOptions = {
                center: new google.maps.LatLng(this.options.lat, this.options.long),
                zoom: this.options.zoom,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            googleMap = new google.maps.Map($(this.options.mapCanvas)[0], mapOptions);
            this._initMarkers(googleMap);
            return googleMap;
        },

        /**
         * Init markers data
         *
         * @param googleMap
         * @private
         */
        _initMarkers: function(googleMap) {
            var markers = this.options.markers, myLatLng = {}, markersArr = [], marker;
            for (var i = 0; i <= markers.length - 1; i++) {
                myLatLng = {lat: markers[i].latitude, lng: markers[i].longitude};

                var contentString = '<div id="content">'+
                    '<div id="siteNotice">'+
                    '</div>'+
                    '<h1 id="firstHeading" class="firstHeading">Uluru</h1>'+
                    '<div id="bodyContent">'+
                    '<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large ' +
                    'sandstone rock formation in the southern part of the '+
                    'Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) '+
                    'south west of the nearest large town, Alice Springs; 450&#160;km '+
                    '(280&#160;mi) by road. Kata Tjuta and Uluru are the two major '+
                    'features of the Uluru - Kata Tjuta National Park. Uluru is '+
                    'sacred to the Pitjantjatjara and Yankunytjatjara, the '+
                    'Aboriginal people of the area. It has many springs, waterholes, '+
                    'rock caves and ancient paintings. Uluru is listed as a World '+
                    'Heritage Site.</p>'+
                    '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">'+
                    'https://en.wikipedia.org/w/index.php?title=Uluru</a> '+
                    '(last visited June 22, 2009).</p>'+
                    '</div>'+
                    '</div>';

                var infowindow = new google.maps.InfoWindow({
                    content: contentString
                });

                marker = new google.maps.Marker({
                    position: myLatLng,
                    map: googleMap,
                    title: markers[i].title
                });

                marker.addListener('click', function() {
                    infowindow.open(map, marker);
                });

                // Add new marker to the map
                markersArr.push(marker);
            }
        }
    });
    return $.mage.mapGoogle
});
