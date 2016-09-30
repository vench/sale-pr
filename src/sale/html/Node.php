<?php
 
namespace sale\html;

/**
 * Description of Node
 *
 * @author vench
 */
class Node {

    /**
     *
     * @var \sale\html\Node[]
     */
    private $childs;
    
    /**
     *
     * @var \sale\html\Node 
     */
    private $parent;
    
    /**
     *
     * @var string 
     */
    private $tagName;
    
    /**
     *
     * @var array
     */
    private $attributes;
    
    /**
     * Plaint text
     * @var string 
     */
    private $data;


    /**
     * 
     * @param string $tagName
     * @param array $attributes
     */
    public function __construct($tagName, $attributes = []) {
        $this->tagName = $tagName;
        $this->attributes = $attributes;
        $this->childs = [];
        $this->parent = null;
    }
    
    /**
     * 
     * @param \sale\html\Node $p
     */
    public function setParent(Node $p) {
        $this->parent = $p;
    }
    
    /**
     * 
     * @return  \sale\html\Node
     */
    public function getParent() {
        return $this->parent;
    }
    
    /**
     * 
     * @return string
     */
    public function getTagName() {
        return $this->tagName;
    }
    
    /**
     * 
     * @param \sale\html\Node $n
     */
    public function addChild(Node $n) {
        $n->setParent($this);
        $this->childs[] = $n;
    }
    
    /**
     * 
     * @return \sale\html\Node[]
     */
    public function getChilds() {
        return $this->childs;
    }
    
    /**
     * 
     * @return string
     */
    public function getData() {
        return trim($this->data);
    }
    
    /**
     * 
     * @param string $char
     */
    public function appendData($char) {
        $this->data .= $char;
    }
    
    /**
     * 
     * @param string $attrName
     * @return string
     */
    public function getAttribute($attrName) {
        return isset($this->attributes[$attrName]) ? $this->attributes[$attrName] : '';
    }
    
    
    /**
     * 
     * @return array
     */
    public function __debugInfo() {
        return [
            'tagName'   => $this->getTagName(),
            'parent'    => empty($this->getParent()) ? '---no---' : $this->getParent()->getTagName(),
            'childs'    => $this->getChilds(),    
            'data'      => $this->getData(),
            'attr'      =>  join(',', array_keys( $this->attributes )),
        ];
    }
    
}
