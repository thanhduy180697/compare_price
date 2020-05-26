<?php

namespace App;

use App\Price;
use App\Follow;
use App\Review;
use App\Provider;
use App\Specification;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //
    
    public $transformer = ProductTransformer::class;
    protected $fillable=[
    	'product_name',
		'product_link',
		'link_image',
		'average_rating',
		'provider_id',
		'specification_id',
        'display',
        'operating_system',
        'front_camera',
        'rear_camera',
        'battery',
        'ram',
        'cpu',
        'brand',
        'provider_id'
    ];
    protected $hidden = [
        'pivot'
    ];
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function prices()
    {
        return $this->hasMany(Price::class);
    }
    public function follows()
    {
        return $this->hasMany(Follow::class);
    }
}
