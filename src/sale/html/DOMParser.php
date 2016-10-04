<?php

namespace sale\html;

/**
 * Description of DOMParser
 *
 * @author vench
 */
class DOMParser {
    
    private $html;


    public function __construct($html) {
       $this->html = $html;
    }
    
    /**
     * 
     * @return \sale\html\Node
     */
    public function parse($validate = false) {
        $html = $this->html;
        $len = strlen($html);
        $root = new Node('document');
        $current = $root;
        $t = '';
        $open = false;
         
        for($i = 0; $i < $len; $i ++) {
            $c = substr($html, $i, 1); 
            
            if($c == '<') {
                $open = true;
            }  else if($open && $c == '>' && substr($t, 0, 1) == '/') {
                $open = false;
                
                if($validate && strpos($t, $current->getTagName()) === false) {//@todo 
                   $msg = "Error open|close: {$t}  <> {$current->getTagName()}, pos: {$i}";
                   //throw new \Exception($msg);
                   echo $msg , PHP_EOL;
                   if(!is_null($current->getParent())){
                       $current =  $current->getParent(); 
                   }     
                } 
                $t = ''; 
                $current =  $current->getParent();
            } else if($open && $c == '>') {
                $open = false; 
                
                try { 
                    $n  = $this->createNodeBySelector($t); 
                } catch (\Exception $ex) { 
                    $t = '';
                    continue;
                } 
                
                $current->addChild($n);
                if(!$this->isSingle($n)) {
                     $current = $n;
                } 
                $t = '';
            } else if($open) {
                $t .= $c;
            } else if(!$open) {
                $current->appendData($c);
            }
        }
        
        
        
        return $root;
    }
    
    /**
     * 
     * @param \sale\html\Node $n
     * @return boolean
     */
    private function isSingle(\sale\html\Node $n) {
        $t = strtolower($n->getTagName());
        return in_array($t, ['img', 'br', 'hr', 'meta', 'link']);
    }
    
    /**
     * 
     * @param string $selector
     * @return \sale\html\Node
     */
    private function createNodeBySelector($selector) {
        $tag = null;
        preg_match('/(^[a-zA-Z]+)(\s.+)?/i', $selector, $tag);
        if(!isset($tag[1])) {
            throw new \Exception("Tag not found: {$selector}");
        } 
        $attr  = [];
        $attrStr = trim(substr($selector, strlen($tag[1])));
        $len = strlen($attrStr);
        $t = '';
        $key = '';
        for($i = 0; $i < $len; $i ++) {
            $c = substr($attrStr, $i, 1);
            
            if($c == '"' && empty($key)) {
                $key = trim($t); 
                $t = '';
            } else if($c == '"' && !empty($key)) { 
                $attr[$key] = trim($t);  
                $t = $key = '';
            } else  if($c == '='){ 
            } else {
                $t .= $c;
            }
        }
         
        $root = new Node($tag[1], $attr);
        return $root;
    }
}
