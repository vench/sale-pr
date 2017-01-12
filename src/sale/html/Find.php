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
            } else if($queryFirst == '#') { 
                if(strpos($c->getAttribute('id'), $queryreal) !== false) {
                    $nodes[] = $c; 
                } 
                $nodes = array_merge($nodes, self::find($c, $query));
            } else if($queryFirst == '*') {
                list($name, $value) = explode('=', $query);
                //var_dump(substr($name, 1) .'=>'. $value .'=>' . $c->getAttribute( substr($name, 1) ) ); 
                if($c->getAttribute( substr($name, 1) ) == $value ) {
                    $nodes[] = $c; 
                } 
                $nodes = array_merge($nodes, self::find($c, $query));
            } else {
                if($c->getTagName() == $query ) {
                    $nodes[] = $c; 
                } 
                $nodes = array_merge($nodes, self::find($c, $query));
            }
        }

        if(!empty($pathArr)) {

        }

        return $nodes;
    }
    
    
    /**
     * 
     * @param \sale\html\Node $n
     * @param type $path
     * @param type $debug
     * @return \sale\html\Node[]
     */
    public static function find2(Node $n, $path, $debug = false, $level = 0) {
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
               /* if($debug) {
                    echo $level, PHP_EOL;
                    var_dump($npath, $n->getTagName(). '#'. $n->getAttribute('id') . '.' . $n->getAttribute('class') .':' . count($n->getChilds())); 
                }*/
                $nodes[] = $c;
            }
            
            $find = self::find2($c, $path, $debug,  $level + 1 );
            if(!empty($find)) { 
                $nodes = array_merge($nodes, $find);
            }
        }
        
        return $nodes;
    }
}
