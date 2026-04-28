<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_name',
        'product_description',
        'target_audience',
        'price',
        'usp',
        'generated_content'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}