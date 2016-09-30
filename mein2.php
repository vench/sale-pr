<?php


require_once dirname(__FILE__) . '/src/AutoLoad.php';  

AutoLoad::init();

$baseUrl = 'http://www.mvideo.ru/product-list?Ntt=1&Nty=1&Dy=1&Nrpp=12&_requestid=4108254';
$baseUrl = 'http://www.mvideo.ru/product-list?Ntt=1&Nty=1&Dy=1&Nrpp=12&_requestid=4108254';
$html = file_get_contents($baseUrl);


function top($n, $query) { 
    return sale\html\Find::top($n, $query);
}

function find(sale\html\Node $n, $path) {
     return sale\html\Find::find($n, $path);
}

$p = new sale\html\DOMParser($html);
$n = $p->parse();

$nodes = find($n, '.product-price-old');
foreach($nodes as $node) {
    $top = top($node, '.showcompare');
    if(!is_null($top)) {
    
    
    $nodes1 = find($top, '.product-price-current');
    $img = find($top, '.product-tile-picture-image');
    $title = find($top, '.product-tile-title-link');
    
    if(count($title) > 0) {
        echo $title[0]->getAttribute('data-track-label'), PHP_EOL;
    }
     
        //echo '>>', $img->getData(); echo "\n";
        print_r($node->getData() . " > " . $nodes1[0]->getData());
    echo "\n\n";
    }
    
    
}



//http://www.mvideo.ru/product-list?Dy=1&No=36&Nr=AND%28product.searchable%3A1%2Cproduct.siteId%3ASite_6%29&Nrpp=12&Ntt=1&Nty=1&_=1473832235682
//http://www.mvideo.ru/product-list?Dy=1&No=24&Nr=AND%28product.searchable%3A1%2Cproduct.siteId%3ASite_6%29&Nrpp=12&Ntt=1&Nty=1&_=1473832235683
//http://www.mvideo.ru/product-list?Dy=1&No=12&Nr=AND%28product.searchable%3A1%2Cproduct.siteId%3ASite_6%29&Nrpp=12&Ntt=1&Nty=1&_=1473832235684
//http://www.mvideo.ru/product-list?Dy=1&No=0&Nr=AND%28product.searchable%3A1%2Cproduct.siteId%3ASite_6%29&Nrpp=12&Ntt=1&Nty=1&_=1473832235685
//5 840
