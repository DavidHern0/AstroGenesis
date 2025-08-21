const metalElement = document.getElementById('metal');
const crystalElement = document.getElementById('crystal');
const deuteriumElement = document.getElementById('deuterium');
const energyElement = document.getElementById('energy');

const planetListName = document.getElementById('planetListName');
const planetName = document.getElementById('planetName');
const editIcon = document.getElementById('editIcon');
const editInput = document.getElementById('editInput');

const shipNumberInputs = document.querySelectorAll('input[name="ship_number"]');
const defenseNumberInputs = document.querySelectorAll('input[name="defense_number"]');
const numberInputs = document.querySelectorAll('input[type="number"]');

let spyArrival = document.getElementById('spy_arrival');
let arrivalCoordinates = document.getElementById('arrival_coordinates');
let arrivalType = document.getElementById('arrival_type');
const accordionItems = document.querySelectorAll('.accordion-item');
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const deleteButtons = document.querySelectorAll('.fas.fa-times');
const notifications = document.querySelectorAll('.accordion-header.unread');

if (metalElement && crystalElement && deuteriumElement && energyElement) {   
    function updateResources() {
        fetch('/update-resources')
        .then(response => response.json())
        .then(data => {
            const { metal, crystal, deuterium, energy } = data;
            metalElement.textContent = Math.floor(metal);
            crystalElement.textContent = Math.floor(crystal);
            deuteriumElement.textContent = Math.floor(deuterium);
            energyElement.textContent = Math.floor(energy);
        })
        .catch(error => console.log(error));
    }   
    setInterval(updateResources, 5000);

const energyValue = parseInt(energyElement.textContent);
if (energyValue < 0) {
    energyElement.style.color = 'red';
}

setTimeout(() => {
    let alerts = document.getElementsByClassName('alert');
    for (let i = 0; i < alerts.length; i++) {
        alerts[i].style.display = 'none';
    }
}, 10000);

document.addEventListener('DOMContentLoaded', () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    editIcon.addEventListener('click', () => {
        editInput.value = planetName.innerText;
        planetName.style.display = 'none';
        editInput.style.display = 'inline-block';
        editInput.focus();
    });

    editInput.addEventListener('keypress', event => {
        if (event.key === 'Enter') {
            const newPlanetName = editInput.value;

            fetch('/update-planetname', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    planetName: newPlanetName
                })
            })
                .then(response => response.json())
                .then(data => {
                    planetName.innerText = newPlanetName;
                    planetListName.innerText = newPlanetName;
                    planetName.style.display = 'inline-block';
                    editInput.style.display = 'none';
                })
                .catch(error => console.error(error));
        }
    });

    const shipNumberInputs = document.querySelectorAll('input[name="ship_number"]');

    shipNumberInputs.forEach((shipNumberInput) => {
        shipNumberInput.addEventListener('input', () => {
            let shipNumber = parseInt(shipNumberInput.value);

            if (shipNumber <= 0) {
                shipNumberInput.value = 1;
            }
        });
    });

    const defenseNumberInputs = document.querySelectorAll('input[name="defense_number"]');

    defenseNumberInputs.forEach((defenseNumberInput) => {
        defenseNumberInput.addEventListener('input', () => {
            let defenseNumber = parseInt(defenseNumberInput.value);

            if (defenseNumber <= 0) {
                defenseNumberInput.value = 1;
            }
        });
    });

    accordionItems.forEach(item => {
        const header = item.querySelector('.accordion-header h3');
        const content = item.querySelector('.accordion-content');

        header.addEventListener('click', () => {
            item.classList.toggle('active');
            if (item.classList.contains('active')) {
                content.style.maxHeight = content.scrollHeight + 'px';
            } else {
                content.style.maxHeight = '0';
            }
        });
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            const notificationId = button.getAttribute('data-notification-id');
            const notificationItem = button.closest('.accordion-item');

            fetch('/notifications/' + notificationId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
            })
                .then(response => {
                    if (response.ok) {
                        notificationItem.remove();
                    } else {
                        throw new Error('Error while deleting notification');
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        });
    });

    notifications.forEach(notification => {
        notification.addEventListener('click', () => {
            const notificationId = notification.getAttribute('data-notification-id');

            fetch('/notification-read/' + notificationId, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
            })
                .catch(error => {
                    console.error(error);
                });
        });
    });
});

