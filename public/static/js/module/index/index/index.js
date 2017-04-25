define(['jquery'], function($) {
    var module = {
        init: function() {
            $(document).on('click', '.toolbar-handle', function() {
                var handle = $(this).data('handle');
                if(module['handle'] && typeof module['handle'][handle] == 'function'){
                    module['handle'][handle](this);
                }
            });

            $(document).on("keyup", "input", function(event) {
                if(event.keyCode ==13) module.handle.search();
                return false;
            });
        },

        handle: {
            search: function() {
                alert("hello");
            }
        }
    };

    return module;
});
