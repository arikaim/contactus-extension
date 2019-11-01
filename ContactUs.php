<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c) 2016-2018 Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\ContactUs;

use Arikaim\Core\Packages\Extension\Extension;
use Arikaim\Core\Arikaim;

/**
 * ContactUs extension
*/
class ContactUs extends Extension
{
    /**
     * Install extension routes, events, jobs
     *
     * @return boolean
    */
    public function install()
    {
        // Contact us page
        $this->addPageRoute('/contact-us/','contact-us',null,'ContactUsPages','contactUs');  
        // Save message
        $this->addApiRoute('POST','/api/contact-us/','ContactUs','add');
        $this->addApiRoute('GET','/api/contact-us/config','ContactUs','getConfig');

        // Control Panel
        $this->addApiRoute('PUT','/api/contact-us/readed/{uuid}','ControlPanelContactUs','setReaded','session'); 
        $this->addApiRoute('PUT','/api/contact-us/delete/selected','ControlPanelContactUs','deleteSelected','session'); 
        $this->addApiRoute('DELETE','/api/contact-us/{uuid}','ControlPanelContactUs','delete','session');   

        // Register events
        $this->registerEvent('contactus.create','Trigger after new contact us message is created');
        // Create db tables
        $this->createDbTable('ContactUsSchema');

        // Options
        $form_settings = [
            'name'    => ['show' => false,'required' => false],
            'email'   => ['show' => false,'required' => false],
            'phone'   => ['show' => false,'required' => false],
            'subject' => ['show' => true,'required' => false],
            'captcha' => ['show' => true]
        ];
        $this->createOption('contactus.form.settings',$form_settings);
        $this->createOption('contactus.notifications.email','');
        $this->createOption('contactus.notifications.email.send',true);
        $this->createOption('contactus.send.message','Your message has been sent.'); 
        
        return true;
    }   
}
