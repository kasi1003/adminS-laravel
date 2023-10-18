<div>
    <div class="card mx-auto mt-4" style="width: 85%;">
        <h1 class="card-header">Add a Graveyard</h1>
        <div class="card-body">
            <!--form to add a graveyard-->
            <form wire:submit.prevent="addGrave">

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
                <div class="mb-3">
                    <div>
                        <label for="cemeteries_selected" class="form-label"> Cemetery</label>
                    </div>
                    <div class="mb-3">
                        <select id="cemeteries_selected" name="cemeteries_selected" class="form-select p-2"
                            style="width:100%;" wire:model="cemeteries_selected">

                            <option selected>Select Cemetery</option>
                            @foreach ($cemeteries as $cemetry)
                                <option value="{{ $cemetry->CemeteryID }}">{{ $cemetry->CemeteryName }}</option>
                            @endforeach
                            <option value="other">Other</option>
                        </select>
                    </div>

                </div>
                @if ($cemeteries_selected == 'other')
                    <div class="mb-3">
                        <label for="graveyardName" class="form-label">Graveyard Name</label>
                        <input type="text" class="form-control" id="graveyardName" name="graveyardName"
                            placeholder="Enter Graveyard Name" wire:model="grave_name" />
                    </div>
                @endif
                <!--section details-->
                <div class="mb-3">
                    <label for="sectionNumber" class="form-label">Number of sections in Cemetary</label>
                    <input type="number" class="form-control" id="sectionNumber" name="graveyardNumber"
                        placeholder="Enter Number of Cemetery Sections" wire:model="grave_number" />
                </div>
                <!--if user puts the numer of sections in cemetery, it should display the same number of inputs with the section code placeholder-->
                @if (count($this->sections) < $grave_number)
                    <div class="mb-3" id="gravePerSecContainer">
                        <label for="numberOfGraves" class="form-label">Graves in section
                            {{ count($sections) > 0 ? count($sections) + 1 : 1 }}</label>

                        <input type="number" class="form-control" id="numberOfGraves" name="numberOfGraves"
                            placeholder="Enter Number of Graves for section" wire:model="number_of_graves" />

                    </div>
                @endif

                @if (count($this->sections) == $grave_number && count($this->sections) > 0)
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sectionModal">preview
                        Section(s)</a>
                @else
                    <a type="button" class="btn btn-primary green" wire:click="addSection">Add
                        Section</a>
                    <a type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sectionModal">View
                        Section(s)</a>
                @endif



            </form>

            <!-- Modal -->
            <div class="modal fade" id="sectionModal" tabindex="-1" aria-labelledby="sectionModalLable"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="sectionModalLable">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Cemetery ID </th>
                                        <th scope="col">Section Code</th>
                                        <th scope="col">Total Graves</th>
                                        <th scope="col">Available Graves</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">

                                    @foreach ($sections as $section_item)
                                        <tr>
                                            <th scope="row">{{ $section_item['CemeteryID'] }}</th>
                                            <td>{{ $section_item['SectionCode'] }}</td>
                                            <td>{{ $section_item['TotalGraves'] }}</td>
                                            <td>{{ $section_item['AvailableGraves'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('swal', function(e) {
            Swal.fire({
                title: e.detail.title,
                iconColor: e.detail.iconColor,
                icon: e.detail.icon,
                timer: 1000,
                showConfirmButton: false,
            })


        });
    </script>
</div>
