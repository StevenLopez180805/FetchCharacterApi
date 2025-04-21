import $ from 'jquery';
/**
 * Funcion que llena los datos de la modal de detalles
 * @param {Object} data Datos de un determinado personaje
 * @param {Modal} modal Instancia de la modal de Bootstrap
 */
export function setDataDetail(data, modal){
    $("#idDetail").text(data.id);
    $("#nameDetail").text(capitalizeFirstLetter(data.name));
    $("#imageDetail").attr('src', data.image);
    $("#urlImgDetail").text(data.image);
    $("#statusDetail").text(capitalizeFirstLetter(data.status));
    $("#specieDetail").text(capitalizeFirstLetter(data.species));
    $("#typeDetail").text(data.type != ''?capitalizeFirstLetter(data.type):'N/A');
    $("#genderDetail").text(capitalizeFirstLetter(data.gender));
    $("#locationDetail").text(capitalizeFirstLetter(data.orname));
    $("#urlLocDetail").text(data.orurl != ''?data.orurl:'N/A');
    modal.show();
}
function capitalizeFirstLetter(text) {
    return text.charAt(0).toUpperCase() + text.slice(1)
}
