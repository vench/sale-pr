<?php
 

namespace sale\provider;

/**
 * Description of Peterochka
 *
 * @author vench
 */
class Peterochka extends Provider {
    
    public function getAllSaleItem() {
        $base  = 'https://5ka.ru/api/special_offers/?records_per_page=15&page=' ;
        
        for($i = 2; $i < (500 / 15 ); $i ++) {
            $url = $base . $i;
            $json = @file_get_contents($url);
             
            $data = json_decode($json, true);
            
            if(!isset( $data['results']) || empty( $data['results'])) {
                continue;
            }
            
            foreach( $data['results'] as $item) {
                
                if(!isset($item['id']) || !isset($item['name']) || !isset($item['params']['special_price']) 
                        || !isset($item['params']['regular_price']) || !isset($item['image_small'])  ) {
                    continue;
                }
                
                $url = 'https://5ka.ru/special_offers/'.$item['id'].'/';
                $hash = md5($url);
                $model = new \sale\model\SaleItem();
                $model->setHash($hash);
                
                $title = $item['name'];
                $model->setTitle( $title );
                $model->setPriceOld(intval(  $item['params']['regular_price'] ));
                $model->setPriceNew(intval(  $item['params']['special_price'] ));
                $model->setLink( $url );
                $model->setDateInsert(date('Y-m-d H:i'));
                $model->setHost($this->getName());
                $model->setImage(  'https://5ka.ru/' . ltrim($item['image_small'] , '/') );
                $model->setPriceDiff(   ( 1 - $model->getPriceNew() / $model->getPriceOld()) * 100  );

                yield $model;
            }
        }
    }
 
}
