define(["google"], function () {
    "use strict"
    var mapCanvas = document.getElementById('map'), mapOptions;
    mapCanvas.style.height = this.options.height;
    mapCanvas.style.width = this.options.width;
    mapOptions = {
        center: new google.maps.LatLng(this.options.lat, this.options.long),
        zoom: this.options.zoom,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    $.mage.googleMap = new google.maps.Map(mapCanvas, mapOptions);
    return $.mage.mapGoogle;
});
