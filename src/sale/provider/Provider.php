<?php
 
namespace sale\provider;

/**
 * Description of Provider
 *
 * @author vench
 */
abstract class Provider implements IProvider {
    
    const TYPE_TEHNOSILA = 'tehnosila.ru';
    
    const TYPE_ELDORADO = 'eldorado.ru';
    
    const TYPE_MVIDEO = 'mvideo.ru';
    
    /**
     *
     * @var string 
     */
    private $name;
    
    /**
     * 
     * @param string $name
     */
    public function __construct($name) {
        $this->name = $name;
    }
    
    /**
     * 
     * @return string
     */
    public function getName() {
        return $this->name;    
    }
    
    
    
 
    /**
     * 
     * @param string $name
     * @return IProvider
     */
    public static function getProvider($name) {
        
        switch ($name) {
            case self::TYPE_TEHNOSILA:
                return new Tehnosila($name);
            case self::TYPE_ELDORADO:
                return new Eldorado($name);
            case self::TYPE_MVIDEO:
                return new Mvideo($name);
        }
        
        return null;
    }
}
