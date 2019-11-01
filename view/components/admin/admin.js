/**
 *  Arikaim
 *  
 *  @copyright  Copyright (c) Konstantin Atanasov <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 * 
 *  Extension: Category
 *  Component: category:admin
 */

function ContactUsControlPanel() {
   
    this.setReaded = function(uuid, onSuccess, onError) {                 
        return arikaim.put('/api/contact-us/readed/'+ uuid,null,onSuccess,onError);      
    };

    this.delete = function(uuid, onSuccess, onError) {
        return arikaim.delete('/api/contact-us/' + uuid,onSuccess,onError);
    };

    this.deleteSelected = function(selected, onSuccess, onError) {
        return arikaim.put('/api/contact-us/delete/selected',selected,onSuccess,onError);      
    };

    this.init = function() {    
        arikaim.ui.tab(); 
    };
}

var contactUsAdmin = new ContactUsControlPanel();

$(document).ready(function() {
    contactUsAdmin.init();
});