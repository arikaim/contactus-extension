/**
 *  Arikaim
 *  
 *  @copyright  Copyright (c) Konstantin Atanasov <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 * 
 *  Extension: ContactUs
 *  Component: contactus:form
 */

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
        this.loadSettings().then(function(data) {
            var config = JSON.parse(data);
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
            return arikaim.post('/api/contact-us/','#contact_us_form');          
        },function(data) {  
            self.showDoneMessage('contact_us_form');
            callFunction(onSuccess,data);
        },function(errors) {
            callFunction(onError,errors);
        });
    };

    this.showDoneMessage = function(form_id) {       
        arikaim.page.loadContent({
            id: form_id,
            component: 'contactus::done-message'
        });
    };

    this.initValidation = function(form_id, fields) {
        form_id = getDefaultValue(form_id,'#contact_us_form');
        arikaim.ui.form.addRules(form_id,{
            inline: false,
            fields: fields
        });
    };

    this.loadSettings = function(onSuccess,onError) {
        return arikaim.get('/api/contact-us/config',onSuccess,onError);      
    };
}

var contactUs = new ContactUs();

$(document).ready(function() {
    contactUs.init();
});
