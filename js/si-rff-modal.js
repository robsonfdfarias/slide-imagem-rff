jQuery(document).ready(function($) {
    // Abre o modal
    $(document).on('click', '.si-rff-detalhes-link', function(e) {
        e.preventDefault();
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
