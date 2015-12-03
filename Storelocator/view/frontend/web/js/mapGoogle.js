/**
 * Copyright © 2015 Fastgento. All rights reserved.
 * See COPYING.txt for license details.
 */
/*jshint jquery:true*/
define(["jquery",
        "mage/translate",
        "google",
        "jquery/ui"
], function ($, $t) {
    "use strict"

    $.widget('mage.mapGoogle',{
        options: {
            mapCanvas: '#map'
        },
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
            return googleMap;
        }
    });
    return $.mage.mapGoogle
});
