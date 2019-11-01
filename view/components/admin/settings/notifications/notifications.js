$(document).ready(function() {
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
        var notification_email = $('#notification_email').val();
        return options.save('contactus.notifications.email',notification_email);
    }).done(function(data) {  
      
    }).fail(function(error) {
       
    });
});