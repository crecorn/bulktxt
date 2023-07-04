<?php
/*
* BulkTxt Building Script
*
*
*/


/* bulktxt building script */
echo 'Building BulkTxt package';

$root = dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/';
/* variables for package */
define('PKG_NAME','BulkTxt');
define('PKG_NAME_LOWER', strtolower(PKG_NAME));
define('PKG_VERSION','1.0.5.9');
define('PKG_RELEASE','alpha7');
define('MODX_CORE_PATH', $root . 'core/');
define('MODX_ASSET_PATH', $root . 'assets/');
$pack_dir = $root . 'assets/components/' . PKG_NAME_LOWER . '/';
/* File Paths */
$sources = array(
    'root' => $root, 
    'build' => $pack_dir . '_build/',
    'data' => $pack_dir . '_build/data/',
    'validators' => $pack_dir . '_build/validators/',
    'ressolvers' => $pack_dir . '_build/ressolvers/',
    'source_assets' => $root . 'assets/components/' . PKG_NAME_LOWER . '/assets/components/' . PKG_NAME_LOWER,
    'source_core' => $root . 'assets/components/' . PKG_NAME_LOWER . '/core/components/' . PKG_NAME_LOWER,
    'docs' => $root . 'core/components/' . PKG_NAME_LOWER . '/docs/',
    'packages' => $root . 'core/packages',
);
unset($root, $pack_dir);


// initialize modx
use MODX\Revolution\Transport\modPackageBuilder;
require_once $sources['root'] . '/core/model/modx/modx.class.php';
$modx = new modX();
$modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');

/* load package builder and create the package */
$modx->loadClass('transport.modPackageBuilder', '', false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME_LOWER, PKG_VERSION, PKG_RELEASE);
$builder->registerNamespace(PKG_NAME_LOWER, false, true, '{core_path}components/' . PKG_NAME_LOWER .'/');

/* Creating menu */
$menu = $modx->newObject('modMenu');
$menu->fromArray(array(
    'text' => 'bulktxt',
    'namespace' => 'bulktxt',
    'action' => 'index',
    'parent' => 'components',
    'description' => 'create multiple resources with txt files',
    'icon' => '',
    'menuindex' => '0',
    'params' => '',
    'handler' => '',
), '', true, true);

$vehicle = $builder->createVehicle($menu, array(
    xPDOTransport::PRESERVE_KEYS => true,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::UNIQUE_KEY => 'text',
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array(
        'Action' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => array('namespace', 'controller'),
        ),
    ),
));

$builder->putVehicle($vehicle);
unset($vehicle);

/* function  to remove '<?php ?>', for clean snippets and plugins imports */

if (! function_exists('getSnippetContent')) {
    function getSnippetContent($filename) {
        $o = file_get_contents($filename);
        $o = str_replace('<?php','',$o);
        $o = str_replace('?>','',$o);
        $o = trim($o);
        return $o;
    }
}

/* create the snippets object to be package */
// did not add thee other snippets yet plaanning to add them afterr fix the Custom Manager Page
$obj = $modx->newObject('modSnippet');

// create the main snippet bulktxt
$obj->set('name', 'BulkTxt');
$obj->set('description', PKG_NAME . ' ' . PKG_VERSION . ' create multiple resources using the txt files');
$obj->setContent(getSnippetContent($sources['source_core'] . '/snippets/BulkTxt.snippet.php'));

/* create the category object */
$category = $modx->newObject('modCategory');
$category->set('id', 1);
$category->set('category', PKG_NAME);

// adding snippet to our category (same for chunks etc)
$snippets = array();
$snippets[] = $obj;
$category->addMany($snippets);

/* attributes for vehicle */
$attr = array(
    xPDOTransport::UNIQUE_KEY => 'category',
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::RELATED_OBJECTS => true,  
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array(
        'Snippets' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',
        ),
        /*
        'Snipppets' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',
        ),*/
    ),
);

/* create vehicle */
$vehicle = $builder->createVehicle($category, $attr);

// resolver here

$vehicle->resolve('file', array(
    'type' => 'file',
    'source' => $sources['source_assets'],
    'target' => "return MODX_ASSETS_PATH . 'components/';",
    'options' => array(
        'chmod' => '0755', // to fix the can't write permission in some cases
    ),
));

$vehicle->resolve('file', array(
    'type' => 'file',
    'source' => $sources['source_core'],
    'target' => "return MODX_CORE_PATH . 'components/';",
    'options' => array(
        'chmod' => '0755',
    ),
));

/* vehicle to transport package */
$builder->putVehicle($vehicle);

/* package compile */
$builder->pack();
echo '<br /> Package complete';

?>