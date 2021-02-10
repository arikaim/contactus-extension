<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\ContactUs;

use Arikaim\Core\Extension\Extension;

/**
 * ContactUs extension
*/
class ContactUs extends Extension
{
    /**
     * Install extension routes, events, jobs
     *
     * @return void
    */
    public function install()
    {
        // Save message
        $this->addApiRoute('GET','/api/contact-us/config','ContactUs','getConfig');      
        $this->addApiRoute('POST','/api/contact-us','ContactUs','add');
        // Control Panel
        $this->addApiRoute('PUT','/api/contact-us/admin/readed/{uuid}','ControlPanelContactUs','setReaded','session'); 
        $this->addApiRoute('PUT','/api/contact-us/admin/delete/selected','ControlPanelContactUs','deleteSelected','session'); 
        $this->addApiRoute('DELETE','/api/contact-us/admin/{uuid}','ControlPanelContactUs','delete','session');   

        // Register events
        $this->registerEvent('contactus.create','Trigger after new contact us message is created');
        // Create db tables
        $this->createDbTable('ContactUsSchema');

        // Options
        $formSettings = [
            'name'    => ['show' => false,'required' => false],
            'email'   => ['show' => false,'required' => false],
            'phone'   => ['show' => false,'required' => false],
            'subject' => ['show' => true,'required' => false],
            'captcha' => ['show' => true]
        ];
        $this->createOption('contactus.form.settings',$formSettings);
        $this->createOption('contactus.notifications.email','');
        $this->createOption('contactus.notifications.email.send',true);
        $this->createOption('contactus.send.message','Your message has been sent.');  
    }   

    /**
     * Uninstall extension
     *
     * @return void
     */
    public function unInstall()
    {         
    }
}
