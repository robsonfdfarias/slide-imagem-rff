<?php

/**
 * Plugin Name: Slide image RFF
 * Plugin URI: http://exemplo.com
 * Description: Cria um slide de imagens com área de administração para facilitar para o usuário comum.
 * Version: 1.0
 * Author: Robson Ferreira de Farias
 * Email: robsonfdfarias@gmail.com
 * Author URI: http://infocomrobson.com.br
 * License: GPL2
 *  */

 //se chamar diretamente e não pelo wordpress, aborta
 if(!defined('WPINC')){
    die();
 }

 //Definição das constantes
 define('SI_RFF_CORE_INC', dirname(__FILE__).'/inc/'); //Caminho da pasta dos arquivos PHP
 define('SI_RFF_DIR_IMG', dirname(__FILE__).'/img/'); //Caminho da pasta das imagens
 define('SI_RFF_URL_IMG', plugin_url('img/', __FILE__)); //Caminho da pasta das imagens
 define('SI_RFF_URL_CSS', plugin_url('css/', __FILE__)); //Caminho da pasta dos arquivos CSS
 define('SI_RFF_URL_JS', plugin_url('js/', __FILE__)); //Caminho da pasta dos arquivos JS

 /**
  * Registrando o css (frontend)
  */
  function si_rff_registre_css_core(){
    wp_enqueue_style('si-rff-css-core', SI_RFF_URL_CSS.'si-rff-core.css', null, time(), 'all');
  }
  add_action('wp_enqueue_scripts', 'si_rff_registre_css_core');

 /**
  * Registrando o css (frontend)
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
  add_action('wp_enqueue_scripts', 'si_rff_registre_css_admin');
  
  /**
   * Includes PHP
   */
if(file_exists(SI_RFF_CORE_INC.'si-rff-functions.php')){
    require_once(SI_RFF_CORE_INC.'si-rff-functions.php');
}