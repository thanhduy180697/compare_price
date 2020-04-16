<?php

namespace App\Http\Controllers\Product;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductReviewsController extends ApiController
{
// public function __construct()
    // {
       
    //     parent::__construct();
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {

        $reviews = $product->reviews;
        
        return $this->showAll($reviews);
    }

}
