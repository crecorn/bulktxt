<?php
class Bulktxts {
    public $modx;
    public $config = array();
    public function __construct(modX &$modx,array $config = array()) {
        $this->modx =& $modx;
        $basePath = '/core/components/bulktxt/';
        $assetsUrl ='/assets/components/bulktxt/';
        $this->config = array_merge(array(
            'basePath' => $basePath,
            'corePath' => $basePath,
            'modelPath' => $basePath.'model/',
            'processorsPath' => $basePath.'processors/',
            'templatesPath' => $basePath.'templates/',
            'chunksPath' => $basePath.'elements/chunks/',
            'jsUrl' => $assetsUrl.'js/',
            'cssUrl' => $assetsUrl.'css/',
            'assetsUrl' => $assetsUrl,
            'connectorUrl' => $assetsUrl.'connector.php',
        ),$config);
    }
}

// for debug purposes
$modx = new modX();
$modx->initialize('mgr');
$modx->log(modX::LOG_LEVEL_ERROR, 'builktxt class worrking!');