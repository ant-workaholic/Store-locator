/**
 * Locations js component.
 */
define(['ko', "uiComponent", 'Fastgento_Storelocator/js/model/markers'], function(ko, Component, markers, map) {
    var self;
    return Component.extend({
        markers: markers.items,
        active: markers.active,

        /**
         * Initialize locations component
         */
        initialize: function () {
            self = this;
            this._super();
        },

        /**
         * Specify an active location.
         * Handle a click event on a specific location.
         *
         * @param element
         */
        clickHandler: function (element) {
            self.active(element.name);
        }
    });
});
