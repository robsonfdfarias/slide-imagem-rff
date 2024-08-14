<?php

/**
 * Classe de controle de filtro
 */

if(!defined('WPINC')){
    die();
}

$fileName = SI_RFF_DIR_IMG.'filtro.txt';

class SIRffFilter {
    function save_filter($valor){
        global $fileName;
        if(isset($valor)){
            $arq = fopen($fileName, 'w');
            fwrite($arq, $valor);
            fclose($arq);
            // echo 'Arquivo salvo';
        }else{
            // echo 'Não foi possível salvar o arquivo';
        }
    }

    function read_filter($conn){
        global $fileName;
        if(isset($conn)){
            if(!file_exists($fileName)){
                $this->save_filter("0");
            }
            $linhas = file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $val = null;
            if($linhas===false){
                $dados = $conn->slide_image_rff_recuperar_dados();
            }else{
                if(sizeof($linhas)>0){
                    if($linhas[0]!=0){
                        $val = $linhas[0];
                        $dados = $conn->slide_image_rff_recuperar_dados_by_slide($val);
                    }else{
                        $dados = $conn->slide_image_rff_recuperar_dados();
                    }
                }else{
                    $dados = $conn->slide_image_rff_recuperar_dados();
                }
            }
        }else{
            $dados = $conn->slide_image_rff_recuperar_dados();
        }
        return ['val'=>$val, 'dados'=>$dados];
    }
}