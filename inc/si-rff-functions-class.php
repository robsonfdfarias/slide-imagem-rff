<?php

/**
 * Arquivo de funções de conexão com o DB
 *  */

 //se chamar diretamente e não pelo wordpress, aborta
 if(!defined('WPINC')){
    die();
 }
 
if(file_exists(SI_RFF_CORE_INC.'si-rff-upload-class.php')){
    require_once(SI_RFF_CORE_INC.'si-rff-upload-class.php');
 }

 $upload_si_rff = new SiRffUpload();

 /**
 * CRUD tabela slide_image_name_rff
 */
class SiRffConection {
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
        $retorno = $wpdb->delete(
            $table_name,
            array('id' => $id), //Condição para atualizar (WHERE id = $id)
            array('%d') //Tipo de dado da condição (%d indica que o valor é um inteiro)
        );
        if($retorno<=0 || $retorno==false){
            echo '<div class="notice notice-failure is-dismissible"><p>Não foi possível excluir o slide!</p></div>';
        }else{
            echo '<div class="notice notice-success is-dismissible"><p>Slide excluído com sucesso!</p></div>';
        }
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
        $status = 'Ativo';
        $results = $wpdb->get_results("SELECT * FROM $table_name WHERE tableId = $slideId AND statusItem = '$status'");
        return $results;
    }

    //Excluir o registro
    function slide_image_rff_excluir_dados($id, $img){
        global $upload_si_rff;
        $upload_si_rff->removeImage($img);
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



    //--------------------------- Adiciona no GraphQl ---------------------------------------//
    // function insertTableInGraphQl(){
    //     //Registrar tipos e campos no GraphQl
    //     add_action('graphql_register_types', 'register_custom_table_si_rff_in_graphql');
    //     //Registrar tipos e campos no GraphQl tabela name slide
    //     add_action('graphql_register_types', 'register_custom_table_si_rff_name_in_graphql');
    // }
}