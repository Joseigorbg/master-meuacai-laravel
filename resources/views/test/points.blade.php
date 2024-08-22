@foreach($points as $index => $point)
            <div class="col-md-12 mb-4 point-item">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">{{ $point->name }}</h5>
                            <span class="badge {{ $point->status ? 'bg-success' : 'bg-danger' }}">
                                {{ $point->status ? 'Aberto' : 'Fechado' }}
                            </span>
                        </div>
                        <p class="card-text mt-2">
                            <strong>Endereço:</strong> {{ $point->address }}<br>
                            <strong>CEP:</strong> {{ $point->cep }}<br>
                            <strong>Telefone:</strong> {{ $point->phone }}<br>
                            <strong>Latitude:</strong> {{ $point->latitude }}<br>
                            <strong>Longitude:</strong> {{ $point->longitude }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                            <form action="{{ route('points.destroy', $point) }}" method="POST" class="d-inline" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash"></i> Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="d-flex justify-content-center flex-column align-items-center">
            <button id="show-more-btn" class="btn btn-primary mt-2 mb-2">
                <i class="bi bi-chevron-down"></i> Mostrar Mais
            </button>
            <button id="show-less-btn" class="btn btn-secondary mb-2">
                <i class="bi bi-chevron-up"></i> Mostrar Menos
            </button>
        </div>

        <button class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#settingsModal-{{ $point->id }}">
                <i class="bi bi-gear-fill gear-icon"></i>
            </button>
        @include('layouts.components.modal')