//UPDATE NOTIFICACIONES (SOLO VISUAL)
document.querySelectorAll('.spy_arrival').forEach((spyArrival, index) => {
    let arrivalCoordinates = document.querySelectorAll('#arrival_coordinates')[index];
    if (spyArrival && arrivalCoordinates) {
        arrivalCoordinates = arrivalCoordinates.innerText.match(/\d+/g);
        const arrival_time = spyArrival.innerText;

        const intervalID = setInterval(() => {
            const now = new Date();
            const timeDifference = -(now - new Date(arrival_time)) / 1000;

            if (timeDifference > 0) {
                const hoursDiff = Math.floor(timeDifference / 3600);
                const minutesDiff = Math.floor((timeDifference % 3600) / 60);
                const secondsDiff = Math.floor(timeDifference % 60);

                spyArrival.style.display = "initial";
                spyArrival.innerText = `${hoursDiff}h ${minutesDiff}m ${secondsDiff}s`;
            } else {
                // DETENER EL INTERVALO (sale de la "iteración")
                clearInterval(intervalID);
                const parentP = spyArrival.closest('p');
                if (parentP) parentP.remove();
            }
        }, 1000);
    }
});

//UPDATE NOTIFICACIONES
if (spyArrival && arrivalCoordinates) {
    arrivalCoordinates = arrivalCoordinates.innerText;
    arrivalCoordinates = arrivalCoordinates.match(/\d+/g);

    const arrival_time = spyArrival.innerText;

    const updateSpy = () => {
        let fechaActual = new Date();

        let year = fechaActual.getFullYear();
        let month = (fechaActual.getMonth() + 1).toString().padStart(2, '0');
        let day = fechaActual.getDate().toString().padStart(2, '0');
        let hours = fechaActual.getHours().toString().padStart(2, '0');
        let minutes = fechaActual.getMinutes().toString().padStart(2, '0');
        let seconds = fechaActual.getSeconds().toString().padStart(2, '0');

        let now = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;

        let timeDifference = -(new Date(now) - new Date(arrival_time)) / 1000; // Convertir a segundos

        let hoursDiff = Math.floor(timeDifference / 3600);
        let minutesDiff = Math.floor((timeDifference % 3600) / 60);
        let secondsDiff = Math.floor(timeDifference % 60);

        spyArrival.style.display = "initial";
        spyArrival.innerText = `${hoursDiff}h ${minutesDiff}m ${secondsDiff}s`;

        if (timeDifference <= 0) {
            if (arrivalType == "spy") {
                $.ajax({
                    url: '/notification-spy',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        ssp_otherPlanet: arrivalCoordinates[1],
                        gp_otherPlanet: arrivalCoordinates[0],
                    },
                success: function (response) {
                    console.log(response);
                },
                error: function (xhr) {
                    console.error(xhr);
                }
            });
        } else {
            $.ajax({
                url: '/notification-fleet',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    type: "fleet",
                },
            success: function (response) {
                console.log(response);
            },
            error: function (xhr) {
                console.error(xhr);
            }
        });
            
        }
        location.reload();
        }
    };

    setInterval(updateSpy, 1000);
}

document.addEventListener('DOMContentLoaded', function () {
    let  itemCosts = document.querySelectorAll('.item-cost');

    itemCosts.forEach(function (element) {
        let value = parseInt(element.innerText);

        let newValue;
        if (value < 1000) {
            newValue = value;
        } else if (value < 1000000) {
            newValue = (value / 1000) + 'K';
        } else {
            newValue = (value / 1000000) + 'M';
        }

        element.innerText = newValue;
    });
});
}

document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.ship-number');
    const selectedCargoDisplay = document.getElementById('selectedCargo');
    const selectedconstructionTimeDisplay = document.getElementById('constructionTime');
    
    function updateSelectedCargo() {
        let total = 0;
        inputs.forEach(input => {
            const quantity = parseInt(input.value) || 0;
            const cargo = parseInt(input.dataset.cargo) || 0;
            total += quantity * cargo;
        });
        if (selectedCargoDisplay) {
            selectedCargoDisplay.textContent = total;
        }
    }
    function updateConstructionTime() {
        let total = 0;
        inputs.forEach(input => {
            const quantity = parseInt(input.value) || 0;
            const constructionTime = parseInt(input.dataset.constructiontime) || 0;
            total += quantity * constructionTime;
        });
        
        if (selectedconstructionTimeDisplay) {
            selectedconstructionTimeDisplay.textContent = total;
        }
    }
    if (inputs) {   
        inputs.forEach(input => {
            input.addEventListener('input', updateSelectedCargo);
            input.addEventListener('input', updateConstructionTime);
        });
    }
    updateSelectedCargo();
    updateConstructionTime();
});

document.addEventListener("DOMContentLoaded", () => {
    const showMoreBtn = document.querySelector(".show-more");
    if (showMoreBtn) {
        showMoreBtn.addEventListener("click", () => {
            document.querySelectorAll(".hidden-fleet").forEach(el => {
                el.style.display = "block"; // mostrar las ocultas
            });
            showMoreBtn.remove(); // quitar los "..."
        });
    }
});