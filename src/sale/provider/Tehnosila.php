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

        for ($i = 1; $i < (int) (54768 / 30); $i ++) { 
            echo "{$i}\n";
            $url = $baseUrl . $i;
            $html = file_get_contents($url);
            preg_match_all('/<div\s+class="item-info"\s+id="item-info-\d+"\s+data-id="\d+">(.*)<div\s+class="delivery-info">/isU', $html, $math);
            if (isset($math[1])) {
                foreach ($math[1] as $math) {
                    if (strpos($math, 'number-old') === false) {
                        continue;
                    } //echo "{$math}\n\n"; exit();
                    if (preg_match('/<div\s+class="price">\s+<span\s+class="number-old">(.*)<\/div>/isU', $math, $price) && isset($price[1])) {
                        //print_r( $price[1]);
                        preg_match('/<span\s+class="was-word">.+<\/span>(.*)<span\s+class="currency">.+<\/span><\/span>\s+<span\s+class="number-new">(.*)<span\s+class="currency">/isU', $price[1], $prices);
                        if (isset($prices[1]) && isset($prices[2])) {  

                            preg_match('/<div class="title">\s+<a.+href="(.*)"\s+title="(.*)"/isU', $math, $title); //title
                            if (isset($title[1]) && isset($title[2])) {

                                $hash = md5($title[1]);
                                $model = new \sale\model\SaleItem();
                                $model->setHash($hash);
                                $model->setTitle($title[2]);
                                $model->setPriceOld(intval(str_replace(' ', '', $prices[1])));
                                $model->setPriceNew(intval(str_replace(' ', '', $prices[2])));
                                $model->setLink($title[1]);
                                $model->setDateInsert(date('Y-m-d H:i'));
                                $model->setHost($this->getName());
                                $model->getImage(null);
                                $model->setPriceDiff(   ( 1 - $model->getPriceNew() / $model->getPriceOld()) * 100  );

                                yield $model;
                            }
                        }
                    }
                }
            }
        }
    }

}
