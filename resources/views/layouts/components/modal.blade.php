<!-- Modal Popup -->
<div class="modal fade" id="additionalInfoModal" tabindex="-1" aria-labelledby="additionalInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="modalForm" method="POST" action="{{ route('complemento.update', $point->complemento->first()->id ?? '') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="additionalInfoModalLabel">Configurações Avançadas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="status" class="form-label">
                        <i class="bi bi-toggle-on"></i> Status de Funcionamento:
                    </label>
                    <select id="status" name="status" class="form-select">
                        <option value="1" {{ $point->complemento->first()->status ? 'selected' : '' }}>Ativo</option>
                        
                    </select>
                </div>        

                <div id="dayHourContainer" class="mb-3">
                    <label for="days_hours" class="form-label">
                        <i class="bi bi-calendar"></i> Dia e Hora de Funcionamento:
                    </label>
                    <div class="mb-2" id="daysHoursFields">
                        @if(isset($point->complemento) && $point->complemento->count() && is_array($point->complemento->first()->days_hours))
                            @foreach($point->complemento->first()->days_hours as $dayHour)
                                <select class="form-select mb-3" name="days_hours[day][]">
                                    <option value="Seg" {{ $dayHour['day'] === 'Seg' ? 'selected' : '' }}>Segunda-feira</option>
                                    <!-- Continue com outras opções -->
                                </select>
                                <input type="text" class="form-control mb-3" name="days_hours[hours][]" value="{{ $dayHour['hours'] }}">
                            @endforeach
                        @else
                            <!-- Caso não haja dados, talvez exibir um campo padrão ou uma mensagem -->
                            <p>Nenhum horário definido. Adicione um novo horário abaixo.</p>
                        @endif
                        <button type="button" class="btn btn-secondary" id="addDayHourField">
                            <i class="bi bi-plus-circle"></i> Adicionar Dia e Hora
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="images" class="form-label">
                        <i class="bi bi-images"></i> Imagens:
                    </label>
                    <input type="file" id="images" name="images[]" class="form-control" multiple>
                </div>        

                <div class="mb-3">
                    <label for="videos" class="form-label">
                        <i class="bi bi-camera-video"></i> Vídeo Promocional:
                    </label>
                    <input type="file" id="videos" name="videos[]" class="form-control" multiple>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary" id="saveSettingsBtn">Salvar Configurações</button>
            </div>
        </form>
        </div>
    </div>
</div>
