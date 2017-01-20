<?php
 

namespace sale\provider;

/**
 * Description of Okey
 *
 * @author vench
 */
class Okey extends Provider {
    
    public function getAllSaleItem() {
        $url= 'https://www.okeydostavka.ru/webapp/wcs/stores/servlet/ProductListingView?searchType=1000&filterTerm=&langId=-20&advancedSearch=&sType=SimpleSearch&gridPosition=&metaData=&manufacturer=&custom_view=true&ajaxStoreImageDir=%2Fwcsstore%2FOKMarketSAS%2F&resultCatEntryType=&catalogId=12051&searchTerm=&resultsPerPage=72&emsName=&facet=&categoryId=38057&storeId=10151&disableProductCompare=true&ddkey=ProductListingView_6_-1011_3074457345618259713&filterFacet=';
        
        $opts = array(
            'http'=>array(
              'method'=>"GET",
              'header'=>"User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.90 Safari/537.36\r\n" .
                        "Upgrade-Insecure-Requests: 1\r\n".
                        "Cookie: foo=bar\r\n"
            )
          );

          $context = stream_context_create($opts);
        $html = file_get_contents($url, false, $context);
        if(strpos($html, 'product_price') !== false) {
            $content = preg_replace('/<!--(.*?)-->/is', '', $html);
            $content = preg_replace('/<script.*?>(.*?)<\/script>/is', '', $content);
            $content = preg_replace('/<style.*?>(.*?)<\/style>/is', '', $content);
        
            $p = new \sale\html\DOMParser($content);  
            $n = $p->parse(true); 
            $ns = \sale\html\Find::find($n, '.product_listing_container');
            
            $base = isset($ns[0]) ? $ns[0] : $n;
             
            
            $ns = \sale\html\Find::find($base, '.shopperActions');  
            echo "product: ", count($ns), PHP_EOL;
      
            foreach($ns as $node) {
                 
                 $parent = $node->getParent();
                 $price = \sale\html\Find::find($parent, '.crossed'); 
                 $price2 = \sale\html\Find::find($parent, '.label-red');   
                 $product_name = \sale\html\Find::find($parent, '.product_name'); 
                 $img = \sale\html\Find::find($parent, 'img'); 
                 
                 if(!isset($price[0]) || !isset($price2[0]) || !isset($product_name[0]) || !isset($img[0])) {
                     continue;
                 }
                 $a = $product_name[0]->getChilds()[0];
               // var_dump(  $price, $price2, $a, $img[0]->getAttribute('src') , $a);  exit();  
                
                $url = 'https://www.okeydostavka.ru/'.$a->getAttribute('href');
                $hash = md5($url);
                $model = new \sale\model\SaleItem();
                $model->setHash($hash);
           
                $title = $a->getData();
                $model->setTitle( $title );
                $model->setPriceOld(intval(  substr($price[0]->getData(), 0, strpos($price[0]->getData(), ',') ) ));
                $model->setPriceNew(intval(  substr($price2[0]->getData(), 0, strpos($price2[0]->getData(), ',') ) ));
                $model->setLink( $url );
                $model->setDateInsert(date('Y-m-d H:i'));
                $model->setHost($this->getName());
                $model->setImage(  'https://www.okeydostavka.ru/' . ltrim($img[0]->getAttribute('src') , '/') );
                $model->setPriceDiff(   ( 1 - $model->getPriceNew() / $model->getPriceOld()) * 100  );

                yield $model; 
            }
        }
        
        
        
             
    }

    
    
}
