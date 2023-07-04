<?php
/**
 * BulkTxt Connector
 *
 * @package bulktxt
 */

 $modx = new modX();
 $modx->initialize('mgr');
 $modx->initialize('web');

require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$corePath = '/components/bulktxt/processors/bulktxt.processor.php';
require_once 'core/components/bulktxt/model/bulktxt.class.php';

$modx->lexicon->load('bulktxt:default');

/* handle request */
$path = '/core/components/bulktxt/processors/bulktxt.processor.php';
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));


$modx->log(modX::LOG_LEVEL_ERROR, 'connector class worrking!');