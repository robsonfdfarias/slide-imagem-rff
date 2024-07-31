<?php

/**
 * Arquivo de funções de conexão com o DB
 *  */

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
if(file_exists(SI_RFF_CORE_INC.'si-rff-graphql.php')){
    require_once(SI_RFF_CORE_INC.'si-rff-graphql.php');
}
if(file_exists( SI_RFF_CORE_INC.'si-rff-shortcode.php' )){
  require_once( SI_RFF_CORE_INC.'si-rff-shortcode.php' );
}
// function add_font_awesome() {
//     wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
// }
// add_action('wp_enqueue_scripts', 'add_font_awesome');

 //Adicionar menu na área administrativa
 add_action('admin_menu', 'slide_image_rff_add_admin_menu');
 function slide_image_rff_add_admin_menu(){
    add_menu_page(
        'Slide Image', //Título da página
        'Slide Image', //Título do menu
        'manage_options', //Nível de permissão
        'slide-image', //Slug
        'slide_image_rff_admin_page', //Função
        'dashicons-slides', //Ícone https://developer.wordpress.org/resource/dashicons/#admin-generic
        5 //Posição no menu
    );
 }

 function load_dashicons() {
    wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'load_dashicons');

 function slide_image_rff_admin_page(){
    // slide_image_rff_install();
    $style_select = "padding: 5px 15px; font-weight: bold; text-transform: uppercase; margin-top:-5px";
    ?>
    <div class="wrap">
        <div id="si_rff_dados_info"></div>
        <h1>
            Configuração do Slide Imagem RFF 
            <img src="<?php echo plugins_url('/', __FILE__); ?>wpgraphql-logo.svg" width="25" class="btGraphQl" title="Adicionar ao GraphQl" id="si_rff_img_info">
            
        </h1>
        <h2>Slides cadastrados</h2>
        <form method="post" action="" id="si-rff-form">
            <input type="text" name="titleSlide" placeholder="Digite o título" value="">
            <select className="si-rff-status" name="slideStatus" style="<?php echo $style_select; ?>">
                <option value="ativo">Ativo</option>
                <option value="inativo">Inativo</option>
            </select>
            <input type="submit" class="si-rff-bt-submit" id="cadastrar_slide_name" name="cadastrar_slide_name" value="Cadastrar slide">
        </form>
    </div>
    <?php
    ////////////////////////////////////////////////////
    if(isset($_POST['graphql'])){
        insertTableInGraphQl();
        echo '<div class="notice notice-success is-dismissible"><p>Tabelas inseridas no WpGraphQl com sucesso!</p></div>';
    }
    if(isset($_POST['cadastrar_slide_name'])){
        if((!isset($_POST['titleSlide']) || $_POST['titleSlide'] == '') && (!isset($_POST['slideStatus']) || $_POST['slideStatus'] == '')){
            echo '<div class="notice notice-failure is-dismissible"><p>Todos os campos precisam ser preenchidos!</p></div>';
        }else{
            $slideTitulo = sanitize_text_field($_POST['titleSlide']);
            $slideStatus = sanitize_text_field($_POST['slideStatus']);
            slide_image_name_rff_gravar_dados($slideTitulo, $slideStatus);
            echo '<div class="notice notice-success is-dismissible"><p>Slide cadastrado com sucesso!</p></div>';
        }
    }else if(isset($_POST['EditarSlide'])){
        if((!isset($_POST['idSlide']) || $_POST['idSlide'] == '') && (!isset($_POST['titleSlide']) || $_POST['titleSlide'] == '') && (!isset($_POST['slideStatus']) || $_POST['slideStatus'] == '')){
            echo '<div class="notice notice-failure is-dismissible"><p>Todos os campos precisam ser preenchidos!</p></div>';
        }else{
            $idSlide = sanitize_text_field($_POST['idSlide']);
            $slideTitulo = sanitize_text_field($_POST['titleSlide']);
            $slideStatus = sanitize_text_field($_POST['slideStatus']);
            //A mensagem com o status da atualização é retornada pela função slide_image_name_rff_editar_dados
            slide_image_name_rff_editar_dados($idSlide, $slideTitulo, $slideStatus);
        }
    }

    $slideDados = slide_image_name_rff_recuperar_dados();
    if($slideDados){
        echo '<br><strong>Dados Gravados</strong>';
        echo '<table class="wp-list-table widefat fixed striped" style="table-layout: auto !important;">';
        echo '<thead><tr><th>ID</th><th>Título</th><th>Status</th><th>Ações</th></tr></thead>';
        echo '<tbody>';
        foreach($slideDados as $slideDado){
            echo '<tr>';
            echo '<form method="post" action="" enctype="multipart/form-data">';
            echo '<td><input type="hidden" value="'.esc_html($slideDado->id).'" name="idSlide" id="idSlide" />' . esc_html($slideDado->id) . '</td>';
            echo '<td><input type="text" value="' . esc_html($slideDado->title) . '" name="titleSlide" id="titleSlide" placeholder="Digite o título" /></td>';
            echo '<td><select className="si-rff-status" name="slideStatus" style="'.$style_select.'; margin:0px;">
                    <option value="'.esc_html($slideDado->slideStatus).'">-> '.$slideDado->slideStatus.' <-</option>
                    <option value="ativo">Ativo</option>
                    <option value="inativo">Inativo</option>
                  </select></td>';
            // echo '<td><input type="text" value="' . esc_html($slideDado->slideStatus) . '" name="slideStatus" id="slideStatus" /></td>';
            echo '<td><input type="submit" class="si-rff-bt-submit" id="EditarSlide" name="EditarSlide" value="Editar" /><input type="submit" class="si-rff-bt-submit" id="ExcluirSlide" name="ExcluirSlide" value="Excluir" /></td>';
            echo '</form>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }
    ////////////////////////////////////////////////////
    ?>
    <div class="wrap">
        <h2>Conteúdo dos slides </h2>
        <form method="post" action="" enctype="multipart/form-data" id="si-rff-form">
            <input type="text" name="orderItems" placeholder="O número na order dos elementos" value="">
            <input type="text" name="title" placeholder="Digite o título" value="">
            <!-- <input type="text" name="urlImg" placeholder="Digite a url da imagem" value=""> -->
            <input type="file" name="urlImg" id="urlImg" accept="image/*">
            <span id="infoBt" class="dashicons dashicons-info-outline" style="font-size:25px;vertical-align:text-bottom; padding-right: 1em;">
                <div id="divInfo">A imagem deve ter 750px de largura por 235px de altura<br>(height = 31,3% do width)</div>
            </span>
            <input type="text" name="urlLink" placeholder="Digite a url do link" value="">
            <input type="text" name="altText" placeholder="Digite o texto que deve aparecer ao passar o mouse por cima da imagem" value="">
            
            <select className="si-rff-status" name="slideId" style="<?php echo $style_select; ?>">
                <?php
                    if($slideDados){
                        foreach($slideDados as $slideDado){
                            echo '<option value="'.esc_html($slideDado->id).'">'.esc_html($slideDado->title).'</option>';
                        }
                    }
                ?>
            </select>
            <select className="si-rff-status" name="statusItem" style="<?php echo $style_select; ?>">
                <option value="Ativo">Ativo</option>
                <option value="Inativo">Inativo</option>
            </select>
            <input type="submit" class="si-rff-bt-submit" id="Enviar" name="Enviar" value="Cadastrar">
        </form>
    </div>
    <?php
    if(isset($_POST['Editar']) && isset($_POST['id']) && isset($_POST['title']) && isset($_POST['urlImg']) && isset($_POST['urlLink']) && isset($_POST['altText']) && isset($_POST['slideId']) && $_POST['slideId']!=''){
        if($_POST['id']!='' && $_POST['title']!='' && $_POST['urlImg']!='' && $_POST['urlLink']!='' && $_POST['altText']!='' && isset($_POST['slideId']) && $_POST['slideId']!=''){
            //A mensagem com o status da atualização é retornada pela função slide_image_rff_editar_dados()
            slide_image_rff_editar_dados(
                $_POST['id'], 
                $_POST['title'], 
                $_POST['urlImg'], 
                $_POST['urlLink'], 
                $_POST['altText'], 
                $_POST['slideId'],
                $_POST['orderItems'],
                $_POST['statusItem']
            );
        }else{
            echo '<div class="notice notice-failure is-dismissible"><p>Todos os campos precisam ser preenchidos!</p></div>';
        }
    }else if (isset($_POST['Enviar'])) {
        if($_POST['title']!='' && $_POST['urlLink']!='' && $_POST['altText']!='' && isset($_POST['title']) && !empty($_FILES['urlImg']['name']) && isset($_POST['urlLink']) && isset($_POST['altText']) && isset($_POST['slideId']) && $_POST['slideId']!=''){
            $title = sanitize_text_field($_POST['title']);
            $urlImg = $_FILES['urlImg'];
            $urlLink = sanitize_text_field($_POST['urlLink']);
            $altText = sanitize_text_field($_POST['altText']);
            $slideId = sanitize_text_field($_POST['slideId']);
            $orderItems = sanitize_text_field($_POST['orderItems']);
            $statusItem = sanitize_text_field($_POST['statusItem']);
            // printf($urlImg);
            $image = uploadImage_si_rff($urlImg);
            // echo '//-----------------------------------//<br>';
            // echo $image;
            // echo '<br>........................................';
            // menuImage_rff_gravar_dados($title, $urlImg, $urlLink, $altText);
            slide_image_rff_gravar_dados($title, $image, $urlLink, $altText, $slideId, $orderItems, $statusItem);
            echo '<div class="notice notice-success is-dismissible"><p>Dados gravados com sucesso!</p></div>';
        }else{
            echo '<div class="notice notice-failure is-dismissible"><p>Todos os campos precisam ser preenchidos! Lembre de ter pelo menos um slide cadastrado para adicionar um item</p></div>';
        }
    }else if(isset($_POST['Excluir']) && isset($_POST['id'])){
        if($_POST['id']!=''){
            slide_image_rff_excluir_dados($_POST['id'], $_POST['urlImg']);
            echo '<div class="notice notice-success is-dismissible"><p>Registro excluído com sucesso!</p></div>';
        }else{
            echo '<div class="notice notice-failure is-dismissible"><p>Não foi possível excluir o registro!</p></div>';
        }
    }
    //
    //mostra os dados gravados
    if(isset($_POST['Filtrar'])){
        $slideId = sanitize_text_field($_POST['slideId']);
        $dados = slide_image_rff_recuperar_dados_by_slide($slideId);
    }else{
        $dados = slide_image_rff_recuperar_dados();
    }
    if ($dados) {
        // echo '<img src="'.$dados[0]->urlImg.'" width="100">';
        echo '<br><strong>Dados Gravados</strong>';
        echo '<br>Escolha o slide: ';
        echo '<form method="post" action=""><select className="si-rff-status" name="slideId" style="'.$style_select.'; margin:0px;">';
                        if($slideDados){
                            foreach($slideDados as $slideDado){
                                echo '<option value="'.esc_html($slideDado->id).'">'.esc_html($slideDado->title).'</option>';
                            }
                        }
        echo '</select><input type="submit" class="si-rff-bt-submit" id="Filtrar" name="Filtrar" value="Filtrar"></form>';
        if(isset($_POST['Filtrar'])){
            $slideId = sanitize_text_field($_POST['slideId']);
            $slideSel = slide_image_name_rff_recuperar_dados_por_ID(esc_html($slideId));
            echo '<span style="font-size:1.5rem;">Filtrado pelo slide: <strong>'.$slideSel->title.'</strong></span>';
        }

        echo '<table class="wp-list-table widefat fixed striped" style="table-layout: auto !important;">';
        echo '<thead><tr><th>ID</th><th>Ordem</th><th>Título</th><th>Url Image</th><th>Url Link</th><th>Texto alternativo</th><th>Nome do slide</th><th>Status</th><th>Ações</th></tr></thead>';
        echo '<tbody>';
        foreach ($dados as $dado) {
            $slideSel = slide_image_name_rff_recuperar_dados_por_ID(esc_html($dado->tableId));
            echo '<tr>';
            echo '<form method="post" action="" enctype="multipart/form-data">';
            echo '<td><input type="hidden" value="'.esc_html($dado->id).'" name="id" id="id" />' . esc_html($dado->id) . '</td>';
            echo '<td><input type="text" value="' . esc_html($dado->orderItems) . '" name="orderItems" id="orderItems" placeholder="O número na order dos elementos" size="5" /></td>';
            echo '<td><input type="text" value="' . esc_html($dado->title) . '" name="title" id="title" placeholder="Digite o título" /></td>';
            // echo '<td>' . esc_html($dado->urlImg) . '</td>';
            echo '<td>' . '<img src="'.$dado->urlImg.'" class="si-rff-img-admin"><input type="hidden" name="urlImg" id="urlImg" value="'.$dado->urlImg.'" /></td>';
            echo '<td><input type="text" value="' . esc_html($dado->urlLink) . '" name="urlLink" id="urlLink" placeholder="Digite a url do link" /></td>';
            echo '<td><input type="text" value="' . esc_html($dado->altText) . '" name="altText" id="altText" placeholder="Digite o texto alternativo" /></td>';
            echo '<td><select className="si-rff-status" name="slideId" style="'.$style_select.'; margin:0px;">
                        <option value="'.esc_html($slideSel->id).'">-> <span class="selSpan">'.esc_html($slideSel->title).'</span> <-</option>';
                        if($slideDados){
                            foreach($slideDados as $slideDado){
                                echo '<option value="'.esc_html($slideDado->id).'">'.esc_html($slideDado->title).'</option>';
                            }
                        }
            echo        '</select></td>';

            echo '<td><select className="si-rff-status" name="statusItem" style="'.$style_select.'; margin:0px;">
                        <option value="'.esc_html($dado->statusItem).'">-> <span class="selSpan">'.esc_html($dado->statusItem).'</span> <-</option>';
            echo        '<option value="Ativo">Ativo</option>';
            echo        '<option value="Inativo">Inativo</option>';
            echo        '</select></td>';

            echo '<td><input type="submit" class="si-rff-bt-submit" id="Editar" name="Editar" value="Editar" /><input type="submit" class="si-rff-bt-submit" id="Excluir" name="Excluir" value="Excluir" /></td>';
            echo '</form>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>Nenhum dado encontrado.</p>';
    }
 }


function uploadImage_si_rff($file){
    $uploadedfile = $file;

    // Defina o diretório de destino para a pasta 'img' dentro do diretório do plugin
    $plugin_dir = plugin_dir_path(__FILE__); // Caminho absoluto para o diretório do plugin
    $upload_dir = $plugin_dir . 'img/'; // Diretório de upload
    $urlBase = plugins_url('img/', __FILE__);
    
    // Verifica se o diretório existe; caso contrário, tenta criar
    if (!file_exists($upload_dir)) {
        wp_mkdir_p($upload_dir);
    }

    // Verifica o tipo de arquivo e o tamanho, se necessário
    $file_type = wp_check_filetype($uploadedfile['name']);
    if ($file_type['ext'] !== 'jpg' && $file_type['ext'] !== 'jpeg' && $file_type['ext'] !== 'png' && $file_type['ext'] !== 'gif') {
        echo "<p>Tipo de arquivo não permitido. Apenas imagens JPG, JPEG, PNG e GIF são permitidas.</p>";
        return;
    }

    $upload_overrides = array('test_form' => false, 'move_uploaded_file' => true);

    // Move o arquivo carregado para o diretório de upload
    $movefile = wp_handle_upload($uploadedfile, $upload_overrides);
    if ($movefile && !isset($movefile['error'])) {
        $arqNameG = basename($movefile['file']);
        $partes = explode('.', $arqNameG);
        $newName = $partes[0].time().'.'.$partes[1];
        $new_file_path = $upload_dir . $newName; // Caminho final do arquivo
        if (rename($movefile['file'], $new_file_path)) {
            return $urlBase.basename($new_file_path);
        } else {
            echo "<p>Erro ao mover o arquivo para o diretório de destino.</p>";
        }
    } else {
        echo "<p>Erro ao carregar arquivo: {$movefile['error']}</p>";
    }
    return null;
}
