jQuery(document).ready(function($) {

    // Abre o modal
    $(document).on('click', '.si-rff-detalhes-link', function(e) {
        e.preventDefault();
        insertModal();
        $('#si-rff-modal').fadeIn();
        // $('#si-rff-modal').fadeTo(1000, 1);
    });

    // Fecha o modal
    $(document).on('click', '.si-rff-modal-close', function() {
        $('#si-rff-modal').fadeOut();
    });

    // Fecha o modal se o usuário clicar fora dele
    $(window).on('click', function(event) {
        if ($(event.target).is('#si-rff-modal')) {
            $('#si-rff-modal').fadeOut();
        }
    });
});

function insertModal(){
    var myPluginUrl = siRffData.pluginUrl; //Url recuperada do arquivo slide-image-rff.php
    var styleModel = 'background-color:#f2f2f2; padding: 20px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #cdcdcd; box-shadow: 2px 2px 2px rgba(0,0,0,0.1)';
    let div1 = document.createElement('div');
    div1.setAttribute('id', 'si-rff-modal');
    div1.setAttribute('class', 'si-rff-modal');
    let div2 = document.createElement('div');
    div2.setAttribute('class', 'si-rff-modal-content');
    div2.innerHTML = '<span class="si-rff-modal-close">&times;</span>'+
        '<h1>Informações importantes sobre o plugin Slide Image Rff</h1>'+
        '<h2>'+
        '  Como usar o schortcode?'+
        '</h2>'+
        '<div style="'+styleModel+'">'+
        '<p style="">'+
            '- Modelo 1:'+
        '</p>'+
        '<p style="">'+
            '<img src="'+myPluginUrl+'/imginfo/si_rff_slide1.png" width="100%"><br>'+
        '</p>'+
        '<p style="">'+
            'Insira o código abaixo em um post ou página, conforme imagem abaixo:'+
            '<pre>[si_rff_1 slideid="1"]</pre><br>'+
            '<img src="'+myPluginUrl+'/imginfo/si_rff_slide1_info.png" width="100%"><br>'+
            'Aqui o slideid="1" indica que eu quero o slide com o id 1, para especificar qual slide quero usar.<br>'+
            '<img src="'+myPluginUrl+'/imginfo/si_rff_id_slide.png"><br>'+
            'Obs: O modelo 1 foi desenvolvido para ser inserido e executado com uma proporção de 750px X 235px, por isso, as imagens devem ter essa proporção'+
        '</p>'+
        '</div>'+
        '<div style="'+styleModel+'">'+
        '<p style="">'+
            '- Modelo 2:'+
        '</p>'+
        '<p style="">'+
            '<img src="'+myPluginUrl+'/imginfo/si_rff_slide2.png" width="100%"><br>'+
        '</p>'+
        '<p style="">'+
            'Insira o código abaixo em um post ou página, conforme imagem abaixo:'+
            '<pre>[si_rff_2 slideid="1"]</pre><br>'+
            '<img src="'+myPluginUrl+'/imginfo/si_rff_slide2_info.png" width="100%"><br>'+
            'Note que foi inserido alguns parágrafos com a letra S, isso foi feito porque esse modelo fica supenso, então ele faz com que o conteúdo debaixo suba e fique por trás dele. Por isso, a quantidade de parágrafos com S que você vai colocar, vai depender da altura da sua imagem.<br>'+
            'Aqui o slideid="1" indica que eu quero o slide com o id 1, para especificar qual slide quero usar.<br>'+
            '<img src="'+myPluginUrl+'/imginfo/si_rff_id_slide.png"><br>'+
            'Obs: O modelo 2 foi desenvolvido para ser inserido e executado com uma proporção de 100% da largura tela, a altura é ajustada automaticamente(Favor manter a mesma altura nas imagens), por isso, as imagens devem ter uma resolução boa'+
        '</p>'+
        '</div>'+
        '<br>'+
        '<h2>Alguns detalhes sobre o uso do GraphQl</h2>'+
        '<div style="'+styleModel+'">'+
        '<p style="">'+
            '<img src="'+myPluginUrl+'/imginfo/si_rff_graphql_info.png" width="100%"><br>'+
        '</p>'+
        '<p style="">'+
            '<strong>Pesquisa no GraphQl:</strong><br>'+
            '<strong>Por ID (aparece na coluna ID da tabela de itens do slide) -> </strong>Digite o ID do item do slide para receber como retorno os dados desse item.<br>'+
            '<strong>Por OrdenItems (ordem delimitada pelo campo orderItems no formulário) -> </strong>Digite ASC para ordem crescente ou DESC para ordem decrescente.<br>'+
            '<strong>Por StatusItem (status do item) -> </strong>Digite Ativo para pegar os itens ativos e Inativo para pegar os inativos.<br>'+
            '<strong>Por TableId (aparece na coluna ID da tabela de nome do slide) -> </strong>Digite o ID do slide para receber como retorno todos os itens daquele slide.<br>'+
            '<strong>Por Title -> </strong>Digite o titulo, ou parte dele, que você receberá como retorno os itens que contiverem no campo title o texto digitado.<br>'+
            'Você também pode combinar a pesquisa, mas cuidado, algumas combinações pode ser disperdício de processamento.<br>'+
        '</p>'+
        '</div>'+
        '<br>'+
        '<h2>Mais detalhes</h2>'+
        '<p>As instruções de como usar estão disponíveis no github, seguem os links importantes:</p>'+
        '<p style="padding-left:40px; margin-top: -15px;">'+
          'Url do Github: <a href="https://github.com/robsonfdfarias/slide-imagem-rff">https://github.com/robsonfdfarias/slide-imagem-rff</a><br>'+
          'Linkedin do author: <a href="https://www.linkedin.com/in/robson-farias-a8b01723a/">Robson Farias</a><br>'+
          'Email de contato: robsonfdfarias@gmail.com<br>'+
          'Canal do youtube: <a href="https://www.youtube.com/c/Inform%C3%A1ticacomRobsonFarias">Canal informática com Robson Farias</a><br>'+
        '</p>';
    div1.appendChild(div2);
    document.body.appendChild(div1);
}