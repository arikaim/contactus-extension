'use strict';

arikaim.component.onLoaded(function() {
    $('#settings_form .checkbox').on('change', function() {
        var settings = contactUsSettings.getSettings();
        options.save('contactus.form.settings',settings);
    });
    
    arikaim.ui.button('#save_send_message',function(element) {
        var text = $('#send_message').val();  

        return options.save('contactus.send.message',text,function(result) {           
            arikaim.ui.getComponent('toast').show(result.message);
        });
    });   
});