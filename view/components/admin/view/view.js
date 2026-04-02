/**
 *  Arikaim 
 *  @copyright  Copyright (c)  <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
*/
'use strict';

function ContactUsView() {
    var self = this;
 
    this.init = function() {           
        this.loadMessages('contactus::admin');
            
        search.init({ 
            id: 'contactus_rows',
            component: 'contactus::admin.view.rows'
        },'contactus');

        arikaim.ui.button('#delete_selected',function(element) {
            return  arikaim.ui.getComponent('confirm_delete').open( 
                function() {
                    var selected = arikaim.ui.getChecked('.selected-row');
                    contactUsAdmin.deleteSelected(selected,function(result) {
                        arikaim.ui.table.removeSelectedRows(selected.selected);
                    });
                },self.getMessage('remove_selected.content'));
        });

        arikaim.ui.button('#select_all',function(element) {      
            arikaim.ui.selectAll(element);                
        });   

        this.initRows();
    };

    this.initRows = function() {
        arikaim.ui.button('.view-message',function(element) {
            var uuid = $(element).attr('uuid');              
            
            return arikaim.ui.loadComponent({ 
                mountTo: 'message_details',
                component: 'contactus::admin.view.message',
                params: { 
                    uuid: uuid 
                }              
            },function() {
                contactUsAdmin.setReaded(uuid).done(function(result) {
                    $('#' + uuid).removeClass('font-bold');
                });     
            });                       
        });

        arikaim.ui.button('.delete-button',function(element) {
            var uuid = $(element).attr('uuid');   

            return arikaim.ui.getComponent('confirm_delete').open( 
                function() {
                    contactUsAdmin.delete(uuid,function(result) {
                        arikaim.ui.table.removeRow('#' + uuid);
                    });
                },self.messages.remove.content);
        });
    };
}

var contactUsView = createObject(ContactUsView,ControlPanelView);

arikaim.component.onLoaded(function() {
    contactUsView.init();
});