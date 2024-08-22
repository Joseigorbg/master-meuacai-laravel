<div class="mt-4">
    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#additionalSettingsFormContainer" aria-expanded="false" aria-controls="additionalSettingsFormContainer">
        Configurações adicionais
    </button>

    <div class="collapse mt-3" id="additionalSettingsFormContainer">
        <div class="card card-body">
            <form id="additionalSettingsForm" action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="type" class="form-label">Tipo do açaí:</label>
                    <input type="text" id="type" name="type" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="hours" class="form-label">Horário de funcionamento:</label>
                    <input type="text" id="hours" name="hours" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="days" class="form-label">Dias da semana de funcionamento:</label>
                    <input type="text" id="days" name="days" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status:</label>
                    <select id="status" name="status" class="form-control">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="video" class="form-label">Vídeo de 30 segundos:</label>
                    <input type="file" id="video" name="video" class="form-control" accept="video/*">
                </div>
                <div class="mb-3">
                    <label for="images" class="form-label">5 Imagens:</label>
                    <input type="file" id="images" name="images[]" class="form-control" accept="image/*" multiple>
                </div>
                <button type="submit" class="btn btn-success">Salvar Configurações Adicionais</button>
            </form>
        </div>
    </div>
</div>
