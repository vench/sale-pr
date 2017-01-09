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
    
    const TYPE_OKEY = 'okeydostavka.ru';
    
    const TYPE_STOCK_ULMART = 'stock.ulmart.ru';
    
    const TYPE_YOOX = 'yoox.com';
    
    const TYPE_5KA = '5ka.ru';
    
    
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
            case self::TYPE_OKEY:
                return new Okey($name);
            case self::TYPE_STOCK_ULMART:
                return new StockUlmart($name);
            case self::TYPE_YOOX:
                return new Yoox($name);
            case self::TYPE_5KA:
                return new Peterochka($name);
        }
        
        return null;
    }
    
    
            
}
