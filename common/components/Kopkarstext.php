<?php
namespace common\components;

use Yii;
use yii\helpers\Url;
use yii\base\Component;
use yii\helpers\StringHelper;


class Kopkarstext extends Component {
   public function hp62($input)
    {
       return empty($input)?null:'62'.$input;
    }
    public function textOrNull($input)
    {
       return empty($input)?null:$input;
    }
    public function urlFotoProdukBackend($kode_toko,$sku,$ke){
       return 'https://kopkars.setneg-ppkk.co.id/backend/produk-foto/'.$kode_toko.'/'.$sku.'-'.$ke.'.jpg';
      }

}
