document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const addDayHourFieldButton = document.getElementById('addDayHourField');
    const dayHourContainer = document.getElementById('daysHoursFields');
    const saveSettingsBtn = document.getElementById('saveSettingsBtn');

    function addDayHourField(container) {
        const daySelect = document.createElement('select');
        daySelect.className = 'form-select mb-3';
        daySelect.name = 'days_hours[day][]';
        daySelect.innerHTML = `
            <option value="Seg">Segunda-feira</option>
            <option value="Ter">Terça-feira</option>
            <option value="Qua">Quarta-feira</option>
            <option value="Qui">Quinta-feira</option>
            <option value="Sex">Sexta-feira</option>
            <option value="Sáb">Sábado</option>
            <option value="Dom">Domingo</option>
        `;

        const hourInput = document.createElement('input');
        hourInput.type = 'text';
        hourInput.className = 'form-control mb-3';
        hourInput.name = 'days_hours[hours][]';
        hourInput.placeholder = '12:00 - 18:00';

        container.appendChild(daySelect);
        container.appendChild(hourInput);
    }

    addDayHourFieldButton.addEventListener('click', function() {
        addDayHourField(dayHourContainer);
    });

    saveSettingsBtn.addEventListener('click', function() {
        const form = document.getElementById('modalForm');
        form.submit();
    });
});
