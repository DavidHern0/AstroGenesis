    // Seleccionamos todos los radio buttons
const radios = document.querySelectorAll('input[name="type"]');

// Seleccionamos los contenedores
const expeditionContainer = document.getElementById('expedition_container');
const attackContainer = document.getElementById('attack_resource_container');

// Función para mostrar/ocultar según la opción seleccionada
function toggleContainers() {
    const selectedValue = document.querySelector('input[name="type"]:checked').value;

    if (selectedValue === 'expedition') {
        expeditionContainer.style.display = 'block';
        attackContainer.style.display = 'none';
    } else if (selectedValue === 'attack') {
        expeditionContainer.style.display = 'none';
        attackContainer.style.display = 'block';
    } else {
        // En caso de otras opciones futuras
        expeditionContainer.style.display = 'none';
        attackContainer.style.display = 'none';
    }
}

// Añadimos el evento a cada radio button
radios.forEach(radio => {
    radio.addEventListener('change', toggleContainers);
});

// Opcional: ejecutar al cargar la página para ajustar la visibilidad según el radio seleccionado por defecto
window.addEventListener('DOMContentLoaded', toggleContainers);
