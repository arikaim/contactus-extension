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

use Arikaim\Extensions\Category\Models\Category;

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
    protected $table = 'contact_us';

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
        return $this->belongsTo(Category::class,'category_id');  
    }

    /**
     * Set readed
     *
     * @param string|integer $id
     * @param integer $read
     * @return boolean
     */
    public function setRead($id, int $read = 1): bool
    {
        $model = $this->findById($id);
        if ($model == null) {
            return false;
        }
        $model->read = $read;

        return (bool)$model->save();
    }
}
