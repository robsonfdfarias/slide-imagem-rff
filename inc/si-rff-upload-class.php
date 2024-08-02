<?php

/**
 * Arquivo de funções de conexão com o DB
 *  */

 //se chamar diretamente e não pelo wordpress, aborta
 if(!defined('WPINC')){
    die();
 }
 

class SiRffUpload {
    function uploadImage_si_rff($file){
        $uploadedfile = $file;

        $upload_dir = str_replace('inc/', 'img/', plugin_dir_path(__FILE__)); // Caminho absoluto para o diretório do plugin
        $urlBase = str_replace('inc/', '', plugins_url('img/', __FILE__));
        
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

    function removeImage($img){
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
    }

}