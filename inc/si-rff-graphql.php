<?php

/**
 * Arquivo de funções de conexão com o DB
 *  */

 //se chamar diretamente e não pelo wordpress, aborta
 if(!defined('WPINC')){
    die();
 }

 //Registrar tipos e campos no GraphQl
 add_action('graphql_register_types', 'register_custom_table_si_rff_in_graphql');
 function register_custom_table_si_rff_in_graphql(){
    register_graphql_object_type('CustomTableTypeSiRff', [
        'fields' => [
            'id' => [
                'type' => 'ID',
                'description' => __('ID of the item', 'your-textdomain'),
            ],
            'title' => [
                'type'=>'String',
                'description'=>__('Título do item do slide de imagem', 'your-textdomain'),
            ],
            'urlImg' => [
                'type' => 'String',
                'description' => __( 'Url da image do item do slide de imagem', 'your-textdomain' ),
            ],
            'urlLink' => [
                'type' => 'String',
                'description' => __( 'Url do link do item do slide de imagem', 'your-textdomain' ),
            ],
            'altText' => [
                'type' => 'String',
                'description' => __( 'Texto alternativo do item do slide de imagem', 'your-textdomain' ),
            ],
        ],
    ]);

    register_graphql_field('RootQuery', 'slide_image_rff', [
        'type'=>['list_of' => 'CustomTableTypeSiRff'],
        'description' => __('Query de consulta da tabela', 'your-textdomain'),
        'resolve' => function($root, $args, $context, $info){
            global $wpdb;
            $table_name = $wpdb->prefix.'slide_image_rff';
            $results = $wpdb->get_results("SELECT * FROM $table_name");
            return $results;
        }
    ]);
 }

