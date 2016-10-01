<?php



namespace app\util;

/**
 * Description of View
 *
 * @author vench
 */
class View {
    
    /**
     * 
     * @return string
     * @todo ТОже надо тянуть через конфиг
     */
    public static function getPathView() {
        return dirname(__FILE__) . '/../../resource/views';
    }

    /**
     * 
     * @param type $file
     * @param type $params
     * @param type $output
     * @return type
     * @throws \Exception
     */
    public static function renderPhp($file, $params = array(), $output = true) {
       
        $path = self::getPathView() .  DIRECTORY_SEPARATOR . $file;
        if(strpos($path, '.php') === FALSE) {
            $path .= '.php';
        }
        if(!file_exists($path)) {
           throw new \Exception("Not exists file view [{$file}, {$path}]");
        }
       
        ob_start();
        extract($params);
	extract(self::getHelperFunstions());
        include_once($path);
        $s = ob_get_contents();
        ob_end_clean();
           
        if($output) {
            echo $s;
        }
        return $s; 
    }


   public static function getHelperFunstions() {
	return [

		'priceFormat' => function($price){ return number_format($price, 0, ',', ' ') . ' р'; },
		'dateFormat'	=> function($dateStr){ return date('d.m.Y H:i', strtotime($dateStr)); }
	];

   }
}
