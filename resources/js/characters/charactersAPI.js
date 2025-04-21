import * as bootstrap from 'bootstrap';
import $ from 'jquery';
import Swal from 'sweetalert2';
import { setDataDetail } from './charactersCommons';

$(async() => {
    var detailsModal = new bootstrap.Modal(document.getElementById('detailsModal'));
    try {
        let resCharacters = await getCharacters();
        setTimeout(
            () => $("#preload").hide(), 450
        )
        if (resCharacters.status != 1){
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: `An error occurred while fetching the characters. Please try again later.`,
            }).then(() => {
                location.reload();
            });
        }
        let characters = resCharacters.results;
        printCharacters(characters);
        $('#charactersJson').val(JSON.stringify(characters));
    } catch (error) {
        $("#preload").hide()
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: `An error occurred while fetching the characters. Please try again later.`,
        }).then(() => {
            location.reload();
        });
    }
    $("#btnGuardar").on('click', function(){
        $.ajax({
            type: "POST",
            url: "/saveCharacters",
            data: {
                characters: $('#charactersJson').val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function (response) {
                Swal.fire({
                    icon: response.status == 1?'success':'error',
                    text: response.msg,
                });
            },
            error: () => {
                Swal.fire({
                    icon: 'error',
                    text: 'Failed to process the information.',
                });
            }
        });
    });
    $(".btn-details").on('click', function(){
        let data = $(this).data();
        setDataDetail(data, detailsModal);
    });
})

/**
 * Funcion que obtiene el listado de personajes del API
 * @param {Int?} page Pagina a consultar
 * @return {Object} {status:int, msg:string, personajes?: array}
 */
const getCharacters = async(page = 1) => {
    let data = {};
    let response = await fetch(`https://rickandmortyapi.com/api/character?page=${page}`);
    if (!response.ok) return {status: 0, msg:'Ocurrio un error al obtener los personajes'};
    data = await response.json();
    if (page < 5) {
        let res = await getCharacters(page + 1);
        if (res.status != 1) return res;
        data.results = [ ...data.results, ...res.results ];
    }
    return {status: 1, msg: 'Personajes obtenidos correctamente.', results: data.results};
}

/**
 * Funcion que pinta un arreglo de personajes
 * @param {Character[]} characters Pagina a consultar
 * @return {void}
 */
const printCharacters = (characters) => {
    $("#charactersContainer").empty();
    characters.forEach(element => {
        $("#charactersContainer").append(`
            <div class="col-lg-4 col-sm-12">
                <div class="card mb-3 text-white card-characters">
                    <div class="row g-0">
                        <div class="col-md-4">
                        <img src="${element.image}" class="img-fluid h-100 w-100 rounded-start" alt="${element.name}">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body d-flex flex-column h-100">
                                <h5 class="card-title">${element.id} - ${element.name}</h5>
                                <p class="m-0 p-0 mb-1"><span class="fw-semibold">Status: </span>${element.status}</p>
                                <p class="m-0 p-0 mb-1"><span class="fw-semibold">Species: </span>${element.species}</p>
                                <div class="flex-grow-1"></div>
                                <button class="btn btn-sm btn-outline-light w-100 btn-details"
                                    data-id="${element.id}"
                                    data-name="${element.name}"
                                    data-status="${element.status}"
                                    data-species="${element.species}"
                                    data-image="${element.image}"
                                    data-type="${element.type}"
                                    data-gender="${element.gender}"
                                    data-orname="${element.origin.name}"
                                    data-orurl="${element.origin.url}"
                                >Details</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `);
    });
}
