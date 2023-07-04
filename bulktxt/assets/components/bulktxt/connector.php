<?php
/**
 * BulkTxt Connector
 *
 * @package bulktxt
 */

 $modx = new modX();
 $modx->initialize('mgr');
 $modx->log(modX::LOG_LEVEL_ERROR, 'connector section Called!');



require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

file_put_contents('connector_log.txt', 'Connector.php executed', FILE_APPEND);


$corePath = $modx->getOption('bulktxt.core_path', '/modx/core/components/bulktxt/');
require_once 'core/components/bulktxt/model/bulktxt.class.php';
$modx->bulktxt = new BulkTxt($modx);

$modx->lexicon->load('bulktxt:default');

/* handle request */
$path = $modx->getOption('processorsPath', '/modx/core/components/bulktxt/processors/bulktxt.processor.php');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bulktxt-form'])) {
    echo json_encode($_POST);
    exit();
}
