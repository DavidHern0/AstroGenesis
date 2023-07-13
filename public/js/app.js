function updateResources() {
    $.ajax({
        url: '/update-resources',
        method: 'GET',
        success: function (response) {
            $('#metal').text(Math.floor(response.metal));
            $('#crystal').text(Math.floor(response.crystal));
            $('#deuterium').text(Math.floor(response.deuterium));
            $('#energy').text(Math.floor(response.energy));
        },
        error: function (xhr, status, error) {
            console.log(error);
        }
    });
}

setInterval(updateResources, 5000);


const energyElement = document.getElementById('energy');
const energyValue = parseInt(energyElement.textContent);
if (energyValue < 0) {
    energyElement.style.color = 'red';
}

setTimeout(function () {
    let alerts = document.getElementsByClassName('alert');
    for (var i = 0; i < alerts.length; i++) {
        alerts[i].style.display = 'none';
    }
}, 10000);

$(document).ready(function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const planetListName = document.getElementById('planetListName');
    const planetName = document.getElementById('planetName');
    const editIcon = document.getElementById('editIcon');
    const editInput = document.getElementById('editInput');

    editIcon.addEventListener('click', function () {
        editInput.value = planetName.innerText;
        planetName.style.display = 'none';
        editInput.style.display = 'inline-block';
        editInput.focus();
    });

    editInput.addEventListener('keypress', function (event) {
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
                success: function (response) {
                    planetName.innerText = newPlanetName;
                    planetListName.innerText = newPlanetName;
                    planetName.style.display = 'inline-block';
                    editInput.style.display = 'none';
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });
});

$(document).ready(function () {
    const shipNumberInput = $('input[name="ship_number"]');

    shipNumberInput.on('input', function () {
        let shipNumber = parseInt(shipNumberInput.val());

        if (shipNumber <= 0) {
            shipNumberInput.val(1);
        }
    });
});

const spy_arrival = document.getElementById('spy_arrival');
let arrival_coordinates = document.getElementById('arrival_coordinates');
if (spy_arrival && arrival_coordinates) {
    arrival_coordinates = arrival_coordinates.innerText;
    arrival_coordinates = arrival_coordinates.match(/\d+/g);
    
    const arrival_time = spy_arrival.innerText;
    
    function actualizarSpy() {
        let fechaActual = new Date();
        
        let year = fechaActual.getFullYear();
        let month = (fechaActual.getMonth() + 1).toString().padStart(2, '0');
        let day = fechaActual.getDate().toString().padStart(2, '0');
        let hours = fechaActual.getHours().toString().padStart(2, '0');
        let minutes = fechaActual.getMinutes().toString().padStart(2, '0');
        let seconds = fechaActual.getSeconds().toString().padStart(2, '0');
        
        let now = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        
        let timeDifference = -(new Date(now) - new Date(arrival_time)) / 1000; // Convertir a segundos
        
        // Calcular horas, minutos y segundos
        let hoursDiff = Math.floor(timeDifference / 3600);
        let minutesDiff = Math.floor((timeDifference % 3600) / 60);
        let secondsDiff = Math.floor(timeDifference % 60);
        
        // Mostrar los componentes de tiempo separados
        spy_arrival.style.display = "initial";
        spy_arrival.innerText = `${hoursDiff}h ${minutesDiff}m ${secondsDiff}s`;
        
        if (timeDifference <= 0) {
            $.ajax({
                url: '/notification-spy',
                type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            ssp_otherPlanet: arrival_coordinates[0],
            gp_otherPlanet: arrival_coordinates[1],
        },
        success: function(response) {
            console.log(response);
        },
        error: function(xhr) {
            console.error(xhr);
        }
    });
    location.reload();
}
}

setInterval(actualizarSpy, 1000);
}

document.addEventListener('DOMContentLoaded', function() {
    const accordionItems = document.querySelectorAll('.accordion-item');
  
    accordionItems.forEach(function(item) {
      const header = item.querySelector('.accordion-header h3');
      const content = item.querySelector('.accordion-content');
  
      header.addEventListener('click', function() {
        item.classList.toggle('active');
        if (item.classList.contains('active')) {
          content.style.maxHeight = content.scrollHeight + 'px';
        } else {
          content.style.maxHeight = '0';
        }
      });
    });
  });

  document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const deleteButtons = document.querySelectorAll('.fas.fa-times');
    const notifications = document.querySelectorAll('.accordion-header.unread');

    
    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const notificationId = this.getAttribute('data-notification-id');
            const notificationItem = this.closest('.accordion-item');

            fetch('/notifications/' + notificationId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
            })
            .then(function (response) {
                if (response.ok) {
                    notificationItem.remove();
                } else {
                    throw new Error('Error while deleting notification');
                }
            })
            .catch(function (error) {
                console.error(error);
            });
        });
    });

    notifications.forEach(function (notification) {
        notification.addEventListener('click', function () {
            const notificationId = this.getAttribute('data-notification-id');
            
            fetch('/notification-read/' + notificationId, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
            })
            .catch(function (error) {
                console.error(error);
            });
        });
    });
});