@extends('layouts.app')

@section('title', 'Characters API')

@section('content')
    @section('subTitle', 'FETCH API')
    <input type="hidden" id="charactersJson" value="" />
    <div class="row overflow-auto" id="charactersContainer">

    </div>
    <div class="d-flex flex-row justify-content-center align-items-center flex-grow-1">
        <button class="btn btn-outline-light me-3" id="btnGuardar">Save records</button>
        <a class="btn btn-outline-secondary" href="/listCharacters">See saved records</a>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/characters/charactersAPI.js')
@endpush
