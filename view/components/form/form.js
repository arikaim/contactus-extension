/**
 *  Arikaim
 *  @copyright  Copyright (c)  <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function ContactUs() {
    var self = this;

    this.init = function(onSuccess, onError) {
        var fields = {
            message: {
                identifier: "message",      
                rules: [{
                    type: "minLength[2]"       
                }]
            }
        };
        this.loadSettings().then(function(config) {
          
            if (config.subject.required == "true") {
                fields.subject = {
                    identifier: "subject",      
                    rules: [{
                        type: "minLength[2]"       
                    }]
                }
            }
            if (config.name.required == "true") {
                fields.name = {
                    identifier: "name",      
                    rules: [{
                        type: "minLength[2]"       
                    }]
                }
            }
            if (config.phone.required == "true") {
                fields.phone = {
                    identifier: "phone",      
                    rules: [{
                        type: "minLength[2]"       
                    }]
                }
            }
            if (config.email.required == "true") {
                fields.email = {
                    identifier: "email",      
                    rules: [{
                        type: "email"       
                    }]
                }
            }
            self.initValidation('#contact_us_form',fields);
        });
        
        arikaim.ui.form.onSubmit("#contact_us_form",function() {  
            return arikaim.post('/api/contact-us','#contact_us_form');          
        },function(data) {  
            self.showDoneMessage('contact_us_form');
            callFunction(onSuccess,data);
        },function(errors) {
            callFunction(onError,errors);
        });
    };

    this.showDoneMessage = function(formId) {       
        arikaim.page.loadContent({
            id: formId,
            component: 'contactus::done-message'
        });
    };

    this.initValidation = function(formId, fields) {
        formId = getDefaultValue(formId,'#contact_us_form');
        arikaim.ui.form.addRules(formId,{
            inline: false,
            fields: fields
        });
    };

    this.loadSettings = function(onSuccess, onError) {
        return arikaim.get('/api/contact-us/config',onSuccess,onError);      
    };
}

var contactUs = new ContactUs();

arikaim.component.onLoaded(function() {
    contactUs.init();
});
