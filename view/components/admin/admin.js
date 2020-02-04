/**
 *  Arikaim
 *  @copyright  Copyright (c) Konstantin Atanasov <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */

function ContactUsControlPanel() {
   
    this.setReaded = function(uuid, onSuccess, onError) {                 
        return arikaim.put('/api/contact-us/admin/readed/'+ uuid,null,onSuccess,onError);      
    };

    this.delete = function(uuid, onSuccess, onError) {
        return arikaim.delete('/api/contact-us/admin/' + uuid,onSuccess,onError);
    };

    this.deleteSelected = function(selected, onSuccess, onError) {
        return arikaim.put('/api/contact-us/admin/delete/selected',selected,onSuccess,onError);      
    };

    this.init = function() {    
        arikaim.ui.tab(); 
    };
}

var contactUsAdmin = new ContactUsControlPanel();

$(document).ready(function() {
    contactUsAdmin.init();
});