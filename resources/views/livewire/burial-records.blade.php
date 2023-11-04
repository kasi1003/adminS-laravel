<div>
    <div class="card bg-light mb-3 w-75">
        <div class="card-header">Header</div>
        <div class="card-body">
            <form wire:submit.prevent="addRecord">
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
                <div class="mb-3">
                    <div>
                        <label for="sectionSelect" class="form-label">Select Section</label>
                    </div>
                    <div class="mb-3">
                        <select id="sectionSelect" name="sectionBuried" class="form-select p-2"
                            aria-label="Default select example" style="width:100%;" wire:model="town_selected">

                            <option selected>Select Section</option>
                            @foreach ($buried_records as $buried_record)
                                <option value="{{ $buried_record->id }}">{{ $buried_record->SectionCode }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

            </form>
          
        </div>
      </div>
</div>
