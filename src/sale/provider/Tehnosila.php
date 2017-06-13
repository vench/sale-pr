<?php

namespace sale\provider;

/**
 * Description of Tehnosila
 *
 * @author vench
 */
class Tehnosila extends Provider {

    /**
     * @return \sale\model\SaleItem[]
     */
    public function getAllSaleItem() {
        $baseUrl = 'http://www.tehnosila.ru/search?q=1&p=';

        //todo!!! 100
        for ($i = 1; $i < 1000; $i ++) { 
            echo "{$i}\n";
            $url = $baseUrl . $i;
            $html = file_get_contents($url);
            preg_match_all('/<div\s+class="item-info"\s+id="item-info-\d+"\s+data-id="\d+">(.*)<div\s+class="delivery-info">/isU', $html, $math);
            if (isset($math[1])) {
                foreach ($math[1] as $math) {
         
                    
                    if (preg_match('/<div\s+class="price">(.*)<\/div>/isU', $math, $price) && isset($price[1])) {
                        
                       # preg_match('/<span\s+class="was-word">.+<\/span>(.*)<span\s+class="currency">.+<\/span><\/span>\s+<span\s+class="number-new">(.*)<span\s+class="currency">/isU', $price[1], $prices);
                        preg_match_all('/>([0-9\s]{1,})<span/isU', $price[1], $prices);
                      //  print_r( $prices);
                        
                        
                        if (isset($prices[1])) {  
                                 
                            preg_match('/<div class="title">\s+<a.+href="(.*)"\s+title="(.*)"/isU', $math, $title); //title
                            if (isset($title[1]) && isset($title[2])) {
                                
                                
                                $image = null;
                                //img class="lazy" data-src=
                                if (preg_match('/<img\s+class="lazy"\s+data-src="(.*)"/isU', $math, $img) && isset($img[1])) {
                                    $image = $img[1];
                                }
                                //echo ($image), PHP_EOL;
                                

                                $hash = md5($title[1]);
                                $model = new \sale\model\SaleItem();
                                $model->setHash($hash);
                                $model->setTitle($title[2]);
                                $model->setPriceOld(intval(str_replace(' ', '', $prices[1][0])));
                                if(isset($prices[1][2])) {
                                    $model->setPriceNew(intval(str_replace(' ', '', $prices[1][2])));
                                } else {
                                    $model->setPriceNew(intval(str_replace(' ', '', $prices[1][0])));
                                }
                                
                                $model->setLink($title[1]);
                                $model->setDateInsert(date('Y-m-d H:i'));
                                $model->setHost($this->getName());
                                $model->setImage($image);
                                $model->setPriceDiff(   ( 1 - $model->getPriceNew() / $model->getPriceOld()) * 100  );

                                yield $model;
                            }
                        }
                    }
                }    
            }
        }
    }
    
    /**
     * 
     * @param \sale\model\SaleItem $item
     * @return string
     */
    public function getItemDescription($item) {
        $html = file_get_contents($item->getLink() );        
        
        if(strpos($html, 'item-description') !== false) {
            $p = new \sale\html\DOMParser($html);
            $n = $p->parse();
            $ns = \sale\html\Find::find($n, '.item-description'); 
        
            return isset($ns[0]) ? ($ns[0]->toHtml()) : '';
        } 
        
        return ''; 
    }

}
