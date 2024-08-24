<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unit Map</title>

    <style type="text/css">
        #unit-map {
    display: flex;
    flex-direction: column;
    width: 100%;
    padding: 20px;
}

.floor {
    margin-bottom: 20px;
}

.unit {
    display: inline-block;
    width: 30px;
    height: 30px;
    margin: 5px;
    text-align: center;
    line-height: 30px;
    cursor: pointer;
    transition: transform 0.3s, background-color 0.3s;
}

.unit:hover {
    transform: scale(1.2);
}

.rented {
    background-color: red;
    color: white;
}

.available {
    background-color: green;
    color: white;
}

    </style>
</head>
<body>
    <div id="unit-map"></div>
   <script>
       document.addEventListener('DOMContentLoaded', function() {
    fetch('/unitsall')
        .then(response => response.json())
        .then(data => {
            const unitMap = document.getElementById('unit-map');

            // Group units by floor
            const floors = data.reduce((acc, unit) => {
                if (!acc[unit.unit_floor]) {
                    acc[unit.unit_floor] = [];
                }
                acc[unit.unit_floor].push(unit);
                return acc;
            }, {});

            // Create HTML for each floor
            for (const [floorNumber, units] of Object.entries(floors)) {
                const floorDiv = document.createElement('div');
                floorDiv.className = 'floor';

                const floorTitle = document.createElement('h2');
                floorTitle.textContent = `Floor ${floorNumber}`;
                floorDiv.appendChild(floorTitle);

                units.forEach(unit => {
                    const unitDiv = document.createElement('div');
                    unitDiv.className = `unit ${unit.is_rented ? 'rented' : 'available'}`;
                    unitDiv.textContent = unit.unit_number;
                    floorDiv.appendChild(unitDiv);
                });

                unitMap.appendChild(floorDiv);
            }
        })
        .catch(error => {
            console.error('Error fetching unit data:', error);
        });
});

   </script>
</body>
</html>
