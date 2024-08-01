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
    //slide 2 ----------------------------------------
    var si_rff_imgs2 = document.getElementById('si_rff_imgs2');
    var childrenSlide2 = si_rff_imgs2.children.length;
    var si_rff_controller2 = 1;
    setInterval(si_rff_move_imgs2, 3000);
    function si_rff_move_imgs2(){
        var si_rff_doc_width = window.innerWidth;
        if(si_rff_controller2>=childrenSlide2){
            // si_rff_imgs.setAttribute('style', 'margin-left:0px; transition: easy-in-out all 0.3s');
            si_rff_imgs2.style.marginLeft = '0px';
            si_rff_controller2=1;
        }else{
            // si_rff_imgs.setAttribute('style', 'margin-left:'+(si_rff_controller*750)+'px; transition: easy-in-out all 0.3s');
            si_rff_imgs2.style.marginLeft = '-'+(si_rff_controller2*si_rff_doc_width)+'px';
            si_rff_controller2++;
        }
    }
});