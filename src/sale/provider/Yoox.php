<?php
 

namespace sale\provider;

/**
 * Description of Yoox
 * http://www.yoox.com/RU/shoponline?gender=D&page=3
 *
 * @author vench
 */
class Yoox extends Provider {
    
    public function getAllSaleItem() {
        $baseUrl = 'http://www.yoox.com/RU/shoponline?gender=D&page=';
        
        for($i = 0; $i < 2500; $i ++) {
            $url = $baseUrl . $i;
            echo "{$i}\n";
            
            $html = file_get_contents($url);
           // echo $url , PHP_EOL;
            if(strpos($html, 'oldprice') === false) {
               // file_put_contents($i . '-product.html', $html);
                continue;
            } 
            
            
            //itemContainer
            $p = new \sale\html\DOMParser($html);
            $n = $p->parse();
            $ns = \sale\html\Find::find($n, '.itemContainer');  
            
            foreach ($ns as $node) {
                
                // oldprice
                $oldprice = \sale\html\Find::find($node, '.oldprice');
                //newprice
                $newprice = \sale\html\Find::find($node, '.newprice');
                
                if(!isset($oldprice[0]) || !isset($newprice[0])) {
                    continue;
                }
                
                // itemlink
                $link = \sale\html\Find::find($node, '.itemlink');
                
                //img
                $img = \sale\html\Find::find($node, '.js-lazy-load'); 
                
                //microcategory
                $microcategory = \sale\html\Find::find($node, '.microcategory'); 
                //brand
                $brand = \sale\html\Find::find($node, '.brand'); 
                
                if(!isset($img[0]) || !isset($link[0])  || !isset($brand[0]) || !isset($microcategory[0])) {
                    continue;
                }
                
                //var_dump($microcategory, $brand); exit();
                //var_dump($img[0]->getAttribute('data-original'), $oldprice, $newprice, $link[0]->getAttribute('href')); exit();
                
                $url = 'http://'. $this->getName() . $link[0]->getAttribute('href');
                $hash = md5($url);
                $model = new \sale\model\SaleItem();
                $model->setHash($hash);
                
                $title = $microcategory[0]->getData() . ' ' . $brand[0]->getData();
                $model->setTitle( $title );
                $model->setPriceOld(intval( str_replace(' ', '',$oldprice[0]->getData()) ));
                $model->setPriceNew(intval( str_replace(' ', '',$newprice[0]->getData())));
                $model->setLink( $url );
                $model->setDateInsert(date('Y-m-d H:i'));
                $model->setHost($this->getName());
                $model->setImage( $img[0]->getAttribute('data-original') );
                $model->setPriceDiff(   ( 1 - $model->getPriceNew() / $model->getPriceOld()) * 100  );

                yield $model;
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
        
        if(strpos($html, 'ItemDescription') !== false) { 
            $p = new \sale\html\DOMParser($html);
            $n = $p->parse();
            $ns = \sale\html\Find::find($n, '.item-info-content');  
         
            return join("\n", array_map(function($n){
                return $n->toHtml( function($n) { 
                    if($n->getTagName() != 'li') {
                        return $n->getData();
                    }
                    return   $n->getData().'<br/>';
                });
                
            }, array_slice($ns, 0, 2)));
            
             
        } 
        
        return ''; 
    }

}
