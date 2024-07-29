<?php

/**
 * Arquivo de funções de conexão com o DB
 *  */

 //se chamar diretamente e não pelo wordpress, aborta
 if(!defined('WPINC')){
    die();
 }

 //Registrar tipos e campos no GraphQl tabela name slide
 add_action('graphql_register_types', 'register_custom_table_si_rff_name_in_graphql');
 function register_custom_table_si_rff_name_in_graphql(){
    register_graphql_object_type('CustomTableTypeSiRffName', [
        'fields' => [
            'id' => [
                'type' => 'ID',
                'description' => __('ID of the item', 'your-textdomain'),
            ],
            'title' => [
                'type'=>'String',
                'description'=>__('Título do item do slide de imagem', 'your-textdomain'),
            ],
            'slideStatus' => [
                'type' => 'String',
                'description' => __( 'status do slide', 'your-textdomain' ),
            ],
        ],
    ]);

    register_graphql_field('RootQuery', 'slide_image_name_rff', [
        'type'=>['list_of' => 'CustomTableTypeSiRffName'],
        'description' => __('Query de consulta da tabela', 'your-textdomain'),
        'args' => [
             'id' => [
                 'type' => 'ID',
                 'description' => __('ID of the item', 'your-textdomain'),
             ],
             'title' => [
                 'type' => 'String',
                 'description' => __('Título do item do slide de imagem', 'your-textdomain'),
             ],
         ],
        'resolve' => function($root, $args, $context, $info){
            global $wpdb;
            $table_name_slide = $wpdb->prefix.'slide_image_name_rff';
            $results = $wpdb->get_results("SELECT * FROM $table_name_slide");
            return $results;
        }
    ]);
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
           'orderItems' => [
               'type' => 'int',
               'description' => __( 'Texto alternativo do item do slide de imagem', 'your-textdomain' ),
           ],
           'statusItem' => [
               'type' => 'String',
               'description' => __( 'Texto alternativo do item do slide de imagem', 'your-textdomain' ),
           ],
       ],
   ]);

   register_graphql_field('RootQuery', 'slide_image_rff', [
       'type'=>['list_of' => 'CustomTableTypeSiRff'],
       'description' => __('Query de consulta da tabela', 'your-textdomain'),
       'args' => [
            'id' => [
                'type' => 'ID',
                'description' => __('ID of the item', 'your-textdomain'),
            ],
            'title' => [
                'type' => 'String',
                'description' => __('Título do item do slide de imagem', 'your-textdomain'),
            ],
            'orderItems' => [
                'type' => 'String',
                'description' => __('Título do item do slide de imagem', 'your-textdomain'),
            ],
            'statusItem' => [
                'type' => 'String',
                'description' => __('Título do item do slide de imagem', 'your-textdomain'),
            ],
        ],
       'resolve' => function($root, $args, $context, $info){
           global $wpdb;
           $table_name = $wpdb->prefix.'slide_image_rff';
           //Contruir a consulta sql com where
           $where_clauses = [];
           if(!empty($args['id'])){
            $where_clauses[] = $wpdb->prepare("id = %d", $args['id']);
           }
           if(!empty($args['title'])){
            $where_clauses[] = $wpdb->prepare("title like %s", "%".$args['title']."%");
           }
           if(!empty($args['statusItem'])){
            $where_clauses[] = $wpdb->prepare("statusItem = %s", $args['statusItem']);
           }
           $where_sql = '';
           if(!empty($where_clauses) && sizeof($where_clauses)>0){
            $where_sql = 'WHERE '.implode(' And ', $where_clauses);
           }
           $order_sql = '';
           if(!empty($args['orderItems'])){
            $order_sql = " ORDER BY orderItems ".$args['orderItems'];
           }
           $query = "SELECT * FROM $table_name $where_sql $order_sql";
           $results = $wpdb->get_results($query);
           return $results;
       }
   ]);
}

