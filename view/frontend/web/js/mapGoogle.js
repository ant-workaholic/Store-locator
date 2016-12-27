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
                    '<h1 id="firstHeading" class="firstHeading">' + markers[i].title + '</h1>'+
                    '<div id="bodyContent">'+
                    '<p>' + markers[i].description + '</p>' +
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

                marker.addListener('click', function(i) {
                    infowindow.open(map, markers[i]);
                });

                // Add new marker to the map
                markersArr.push(marker);
            }
        }
    });
    return $.mage.mapGoogle
});
