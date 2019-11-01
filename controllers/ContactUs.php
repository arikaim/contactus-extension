<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c) 2016-2018 Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\ContactUs\Controllers;

use Arikaim\Core\Db\Model;
use Arikaim\Core\Controllers\ApiController;
use Arikaim\Core\Arikaim;
use Arikaim\Core\Mail\Mail;

/**
 * ContactUs api controler
*/
class ContactUs extends ApiController
{
    /**
     * Save contact us message
     *
     * @param object $request
     * @param object $response
     * @param object $data
     * @return object
    */
    public function addController($request, $response, $data) 
    {               
        $settings = Arikaim::options()->get('contactus.form.settings');
    
        if ($settings['captcha']['show'] == true) {           
            $recaptcha = Arikaim::module()->create('recaptcha');
            $result = $recaptcha->verify($data['g-recaptcha-response'],$request->getAttribute('client_ip'));
            if ($result == false) {
                $this->withError('Captcha verification failed.')->getResponse();              
            } 
        }
       
        $this->onDataValid(function($data) { 
            $model = Model::ContactUs('contactus')->create($data->toArray());
              
            if (is_object($model) == false) {
                $this->setError('ERROR_SAVE_DATA');
            } else {
                $result = Arikaim::event()->trigger('contactus.add',$data->toArray());                     
                $send_email = Arikaim::options()->get('contactus.notifications.email.send');

                if ($send_email == true) {       
                    $notifications_email = Arikaim::options()->get('contactus.notifications.email');                  
                    // send mail 
                    $result = Mail::create()
                        ->to($notifications_email) 
                        ->loadComponent('contactus::admin.email',['uuid' => $model->uuid])
                        ->send();                        
                }
                $this->setResult(['message' => 'Contact Us message saved','id' => $model->id,'uuid' => $model->uuid]);   
            }
        });
        $data
            ->addRule('text:min=2','message')
            ->validate();
    }

    /**
     * Read contact us config
     *
     * @param object $request
     * @param object $response
     * @param object $data
     * @return object
    */
    public function getConfig($request, $response, $data)
    {
        $options = Arikaim::options()->read('contactus.form.settings');
        return $this->setResult($options)->getResponse();      
    }

    /**
     * Read contact us config
     *
     * @param object $request
     * @param object $response
     * @param object $data
     * @return object
    */
    public function contactUsPage($request, $response, $data)
    {
        echo "cu page";
    }
}
