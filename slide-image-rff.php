<?php

/*
Plugin Name: Slide image RFF
Plugin URI: http://exemplo.com
Description: Cria um slide de imagens com área de administração para facilitar para o usuário comum.
Version: 1.0
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

 
// Adiciona um link de detalhes à lista de ações do plugin
function si_rff_adicionar_link_detalhes($links) {
  // $link_detalhes = '<a href="#" class="si-rff-detalhes-link">Detalhes</a>';
  $link_detalhes = '<a href="#" class="si-rff-detalhes-link">Detalhes</a>';
  array_unshift($links, $link_detalhes);
  return $links;
}

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'si_rff_adicionar_link_detalhes');

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
  }
  add_action('admin_enqueue_scripts', 'si_rff_registre_js_admin');
  
  
  /**
   * Includes PHP
   */
if(file_exists(plugin_dir_path(__FILE__).'si-rff-core.php')){
    require_once(plugin_dir_path(__FILE__).'si-rff-core.php');
}

if(file_exists(SI_RFF_CORE_INC.'si-rff-functions.php')){
    require_once(SI_RFF_CORE_INC.'si-rff-functions.php');
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

echo '<div id="si-rff-modal" class="si-rff-modal">
<div class="si-rff-modal-content">
    <span class="si-rff-modal-close">&times;</span>
    <h1>Informações importantes sobre o plugin Slide Image Rff</h1>
    <h2>
      Como usar o schortcode?
    </h2>
    <p style="padding-left: 20px;">
        - Modelo 1:
    </p>
    <p style="padding-left: 40px;">
        [si_rff_1 slideid="1"]<br>
        Aqui o slideid="1" indica que eu quero o slide com o id 1, para especificar qual slide quero usar.<br>
        <img src="'.plugins_url('/', __FILE__).'si_rff_id_slide.png"><br>
        Obs: O modelo 1 foi desenvolvido para ser inserido e executado com uma proporção de 750px X 235px, por isso, as imagens devem ter essa proporção
    </p>
    <p style="padding-left: 20px;">
        - Modelo 2:
    </p>
    <p style="padding-left: 40px;">
        [si_rff_2 slideid="1"]<br>
        Aqui o slideid="1" indica que eu quero o slide com o id 1, para especificar qual slide quero usar.<br>
        <img src="'.plugins_url('/', __FILE__).'si_rff_id_slide.png">
    </p>
    <br>
    <h2>Mais detalhes</h2>
    <p>As instruções de como usar estão disponíveis no github, seguem os links importantes:</p>
    <p style="padding-left:40px; margin-top: -15px;">
      Url do Github: <a href="https://github.com/robsonfdfarias/slide-imagem-rff">https://github.com/robsonfdfarias/slide-imagem-rff</a><br>
      Linkedin do author: <a href="https://www.linkedin.com/in/robson-farias-a8b01723a/">Robson Farias</a><br>
      Email de contato: robsonfdfarias@gmail.com<br>
      Canal do youtube: <a href="https://www.youtube.com/c/Inform%C3%A1ticacomRobsonFarias">Canal informática com Robson Farias</a><br>
    </p>
</div>
</div>
';