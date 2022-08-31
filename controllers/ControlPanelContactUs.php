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
use Arikaim\Core\Controllers\ControlPanelApiController;

/**
 * ContactUs Control Panel api controler
*/
class ControlPanelContactUs extends ControlPanelApiController
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
     * Delete message
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */ 
    public function delete($request, $response, $data)
    { 
        $data->validate(true);       

        $uuid = $data->get('uuid');
        $model = Model::ContactUs('contactus')->findById($uuid);
        $result = $model->delete();

        $this->setResponse($result,function() use($uuid) {                  
            $this
                ->message('delete')
                ->field('uuid',$uuid);             
        },'errors.delete');              
    }
    
    /**
     * Set readed status
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */   
    public function setReaded($request, $response, $data)
    {
        $data->validate(true);

        $uuid = $data->get('uuid');
        $result = Model::ContactUs('contactus')->setRead($uuid);

        $this->setResponse($result,function() use($uuid) {                  
            $this
                ->message('readed')
                ->field('uuid',$uuid);             
        },'errors.readed');           
    }

    /**
     * Delete selected messages
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */   
    public function deleteSelected($request, $response, $data)
    {
        $data->validate(true); 

        $items = Model::ContactUs('contactus')->findItems($data->get('selected',[]));   
        $count = 0;       
        if ($items !== false) {
            $count = $items->count();
            $result = $items->delete();                                  
        }

        $this->setResponse($result,function() use($count) {                  
            $this
                ->message('delete')
                ->field('count',$count);             
        },'errors.delete');        
    }
}
