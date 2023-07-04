<?php
/**/
class BulktxtHomeManagerController extends BulktxtManagerController {
    public function process(array $scriptProperties = array()) {
        return '<h2 class="bulktxt-page-header">Test Output</p>'; //testing this to work then add the form
    }
    public function getPageTitle() {
        return 'Bulk Txt Page';
    }

    // public function loadCustomCssJs() {
    //     $this->addJavascript($this->bulktxt->config['jsUrl'].'mgr/widgets/bulktxt.grid.js');
    // }
}
