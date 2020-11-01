<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\ContactUs\Controllers;

use Arikaim\Core\Db\Model;
use Arikaim\Core\Controllers\ApiController;

use Arikaim\Core\Controllers\Traits\Captcha;

/**
 * ContactUs api controler
*/
class ContactUs extends ApiController
{
    use Captcha;
    
    /**
     * Init controller
     *
     * @return void
     */
    public function init()
    {
        $this->loadMessages('contactus::admin.messages');
    }
    
    /**
     * Save message
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */ 
    public function addController($request, $response, $data) 
    {               
        $settings = $this->get('options')->get('contactus.form.settings');
    
        if ($settings['captcha']['show'] == true) {           
            if ($this->verifyCaptcha($request,$data) == false) {            
                return;      
            } 
        }
       
        $this->onDataValid(function($data) { 
            $model = Model::ContactUs('contactus');
            $model->authId = $this->get('access')->getId();
            
            $message = $model->create($data->toArray());

            $this->setResponse(\is_object($message),function() use($message,$data) {                      
                $this->get('event')->dispatch('contactus.add',$data->toArray());                     
                $sendEmail = $this->get('options')->get('contactus.notifications.email.send');

                if ($sendEmail == true) {       
                    $notificationsEmail = $this->get('options')->get('contactus.notifications.email');                  
                    // send mail 
                    $this->get('mailer')
                        ->create('contactus>contact-us',['message' => $message->toArray()])
                        ->to($notificationsEmail)                      
                        ->send();                        
                }
                $this
                    ->message('save')
                    ->field('uuid',$message->uuid);     
            },'errors.save'); 
        });
        $data
            ->addRule('text:min=2','message')
            ->validate();
    }

    /**
     * Read form config
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */ 
    public function getConfig($request, $response, $data)
    {
        $options = $this->get('options')->get('contactus.form.settings');
        
        return $this->setResult($options)->getResponse();      
    }
}
