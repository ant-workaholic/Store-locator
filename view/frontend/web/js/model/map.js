
/**
 * Location js component.
 */
define(['jquery',
        'uiComponent',
        'ko',
        'Fastgento_Storelocator/js/actions/get_nearest',
        'Fastgento_Storelocator/js/model/markers'
    ],
    function ($, Component, ko, action, markers) {
        'use strict';
        return Component.extend({
            map: ko.observable(),
            markers: ko.observableArray([]),
            active: markers.active,
            defaults: {
                template: 'Fastgento_Storelocator/map'
            },

            /**
             * Google map component initialize.
             */
            initialize: function () {
                this._super();
                this.applyCustomBindings();
                this.handleSubscription();
            },

            /**
             * Observe an active item.
             * Subscribe to an active item,
             * click on appropriate marker.
             */
            handleSubscription: function () {
                var self = this;
                self.active.subscribe(function (newValue) {
                    var markers = self.markers();
                    for (var i = 0; i< markers.length; i++) {
                        if (markers[i]) {
                            markers[i].setIcon(null);
                            if (markers[i].title == newValue) {
                                // Click on a specific marker for current marker.
                                new google.maps.event.trigger(markers[i], 'click' );
                            }
                        }
                    }
                });
            },

            /**
             * Apply an all markers.
             *
             * @param map
             */
            applyMarkers: function (map) {
                var markersLocal = this.data.markers,
                    myLatLng = {},
                    marker,
                    content,
                    self = this;

                for (var i = 0; i <= markersLocal.length - 1; i++) {
                    myLatLng = {lat: markersLocal[i].latitude, lng: markersLocal[i].longitude};
                    marker = new google.maps.Marker({
                        position: myLatLng,
                        map: map,
                        title: markersLocal[i].title,
                        clickable: true
                    });

                    content = '<h2>' + markersLocal[i].title + '</h2>' +
                        '<div class="content">' + markersLocal[i].description + '</div>';
                    attachSecretMessage(marker, content);
                    // Add new marker to the map
                    self.markers.push(marker);
                }
                function attachSecretMessage(marker, message) {
                    var infowindow = new google.maps.InfoWindow({
                        content: message
                    });
                    marker.addListener('click', function () {
                        infowindow.open(marker.get('map'), marker);
                    });
                }
            },

            /**
             * Created a custom bind for googlmap binding
             * Specified a new bindning for a google map component.
             * data-bind="googlemap"
             */
            applyCustomBindings: function () {
                var self = this;
                ko.bindingHandlers.googlemap = {
                    init: function (element, valueAccessor) {
                        var value = valueAccessor(),
                            latLng = new google.maps.LatLng(self.data.lat, self.data.long),
                            mapOptions = {
                                zoom: self.data.zoom,
                                center: latLng,
                                mapTypeId: google.maps.MapTypeId.ROADMAP
                            };
                        self.map(new google.maps.Map(element, mapOptions));
                        self.applyMarkers(self.map());
                        var input = document.getElementById('location_search');
                        var searchBox = new google.maps.places.SearchBox(input);
                        // Bias the SearchBox results towards current map's viewport.
                        self.map().addListener('bounds_changed', function () {
                            searchBox.setBounds(self.map().getBounds());
                        });
                        var position = self.findVisitorPosition();
                    }
                };
            },

            /**
             * TODO:// Fix the visitor location implementation. This is not work for a Chrome.
             *
             * Find a visitor position.
             */
            findVisitorPosition: function() {
                var self = this, location;
                if (navigator.geolocation) {
                    var infoWindow = new google.maps.InfoWindow;
                    navigator.geolocation.getCurrentPosition(function (position, location) {
                        location = {
                            lat: function() {return position.coords.latitude},
                            lng: function() {return position.coords.longitude}
                        };
                        var pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        infoWindow.setPosition(pos);
                        infoWindow.setContent('Location found.');
                        infoWindow.open(self.map());
                        self.map().setCenter(pos);
                    }, function () {
                    });
                    return location;
                }
            },

            /**
             * Find nearest places based on location and radius
             *
             * @param location
             * @param radius
             */
            findMarkers: function (location, radius) {
                var self = this;
                action(location, radius).always(function (response) {
                    var markers = Object.keys(response[0]).map(function (key) {
                        return response[0][key];
                    });
                    var existing = self.markers();
                    var bounds = new google.maps.LatLngBounds();

                    for (var i = 0; i <= existing.length - 1; i++) {
                        if (existing[i]) {
                            existing[i].setMap(null);
                        }
                    }
                    for (var j = 0; j <= markers.length - 1; j++) {
                        if (markers[j]) {
                            var myLatLng = {lat: parseFloat(markers[j].lat), lng: parseFloat(markers[j].lng)};
                            // Create a new googlemap marker
                            var marker = new google.maps.Marker({
                                position: myLatLng,
                                map: self.map(),
                                title: markers[j].name,
                                clickable: true
                            });

                            attachSecretMessage(marker);
                            bounds.extend(myLatLng);
                            // Add new marker to the map
                            self.markers.push(marker);
                        }
                        self.map().fitBounds(bounds);
                    }
                    function attachSecretMessage(marker) {
                        marker.addListener('click', function () {
                            self.active(marker.title);
                            // TODO: Add ability to specify a marker item from admin panel.
                            marker.setIcon('https://www.google.com/mapfiles/marker_green.png');
                        });
                    }
                });
            },

            /**
             * Save location form data, search a specific markers.
             *
             * @param saveForm
             */
            save: function (saveForm) {
                var self = this;
                var geocoder = new google.maps.Geocoder();
                var saveData = {},
                    formDataArray = $(saveForm).serializeArray();
                formDataArray.forEach(function (entry) {
                    saveData[entry.name] = entry.value;
                });
                geocoder.geocode({address: saveData.q}, function (results, status) {
                    var result;
                    if (status == google.maps.GeocoderStatus.OK) {
                        result = results[0].geometry.location;
                        self.findMarkers(result, saveData.radius);
                    } else {
                        alert('Your address was not found');
                    }
                });
            }
        })
    });

