

document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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

    function updateStatusIcon(checkbox) {
        const statusIcon = document.querySelector(`#status-icon-${checkbox.id.split('-')[1]}`);
        if (statusIcon) {
            if (checkbox.checked) {
                statusIcon.classList.remove('text-danger');
                statusIcon.classList.add('text-success');
            } else {
                statusIcon.classList.remove('text-success');
                statusIcon.classList.add('text-danger');
            }
        }
    }

    function validateFiles(files, maxCount, maxDuration = 0) {
        if (files.length > maxCount) {
            alert(`Você pode enviar no máximo ${maxCount} arquivos.`);
            return false;
        }
        if (maxDuration > 0) {
            for (let file of files) {
                if (file.type.startsWith('video/') && file.duration > maxDuration) {
                    alert(`Cada vídeo deve ter no máximo ${maxDuration} segundos.`);
                    return false;
                }
            }
        }
        return true;
    }

    function saveSettings(pointId, form, standardize = false) {
        if (!(form instanceof HTMLFormElement)) {
            console.error('O elemento fornecido não é um formulário.');
            return;
        }

        const formData = new FormData(form);

        const daysHours = {
            'Seg': 'indefinido',
            'Ter': 'indefinido',
            'Qua': 'indefinido',
            'Qui': 'indefinido',
            'Sex': 'indefinido',
            'Sáb': 'indefinido',
            'Dom': 'indefinido'
        };

        if (standardize) {
            const hourInputs = form.querySelectorAll('input[name="days_hours[hours][]"]');
            if (hourInputs.length > 0) {
                const standardHours = hourInputs[0].value;
                for (let day in daysHours) {
                    daysHours[day] = standardHours;
                }
            }
        } else {
            form.querySelectorAll('select[name="days_hours[day][]"]').forEach((select, index) => {
                const day = select.value;
                const hoursInput = form.querySelectorAll('input[name="days_hours[hours][]"]')[index];
                if (hoursInput) {
                    const hours = hoursInput.value;
                    if (hours) {
                        daysHours[day] = hours;
                    }
                }
            });
        }
        formData.append('days_hours', JSON.stringify(daysHours));

        const imagesInput = form.querySelector(`#newImages-${pointId}`);
        const videosInput = form.querySelector(`#newVideos-${pointId}`);

        const images = imagesInput ? imagesInput.files : [];
        const videos = videosInput ? videosInput.files : [];

        if (!validateFiles(images, 5) || !validateFiles(videos, 1, 30)) {
            return;
        }

        for (const file of images) {
            formData.append('images[]', file);
        }

        for (const file of videos) {
            formData.append('videos[]', file);
        }

        const saveButton = form.querySelector('.save-modal-btn');
        saveButton.disabled = true;
        saveButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Salvando...';

        fetch(`/points/${pointId}/settings`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.success);
                console.log('Updated days_hours:', JSON.stringify(daysHours));
                const targetModal = document.querySelector(`#settingsModal-${pointId}`);
                if (targetModal) {
                    const modal = bootstrap.Modal.getInstance(targetModal);
                    modal.hide();
                }

                const updatedDaysHours = JSON.parse(formData.get('days_hours'));
                updateDaysHoursOnScreen(updatedDaysHours, pointId);
            } else {
                alert('Erro ao salvar configurações');
            }
        })
        .catch(error => {
            console.error('Erro ao salvar configurações:', error);
            alert('Erro ao salvar configurações');
        })
        .finally(() => {
            saveButton.disabled = false;
            saveButton.innerHTML = 'Salvar';
        });
    }

    function updateDaysHoursOnScreen(daysHours, pointId) {
        const container = document.querySelector(`#days-hours-container-${pointId}`);
        if (!container) return;

        while (container.firstChild) {
            container.removeChild(container.firstChild);
        }

        for (let day in daysHours) {
            const daySelect = document.createElement('select');
            daySelect.className = 'form-select mb-3';
            daySelect.name = 'days_hours[day][]';
            daySelect.innerHTML = `
                <option value="Seg" ${day === 'Seg' ? 'selected' : ''}>Segunda-feira</option>
                <option value="Ter" ${day === 'Ter' ? 'selected' : ''}>Terça-feira</option>
                <option value="Qua" ${day === 'Qua' ? 'selected' : ''}>Quarta-feira</option>
                <option value="Qui" ${day === 'Qui' ? 'selected' : ''}>Quinta-feira</option>
                <option value="Sex" ${day === 'Sex' ? 'selected' : ''}>Sexta-feira</option>
                <option value="Sáb" ${day === 'Sáb' ? 'selected' : ''}>Sábado</option>
                <option value="Dom" ${day === 'Dom' ? 'selected' : ''}>Domingo</option>
            `;

            const hourInput = document.createElement('input');
            hourInput.type = 'text';
            hourInput.className = 'form-control mb-3';
            hourInput.name = 'days_hours[hours][]';
            hourInput.placeholder = '12:00 - 18:00';
            hourInput.value = daysHours[day];

            container.appendChild(daySelect);
            container.appendChild(hourInput);
        }
    }

    document.querySelectorAll('.status-checkbox').forEach(input => {
        input.addEventListener('change', function() {
            const pointId = this.id.split('-')[1];
            fetch(`/points/${pointId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ status: input.checked })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    updateStatusIcon(input);
                } else {
                    alert('Erro ao atualizar status');
                }
            })
            .catch(error => {
                console.error('Erro ao atualizar status:', error);
                alert('Erro ao atualizar status');
            });
        });
    });

    document.querySelectorAll('.standardize-btn').forEach(button => {
        button.addEventListener('click', function() {
            const pointId = this.dataset.pointId;
            const form = document.querySelector(`#settingsForm-${pointId}`);

            const hourInputs = form.querySelectorAll('input[name="days_hours[hours][]"]');
            if (hourInputs.length > 0) {
                const standardHours = hourInputs[0].value;
                form.querySelectorAll('input[name="days_hours[hours][]"]').forEach(input => {
                    input.value = standardHours;
                });
            }

            saveSettings(pointId, form, true);
        });
    });
});





fetch('/load-all-points')
    .then(response => response.json())
    .then(points => {
        window.points = points; // Armazena os pontos em uma variável global
        points.forEach(point => {
            addMarker(point);
        });
    });

// Fetch para os marcadores em destaque
fetch('/highlighted-markers')
    .then(response => response.json())
    .then(points => {
        points.forEach(point => {
            addMarker(point, customPurpleIcon);
        });
    });