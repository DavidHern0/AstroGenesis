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
    let alerts = document.getElementsByClassName('alert');
    for(var i = 0; i < alerts.length; i++) {
        alerts[i].style.display = 'none';
    }
}, 10000);

$(document).ready(function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const planetListName = document.getElementById('planetListName');
    const planetName = document.getElementById('planetName');
    const editIcon = document.getElementById('editIcon');
    const editInput = document.getElementById('editInput');

    editIcon.addEventListener('click', function() {
        editInput.value = planetName.innerText;
        planetName.style.display = 'none';
        editInput.style.display = 'inline-block';
        editInput.focus();
    });

    editInput.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            let newPlanetName = editInput.value;

            $.ajax({
                url: '/update-planetname',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    planetName: newPlanetName
                },
                success: function(response) {
                    planetName.innerText = newPlanetName;
                    planetListName.innerText = newPlanetName;
                    planetName.style.display = 'inline-block';
                    editInput.style.display = 'none';
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });
});