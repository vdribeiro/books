<?php

 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN', DOKU_INC . 'lib/plugins/');
require_once (DOKU_PLUGIN . 'action.php');
 
class action_plugin_novolivro extends DokuWiki_Action_Plugin {
 
    /**
     * Return some info
     */
    function getInfo() {
        return array (
            'author' => 'Grupo1',
            'date'   => '25/11/2010',
            'name'   => 'NovoLivro Plugin',
            'desc'   => 'Cria um novo livro',
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
            'title' => 'Nome do Livro',
            'icon' => '../../plugins/novolivro/images/book_icon.png',
            'open' => '<novolivro>',
            'close' => '</novolivro>',
        );
    }
 
}