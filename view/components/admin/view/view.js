/**
 *  Arikaim 
 *  @copyright  Copyright (c) Konstantin Atanasov <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
*/

function ContactUsView() {
    var self = this;
    this.messages = null;

    this.loadMessages = function() {
        if (isObject(this.messages) == true) {
            return;
        }

        arikaim.component.loadProperties('contactus::admin',function(params) { 
            self.messages = params.messages;
        }); 
    };

    this.init = function() {           
        this.loadMessages();

        paginator.init('contactus_rows',"contactus::admin.view.rows",'contactus');         
        
        $('.actions').dropdown({});       
         
        search.init({ 
            id: 'contactus_rows',
            component: 'contactus::admin.view.rows'
        },'contactus');

        arikaim.ui.button('#delete_selected',function(element) {
            return modal.confirmDelete({ 
                title: self.messages.remove_selected.title,
                description: self.messages.remove_selected.content
            },function() {
                var selected = arikaim.ui.getChecked('.selected-row');
                contactUsAdmin.deleteSelected(selected,function(result) {
                    arikaim.ui.table.removeSelectedRows(selected.selected);
                });
            });
        });

        arikaim.ui.button('#select_all',function(element) {      
            arikaim.ui.selectAll(element);                
        });   
    };

    this.initRows = function() {
        var component = arikaim.component.get('contactus::admin');

        arikaim.ui.button('.view-message',function(element) {
            var uuid = $(element).parent().attr('id');   
            contactUsAdmin.setReaded(uuid).done(function(result) {
                $('#' + uuid).removeClass('font-bold');
            });       
            return modal.alert({ 
                title: 'Message',
                component: {
                    name: 'contactus::admin.view.message',
                    params: { uuid: uuid }
                },
                icon: "address card outline icon"
            });                       
        });

        arikaim.ui.button('.delete-button',function(element) {
            var uuid = $(element).attr('uuid');          
            return modal.confirmDelete({ 
                title: self.messages.remove.title,
                description: self.messages.remove.content
            },function() {
                contactUsAdmin.delete(uuid,function(result) {
                    arikaim.ui.table.removeRow('#' + uuid);
                });
            });
        });
    };
}

var contactUsView = new ContactUsView();

$(document).ready(function() {
    contactUsView.init();
    contactUsView.initRows();
});