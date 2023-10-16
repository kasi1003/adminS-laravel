<div>
    <div class="card mx-auto mt-4" style="width: 85%;">
        <h1 class="card-header">Add a Graveyard</h1>
        <div class="card-body">
            <!--form to add a graveyard-->
            <form wire:submit.prevent="addGrave">
                <div class="mb-3">
                    <label for="graveyardName" class="form-label">Graveyard Name</label>
                    <input type="text" class="form-control" id="graveyardName" name="graveyardName"
                        placeholder="Enter Graveyard Name" wire:model="grave_name" />
                </div>
                <div class="mb-3">
                    <div>
                        <label for="graveyardLocation" class="form-label">Graveyard Location</label>
                    </div>
                    <div class="mb-3">
                        <select id="regionSelect" name="graveyardLocation" class="form-select p-2"
                            aria-label="Default select example" style="width:100%;" wire:model="region_selected">
                            <option selected>Select Region</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="mb-3">
                    <div>
                        <label for="townLocation" class="form-label">Town Location</label>
                    </div>
                    <div class="mb-3">
                        <select id="townSelect" name="townLocation" class="form-select p-2"
                            aria-label="Default select example" style="width:100%;" wire:model="town_selected">

                            <option selected>Select Town</option>
                            @foreach ($towns as $town)
                                <option value="{{ $town->id }}">{{ $town->town_name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <!--section details-->
                <div class="mb-3">
                    <label for="sectionNumber" class="form-label">Number of sections in Cemetary</label>
                    <input type="number" class="form-control" id="sectionNumber" name="graveyardNumber"
                        placeholder="Enter Number of Cemetery Sections" wire:model="grave_number"/>
                </div>
                <!--if user puts the numer of sections in cemetery, it should display the same number of inputs with the section code placeholder-->
                <div class="mb-3" id="gravePerSecContainer">
                    <label for="numberOfGraves" class="form-label">Graves per section</label>

                    <input type="number" class="form-control" id="numberOfGraves" name="numberOfGraves"
                        placeholder="Enter Number of Graves for section" wire:model="number_of_graves"/>

                </div>



                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
