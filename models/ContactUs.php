<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\ContactUs\Models;

use Illuminate\Database\Eloquent\Model;

use Arikaim\Core\Db\Traits\Uuid;
use Arikaim\Core\Db\Traits\DateCreated;
use Arikaim\Core\Db\Traits\Find;
use Arikaim\Core\Db\Traits\Status;
use Arikaim\Core\Db\Traits\UserRelation;

class ContactUs extends Model  
{
    use Uuid,
        Find,
        Status,
        UserRelation,
        DateCreated;
    
    /**
     * Db table name
     *
     * @var string
     */
    protected $table = "contact_us";

    /**
     * Fillable attributes
     *
     * @var array
     */
    protected $fillable = [    
        'uuid',
        'status',  
        'message',
        'category_id',
        'name',
        'email',
        'phone',
        'read',
        'subject',
        'address',
        'date_created',
        'user_id'
    ];
    
    /**
     * Disable Timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Category relation
     *
     * @return Relation
     */
    public function category()
    {
        $class = 'Arikaim\\Extensions\\Category\\Models\\Category';
        if (class_exists($class) == true) {
            return $this->belongsTo($class);
        }
        
        return null;
    }

    /**
     * Set readed
     *
     * @param string|integer $id
     * @param integer $read
     * @return boolean
     */
    public function setRead($id, $read = 1)
    {
        $model = $this->findById($id);
        if (is_object($model) == false) {
            return false;
        }
        $model->read = $read;

        return $model->save();
    }
}
