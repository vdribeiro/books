<?php

 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN', DOKU_INC . 'lib/plugins/');
require_once (DOKU_PLUGIN . 'action.php');
 
class action_plugin_novaedicao extends DokuWiki_Action_Plugin {
 
    /**
     * Return some info
     */
    function getInfo() {
        return array (
            'author' => 'Grupo1',
            'date'   => '22/11/2010',
            'name'   => 'NovaEdicao Plugin',
            'desc'   => 'Cria uma nova edicao do livro',
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
            'title' => 'Nome Edicao',
            'icon' => '../../plugins/novaedicao/images/novaedicao.png',
            'open' => '<novaedicao>',
            'close' => '</novaedicao>',
        );
    }
 
}