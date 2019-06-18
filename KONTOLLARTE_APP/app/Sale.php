<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'saleId', 'saleUrl', 'paintId'
    ];

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'saleId';

    /**
     * Gets the paint related with the sale.
     *
     * @return Paint \App\Paint
     */
    public function paint() 
    {
        return $this->belongsTo('App\Paint', 'paintId', 'paintId');
    }


}
