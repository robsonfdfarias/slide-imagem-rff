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
    $table_name = $wpdb->prefix . 'slide_image_rff';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title varchar(200),
        urlImg varchar(150) NOT NULL,
        urlLink varchar(150) NOT NULL,
        altText varchar(255),
        PRIMARY KEY  (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
 }

function slide_image_rff_uninstall(){
    global $wpdb;
    $table_name = $wpdb->prefix. 'slide_image_rff';
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query($sql);
}

//  global $wpdb;
 define('SI_RFF_TABLE_NAME', 'slide_image_rff');

//Grava os dados na tabela
function slide_image_rff_gravar_dados($titulo, $urlImg, $urlLink, $altText){
    global $wpdb;
    $table_name = $wpdb->prefix.SI_RFF_TABLE_NAME;
    $wpdb->insert(
        $table_name,
        array(
            'title' => $titulo,
            'urlImg' => $urlImg,
            'urlLink' => $urlLink,
            'altText' => $altText,
        )
    );
}

//Recupera os dados da tabela
function slide_image_rff_recuperar_dados(){
    global $wpdb;
    $table_name = $wpdb->prefix.SI_RFF_TABLE_NAME;
    $results = $wpdb->get_results("SELECT * FROM $table_name");
    return $results;
}

//Excluir o registro
function slide_image_rff_excluir_dados($id, $img){
    $imgParts = explode('/', $img);
    $imgPath = SI_RFF_DIR_IMG.$imgParts[(sizeof($imgParts)-1)];
    // echo '<h1>Url da img a ser Excluida: '.$imgPath.'</h1>';
    if(file_exists($imgPath)){
        if(unlink($imgPath)){
            echo '<div class="notice notice-success is-dismissible"><p>Imagem excluída com sucesso!</p></div>';
        }else{
            echo '<div class="notice notice-failure is-dismissible"><p>Não foi possível excluir a imagem!</p></div>';
            die();
        }
    }else{
        echo '<div class="notice notice-failure is-dismissible"><p>Imagem não encontrada!</p></div>';
        die();
    }
    global $wpdb;
    $table_name = $wpdb->prefix.SI_RFF_TABLE_NAME;
    $wpdb->delete(
        $table_name,
        array('id' => $id), //Condição para atualizar (WHERE id = $id)
        array('%d') //Tipo de dado da condição (%d indica que o valor é um inteiro)
    );
}

//Editar registro
function slide_image_rff_editar_dados($id, $title, $urlImg, $urlLink, $altText){
    global $wpdb;
    $table_name = $wpdb->prefix.SI_RFF_TABLE_NAME;
    $wpdb->update(
        $table_name,
        array(// Um array associativo onde as chaves são os nomes das colunas e os valores são os novos dados a serem inseridos
            'title'=>$title,
            'urlImg' => $urlImg,
            'urlLink' => $urlLink,
            'altText' => $altText,
        ),
        array('id'=>$id), // Condição para atualizar (WHERE id = $id)
        array('%s'), // Tipo de dado dos valores novos (%s indica que o valor é uma string)
        array('%d') // Tipo de dado da condição (%d indica que o valor é um inteiro)
    );
}