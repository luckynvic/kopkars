<?php
namespace api\models;

use common\models\Produk as CommonProduk;

class Produk extends CommonProduk {

    public function fields()
    {
        return['sku','nama_produk',
        //'url_image_1' => function($model){
        //    return $model->sku;
        //}
        ];
    }
}