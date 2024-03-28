<div class="row">
    <div class="col-md-6">
        <div class="card mt-5 ml-5" style="width: 95%;">
            <h1 class="card-header">Add a Graveyard</h1>
            <div class="card-body">
                <!--form to add a graveyard-->
                <form wire:submit="addGrave">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <!-- checked -->

                    <!-- Blade View -->
                    <!-- Blade View -->
                    <div class="mb-3">
                        <div>
                            <label for="townSelect" class="form-label">Town Location</label>
                        </div>
                        <div class="mb-3">
                            <!-- Search input field -->
                            <div class="mb-3">
                                <!-- Select dropdown with search functionality -->
                                <select id="townSelect" name="townLocation" class="form-select p-2" style="width:100%;" wire:model="town_selected" @input="filterTowns">
                                    <option value="" selected>Select Town</option>
                                    <!-- Loop through the towns data to populate the dropdown -->
                                    @foreach ($towns as $town)
                                    <option value="{{ $town->town_id }}">{{ $town->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>


                    <div class="mb-3">
                        <div>
                            <label for="cemeteries_selected" class="form-label"> Cemetery</label>
                        </div>
                        <div class="mb-3">
                            <select id="cemeteries_selected" name="cemeteries_selected" class="form-select p-2" style="width:100%;" wire:model="cemeteries_selected">

                                <option selected>Select Cemetery</option>
                                @foreach ($cemeteries as $cemetery)
                                <option value="{{ $cemetery->CemeteryID }}">{{ $cemetery->CemeteryName }}</option>
                                @endforeach

                                <option value="other">Create New Cemetery</option>
                            </select>
                        </div>

                    </div>
                    <div class="mb-3">
                        @if ($cemeteries_selected == 'other' || $editCemeteryName)
                        <label for="graveyardName" class="form-label">Graveyard Name</label>
                        <input type="text" class="form-control" id="graveyardName" name="graveyardName" placeholder="Enter Graveyard Name" wire:model="grave_name" />
                        @endif
                    </div>
               

                    <!--section details-->
                    <div class="mb-3">
                        <label for="sectionNumber" class="form-label">Number of sections in Cemetary</label>
                        <input type="number" class="form-control" id="sectionNumber" name="graveyardNumber" placeholder="Enter Number of Cemetery Sections" wire:model="grave_number" />
                    </div>
                    <!--if user puts the numer of sections in cemetery, it should display the same number of inputs with the section code placeholder-->
                    <!-- Inside the form -->
                    @if (count($sections) < $grave_number) @for ($i=0; $i < $grave_number; $i++) <div class="mb-3">
                        <label for="numberOfRows{{ $i }}" class="form-label">Rows in Section
                            {{ $i + 1 }}</label>
                        <input type="number" class="form-control" id="numberOfRows{{ $i }}" name="numberOfRows{{ $i }}" placeholder="Enter Number of Rows for section {{ $i + 1 }}" wire:model="number_of_rows.{{ $i }}" />
            </div>

            @if (isset($number_of_rows[$i]) && $number_of_rows[$i] > 0)
            @for ($j = 0; $j < $number_of_rows[$i]; $j++) <div class="mb-3">
                <label for="numberOfGraves{{ $i }}{{ $j }}" class="form-label">Graves in row {{ $j + 1 }} for Section
                    {{ $i + 1 }}</label>
                <input type="number" class="form-control" id="numberOfGraves{{ $i }}{{ $j }}" name="numberOfGraves{{ $i }}{{ $j }}" placeholder="Enter Number of Graves for row {{ $j + 1 }} in section {{ $i + 1 }}" wire:model="number_of_graves.{{ $i }}.{{ $j }}" />
        </div>
        @endfor
        @endif
        @endfor
        @endif
        <button type="submit" class="btn btn-primary">Submit</button>



        </form>
    </div>
</div>
</div>
<!-- edit-graveyard component -->
<div class="col-md-6">
    <div class="card mt-5 ml-5" style="width: 95%;">
        <h1 class="card-header">Edit Graveyard</h1>
        <div class="card-body">
            <livewire:edit-graveyard />
        </div>
    </div>
</div>
</div>