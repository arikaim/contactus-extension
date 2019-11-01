<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c) 2016-2018 Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\ContactUs\Models;

use Illuminate\Database\Eloquent\Model;

use Arikaim\Core\Models\Users;

use Arikaim\Core\Traits\Db\Uuid;
use Arikaim\Core\Traits\Db\DateCreated;
use Arikaim\Core\Traits\Db\Find;
use Arikaim\Core\Traits\Db\Status;

class ContactUs extends Model  
{
    use Uuid,
        Find,
        Status,
        DateCreated;
    
    protected $table = "contact_us";

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
   
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(Users::class);
    }

    public function category()
    {
        return $this->belongsTo(Arikaim\Extensions\Category\Models\Category::class);
    }

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
