/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            mapGoogle: 'Fastgento_Storelocator/js/mapGoogle'
        }
    },
    paths:{
        "scroll":"Fastgento_Storelocator/js/jQuery.verticalCarousel"
    },

    shim: {
        scroll: {
            deps: ['jquery'],
            exports: 'verticalCarousel'
        }
    }
};
