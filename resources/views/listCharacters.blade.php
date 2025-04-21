@extends('layouts.app')

@section('title', 'Characters DB')

@section('content')
    @section('subTitle', 'SAVED RECORDS')
    @if (COUNT($characters) == 0)
        <div class="alert alert-light fw-semibold text-center m-4" role="alert">
            No records have been saved yet.
        </div>
    @endif
    <div class="row overflow-auto" id="charactersContainer">
        @foreach ($characters as $character)
            <div class="col-lg-4 col-sm-12">
                <div class="card mb-3 text-white card-characters">
                    <div class="row g-0">
                        <div class="col-md-4">
                        <img src="{{$character->image}}" class="img-fluid h-100 w-100 rounded-start" alt="{{$character->name}}" onerror="this.onerror=null; this.src='{{ asset('images/default-image.png') }}';">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body d-flex flex-column h-100">
                                <h5 class="card-title">{{$character->id}} - {{$character->name}}</h5>
                                <p class="m-0 p-0 mb-1"><span class="fw-semibold">Status: </span>{{ucfirst($character->status)}}</p>
                                <p class="m-0 p-0 mb-1"><span class="fw-semibold">Species: </span>{{ucfirst($character->species)}}</p>
                                <div class="flex-grow-1"></div>
                                <div class="cont-card-buttons d-flex flex-row justify-content-center">
                                    <button class="btn btn-sm btn-outline-success w-50 btn-details me-2"
                                        data-id="{{$character->id}}"
                                        data-name="{{$character->name}}"
                                        data-status="{{$character->status}}"
                                        data-species="{{$character->species}}"
                                        data-image="{{$character->image}}"
                                        data-type="{{$character->type}}"
                                        data-gender="{{$character->gender}}"
                                        data-orname="{{$character->origin->name}}"
                                        data-orurl="{{$character->origin->url}}"
                                    >Details</button>
                                    <button class="btn btn-sm btn-outline-light w-50 btn-edit me-2" data-id="{{$character->id}}">Edit</button>
                                    <button class="btn btn-sm btn-outline-danger w-50 btn-delete" data-id="{{$character->id}}">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex flex-row justify-content-center align-items-center flex-grow-1">
        <a class="btn btn-outline-secondary" href="/">Fetch API</a>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Edit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="editModalBody">

            </div>
        </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/characters/charactersDB.js')
@endpush
