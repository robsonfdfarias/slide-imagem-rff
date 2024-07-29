jQuery(document).ready(function($){
    "use strict";
    var si_rff_imgs = document.getElementById('si_rff_imgs');
    var childrenSlide = si_rff_imgs.children.length;
    var si_rff_controller = 1;
    setInterval(si_rff_move_imgs, 3000);
    function si_rff_move_imgs(){
        if(si_rff_controller>=childrenSlide){
            // si_rff_imgs.setAttribute('style', 'margin-left:0px; transition: easy-in-out all 0.3s');
            si_rff_imgs.style.marginLeft = '0px';
            si_rff_controller=1;
        }else{
            // si_rff_imgs.setAttribute('style', 'margin-left:'+(si_rff_controller*750)+'px; transition: easy-in-out all 0.3s');
            si_rff_imgs.style.marginLeft = '-'+(si_rff_controller*750)+'px';
            si_rff_controller++;
        }
    }
});