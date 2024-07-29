<?php

/*
* Contém os shortcodes
*/

 //se chamar diretamente e não pelo wordpress, aborta
 if(!defined('WPINC')){
    die();
 }


/**
   * Includes PHP
   */
  if(file_exists(SI_RFF_CORE_INC.'si-rff-functions.php')){
    require_once(SI_RFF_CORE_INC.'si-rff-functions.php');
}


function si_rff_ex($atts){
    return '<h1>madjbndçjavçdajbvj</h1>';
}
 function si_rff_shortcode_slide1($atts){
    $html = '<p>vazio</p>';
    //mostra os dados gravados
    $dados = slide_image_rff_recuperar_dados();
    // print_r($dados);
    if ($dados) {
        // echo '<img src="'.$dados[0]->urlImg.'" width="100">';
        $html = '<p><strong>Dados Gravados</strong>';
        // $html .= '<table class="wp-list-table widefat fixed striped">';
        // $html .= '<thead><tr><th>ID</th><th>Título</th><th>Url Image</th><th>Url Link</th><th>Texto alternativo</th><th>Nome do slide</th><th>Ações</th></tr></thead>';
        // $html .= '<tbody>';
        
            $html.= '<div style="max-width:750px !important; height: 235px; display:flex; overflow:hidden;">';
            $html.= '<div id="si_rff_imgs" style="width:750px; height: 235px; display:flex; transition: ease-in-out all 0.3s;">';
        foreach ($dados as $dado) {
            $slideSel = slide_image_name_rff_recuperar_dados_por_ID(esc_html($dado->tableId));
            $html .= '<div style="width:750px; height: 235px; position: relative;">
                        <div style="">
                            <img src="'.$dado->urlImg.'" class="si-rff-img-admin" style="width:750px; height: 235px">
                        </div>
                        <div style="position:absolute;bottom:0px; width: 100%; padding: 10px 20px; background-color: rgba(255,255,255,0.5);">
                            <a href="'.$dado->urlLink.'">'.$dado->altText.'</a>
                        </div>
                    </div>';
            // $html .= '<tr>';
            // $html .= '<td>' . esc_html($dado->id) . '</td>';
            // $html .= '<td>' . esc_html($dado->title) . '</td>';
            // // echo '<td>' . esc_html($dado->urlImg) . '</td>';
            // $html .= '<td>' . '<img src="'.$dado->urlImg.'" class="si-rff-img-admin" style="max-width: 150px; max-height: 100px;"></td>';
            // $html .= '<td>' . esc_html($dado->urlLink) . '</td>';
            // $html .= '<td>' . esc_html($dado->altText) . '</td>';
            // $html .= '<td>'.esc_html($slideSel->title).'</td>';
            // $html .= '</tr>';
        }
            $html.= '</div>';
            $html.= '</div>';
        // $html .= '</tbody>';
        // $html .= '</table></p>';
    }
    return $html;
 }
 
 function foobar_func1($atts){
    return "foo and bar-----";
}
add_shortcode( 'foobar1', 'foobar_func1' );

/**
 * registro de todos os shortcodes
 */
function si_rff_register_shortcodes(){
    //shortcodes registrados
    add_shortcode('si_rff_1', 'si_rff_shortcode_slide1');
    add_shortcode('si_rff_2', 'si_rff_ex');
}

add_action('init', 'si_rff_register_shortcodes');