<?php
App::uses('DebugPanel', 'DebugKit.Lib');

class ConfigurePanel extends DebugPanel {
    public $plugin = 'ConfigurePanel';
    public $title = 'Config Data';

    public function beforeRender(Controller $controller) {
        return Configure::read();
    }
}
?>