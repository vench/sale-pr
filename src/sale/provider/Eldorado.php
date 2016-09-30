<?php 

namespace sale\provider;

/**
 * Description of Eldorado
 *
 * @author vench
 */
class Eldorado extends Provider {
    
    public function getAllSaleItem() { return [];
        $baseUrl = 'http://www.eldorado.ru/search/catalog.php?q=10&PAGEN_SEARCH=';
        //http://www.eldorado.ru/search/catalog.php?PAGEN_SEARCH=50&sort=price&type=asc&list_num=20&q=10
        for ($i = 50; $i < (int) (1000 / 10); $i ++) { 
            echo "{$i}\n";
            $url = $baseUrl . $i;
            $html = file_get_contents($url); var_dump($html);
            if(strpos($html, 'oldPrice') === false) {
                continue;
            }
            echo 1 , PHP_EOL;
            $items = null;
            preg_match_all('/<div\s+class="item">(.*)<\/div><div\s+class="item">/i', $html, $items);
            var_dump($items); exit();
            
        }
    }

}
