/**
 *  Arikaim
 *  @copyright  Copyright (c) Konstantin Atanasov <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function ContactUsSettings() {    

    this.init = function() {      
       arikaim.ui.tab('.settings-tab-item','settings_tab')
    };

    this.getSettings = function(form_id) {
        return result = {
            name: {
                show: $('#show_name').prop('checked'),
                required: $('#require_name').prop('checked'),
            },
            email: {
                show: $('#show_email').prop('checked'),
                required: $('#require_email').prop('checked'),
            },
            phone: {
                show: $('#show_phone').prop('checked'),
                required: $('#require_phone').prop('checked'),
            },
            subject: {
                show: $('#show_subject').prop('checked'),
                required: $('#require_subject').prop('checked'),
            },
            captcha: {
                show: $('#show_captcha').prop('checked'),
            }
        };
    };

    this.addNotificationFormRules = function() {
        var checked = $('#send_email_notifications_checkbox').prop('checked'); 
        if (checked == true) {         
            arikaim.ui.form.addRules('#notifications_settings_form',{
                inline: false,
                fields: {
                    email: {
                        identifier: "notification_email",      
                        rules: [{
                            type: "email"       
                        }]
                    }
                } 
            });
        }       
    }
}

var contactUsSettings = new ContactUsSettings();

arikaim.component.onLoaded(function() {
    contactUsSettings.init();
})