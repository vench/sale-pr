<?php

namespace sale\dao;

/**
 */
class QuerySaleItem {

    /**
     *
     * @var int
     */
    public $offset = 0;

    /**
     *
     * @var int
     */
    public $limit = 10;

    /**
     *
     * @var string 
     */
    public $text;

    /**
     *
     * @var int
     */
    public $saleSize;

    /**
     * Tag id
     * @var int
     */
    public $tagId;

    /**
     *
     * @var array [0 => min, 1 => max]
     */
    public $price;
    public $notItemIds = null;

    /**
     * 
     * @param array $params
     */
    public function __construct($params = []) {
        foreach ($params as $field => $value) {
            if ($field == 'text') {
                $this->text = $value;
            }
            if ($field == 'saleSize') {
                $this->saleSize = $value;
            }
            if ($field == 'tag') {
                $this->tagId = $value;
            }
            if ($field == 'price') {
                $this->price = is_array($value) ? $value : [$value, $value];
            }
            if ($field == 'limit') {
                $this->limit = $value;
            }
            if ($field == 'notItemIds ') {
                $this->notItemIds = $value;
            }
        }
    }

    /**
     * 
     * @return \sale\dao\Condition
     */
    public function getCondition() {
        $params = [];
        $condition = '';
        $conditions = [];
        if (!empty($this->text)) {
            $conditions[] = 'title like :title';
            $params[':title'] = $this->text . '%';
        }
        if (!empty($this->saleSize)) {
            $conditions[] = 'price_diff >= :saleSize';
            $params[':saleSize'] = (int) $this->saleSize;
        }

        if (!empty($this->tagId)) {
            $conditions[] = 'id IN (SELECT item_id FROM sale_tag_item WHERE tag_id =:tag)';
            $params[':tag'] = (int) $this->tagId;
        }
        if (!empty($this->price) && ($this->getPriceMax() > $this->getPriceMin())) {

            $conditions[] = 'price_new BETWEEN :priceMin AND :priceMax';
            $params[':priceMin'] = $this->getPriceMin();
            $params[':priceMax'] = $this->getPriceMax();
        }
        if(!empty($this->notItemIds) && is_array($this->notItemIds)) {
            $keys = [];
            foreach ($this->notItemIds as $n => $id) {
                $key = ':notItemIds' . $n;
                $keys[] = $key;
                $params[$key] = $id;
            }
            $conditions[] = 'id NOT IN ('.join(',', $keys).')';
        }

        if (!empty($conditions)) {
            $condition = 'WHERE ' . join(' AND ', $conditions) . '';
        }

        return new Condition($condition, $params, 'ORDER BY price_diff DESC, price_new');
    }

    /**
     * 
     * @return int
     */
    public function getPriceMin() {
        return isset($this->price[0]) ? intval($this->price[0]) : 0;
    }

    /**
     * 
     * @return int
     */
    public function getPriceMax() {
        return isset($this->price[1]) ? intval($this->price[1]) : 0;
    }

    /**
     * 
     * @return string
     */
    public function getParams() {
        $params = [];
        if (!empty($this->text)) {
            $params['text'] = $this->text;
        }
        if (!empty($this->saleSize)) {
            $params['saleSize'] = $this->saleSize;
        }
        if (!empty($this->tagId)) {
            $params['tag'] = $this->tagId;
        }

        return empty($params) ? '' : http_build_query(['f' => $params]);
    }

}
