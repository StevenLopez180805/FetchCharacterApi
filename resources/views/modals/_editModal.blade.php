<div class="row">
    <div class="col-lg-6 col-sm-12">
        <label for="imageURLEdit" class="fw-semibold my-1">Image URL:</label>
        <input id="imageURLEdit" type="text" class="form-control input-required" placeholder="Image URL" value="{{$character->image}}" maxlength="255">
    </div>
    <div class="col-lg-6 col-sm-12">
        <label for="nameEdit" class="fw-semibold my-1">Name:</label>
        <input id="nameEdit" type="text" class="form-control input-required" placeholder="Name" value="{{$character->name}}" maxlength="255">
    </div>
    <div class="col-lg-6 col-sm-12">
        <label for="statusEdit" class="fw-semibold my-1">Status:</label>
        <select id="statusEdit" class="form-select input-required">
            <option value="unknown" @if ($character->status == 'unknown') selected @endif>Unknown</option>
            <option value="alive" @if ($character->status == 'alive') selected @endif>Alive</option>
            <option value="dead" @if ($character->status == 'dead') selected @endif>Dead</option>
        </select>
    </div>
    <div class="col-lg-6 col-sm-12">
        <label for="speciesEdit" class="fw-semibold my-1">Species:</label>
        <input id="speciesEdit" type="text" class="form-control input-required" placeholder="Species" value="{{ucfirst($character->species)}}" maxlength="255">
    </div>
    <div class="col-lg-6 col-sm-12">
        <label for="typeEdit" class="fw-semibold my-1">Type:</label>
        <input id="typeEdit" type="text" class="form-control" placeholder="Type" value="{{$character->type}}" maxlength="255">
    </div>
    <div class="col-lg-6 col-sm-12">
        <label for="genderEdit" class="fw-semibold my-1">Gender:</label>
        <select id="genderEdit" class="form-select input-required">
            <option value="unknown" @if ($character->gender == 'unknown') selected @endif>Unknown</option>
            <option value="male" @if ($character->gender == 'male') selected @endif>Male</option>
            <option value="female" @if ($character->gender == 'female') selected @endif>Female</option>
        </select>
    </div>
    <div class="col-lg-6 col-sm-12">
        <label for="originEdit" class="fw-semibold my-1">Origin:</label>
        <input id="originEdit" type="text" class="form-control input-required" placeholder="Location" value="{{$character->origin->name}}" maxlength="255">
    </div>
    <div class="col-lg-6 col-sm-12">
        <label for="originURLEdit" class="fw-semibold my-1">Origin URL:</label>
        <input id="originURLEdit" type="text" class="form-control" placeholder="Location URL" value="{{$character->origin->url}}" maxlength="255">
    </div>
</div>
<button class="btn btn-success float-end mt-2" id="saveButton" data-id="{{$character->id}}">Save</button>
