<?php
 

namespace sale\command;

/**
 * Description of Pid
 *
 * @author vench
 */
class Pid {

    /**
     *
     * @var string
     */
    private $name;
    
    /**
     *
     * @var type 
     */
    private $fb;


    /**
     * 
     * @param string $name
     */
    public function __construct($name) {
        $this->name = $name;
    }
    
    /**
     * 
     * @return boolean
     */
    public function open() {
        
        $this->fb = fopen($this->getFile(), 'w+');
        if($this->fb === false || !flock($this->fb, LOCK_EX | LOCK_NB)) {
            return false;
        } 
        
        return true;
    }
    
    /**
     * 
     */
    public function close() {
        if(is_resource($this->fb)) {
            flock($this->fb, LOCK_UN | LOCK_NB);
            fclose($this->fb);
        }  
    }
    
    /**
     * 
     */
    public function __destruct() {
        $this->close();
    }
    
    /**
     * 
     * @return string
     */
    private function getFile() {
        $file = './' . $this->name . '.pid';
        return $file;
    }
        
}
