<?php

/**
 * Arquivo de funções de conexão com o DB
 *  */

 //se chamar diretamente e não pelo wordpress, aborta
 if(!defined('WPINC')){
    die();
 }

 global $wpdb;
 define('SI_RFF_TABLE_NAME', $wpdb->prefix.'slide_image_rff');

 register_activation_hook(__FILE__, 'slideImage_rff_install');
 function slideImage_rff_install(){
    $table_name = SI_RFF_TABLE_NAME;
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE IF NOT EXISTS $table_name(
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title varchar(200),
        urlImg varchar(150) NOT NULL,
        urlLink varchar(150) NOT NULL,
        altText varchar(255),
        PRIMARY KEY (id)
    ) $charset_collate;";
    require_once(ABSPATH.'wp-admin-/includes/upgrade.php');
    dbDelta($sql);
 }

 register_deactivation_hook(__FILE__, 'slideImage_rff_uninstall');
function slideImage_rff_uninstall(){
    $table_name = SI_RFF_TABLE_NAME;
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query($sql);
}

