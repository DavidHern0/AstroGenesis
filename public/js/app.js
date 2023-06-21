function actualizarRecursos() {
    $.ajax({
        url: '/update-resources',
        method: 'GET',
        success: function(response) {
            $('#metal').text(Math.floor(response.metal));
            $('#crystal').text(Math.floor(response.crystal));
            $('#deuterium').text(Math.floor(response.deuterium));
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
}

setInterval(actualizarRecursos, 5000);
