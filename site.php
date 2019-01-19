<?php

use \gallesweb\Page;

$app->get('/', function() {
    
	$page = new Page();

	$page->setTpl("index");

});

 ?>