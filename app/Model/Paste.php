<?php
App::uses('AppModel', 'Model');

class Paste extends AppModel {
    public $belongsTo = ['User'];
}
