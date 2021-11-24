"use strict";
// Class definition

var KTSummernoteDemo = function () {
    // Private functions
    var demos = function () {
        $('.summernote').summernote({
            height: 400,
            tabsize: 2
        });
    }

    return {
        // public functions
        init: function() {
            demos();
        }
    };
}();

// Initialization
jQuery(document).ready(function() {
    KTSummernoteDemo.init();
});

var KTSummernoteDemo_2 = function () {
    // Private functions
    var demos_2 = function () {
        $('.summernote_2').summernote({
            height: 400,
            tabsize: 2
        });
    }

    return {
        // public functions
        init: function() {
            demos_2();
        }
    };
}();

// Initialization
jQuery(document).ready(function() {
    KTSummernoteDemo_2.init();
});
