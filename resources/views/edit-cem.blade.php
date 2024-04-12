<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('path/to/x-editable.css') }}">

</head>

<body>
    <div class="card w-75 m-3 mx-auto">
        <div class="card-header"> Edit Tables </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Cemetery Name</th>
                            <th scope="col">Town</th>
                            <th scope="col">Number Of Sections</th>
                            <th scope="col">Total Graves</th>
                            <th scope="col">Available Graves</th>
                            <th scope="col">Action Buttons</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($cemeteries)
                            @foreach ($cemeteries as $cemetery)
                                <!-- Your table row content here -->
                                <tr>



                                    <td>
                                        <a href="" class="update_record" data-name="cemeteryName"
                                            data-type="text" data-pk="{{ $cemetery->id }}"
                                            data-title="Enter Cemetery Name">{{ $cemetery->CemeteryName }}</a>
                                    </td>
                                    <td>
                                        <a href="" class="update_record" data-name="town" data-type="text"
                                            data-pk="{{ $cemetery->id }}"
                                            data-title="Enter Cemetery Town">{{ $cemetery->Town }}</a>
                                    </td>


                                    <td>
                                        <a href="" class="update_record" data-name="numberOfSections"
                                            data-type="number" data-pk="{{ $cemetery->id }}"
                                            data-title="Enter Number of Sections">{{ $cemetery->NumberOfSections }}</a>
                                    </td>


                                    <td>
                                        <a href="" class="update_record" data-name="totalGraves"
                                            data-type="number" data-pk="{{ $cemetery->id }}"
                                            data-title="Enter Total Graves">{{ $cemetery->TotalGraves }}</a>
                                    </td>
                                    <td>
                                        <a href="" class="update_record" data-name="AvailableGraves"
                                            data-type="number" data-pk="{{ $cemetery->id }}"
                                            data-title="Enter Available Graves">{{ $cemetery->AvailableGraves }}</a>
                                    </td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <a type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#sectionModal">View
                                            Section(s)</a>



                                        <button wire:click="deleteCemetery({{ $cemetery->id }})"
                                            class="btn btn-danger">Delete</button>




                                    </td>

                                </tr>
                            @endforeach
                        @else
                            <p>No cemeteries found.</p>
                        @endif

                    </tbody>

                </table>

            </div>

            <!-- Modal -->
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
                            <form wire:submit.prevent="addGrave">

                                <div class="mb-3">
                                    <div>
                                        <label for="graveyardLocation" class="form-label">Graveyard Location</label>
                                    </div>
                                    <div class="mb-3">
                                        <select id="regionSelect" name="graveyardLocation" class="form-select p-2"
                                            aria-label="Default select example" style="width:100%;"
                                            wire:model="region_selected">
                                            <option selected>Select Region</option>
                                            @foreach ($regions as $region)
                                                <option value="{{ $region->id }}">{{ $region->region_name }}
                                                </option>
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
                                            aria-label="Default select example" style="width:100%;"
                                            wire:model="town_selected">

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
                                        <select id="cemeteries_selected" name="cemeteries_selected"
                                            class="form-select p-2" style="width:100%;"
                                            wire:model="cemeteries_selected">

                                            <option selected>Select Cemetery</option>
                                            @foreach ($cemeteries as $cemetry)
                                                <option value="{{ $cemetry->CemeteryID }}">
                                                    {{ $cemetry->CemeteryName }}</option>
                                            @endforeach
                                            <option value="other">Other</option>
                                        </select>
                                    </div>

                                </div>
                                @if ($cemeteries_selected == 'other')
                                    <div class="mb-3">
                                        <label for="graveyardName" class="form-label">Graveyard Name</label>
                                        <input type="text" class="form-control" id="graveyardName"
                                            name="graveyardName" placeholder="Enter Graveyard Name"
                                            wire:model="grave_name" />
                                    </div>
                                @endif
                                <!--section details-->
                                <div class="mb-3">
                                    <label for="sectionNumber" class="form-label">Number of sections in
                                        Cemetary</label>
                                    <input type="number" class="form-control" id="sectionNumber"
                                        name="graveyardNumber" placeholder="Enter Number of Cemetery Sections"
                                        wire:model="grave_number" />
                                </div>
                                <!--if user puts the numer of sections in cemetery, it should display the same number of inputs with the section code placeholder-->
                                @if (count($this->sections) < $grave_number)
                                    <div class="mb-3" id="gravePerSecContainer">
                                        <label for="numberOfGraves" class="form-label">Graves in section
                                            {{ count($sections) > 0 ? count($sections) + 1 : 1 }}</label>

                                        <input type="number" class="form-control" id="numberOfGraves"
                                            name="numberOfGraves" placeholder="Enter Number of Graves for section"
                                            wire:model="number_of_graves" />

                                    </div>
                                @endif

                                @if (count($this->sections) == $grave_number && count($this->sections) > 0)
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#sectionModal">preview
                                        Section(s)</a>
                                @else
                                    <a type="button" class="btn btn-primary green" wire:click="addSection">Add
                                        Section</a>
                                    <a type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#sectionModal">View
                                        Section(s)</a>
                                @endif



                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>






    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>
<script type="text/javascript">
    $.fn.editable.defaults.mode = 'inline';

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    $('.update_record').editable({
        url: "{{ route('edit-cem.update') }}",
        type: 'text',
        name: 'cemeteryName',
        pk: 1,
        title: 'Enter Field'
    });
</script>

</html>
