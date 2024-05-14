<div class="card-body" :class="{ 'dark-mode': isDarkMode, 'light-mode': !isDarkMode }">
    <!-- Form to add a graveyard -->
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

        <!-- Town Select -->   
        <div class="mb-3">
            <label for="townSelect" class="form-label">Town Location</label>
            <select id="townSelect" name="townLocation" class="form-select p-2" style="width:100%;" wire:model="town_selected" @input="filterTowns">
                <option value="" selected>Select Town</option>
                @foreach ($towns as $town)
                <option value="{{ $town->town_id }}">{{ $town->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Cemetery Select -->
        <div class="mb-3">
            <label for="cemeteries_selected" class="form-label">Cemetery</label>
            <select id="cemeteries_selected" name="cemeteries_selected" class="form-select p-2" style="width:100%;" wire:model="cemeteries_selected">
                <option selected>Select Cemetery</option>
                @foreach ($cemeteries as $cemetery)
                <option value="{{ $cemetery->CemeteryName }}">{{ $cemetery->CemeteryName }}</option>
                @endforeach
                <option value="other">Create New Cemetery</option>
            </select>
        </div>

        <!-- Graveyard Name Input -->
        <div class="mb-3">
            @if ($cemeteries_selected == 'other' || $editCemeteryName)
            <label for="graveyardName" class="form-label">Graveyard Name</label>
            <input type="text" class="form-control" :class="{ 'dark-mode-input': isDarkMode, 'light-mode-input': !isDarkMode }" id="graveyardName" name="graveyardName" placeholder="Enter Graveyard Name" wire:model="grave_name" />
            @endif
        </div>

        <!-- Section Details -->
        <div class="mb-3">
            <label for="sectionNumber" class="form-label">Number of sections in Cemetery</label>
            <input type="number" class="form-control" :class="{ 'dark-mode-input': isDarkMode, 'light-mode-input': !isDarkMode }" id="sectionNumber" name="graveyardNumber" placeholder="Enter Number of Cemetery Sections" wire:model="grave_number" />
        </div>

        <!-- Section Rows and Graves -->
        @if (count($sections) < $grave_number)
        @for ($i=0; $i < $grave_number; $i++)
        <div class="mb-3">
            <label for="numberOfRows{{ $i }}" class="form-label">Rows in Section {{ $i + 1 }}</label>
            <input type="number" class="form-control" :class="{ 'dark-mode-input': isDarkMode, 'light-mode-input': !isDarkMode }" id="numberOfRows{{ $i }}" name="numberOfRows{{ $i }}" placeholder="Enter Number of Rows for section {{ $i + 1 }}" wire:model="number_of_rows.{{ $i }}" />
        </div>

        @if (isset($number_of_rows[$i]) && $number_of_rows[$i] > 0)
        @for ($j = 0; $j < $number_of_rows[$i]; $j++)
        <div class="mb-3">
            <label for="numberOfGraves{{ $i }}{{ $j }}" class="form-label">Graves in row {{ $j + 1 }} for Section {{ $i + 1 }}</label>
            <input type="number" class="form-control" :class="{ 'dark-mode-input': isDarkMode, 'light-mode-input': !isDarkMode }" id="numberOfGraves{{ $i }}{{ $j }}" name="numberOfGraves{{ $i }}{{ $j }}" placeholder="Enter Number of Graves for row {{ $j + 1 }} in section {{ $i + 1 }}" wire:model="number_of_graves.{{ $i }}.{{ $j }}" />
        </div>
        @endfor
        @endif
        @endfor
        @endif

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
