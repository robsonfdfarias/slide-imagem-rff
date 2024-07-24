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

 function slide_image_rff_admin_page(){
    // slide_image_rff_install();
    ?>
    <div class="wrap">
        <h1>Configuração do Slide Imagem RFF </h1>
        <form method="post" action="" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Digite o título" value="">
            <!-- <input type="text" name="urlImg" placeholder="Digite a url da imagem" value=""> -->
            <input type="file" name="urlImg" id="urlImg" accept="image/*">
            <input type="text" name="urlLink" placeholder="Digite a url do link" value="">
            <input type="text" name="altText" placeholder="Digite o texto que deve aparecer ao passar o mouse por cima da imagem" value="">
            <input type="submit" class="si-rff-bt-submit" id="Enviar" name="Enviar" value="Enviar">
        </form>
    </div>
    <?php
    if(isset($_POST['Editar']) && isset($_POST['id']) && isset($_POST['title']) && isset($_POST['urlImg']) && isset($_POST['urlLink']) && isset($_POST['altText'])){
        if($_POST['id']!='' && $_POST['title']!='' && $_POST['urlImg']!='' && $_POST['urlLink']!='' && $_POST['altText']!=''){
            slide_image_rff_editar_dados($_POST['id'], $_POST['title'], $_POST['urlImg'], $_POST['urlLink'], $_POST['altText']);
            echo '<div class="notice notice-success is-dismissible"><p>Dados alterados com sucesso!</p></div>';
        }else{
            echo '<div class="notice notice-failure is-dismissible"><p>Todos os campos precisam ser preenchidos!</p></div>';
        }
    }else if (isset($_POST['Enviar']) && isset($_POST['title']) && !empty($_FILES['urlImg']['name']) && isset($_POST['urlLink']) && isset($_POST['altText'])) {
        if($_POST['title']!='' && $_POST['urlLink']!='' && $_POST['altText']!=''){
            $title = sanitize_text_field($_POST['title']);
            $urlImg = $_FILES['urlImg'];
            $urlLink = sanitize_text_field($_POST['urlLink']);
            $altText = sanitize_text_field($_POST['altText']);
            // printf($urlImg);
            $image = uploadImage_si_rff($urlImg);
            // echo '//-----------------------------------//<br>';
            // echo $image;
            // echo '<br>........................................';
            // menuImage_rff_gravar_dados($title, $urlImg, $urlLink, $altText);
            slide_image_rff_gravar_dados($title, $image, $urlLink, $altText);
            echo '<div class="notice notice-success is-dismissible"><p>Dados gravados com sucesso!</p></div>';
        }else{
            echo '<div class="notice notice-failure is-dismissible"><p>Todos os campos precisam ser preenchidos!</p></div>';
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
    $dados = slide_image_rff_recuperar_dados();
    if ($dados) {
        // echo '<img src="'.$dados[0]->urlImg.'" width="100">';
        echo '<h2>Dados Gravados</h2>';
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr><th>ID</th><th>Título</th><th>Url Image</th><th>Url Link</th><th>Texto alternativo</th><th>Ações</th></tr></thead>';
        echo '<tbody>';
        foreach ($dados as $dado) {
            echo '<tr>';
            echo '<form method="post" action="" enctype="multipart/form-data">';
            echo '<td><input type="hidden" value="'.esc_html($dado->id).'" name="id" id="id" />' . esc_html($dado->id) . '</td>';
            echo '<td><input type="text" value="' . esc_html($dado->title) . '" name="title" id="title" placeholder="Digite o título" /></td>';
            // echo '<td>' . esc_html($dado->urlImg) . '</td>';
            echo '<td>' . '<img src="'.$dado->urlImg.'" class="si-rff-img-admin"><input type="hidden" name="urlImg" id="urlImg" value="'.$dado->urlImg.'" /></td>';
            echo '<td><input type="text" value="' . esc_html($dado->urlLink) . '" name="urlLink" id="urlLink" placeholder="Digite a url do link" /></td>';
            echo '<td><input type="text" value="' . esc_html($dado->altText) . '" name="altText" id="altText" placeholder="Digite o texto alternativo" /></td>';
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
