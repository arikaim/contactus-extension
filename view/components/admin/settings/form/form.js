'use strict';

arikaim.component.onLoaded(function() {
    $('#settings_form .checkbox').checkbox({
        onChange: function() {
            var settings = contactUsSettings.getSettings();
            options.save('contactus.form.settings',settings);
        }   
    });
    
    arikaim.ui.button('#save_send_message',function(element) {
        var text = $('#send_message').val();       
        return options.save('contactus.send.message',text);
    });

    arikaim.ui.button('#default_button',function(element) {      
        arikaim.component.loadProperties('contactus::done-message',function(result) {
            if (isEmpty(result.message) == false) {
                $('#send_message').val(result.message); 
            }
        });
    });
});