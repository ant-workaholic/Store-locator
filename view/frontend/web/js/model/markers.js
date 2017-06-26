/**
 * Markers model.
 * This model link google map model and locations model.
 * It contains items array and active model.
 */
define(
    ['ko'],
    function (ko) {
        'use strict';
        var items = ko.observableArray([]);
        var active = ko.observable();
        return {
            items: items,
            active: active
        };
    }
);
