document.addEventListener("DOMContentLoaded", () => {
    // --- ELEMENTOS PRINCIPALES ---
    const metalElement = document.getElementById('metal');
    const crystalElement = document.getElementById('crystal');
    const deuteriumElement = document.getElementById('deuterium');
    const energyElement = document.getElementById('energy');

    const planetListName = document.getElementById('planetListName');
    const planetName = document.getElementById('planetName');
    const editIcon = document.getElementById('editIcon');
    const editInput = document.getElementById('editInput');

    const defenseNumberInputs = document.querySelectorAll('input[name="defense_number"]');
    const numberInputs = document.querySelectorAll('input[type="number"]');

    let spyArrival = document.getElementById('spy_arrival');
    let arrivalCoordinates = document.getElementById('arrival_coordinates');
    let arrivalType = document.getElementById('arrival_type');

    const accordionItems = document.querySelectorAll('.accordion-item');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const deleteButtons = document.querySelectorAll('.fas.fa-times');
    const notifications = document.querySelectorAll('.accordion-header.unread');
    let notificationCount = document.getElementById('notification-count');

    
    // --- FUNCIONES AUXILIARES ---
    function formatValue(value) {
        if (value < 1000) return value;
        if (value < 1000000) {
            let formatVal = value / 1000;
            formatVal = Math.floor(formatVal * 10) / 10;
            return formatVal + 'K';
        }
        let formatVal = value / 1000000;
        formatVal = Math.floor(formatVal * 10) / 10;
        return formatVal + 'M';
    }

    function applyFormatToElements(selector) {
        document.querySelectorAll(selector).forEach(item => {
            const rawText = item.textContent.trim();
            const rawValue = parseInt(rawText.replace(/\D/g, ''), 10);

            if (/^\d+$/.test(rawText)) {
                item.setAttribute("title", rawValue.toLocaleString('de-DE'));
                item.textContent = formatValue(rawValue);
            } else {
                item.setAttribute("title", rawText);
            }
        });
    }
    applyFormatToElements(".item-cost");
    applyFormatToElements(".building-cost");

    // --- ACTUALIZACIÓN DE RECURSOS ---
    if (metalElement && crystalElement && deuteriumElement && energyElement) {
        function updateResources() {
            fetch('/update-resources')
                .then(response => response.json())
                .then(data => {
                    const { metal, crystal, deuterium, energy, metal_storage, crystal_storage, deuterium_storage } = data;

                    // Actualizamos recursos principales
                    metalElement.textContent = Math.floor(metal);
                    crystalElement.textContent = Math.floor(crystal);
                    deuteriumElement.textContent = Math.floor(deuterium);
                    energyElement.textContent = Math.floor(energy);

                    // Actualizamos almacenamiento (segundo span dentro de cada .resource)
                    const storages = document.querySelectorAll('#resources .resource span:nth-child(3)');
                    if (storages.length >= 3) {
                        storages[0].textContent = metal_storage;
                        storages[1].textContent = crystal_storage;
                        storages[2].textContent = deuterium_storage;
                    }

                    // Aplicamos formato (abreviado + tooltip con valor real)
                    applyFormatToElements("#resources .resource span");

                    // Si la energía es negativa, la pintamos en rojo
                    const energyValue = parseInt(energyElement.getAttribute("title")) || 0;
                    energyElement.style.color = (energyValue < 0) ? 'red' : '';
                })
                .catch(error => console.log(error));
        }

        // Ejecutar al inicio
        updateResources();

        // Refrescar cada 5 segundos
        setInterval(updateResources, 5000);

        // Ocultar alertas tras 10s
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => alert.style.display = 'none');
        }, 10000);
    }

    // --- EDICIÓN DEL NOMBRE DEL PLANETA ---
    if (editIcon && editInput && planetName) {
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
                        if (planetListName) planetListName.innerText = newPlanetName;
                        planetName.style.display = 'inline-block';
                        editInput.style.display = 'none';
                    })
                    .catch(error => console.error(error));
            }
        });
    }

    // --- VALIDACIÓN DEFENSAS ---
    defenseNumberInputs.forEach((defenseNumberInput) => {
        defenseNumberInput.addEventListener('input', () => {
            let defenseNumber = parseInt(defenseNumberInput.value);
            if (defenseNumber <= 0) {
                defenseNumberInput.value = 1;
            }
        });
    });

    // --- ACORDEÓN ---
    accordionItems.forEach(item => {
        const header = item.querySelector('.accordion-header h3');
        const content = item.querySelector('.accordion-content');
        if (header && content) {
            header.addEventListener('click', () => {
                item.classList.toggle('active');
                if (item.classList.contains('active')) {
                    content.style.maxHeight = content.scrollHeight + 'px';
                } else {
                    content.style.maxHeight = '0';
                }
            });
        }
    });

    // --- ELIMINAR NOTIFICACIONES ---
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

    // --- MARCAR NOTIFICACIÓN COMO LEÍDA ---
    notifications.forEach(notification => {
        notification.addEventListener('click', () => {
            notification.style.backgroundColor = "#2c2c2c";
            const notificationId = notification.getAttribute('data-notification-id');
            let notificationNumber = notificationCount.textContent;
            if (notification.classList.contains("unread")) { 
                notification.classList.remove("unread");
                notificationNumber--;
                if (notificationNumber === 0) {
                    notificationCount.style.display = "none";
                } else {
                    notificationCount.textContent = notificationNumber;
                }
            }

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

    // --- ACTUALIZACIÓN VISUAL DE NOTIFICACIONES ---
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
                    clearInterval(intervalID);
                    const parentP = spyArrival.closest('p');
                    if (parentP) parentP.remove();
                }
            }, 1000);
        }
    });

    // --- ACTUALIZACIÓN DE SPY Y FLEETS ---
    if (spyArrival && arrivalCoordinates) {
        let arrivalID = document.getElementById('arrival_id');
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

            let timeDifference = -(new Date(now) - new Date(arrival_time)) / 1000;

            let hoursDiff = Math.floor(timeDifference / 3600);
            let minutesDiff = Math.floor((timeDifference % 3600) / 60);
            let secondsDiff = Math.floor(timeDifference % 60);
            spyArrival.style.display = "initial";
            spyArrival.innerText = `${hoursDiff}h ${minutesDiff}m ${secondsDiff}s`;

            if (timeDifference <= 0) {
                if (arrivalType.title === "spy") {
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
                            fleetID: arrivalID.textContent.trim(),
                            fleetType: arrivalType.title
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

    // --- VALIDACIÓN Y ACTUALIZACIÓN DE INPUTS NÚMERICOS ---
    const selectedCargoDisplay = document.getElementById('selectedCargo');
    const selectedconstructionTimeDisplay = document.getElementById('constructionTime');

    function updateSelectedCargo() {
        let total = 0;
        document.querySelectorAll('.ship-number').forEach(input => {
            const quantity = parseInt(input.value) || 0;
            const cargo = parseInt(input.dataset.cargo) || 0;
            total += quantity * cargo;
        });
        if (selectedCargoDisplay) selectedCargoDisplay.textContent = total;
    }

    function updateConstructionTime() {
        let total = 0;
        document.querySelectorAll('.ship-number').forEach(input => {
            const quantity = parseInt(input.value) || 0;
            const constructionTime = parseInt(input.dataset.constructiontime) || 0;
            total += quantity * constructionTime;
        });
        if (selectedconstructionTimeDisplay) selectedconstructionTimeDisplay.textContent = total;
    }

    function enforceMinMax(input) {
        const min = parseInt(input.min);
        const max = parseInt(input.max);
        let value = parseInt(input.value) || min;
        if (value < min) value = min;
        if (value > max) value = max;
        input.value = value;
    }

    numberInputs.forEach(input => {
        input.addEventListener('input', () => {
            enforceMinMax(input);
            if (input.classList.contains('ship-number')) {
                updateSelectedCargo();
                updateConstructionTime();
            }
        });

        input.addEventListener('blur', () => {
            enforceMinMax(input);
            if (input.classList.contains('ship-number')) {
                updateSelectedCargo();
                updateConstructionTime();
            }
        });
    });

    updateSelectedCargo();
    updateConstructionTime();

    // --- MOSTRAR MÁS NAVES ---
    const showMoreBtn = document.querySelector(".show-more");
    if (showMoreBtn) {
        showMoreBtn.addEventListener("click", () => {
            document.querySelectorAll(".hidden-fleet").forEach(el => {
                el.style.display = "block";
            });
            showMoreBtn.remove();
        });
    }

    // --- INCREMENTAR INPUT AL HACER CLICK EN ITEMS (Ships y Defenses) ---
    function setupIncrementOnClick(itemSelector, inputName) {
        document.querySelectorAll(itemSelector).forEach(item => {
            item.addEventListener('click', (event) => {
                if (event.target.tagName.toLowerCase() === 'input') return;

                const input = item.querySelector(`input[name="${inputName}"]`);
                if (input) {
                    let currentValue = parseInt(input.value) || 0;
                    const max = parseInt(input.max) || 99;
                    if (currentValue < max) {
                        input.value = currentValue + 1;
                        input.dispatchEvent(new Event('input'));
                    }
                }
            });
        });
    }

    // Inicializamos para ships y defenses
    setupIncrementOnClick('.ship-item', 'ship_number[]');
    setupIncrementOnClick('.defense-item', 'defense_number[]');
});