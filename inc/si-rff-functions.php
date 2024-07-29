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


/**
 * CRUD tabela slide_image_name_rff
 */
//  global $wpdb;
define('SI_RFF_TABLE_NAME_SLIDE', 'slide_image_name_rff');

//Grava os dados na tabela
function slide_image_name_rff_gravar_dados($titulo, $slideStatus){
    global $wpdb;
    $table_name = $wpdb->prefix.SI_RFF_TABLE_NAME_SLIDE;
    $wpdb->insert(
        $table_name,
        array(
            'title' => $titulo,
            'slideStatus' => $slideStatus,
        )
    );
}

//Recupera os dados da tabela
function slide_image_name_rff_recuperar_dados(){
    global $wpdb;
    $table_name = $wpdb->prefix.SI_RFF_TABLE_NAME_SLIDE;
    $results = $wpdb->get_results("SELECT * FROM $table_name");
    return $results;
}

//Recupera os dados da tabela por id
function slide_image_name_rff_recuperar_dados_por_ID($id){
    global $wpdb;
    $idd = sanitize_text_field($id);
    $table_name = $wpdb->prefix.SI_RFF_TABLE_NAME_SLIDE;
    $results = $wpdb->get_results("SELECT * FROM $table_name WHERE id=$idd");
    return $results[0];
}

//Excluir o registro
function slide_image_name_rff_excluir_dados($id){
    global $wpdb;
    $table_name = $wpdb->prefix.SI_RFF_TABLE_NAME_SLIDE;
    $wpdb->delete(
        $table_name,
        array('id' => $id), //Condição para atualizar (WHERE id = $id)
        array('%d') //Tipo de dado da condição (%d indica que o valor é um inteiro)
    );
}

//Editar registro
function slide_image_name_rff_editar_dados($id, $title, $slideStatus){
    global $wpdb;
    $table_name = $wpdb->prefix.SI_RFF_TABLE_NAME_SLIDE;
    $retorno = $wpdb->update(
        $table_name,
        array(// Um array associativo onde as chaves são os nomes das colunas e os valores são os novos dados a serem inseridos
            'title'=>$title,
            'slideStatus' => $slideStatus,
        ),
        array('id'=>$id), // Condição para atualizar (WHERE id = $id)
        array('%s'), // Tipo de dado dos valores novos (%s indica que o valor é uma string)
        array('%d') // Tipo de dado da condição (%d indica que o valor é um inteiro)
    );
    if($retorno<=0 || $retorno==false){
        echo '<div class="notice notice-failure is-dismissible"><p>Não foi possível fazer a atualização!</p></div>';
    }else{
        echo '<div class="notice notice-success is-dismissible"><p>Slide editado com sucesso!</p></div>';
    }
}



/**
 * CRUD tabela slide_image_rff
 */
//  global $wpdb;
 define('SI_RFF_TABLE_NAME', 'slide_image_rff');

//Grava os dados na tabela
function slide_image_rff_gravar_dados($titulo, $urlImg, $urlLink, $altText, $tableId, $orderItems, $statusItem){
    global $wpdb;
    $table_name = $wpdb->prefix.SI_RFF_TABLE_NAME;
    $wpdb->insert(
        $table_name,
        array(
            'title' => $titulo,
            'urlImg' => $urlImg,
            'urlLink' => $urlLink,
            'altText' => $altText,
            'tableId' => $tableId,
            'orderItems' => $orderItems,
            'statusItem' => $statusItem,
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

//Recupera os dados da tabela por slide
function slide_image_rff_recuperar_dados_by_slide($slideId){
    global $wpdb;
    $table_name = $wpdb->prefix.SI_RFF_TABLE_NAME;
    $results = $wpdb->get_results("SELECT * FROM $table_name WHERE tableId = $slideId");
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
function slide_image_rff_editar_dados($id, $title, $urlImg, $urlLink, $altText, $tableId, $orderItems, $statusItem){
    global $wpdb;
    $table_name = $wpdb->prefix.SI_RFF_TABLE_NAME;
    $retorno = $wpdb->update(
        $table_name,
        array(// Um array associativo onde as chaves são os nomes das colunas e os valores são os novos dados a serem inseridos
            'title'=>$title,
            'urlImg' => $urlImg,
            'urlLink' => $urlLink,
            'altText' => $altText,
            'tableId' => $tableId,
            'orderItems' => $orderItems,
            'statusItem' => $statusItem,
        ),
        array('id'=>$id), // Condição para atualizar (WHERE id = $id)
        array('%s'), // Tipo de dado dos valores novos (%s indica que o valor é uma string)
        array('%d') // Tipo de dado da condição (%d indica que o valor é um inteiro)
    );
    if($retorno<=0 || $retorno==false){
        echo '<div class="notice notice-failure is-dismissible"><p>Não foi possível editar o registro!</p></div>';
    }else{
        echo '<div class="notice notice-success is-dismissible"><p>Dados alterados com sucesso!</p></div>';
    }
}