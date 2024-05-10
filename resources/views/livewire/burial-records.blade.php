<div style="width: 40%;">
    <div class="card mt-5" style="width: 100%;">
        <div class="card-header">Add Burial Record</div>
        <div class="card-body">
            <form wire:submit.prevent="addRecord">
                <div class="mb-3">
                    <label for="cemeteries_selected" class="form-label">Cemetery</label>
                    <select id="cemeteries_selected" name="cemeteries_selected" class="form-select p-2" style="width:100%;" wire:model="selectedCemetery">
                        <option value="">Select Cemetery</option>
                        @foreach ($cemeteries as $cemetery)
                        <option value="{{ $cemetery->CemeteryID }}">{{ $cemetery->CemeteryName }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="section_select" class="form-label">Select Section</label>
                    <select id="section_select" name="section_select" class="form-select p-2" style="width:100%;" wire:model="selectedSection">
                        <option value="">Select Section</option>
                        @foreach ($sections as $section)
                        <option value="{{ $section->SectionCode }}">{{ $section->SectionCode }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="row_select" class="form-label">Select Row</label>
                    <select id="row_select" name="row_select" class="form-select p-2" style="width:100%;" wire:model="selectedRow">
                        <option value="">Select Row</option>
                        @foreach ($rows as $row)
                        <option value="{{ $row->RowID }}">{{ $row->RowID }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="grave_number_select" class="form-label">Select Grave Number</label>
                    <select id="grave_number_select" name="grave_number_select" class="form-select p-2" style="width:100%;" wire:model="selectedGraveNumber">
                        <option value="">Select Grave Number</option>
                        @foreach ($graveNumbers as $GraveNum)
                        <option value="{{ $GraveNum }}">{{ $GraveNum }}</option>
                        @endforeach

                    </select>
                </div>




                <div class="mb-3">
                    <label for="death_code" class="form-label">Enter Death Certificate Number</label>
                    <input type="text" id="death_code" name="death_code" class="form-control" placeholder="Death Certificate Number" wire:model="death_number">
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Enter Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Name" wire:model="name">
                </div>

                <div class="mb-3">
                    <label for="surname" class="form-label">Enter Surname</label>
                    <input type="text" id="surname" name="surname" class="form-control" placeholder="Surname" wire:model="surname">
                </div>

                <div class="mb-3">
                    <label for="dateOfBirth" class="form-label">Date of Birth</label>
                    <input type="date" id="dateOfBirth" name="dateOfBirth" class="form-control" wire:model="date_of_birth">
                </div>

                <div class="mb-3">
                    <label for="dateOfDeath" class="form-label">Date of Death</label>
                    <input type="date" id="dateOfDeath" name="dateOfDeath" class="form-control" wire:model="date_of_death">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>