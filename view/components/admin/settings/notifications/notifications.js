'use strict';

arikaim.component.onLoaded(function() {
    $('#send_email_notifications').checkbox({
        onChange: function() {
            var checked = $(this).prop('checked');        
            arikaim.ui.cssClass('#email_field',!checked,'disabled');          
                       
            contactUsSettings.addNotificationFormRules();
            options.save('contactus.notifications.email.send',checked);
        }   
    });
    
    contactUsSettings.addNotificationFormRules();

    arikaim.ui.form.onSubmit("#notifications_settings_form",function() {  
        var notificationEmail = $('#notification_email').val();
        return options.save('contactus.notifications.email',notificationEmail);
    });
});