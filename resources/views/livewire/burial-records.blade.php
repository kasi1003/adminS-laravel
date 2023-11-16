    <div>
        <div class="card bg-light mb-3 mx-auto mt-3" style="width: 85%;">
            <div class="card-header">Edit Cemetery</div>
            <div class="card-body">
                <form wire:submit.prevent="addRecord">
                    <div class="mb-3">
                        <div>
                            <label for="cemeteries_selected" class="form-label">Cemetery</label>
                        </div>
                        <div class="mb-3">
                            <select id="cemeteries_selected" name="cemeteries_selected" class="form-select p-2"
                                style="width:100%;" wire:model="cemeteries_selected">
                                <option selected>Select Cemetery</option>
                                @foreach ($cemeteries as $cemetery)
                                    <option value="{{ $cemetery->CemeteryName }}">{{ $cemetery->CemeteryName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>



                    <div class="mb-3">
                        <div>
                            <label for="section" class="form-label">Select Section</label>
                        </div>
                        <div class="mb-3">
                            <select id="section_select" name="section_select" class="form-select p-2"
                                aria-label="Default select example" style="width:100%;" wire:model="section_select">
                                <option selected>Select Section</option>
                                @foreach ($sectionOptions as $section)
                                    <option value="{{ $section->SectionCode }}_{{ $section->CemeteryID }}">
                                        {{ $section->SectionCode }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div>
                            <label for="graveNumberSelect" class="form-label">Select Grave Number</label>
                        </div>
                        <div class="mb-3">
                            <select id="grave_number_select" name="grave_number_select" class="form-select p-2"
                                aria-label="Default select example" style="width:100%;" wire:model="selected_grave">
                                <option selected>Select Grave Number</option>
                                @foreach ($availableGraves as $grave)
                                    <option value="{{ $grave }}">{{ $grave }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>



                    <div class="mb-3">
                        <div>
                            <label for="nameInput" class="form-label">Enter Name</label>
                        </div>
                        <div class="input-group mb-3">

                            <input type="text" id="name" name="name" class="form-control" placeholder="Name"
                                aria-label="Name" aria-describedby="basic-addon1" wire:model="name">
                        </div>


                    </div>
                    <div class="mb-3">
                        <div>
                            <label for="surnameInput" class="form-label">Enter Surname</label>
                        </div>
                        <div class="input-group mb-3">

                            <input type="text" id="surname" name="surname" class="form-control"
                                placeholder="Surname" aria-label="Surname" aria-describedby="basic-addon2" wire:model="surname">
                        </div>


                    </div>
                    <div class="mb-3">
                        <div>
                            <label for="dateOfBirthInput" class="form-label">Date of Birth</label>
                        </div>
                        <div class="input-group mb-3">

                            <input type="date" id="dateOfBirth" name="dateOfBirth" class="form-control"
                                placeholder="Enter Persons Birthday" aria-label="Date of Birth"
                                aria-describedby="basic-addon3" wire:model="date_of_birth">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div>
                            <label for="dateOfDeathInput" class="form-label">Date of Birth</label>
                        </div>
                        <div class="input-group mb-3">

                            <input type="date" id="dateOfDeath" name="dateOfDeath" class="form-control"
                                placeholder="Enter Date of Death" aria-label="Date of Birth"
                                aria-describedby="basic-addon3" wire:model="date_of_death">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

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
