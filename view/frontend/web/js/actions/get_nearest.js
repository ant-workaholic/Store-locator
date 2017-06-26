/**
 * This action makes request to search location service.
 *
 */
define(
    [
        'ko',
        'jquery',
        'mage/storage',
        'mage/translate',
        'Fastgento_Storelocator/js/model/markers',
        'Fastgento_Storelocator/js/model/locations'
    ],
    function (
        ko,
        $,
        storage,
        $t,
        markers,
        locations
    ) {
        'use strict';
        return function (data, radius) {
            return storage.get(
                'rest/V1/locations/nearest/lat/'+ data.lat() + '/lng/' + data.lng() + '/dst/' + radius
            ).done(
                function (response) {
                    var result = Object.keys(response[0]).map(function (key) { return response[0][key]; });
                    markers.items.removeAll();
                    for (var i=0; i < result.length; i++) {
                        markers.items.push(result[i]);
                    }
                    return result;
                }
            ).fail(
                function (response) {
                }
            );
        };
    }
);
