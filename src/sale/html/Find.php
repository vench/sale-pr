<?php 

namespace sale\html;

/**
 * Description of Find
 *
 * @author vench
 */
class Find {

    /**
     * 
     * @param \sale\html\Node $n
     * @param string $query
     * @return \sale\html\Node
     */
    public static function top(Node $n, $query) { 
        $queryFirst = substr($query, 0, 1); 
        $queryreal = $query;
        if($queryFirst == '.') {
            $queryreal = substr($queryreal, 1);
        }

        while(!is_null($n = $n->getParent())) {
            if($queryFirst == '.') { 
                if(strpos($n->getAttribute('class'), $queryreal) !== false) {
                    return $n;
                } 
            }
        }
        return null;
    }
    
    /**
     * 
     * @param \sale\html\Node $n
     * @param string[] $path
     * @return \sale\html\Node[]
     * @todo more find level
     */
    public static function find(Node $n, $path) {
        $nodes = [];
        $pathArr = explode(' ', $path);
        $query = array_shift($pathArr); 
        $queryFirst = substr($query, 0, 1);

        $queryreal = $query;
        if($queryFirst == '.') {
            $queryreal = substr($queryreal, 1);
        }

        foreach($n->getChilds() as $c) {
            if($queryFirst == '.') { 
                if(strpos($c->getAttribute('class'), $queryreal) !== false) {
                    $nodes[] = $c; 
                } 
                $nodes = array_merge($nodes, self::find($c, $query));
            }
        }

        if(!empty($pathArr)) {

        }

        return $nodes;
    }
    
    
    public static function find2(Node $n, $path) {
        $nodes = [];
        
        foreach($n->getChilds() as $c) {
            $npath = $c->getTagName(); 
            if(strpos($path, '#') !== false && !empty($id = $c->getAttribute('id'))) {
                $npath .= '#' . $id;
            }
            if(strpos($path, '.') !== false && !empty($klass = $c->getAttribute('class'))) {
                $npath .= '.' . join('.', explode(' ', $klass));
            } 
            if(strpos($path, '>') !== false && !empty($parent = $c->getParent())) {
                $npath = $parent->getTagName() . ' > ' . $npath;
            }
            
            if(strpos($npath, $path) !== false ) {
                $nodes[] = $c;
            }
            
            $childs = self::find2($c, $path);
            if(!empty($childs)) {
                $nodes = array_merge($nodes, $childs);
            }
        }
        
        return $nodes;
    }
}
