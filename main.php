<?php


//mysql

$servername = "localhost";
$username = "root";
$password = "admin";

try {
    $conn = new PDO("mysql:host=$servername;dbname=testdb;charset=utf8", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully\n"; 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }


///end mysql



/*
$baseUrl = 'http://www.tehnosila.ru/search?q=1&p=';

for($i = 1; $i < 1000; $i ++) {
	
	 

	echo "{$i}\n";
	$url = $baseUrl . $i; 
	$html = file_get_contents($url);
	preg_match_all('/<div\s+class="price">\s+<span\s+class="number-old">(.*)<\/div>/isU', $html, $math);

	if(isset($math[1])) {
		foreach($math[1] as $math) {
			echo "{$math}\n\n";

			preg_match('/>(\d[\d\s]*)<.+>(\d[\d\s]*)</isU', $math, $prices);
			if(isset($prices[1]) && isset($prices[2])) {
				echo "Old:" . intval($prices[1]) . " => New: " . intval($prices[2]) . "\n\n";
			}
		}
	}

}*/



$baseUrl = 'http://www.tehnosila.ru/search?q=1&p=';

for($i = 1; $i < 1000; $i ++) {

//$url = 'http://www.tehnosila.ru/catalog/tv_i_video/televizory/televizory';
	echo "{$i}\n";
	$url = $baseUrl . $i; 
$html = file_get_contents($url);
preg_match_all('/<div\s+class="item-info"\s+id="item-info-\d+"\s+data-id="\d+">(.*)<div\s+class="delivery-info">/isU', $html, $math);
if(isset( $math[1])) {
	foreach($math[1] as $math) {
		if(strpos($math, 'number-old') === false) {
			continue;
		} //echo "{$math}\n\n"; exit();
		if(preg_match('/<div\s+class="price">\s+<span\s+class="number-old">(.*)<\/div>/isU', $math, $price) && isset($price[1])) {
			print_r( $price[1]);
			preg_match('/<span\s+class="was-word">.+<\/span>(.*)<span\s+class="currency">.+<\/span><\/span>\s+<span\s+class="number-new">(.*)<span\s+class="currency">/isU', $price[1], $prices);
			if(isset($prices[1]) && isset($prices[2])) {




				//echo "\nOld:" . intval(str_replace(' ','',$prices[1])) . " => New: " . intval(str_replace(' ','',$prices[2]) ). "\n\n";




				preg_match('/<div class="title">\s+<a.+href="(.*)"\s+title="(.*)"/isU', $math, $title);//title
				if(isset($title[1]) && isset($title[2])) {
					$sql = "INSERT INTO sale_item(
							    title,
							    price_old,
							    price_new,
							    link,hash,date_insert) VALUES (
							    :title, 
							    :price_old, 
							    :price_new, 
							    :link, 
							    :hash,NOW())";
					$stmt = $conn->prepare($sql);
					$stmt->execute([
						':title' => $title[2],
						':price_old'	=> intval(str_replace(' ','',$prices[1])),
						':price_new'	=> intval(str_replace(' ','',$prices[2])),
						':link'	=> $title[1],	
						':hash'	=> md5($title[1])
					]);
				}
			}
		}


	}
}



}





