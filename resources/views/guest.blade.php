<!-- resources/views/guest.blade.php -->
@extends('layouts.base')

@section('title', 'Bem-vindo, Visitante')

@section('content')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/home/home.css') }}">
<link rel="stylesheet" href="{{ asset('css/map/detailed-popup.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="home-body">
    <div class="user-status">
        <h1>Bem-vindo ao Meu Açaí</h1>
        <p>Por favor, faça login para ver os destaques da semana.</p>
    </div>
    <div id="map"></div>
    <div class="form">
        <input type="search" class="searchInput" required>
        <i class="fa fa-search" id="searchBtn"></i>
        <div id="loading" style="display: none;"></div>
        <div id="suggestionsBox" class="suggestions-box"></div>
    </div>
    <div id="modalContainer"></div>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/awesomplete/1.1.5/awesomplete.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/awesomplete/1.1.5/awesomplete.min.css" />
<script src="{{ asset('js/map-index/maphome.js') }}"></script>
<script src="{{ asset('js/map-index/components.js') }}"></script>
<script src="{{ asset('js/map-index/complexpop.js') }}"></script>
<script src="{{ asset('js/map-index/preview.js') }}"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    Livewire.emit('loadLikeButton', point.id);
});

</script>
@endsection
