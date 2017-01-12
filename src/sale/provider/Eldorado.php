<?php 

namespace sale\provider;

/**
 * Description of Eldorado
 *
 * @author vench
 */
class Eldorado extends Provider {
    
    public function getAllSaleItem() {
        $baseUrl = 'http://www.eldorado.ru/search/catalog.php?q=__&PAGEN_SEARCH=';
        //http://www.eldorado.ru/search/catalog.php?PAGEN_SEARCH=50&sort=price&type=asc&list_num=20&q=10
        for ($i = 1; $i < 100; $i ++) { 
            echo "{$i}\n";
            $url =  $baseUrl . $i; //'http://www.eldorado.ru/cat/170175332/LEGO/';//
            $html = file_get_contents($url);  
            if(strpos($html, 'oldPrice') === false ) {
                continue;
            }
            
            //itemContainer
            $p = new \sale\html\DOMParser($html);
            $n = $p->parse();
            $ns = \sale\html\Find::find($n, '*class=item');  
           
            if(!empty($ns)) {
                foreach($ns as $node) {
                    // oldprice
                    $oldprice = \sale\html\Find::find($node, '.oldPrice');
                    //newprice
                    $newprice = \sale\html\Find::find($node, '.discountPrice');
                
                    if(!isset($oldprice[0]) || !isset($newprice[0])) {
                       continue;
                    }
                     
                    
                    //itemTitle
                    // itemlink
                    $title = \sale\html\Find::find($node, '.itemTitle');
                    $img = \sale\html\Find::find($node, 'img');
                    //var_dump($img[1]->getAttribute('src'));
                    
                    if(!isset($img[0]) || !isset($title[0])) {
                        continue;
                    }
                   // var_dump($img , $title); exit();
                    $title = $title[0]->getChilds();
                    //var_dump($title[0]->getAttribute('href') . ' ' . $title[0]->getData());
                    
                    $url = 'http://'. $this->getName() . $title[0]->getAttribute('href');
                    $hash = md5($url);
                    $model = new \sale\model\SaleItem();
                    $model->setHash($hash);

                    $titleDate = iconv('windows-1251', 'utf-8', $title[0]->getData());
                    $model->setTitle( $titleDate );
                    $model->setPriceOld(intval( str_replace('&nbsp;', '',$oldprice[0]->getData()) ));
                    $model->setPriceNew(intval( str_replace('&nbsp;', '',$newprice[0]->getData())));
                    $model->setLink( $url );
                    $model->setDateInsert(date('Y-m-d H:i'));
                    $model->setHost($this->getName());
                    $model->setImage( $img[0]->getAttribute('src') );
                    $model->setPriceDiff(   ( 1 - $model->getPriceNew() / $model->getPriceOld()) * 100  );

                    yield $model;
                }
            }
            //exit();
        }
    }
    
    
    public function getItemDescription($item) {
        //itemprop="description";
        $html = file_get_contents($item->getLink() );        
        
        if(strpos($html, 'description') !== false) { 
            $p = new \sale\html\DOMParser($html);
            $n = $p->parse();
            $ns = \sale\html\Find::find($n, '*itemprop=description');  
            
              
            return isset($ns[0]) ? iconv('windows-1251', 'utf-8',($ns[0]->toHtml())) : '';
        }
        //
        return '';
    }

}
