<?php

/**
 * Arquivo de funções de conexão com o DB
 *  */

 //se chamar diretamente e não pelo wordpress, aborta
 if(!defined('WPINC')){
    die();
 }
 

 function slide_image_rff_install(){
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    //Instala a tabela com o nome dos carrosseis
    $table_name_slide = $wpdb->prefix . 'slide_image_name_rff';
    $sql2 = "CREATE TABLE $table_name_slide (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title varchar(200),
        slideStatus varchar(15) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql2);
    //Instala a tabela com o conteudo do slide
    $table_name = $wpdb->prefix . 'slide_image_rff';
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title varchar(200),
        urlImg varchar(150) NOT NULL,
        urlLink varchar(150) NOT NULL,
        altText varchar(255),
        orderItems mediumint(15),
        statusItem varchar(20),
        tableId mediumint(9) NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (tableId) REFERENCES $table_name_slide(id)
    ) $charset_collate;";
    dbDelta($sql);
 }

function slide_image_rff_uninstall(){
    global $wpdb;
    //Desinstala a tabela slide_image_rff
    $table_name = $wpdb->prefix . 'slide_image_rff';
    $sql2 = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query($sql2);
    //Desinstala a tabela slide_image_name_rff
    $table_name_slide = $wpdb->prefix . 'slide_image_name_rff';
    $sql = "DROP TABLE IF EXISTS $table_name_slide;";
    $wpdb->query($sql);
}

