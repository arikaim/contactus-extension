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
use Arikaim\Core\View\Template;

/**
 * ContactUs Control Panel api controler
*/
class ControlPanelContactUs extends ApiController
{
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
     * Delete contact us message
     *
     * @param object $request
     * @param object $response
     * @param object $data
     * @return object
    */
    public function deleteController($request, $response, $data)
    { 
        $this->requireControlPanelPermission();

        $this->onDataValid(function($data) { 
            $uuid = $data->get('uuid');
            $model = Model::ContactUs('contactus')->findById($uuid);
            if (is_object($model) == true) {
                $result = $model->delete();
                $this->setResult(['message' => 'Message removed','uuid' => $uuid]);
            } else {
                $this->setError('Not valid message id');
            }
        });
        $data->validate();        
    }
    
    /**
     * Set readed status
     *
     * @param object $request
     * @param object $response
     * @param Validator $data
     * @return object
    */
    public function setReadedController($request, $response, $data)
    {
        $this->requireControlPanelPermission();

        $this->onDataValid(function($data) {        
            $result = Model::ContactUs('contactus')->setRead($data->get('uuid'));
            if ($result == true) {             
                $this->setResult(['message' => 'Message status set to readed','uuid' => $data->get('uuid')]);
            } else {
                $this->setError('Not valid message id');
            }
        });
        $data->validate();
    }

    /**
     * Set readed status
     *
     * @param object $request
     * @param object $response
     * @param Validator $data
     * @return object
    */
    public function deleteSelectedController($request, $response, $data)
    {
        $this->requireControlPanelPermission();

        $this->onDataValid(function($data) {   
            $items = Model::ContactUs('contactus')->findItems($data->get('selected',[]));          
            if ($items !== false) {
                $count = $items->count();
                $result = $items->delete();
                $this->setResult(['message' => 'Messages deleted!','count' => $count]);
            }
        });
        $data->validate(); 
    }
}
