/**
 *  Arikaim
 *  @copyright  Copyright (c) Konstantin Atanasov <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function ContactUsControlPanel() {
   
    this.setReaded = function(uuid, onSuccess, onError) {                 
        return arikaim.put('/api/admin/contact-us/readed/'+ uuid,null,onSuccess,onError);      
    };

    this.delete = function(uuid, onSuccess, onError) {
        return arikaim.delete('/api/admin/contact-us/' + uuid,onSuccess,onError);
    };

    this.deleteSelected = function(selected, onSuccess, onError) {
        return arikaim.put('/api/admin/contact-us/delete/selected',selected,onSuccess,onError);      
    };  
}

var contactUsAdmin = new ContactUsControlPanel();

arikaim.component.onLoaded(function() {
    arikaim.ui.tab(); 
});