define(["jquery", "jqueryui"], function($, ui) {
    return {
        init : function() {
            $('[data-toggle="tooltip"]').tooltip();
        }
    };
});
