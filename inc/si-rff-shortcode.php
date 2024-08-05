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
if(file_exists(SI_RFF_CORE_INC.'si-rff-functions-class.php')){
   require_once(SI_RFF_CORE_INC.'si-rff-functions-class.php');
}

$conection_si_rff = new SiRffConection();


function si_rff_ex($atts){
    return "<h1>madjbndçjavçdajbvj {$atts['slideId']}</h1>";
}
 function si_rff_shortcode_slide1($atts){
    global $conection_si_rff;
    $html = '<p>vazio</p>';
    // Define os atributos padrão
    $atts = shortcode_atts(array(
        'slideid' => '1',
        'bar'=>'something else',
    ), $atts);
    //mostra os dados gravados
    if(isset($atts['slideid'])){
        $dados = $conection_si_rff->slide_image_rff_recuperar_dados_by_slide(esc_attr($atts['slideid']));
    }else{
        $dados = $conection_si_rff->slide_image_rff_recuperar_dados();
    }
    
    // print_r($dados);
    if ($dados) {
        $html = "<p><strong>Dados Gravados</strong>";
            $html.= '<div style="max-width:750px !important; height: 235px; display:flex; overflow:hidden;">';
            $html.= '<div id="si_rff_imgs" style="width:750px; height: 235px; display:flex; transition: ease-in-out all 0.3s;">';
        foreach ($dados as $dado) {
            $slideSel = $conection_si_rff->slide_image_name_rff_recuperar_dados_por_ID(esc_html($dado->tableId));
            $html .= '<div style="width:750px; height: 235px; position: relative;">
                        <div style="">
                            <img src="'.$dado->urlImg.'" class="si-rff-img-admin" style="width:750px; height: 235px">
                        </div>
                        <div style="position:absolute;bottom:0px; width: 100%; padding: 10px 20px; background-color: rgba(255,255,255,0.5);">
                            <a href="'.$dado->urlLink.'">'.$dado->altText.'</a>
                        </div>
                    </div>';
        }
            $html.= '</div>';
            $html.= '</div></p>';
    }
    return $html;
 }

 function si_rff_shortcode_slide2($atts){
    global $conection_si_rff;
    $html = '<p>vazio</p>';
    // Define os atributos padrão
    $atts = shortcode_atts(array(
        'slideid' => '1',
        'bar'=>'something else',
    ), $atts);
    //mostra os dados gravados
    if(isset($atts['slideid'])){
        $dados = $conection_si_rff->slide_image_rff_recuperar_dados_by_slide(esc_attr($atts['slideid']));
    }else{
        $dados = $conection_si_rff->slide_image_rff_recuperar_dados();
    }
    
    // print_r($dados);
    if ($dados) {
        // $html = "<p><strong>Dados Gravados</strong>";
        $html = "";
            // $html.= '<div id="si_rff_geral_slide" style="max-width:100vw !important; display:flex; position:relative; left: 0;">';
            $html.= '<div style="max-width:100vw !important; display:flex; overflow:hidden; position:absolute; left:0;">';
            $html.= '<div id="si_rff_imgs2" style="100%; display:flex; transition: ease-in-out all 0.3s;">';
        foreach ($dados as $dado) {
            $slideSel = $conection_si_rff->slide_image_name_rff_recuperar_dados_por_ID(esc_html($dado->tableId));
            $html .= '<div style="width:100vw; position: relative;">
                        <div style="">
                            <img src="'.$dado->urlImg.'" class="si-rff-img-admin" style="width:100vw;">
                        </div>
                        <div style="position:absolute;bottom:0px; width: 100vw; padding: 10px 20px; background-color: rgba(255,255,255,0.5); font-size: 2rem;">
                            <a href="'.$dado->urlLink.'">'.$dado->altText.'</a>
                        </div>
                    </div>';
        }
            $html.= '</div>';
            $html.= '</div>';
            $html.= '<div id="si_rff_geral_slide" style="max-width:100% !important; display:flex; position:relative; left: 0;">';
            $html.= '</div>';
            // $html.= '</div>';
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
    add_shortcode('si_rff_2', 'si_rff_shortcode_slide2');
}

add_action('init', 'si_rff_register_shortcodes');