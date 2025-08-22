
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('info-modal');
    const modalBody = document.getElementById('modal-body');
    const closeBtn = document.getElementById('modal-close');

    if (closeBtn) {
        document.querySelectorAll('.info-button').forEach(button => {
            button.addEventListener('click', function () {
                const buildingItem = this.closest('.building-item');
                const info = buildingItem.querySelector('.building-info-template').cloneNode(true);
                const updateContainer = buildingItem.querySelector('.update-container-template').cloneNode(true);
                const form = buildingItem.querySelector('.update-form-template').cloneNode(true);

                info.style.display = 'block';
                updateContainer.style.display = 'block';
                form.style.display = 'block';

                modalBody.innerHTML = '';
                modalBody.appendChild(info);
                modalBody.appendChild(updateContainer);
                modalBody.appendChild(form);

                modal.style.display = 'flex';
            });
        });
        closeBtn.addEventListener('click', () => modal.style.display = 'none');
        window.addEventListener('click', (e) => { if (e.target == modal) modal.style.display = 'none'; });
    }
    
//Galaxy Modal
    document.querySelectorAll('.open-attack-modal').forEach(button => {
        button.addEventListener('click', function () {
            const modal = document.querySelector('.attack-modal');
            const form = modal.querySelector('.attack-form');

            form.querySelector('input[name="planet-id"]')?.remove();
            form.querySelector('input[name="galaxy-id"]')?.remove();

            const planetInput = document.createElement('input');
            planetInput.type = 'hidden';
            planetInput.name = 'planet-id';
            planetInput.value = this.dataset.planetId;

            const galaxyInput = document.createElement('input');
            galaxyInput.type = 'hidden';
            galaxyInput.name = 'galaxy-id';
            galaxyInput.value = this.dataset.galaxyId;

            form.appendChild(planetInput);
            form.appendChild(galaxyInput);

            modal.style.display = 'flex';
        });
    });

    document.querySelector('.attack-modal-close').addEventListener('click', function () {
        document.querySelector('.attack-modal').style.display = 'none';
    });

    window.addEventListener('click', function (e) {
        const modal = document.querySelector('.attack-modal');
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});