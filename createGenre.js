//Create genre javascript
document.addEventListener("DOMContentLoaded", function () {
    // Function to add new location input field - Add a new place of origin text box
    window.addNewLocation = function () {
        var locationContainer = document.getElementById('placeOfOrigin');
        var locationWrapper = document.createElement('div');
        locationWrapper.className = 'form-group';
        
        // Creating the HTML structure for new place input
        locationWrapper.innerHTML = `
            <input type="text" name="placeOfOrigin[]" placeholder="Enter another place here..." class="form-control" required />
            <button type="button" class="remove-btn">Remove</button>
        `;
        
        locationContainer.appendChild(locationWrapper);
    };

    // Adding new artist texfield - same as above but for artists
    window.addArtist = function () {
        var artistContainer = document.getElementById('artistName'); 
        var artistWrapper = document.createElement('div'); 
        artistWrapper.className = 'form-group';
        
        artistWrapper.innerHTML = `
            <input type="text" name="artistName[]" placeholder="Enter another artist..." class="form-control" required />
            <button type="button" class="remove-btn">Remove</button>
        `;
        
        artistContainer.appendChild(artistWrapper);
    };

    //Remove buttons event handler  - this handles all remove clicks
    document.body.addEventListener('click', function (e) {
        if (event.target.classList.contains('remove-btn')) {
            var groupDiv = e.target.closest('.form-group');
            var container = e.target.closest('#placeOfOrigin, #artistName, #artists');

            //  handling for artists- need at least one
            if (container && container.id .id == 'artists') {
                var artistGroup = container.querySelectorAll('.form-group');
                
                if (artistGroups.length > 1) {
                    groupDiv.remove();  // Safe to remove
                } else {
                    alert('At least one artist must be added to the list!');
                }
            } else {
                // For places of origin, just remove it directly
                groupDiv.remove();
            }
        }
    });
    //TO DO testing and probably do 
});