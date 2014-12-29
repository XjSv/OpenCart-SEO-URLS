<?php
// Load Configuration
if (file_exists('config.php')) {
    require_once('config.php');
}

// Connect to the DB
mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
mysql_select_db(DB_DATABASE);

// Products
$products = mysql_query("select * from " . DB_PREFIX . "product_description LIMIT 0, 100000");
while ($product = mysql_fetch_array($products, MYSQL_ASSOC)) {
    $seoname = toAscii($product['name']);
    $seourl  = "product_id=".$product['product_id'];

    $url_result = mysql_query("select * from " . DB_PREFIX . "url_alias where query='".$seourl."'");
    $data       = mysql_fetch_row($url_result);

    if(!$data) {
        mysql_query("insert into " . DB_PREFIX . "url_alias set query='".$seourl."', keyword='".$seoname."'");
        echo "<br>Inserted ".$seoname;
    }
}

// Categories
$categories = mysql_query("select * from " . DB_PREFIX . "category_description LIMIT 0, 100000");
while ($category = mysql_fetch_array($categories, MYSQL_ASSOC)) {
    $seoname = toAscii($category['name']);
    $seourl  = "category_id=".$category['category_id'];

    $url_result = mysql_query("select * from " . DB_PREFIX . "url_alias where query='".$seourl."'");
    $data       = mysql_fetch_row($url_result);

    if(!$data) {
        mysql_query("insert into " . DB_PREFIX . "url_alias set query='".$seourl."', keyword='".$seoname."'");
        echo "<br>Inserted ".$seoname;
    }
}

function toAscii($str) {
    $clean = trim($str);
    $clean = trim($clean, '-');
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower($clean);
    $clean = preg_replace("/[\/_|+ -]+/", '-', $clean);

    return $clean;
}

?>