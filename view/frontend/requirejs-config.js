var config = {
    paths: {
        "hungbd_flex": "Hungbd_Slider/js/jquery.flexslider"
    },
    shim: {
        'hungbd_flex': {
            deps: ['jquery']
        }
    },
    map: {
        '*': {
            hungbd_test:    'Hungbd_Slider/js/test',
            hungbd_flex:    'Hungbd_Slider/js/jquery.flexslider'
        }
    }
};
