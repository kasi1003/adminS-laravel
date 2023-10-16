<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,
    initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link rel="stylesheet" href="../css/addGraveyard.css" />
    <title>Document</title>

</head>

<body> <!--navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark custom-navbar">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#"><span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../html/index.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../html/gravePurchases.html">Grave Purchases</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Manage Graves
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="../html/addGraveyard.html">Create Cemeteries</a>
                        <a class="dropdown-item" href="../html/editGraveyard.html">Edit Cemeteries</a>

                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="card mx-auto mt-4" style="width: 85%;">
        <h1 class="card-header">Add a Graveyard</h5>
            <div class="card-body">
                <!--form to add a graveyard-->
                <form action="../php/addGraveyardInsert.php" method="post">
                    <div class="mb-3">
                        <label for="graveyardName" class="form-label">Graveyard Name</label>
                        <input type="text" class="form-control" id="graveyardName" name="graveyardName" placeholder="Enter Graveyard Name" />
                    </div>
                    <div class="mb-3">
                        <div>
                            <label for="graveyardLocation" class="form-label">Graveyard Location</label>
                        </div>
                        <div class="mb-3">
                            <select id="regionSelect" name="graveyardLocation" class="form-select p-2" aria-label="Default select example" style="width:100%;">
                                <option selected>Select Region</option>
                                @foreach ($region_data as $region)
                                <option value="{{ $region }}">{{ $region->region_name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="mb-3">
                        <div>
                            <label for="townLocation" class="form-label">Town Location</label>
                        </div>
                        <div class="mb-3">
                            <select id="townSelect" name="townLocation" class="form-select p-2" aria-label="Default select example" style="width:100%;">
                                <option selected>Select Town</option>
                            </select>
                        </div>
                        <script>
                            $(document).ready(function() {
                                $('#regionSelect').on('change', function() {
                                    var selectedRegionId = $(this).find(':selected').data('region-id');

                                    // Clear existing options in townSelect
                                    $('#townSelect').empty();

                                    // Populate townSelect based on the selected region
                                    $.get('/getTowns/' + selectedRegionId, function(data) {
                                        var towns = data.towns;
                                        $.each(towns, function(index, town) {
                                            $('#townSelect').append($('<option>', {
                                                value: town.town_name,
                                                text: town.town_name
                                            }));
                                        });
                                    });
                                });
                            });
                        </script>
                    </div>


                    <!--section details-->
                    <div class="mb-3">
                        <label for="sectionNumber" class="form-label">Number of sections in Cemetary</label>
                        <input type="number" class="form-control" id="sectionNumber" name="graveyardNumber" placeholder="Enter Number of Cemetery Sections" oninput="generateGraveInputs()" />
                    </div>
                    <!--if user puts the numer of sections in cemetery, it should display the same number of inputs with the section code placeholder-->
                    <div class="mb-3" id="gravePerSecContainer">
                        <label for="numberOfGraves" class="form-label">Graves per section</label>

                        <input type="number" class="form-control" id="numberOfGraves" name="numberOfGraves" placeholder="Enter Number of Graves for section" />

                    </div>



                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
    </div>
    @livewireScripts
    <script src="../js/addGraveyard.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>
