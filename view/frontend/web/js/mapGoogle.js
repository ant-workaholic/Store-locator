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

            var address = this.options.country;
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode( { 'address': address}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    googleMap.setCenter(results[0].geometry.location);
                    googleMap.fitBounds(results[0].geometry.bounds);
                } else {
                    alert("Geocode was not successful for the following reason: " + status);
                }
            });

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
            var markers = this.options.markers,
                myLatLng = {},
                markersArr = [],
                marker,
                content;

            for (var i = 0; i <= markers.length - 1; i++) {
                myLatLng = {lat: markers[i].latitude, lng: markers[i].longitude};
                marker = new google.maps.Marker({
                    position: myLatLng,
                    map: googleMap,
                    title: markers[i].title,
                    clickable: true
                });

                content = '<h2>' + marker.title + '</h2>' +
                          '<div class="content">' + markers[i].description + '</div>';
                attachSecretMessage(marker, content);
                // Add new marker to the map
                markersArr.push(marker);
            }
            function attachSecretMessage(marker, message) {
                var infowindow = new google.maps.InfoWindow({
                    content: message
                });
                marker.addListener('click', function() {
                    infowindow.open(marker.get('map'), marker);
                });
            }

        }
    });
    return $.mage.mapGoogle
});
