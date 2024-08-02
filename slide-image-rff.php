<?php

/*
Plugin Name: Slide image RFF
Plugin URI: http://exemplo.com
Description: Cria um slide de imagens com área de administração para facilitar para o usuário comum.
Version: 2.0
Author: Robson Ferreira de Farias
Email: robsonfdfarias@gmail.com
Author URI: http://infocomrobson.com.br
License: GPL2
*/

 //se chamar diretamente e não pelo wordpress, aborta
 if(!defined('WPINC')){
    die();
 }

 //Definição das constantes
 define('SI_RFF_CORE_INC', dirname(__FILE__).'/inc/'); //Caminho da pasta dos arquivos PHP
 define('SI_RFF_DIR_IMG', dirname(__FILE__).'/img/'); //Caminho da pasta das imagens
 define('SI_RFF_URL_IMG', plugins_url('img/', __FILE__)); //Caminho da pasta das imagens
 define('SI_RFF_URL_CSS', plugins_url('css/', __FILE__)); //Caminho da pasta dos arquivos CSS
 define('SI_RFF_URL_JS', plugins_url('js/', __FILE__)); //Caminho da pasta dos arquivos JS

 //  global $wpdb;
 define('SI_RFF_TABLE_NAME_SLIDE', 'slide_image_name_rff');
 
 //  global $wpdb;
 define('SI_RFF_TABLE_NAME', 'slide_image_rff');
 

 
// Adiciona um link de detalhes à lista de ações do plugin
function si_rff_adicionar_link_detalhes($links) {
  // $link_detalhes = '<a href="#" class="si-rff-detalhes-link">Detalhes</a>';
  $link_detalhes = '<a href="#" class="si-rff-detalhes-link">Detalhes</a>';
  array_unshift($links, $link_detalhes);
  return $links;
}
//adicionar do lado do botão desativar plugin
// add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'si_rff_adicionar_link_detalhes');


//adicionar do lado do autor
function adicionar_link_detalhes_meta($links, $file) {
  if ($file == plugin_basename(__FILE__)) {
      $link_detalhes = '<a href="#" class="si-rff-detalhes-link">Detalhes</a>';
      array_push($links, $link_detalhes);
  }
  return $links;
}
add_filter('plugin_row_meta', 'adicionar_link_detalhes_meta', 10, 2);

// Adiciona o CSS e JS necessários para o modal
function si_rff_adicionar_scripts() {
  wp_enqueue_style('si-rff-modal-css', plugin_dir_url(__FILE__) . 'css/si-rff-modal.css');
  wp_enqueue_script('si-rff-modal-js', plugin_dir_url(__FILE__) . 'js/si-rff-modal.js', array('jquery'), null, true);
}

add_action('admin_enqueue_scripts', 'si_rff_adicionar_scripts');




 /**
  * Registrando o css (frontend)
  */
  function si_rff_registre_css_core(){
    wp_enqueue_style('si-rff-css-core', SI_RFF_URL_CSS.'si-rff-core.css', null, time(), 'all');
  }
  add_action('wp_enqueue_scripts', 'si_rff_registre_css_core');

 /**
  * Registrando o js (frontend)
  */
  function si_rff_registre_js_core(){
    if(!did_action('wp_enqueue_media')){
        wp_enqueue_media();
    }
    wp_enqueue_script('si-rff-js-core', SI_RFF_URL_JS.'si-rff-core.js', null, time(), 'all');
  }
  add_action('wp_enqueue_scripts', 'si_rff_registre_js_core');
  
 /**
  * Registrando o css (backend)
  */
  function si_rff_registre_css_admin(){
    wp_enqueue_style('si-rff-css-admin', SI_RFF_URL_CSS.'si-rff-admin.css', null, time(), 'all');
  }
  add_action('admin_enqueue_scripts', 'si_rff_registre_css_admin');
  

 /**
  * Registrando o js (backend)
  */
  function si_rff_registre_js_admin(){
    if(!did_action('wp_enqueue_media')){
        wp_enqueue_media();
    }
    wp_enqueue_script('si-rff-js-admin', SI_RFF_URL_JS.'si-rff-admin.js', null, time(), 'all');
    // Passar a URL do plugin para o script JavaScript
    wp_localize_script('si-rff-js-admin', 'siRffData', array(
        'pluginUrl' => plugins_url('', __FILE__)
    ));
  }
  add_action('admin_enqueue_scripts', 'si_rff_registre_js_admin');
  
  
  /**
   * Includes PHP
   */
if(file_exists(plugin_dir_path(__FILE__).'si-rff-core.php')){
    require_once(plugin_dir_path(__FILE__).'si-rff-core.php');
}

if(file_exists(SI_RFF_CORE_INC.'si-rff-hooks.php')){
    require_once(SI_RFF_CORE_INC.'si-rff-hooks.php');
}

register_activation_hook(__FILE__, 'slide_image_rff_install');
register_deactivation_hook(__FILE__, 'slide_image_rff_uninstall');

if(file_exists(SI_RFF_CORE_INC.'si-rff-graphql.php')){
    require_once(SI_RFF_CORE_INC.'si-rff-graphql.php');
}
//Registrar tipos e campos no GraphQl
add_action('graphql_register_types', 'register_custom_table_si_rff_in_graphql');
//Registrar tipos e campos no GraphQl tabela name slide
add_action('graphql_register_types', 'register_custom_table_si_rff_name_in_graphql');
