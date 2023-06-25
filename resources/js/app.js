function actualizarRecursos() {
    $.ajax({
        url: '/update-resources',
        method: 'GET',
        success: function(response) {
            $('#metal').text(Math.floor(response.metal));
            $('#crystal').text(Math.floor(response.crystal));
            $('#deuterium').text(Math.floor(response.deuterium));
            $('#energy').text(Math.floor(response.energy));
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
}

setInterval(actualizarRecursos, 5000);


const energyElement = document.getElementById('energy');
const energyValue = parseInt(energyElement.textContent);
if (energyValue < 0) {
  energyElement.style.color = 'red';
}

setTimeout(function(){
    var alerts = document.getElementsByClassName('alert');
    for(var i = 0; i < alerts.length; i++) {
        alerts[i].style.display = 'none';
    }
}, 10000);