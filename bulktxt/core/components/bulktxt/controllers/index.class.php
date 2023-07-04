<?php
/**
 * manager controller
 * 
 */
require_once dirname(dirname(__FILE__)) . '/model/bulktxt.class.php';

abstract class BulktxtManagerController extends modExtraManagerController {
    // load JS
    public function initialize() {
        $this->addJavascript($this->bulktxt->config['jsUrl'].'mgr/bulktxt.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            // We could run some javascript here that runs on all of our controllers
            // for example something that loads your config
        });
        </script>');
    }

    //For lexicon
    public function getLanguageTopics() {
        return array('bulktxt:default');
    }

    //Check Permission
    public function checkPermissions() {
        return true;
    }
    public function process(array $scriptProperties = array()) {}
    public function getPageTitle() { return 'BulkTxt'; }

    // public function loadCustomCssJs() {
    //     $this->addJavascript($this->bulktxt->config['jsUrl'].'mgr/widgets/bulktxt.grid.js');
    //     $this->addJavascript($this->bulktxt->config['jsUrl'].'mgr/widgets/home.panel.js');
    //     $this->addLastJavascript($this->bulktxt->config['jsUrl'].'mgr/sections/index.js');
    // }

    public function getTemplateFile() {
        return 'home.tpl';
    }
}
 
class IndexManagerController extends BulktxtManagerController {
    // return to home controller
    public static function getDefaultController() {
        return 'home';
    }
}