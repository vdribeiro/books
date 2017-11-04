<?php

 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN', DOKU_INC . 'lib/plugins/');
require_once (DOKU_PLUGIN . 'action.php');
 
class action_plugin_compare extends DokuWiki_Action_Plugin {
 
    /**
     * Return some info
     */
    function getInfo() {
        return array (
            'author' => 'Grupo1',
            'date'   => '2/12/2010',
            'name'   => 'Compare Plugin',
            'desc'   => 'Compara edicoes',
        );
    }
 
    /**
     * Register the eventhandlers
     */
    function register(&$controller) {
        $controller->register_hook('TOOLBAR_DEFINE', 'AFTER', $this, 'insert_button', array ());
    }
 
    /**
     * Inserts the toolbar button
     */
    function insert_button(& $event, $param) {
        $event->data[] = array (
            'type' => 'format',
            'title' => 'Compara',
            'icon' => '../../plugins/comparar/images/comp_icon.png',
            'open' => '<comparar>',
            'close' => '</comparar>',
        );
    }
 
}