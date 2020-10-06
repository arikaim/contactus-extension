<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\ContactUs\Models\Schema;

use Arikaim\Core\Db\Schema;

/**
 * ContactUs db table
 */
class ContactUsSchema extends Schema  
{    
    /**
     * Table name
     *
     * @var string
     */
    protected $tableName = 'contact_us';

    /**
     * Create table
     *
     * @param \Arikaim\Core\Db\TableBlueprint $table
     * @return void
     */    
    public function create($table) 
    {
        // columns     
        $table->id();
        $table->prototype('uuid');  
        $table->userId();
        $table->status();
        $table->string('name')->nullable(true);
        $table->string('email')->nullable(true);
        $table->string('phone')->nullable(true);
        $table->string('subject')->nullable(true);
        $table->text('message')->nullable(false);
        $table->text('address')->nullable(true);
        $table->relation('category_id','category',true);        
        $table->integer('read')->nullable(false)->default(0);
        $table->dateCreated();          
        // indexes         
        $table->index('read');
    }

    /**
     * Update table
     *
     * @param \Arikaim\Core\Db\TableBlueprint $table
     * @return void
    */
    public function update($table) 
    {              
    }
}
