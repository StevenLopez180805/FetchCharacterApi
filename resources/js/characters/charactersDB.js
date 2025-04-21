import * as bootstrap from 'bootstrap';
import $ from 'jquery';
import Swal from 'sweetalert2';
import { setDataDetail } from './charactersCommons';
$(() => {
    $("#preload").hide();
    var editModal = new bootstrap.Modal(document.getElementById('editModal'));
    var detailsModal = new bootstrap.Modal(document.getElementById('detailsModal'));
    $(".btn-details").on('click', function(){
        let data = $(this).data();
        setDataDetail(data, detailsModal);
    });
    $(".btn-edit").on('click', function(){ // Aqui se podrian usar los datos ya renderizados en el template mediante inputs escondidos, pero lo hago de esta manera para mostrar un ejemplo de consulta de datos al back.
        $('#editModalBody').load(`/editCharacter?id=${$(this).data('id')}`, function () {
            editModal.show();
        });
    });
    $(".btn-delete").on('click', function(){
        let id = parseInt($(this).data('id'));
        Swal.fire({
            icon: 'question',
            text: 'Are you sure you want to delete this character?',
            showCancelButton: true,
            confirmButtonText: 'Confirm'
        }).then(swalResponse => {
            if (swalResponse.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "/deleteCharacter",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id,
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 1) {
                            location.reload();
                        }else{
                            Swal.fire({
                                title: 'error',
                                text: response.msg ?? 'Failed to process the information.'
                            });
                        }
                    },
                    error: () => {
                        Swal.fire({
                            icon: 'error',
                            text: 'Failed to process the information.',
                        });
                    }
                });
            }
        })
    });
    $(document).on('click', '#saveButton', function(){
        let error = false;
        $('.input-required').each(function () {
            if ($(this).val().trim() == '') {
                error = true;
                $(this).addClass('is-invalid'); // puedes agregar una clase para resaltar el error
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if(error){
            Swal.fire({
                icon: 'error',
                text: 'All required fields must be completed before submitting.'
            });
            return;
        }
        let id = parseInt($(this).data('id'));
        Swal.fire({
            icon: 'question',
            text: 'Are you sure you want to make changes to this character?',
            showCancelButton: true,
            confirmButtonText: 'Confirm'
        }).then(swalResponse => {
            if (swalResponse.isConfirmed) {
                $.ajax({
                    type: "PUT",
                    url: "/updateCharacter",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id,
                        name: $("#nameEdit").val().trim(),
                        status: $("#statusEdit").val().trim(),
                        species: $("#speciesEdit").val().trim(),
                        image: $("#imageURLEdit").val().trim(),
                        type: $("#typeEdit").val().trim(),
                        gender: $("#genderEdit").val().trim(),
                        orName: $("#originEdit").val().trim(),
                        orURL: $("#originURLEdit").val().trim(),
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 1) {
                            location.reload();
                        }else{
                            Swal.fire({
                                title: 'error',
                                text: response.msg ?? 'Failed to process the information.'
                            });
                        }
                    },
                    error: () => {
                        Swal.fire({
                            icon: 'error',
                            text: 'Failed to process the information.',
                        });
                    }
                });
            }
        });

    });

})
