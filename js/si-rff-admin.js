jQuery(document).ready(function($){
    "use strict";
    // var control = 0;
    // $('#infoBt').on('click', function(e){
    //     e.preventDefault();
    //     var divinfo = document.getElementById('divInfo');
    //     if(control>0){
    //         divinfo.style.display='none';
    //         control=0;
    //     }else{
    //         divinfo.style.display='flex';
    //         control++;
    //     }
    // });
    $('#si_rff_img_info').on('click', function(){
        alert('aviso novo')
        var div = document.getElementById('si_rff_dados_info');
        var html = '<div class="notice notice-success is-dismissible"><p>';
        html += '<div style="display:flex;">';
        html += '<div>sss</div>';
        html += '<div>Author: Robson Farias <br> Email: robsonfdfarias</div>';
        html += '</div>';
        html += '</p></div>';
        div.innerHTML = html+'bsfbfb';
    });
});