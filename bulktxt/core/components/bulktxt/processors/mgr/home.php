<?php
require_once dirname(dirname(__FILE__)) . '/model/bulktxt.class.php';

require_once dirname(dirname(dirname(__FILE__))) . '/controllers/index.class.php';


$controller = new BulktxtHomeManagerController($modx);
$controller->initialize('mgr');
$controller->setProperties(array(
    'template' => 'home.tpl',
    'method' => 'process',
));
echo $controller->run();

//for debug
$modx = new modX();
$modx->initialize('mgr');
$modx->log(modX::LOG_LEVEL_ERROR, 'another home class working!');