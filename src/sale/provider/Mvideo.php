<?php
 
namespace sale\provider;

/**
 * Description of Mvideo
 *
 * @author vench
 */
class Mvideo extends Provider {
    
    public function getAllSaleItem() {
        $baseUrl = "http://www.mvideo.ru/product-list?Dy=1&No={no}&Nrpp=12&Ntt=1&Nty=1";
        $step = 12;
        $size = 6000;
        
        for($i = 0; $i < $size; $i += $step) {
            echo "{$i}\n";
            $url = str_replace('{no}', $i, $baseUrl);
            $html = file_get_contents($url);
           // echo $url , PHP_EOL;
            if(strpos($html, 'product-price-old') === false) {
               // file_put_contents($i . '-product.html', $html);
                continue;
            } 
            
            $p = new \sale\html\DOMParser($html);
            $n = $p->parse();
            $ns = \sale\html\Find::find($n, '.product-price-old');
            foreach($ns as $node) {
                $top = \sale\html\Find::top($node, '.showcompare');
                if(!is_null($top)) {
                     
                    
                    $price = \sale\html\Find::find($top, '.product-price-current');
                    $img = \sale\html\Find::find($top, '.product-tile-picture-image');
                    $title = \sale\html\Find::find($top, '.product-tile-title-link');
//var_dump(); exit();
                    if(!count($title)) {
                        continue;
                    }
                    if(!count($price)) {
                        continue;
                    }
                    
                    $image = null;
                    if(isset($img[0])) {
                        $image =  $img[0]->getAttribute('data-original');
                    }
 
                     $url = 'http://'. $this->getName() . $title[0]->getAttribute('href');
                     $hash = md5($url);
                     $model = new \sale\model\SaleItem();
                     $model->setHash($hash);
                     $model->setTitle($title[0]->getAttribute('data-track-label'));
                     $model->setPriceOld(intval( $node->getData() ));
                     $model->setPriceNew(intval( $price[0]->getData()));
                     $model->setLink( $url );
                     $model->setDateInsert(date('Y-m-d H:i'));
                     $model->setHost($this->getName());
                     $model->setImage( $image );
                     $model->setPriceDiff(   ( 1 - $model->getPriceNew() / $model->getPriceOld()) * 100  );

                     yield $model;
                }
            }
        } 
    }
    
    /**
     * 
     * @param type $item
     * @return string
     */
    public function getItemDescription($item) {
         $html = file_get_contents($item->getLink() );        
        
        if(strpos($html, 'pds-top-description') !== false) { 
            $p = new \sale\html\DOMParser($html);
            $n = $p->parse();
            $ns = \sale\html\Find::find($n, '.pds-top-description');  
            
              
            return isset($ns[0]) ? ($ns[0]->toHtml()) : '';
        }
        //
        return '';
    }

}
