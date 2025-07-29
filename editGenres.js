//Edit generes 
// Add a new place of origin textfield
window.addNewLocation = function () {
    var locationContainer = document.getElementById('placeOfOrigin');
    var locationWrapper = document.createElement('div');
    locationWrapper.className = 'form-group origin-entry';
    locationWrapper.innerHTML = `
        <input type="text" name="placeOfOrigin[]" placeholder="Enter another place..." class="form-control" required />
        <button type="button" class="remove-btn">Remove</button>
    `;
    locationContainer.appendChild(locationWrapper);
    updateRemoveButtons('placeOfOrigin');
};

// Add a new artist textfield
window.addArtist = function () {
    var artistContainer = document.getElementById('artistName');
    var artistWrapper = document.createElement('div');
    artistWrapper.className = 'form-group origin-entry';
    artistWrapper.innerHTML = `
        <input type="text" name="artistName[]" placeholder="Enter another artist..." class="form-control" required />
        <button type="button" class="remove-btn">Remove</button>
    `;
    artistContainer.appendChild(artistWrapper);
    updateRemoveButtons('artistName');
};

//function to remove too many/ accidental textboxes 
function updateRemoveButtons(containerId) {
    var removeButtonContainer = document.getElementById(containerId);
     if (!removeButtonContainer) return;

     var entries = removeButtonContainer.querySelectorAll('.origin-entry');
     var showRemove = entries.length > 1;//checks if ther is more than one remove button 

     entries.forEach(function(entry) {// only if there more than 1 remove button
     var removeButton = entry.querySelector('.remove-btn'); //selects the first button 
     if (removeButton) {
            removeButton.style.display = showRemove ? 'inline' : 'none';//display the button inline with the new textbox set none
        }
    });
}

// Remove an entry if more than one exists
document.addEventListener('click', function (e) {
   if (!e.target || !e.target.classList.contains('remove-btn')) return; //checks for the existance of the remove-btn

        var removeParent = e.target.closest('.origin-entry');//finds the first instasnce of the parent of the remove button
        if(!removeParent) return;

        var removeButtonContainer = removeParent.parentElement;//finds the entries within the parent container 
        var entries = removeButtonContainer.querySelectorAll('.origin-entry');

        if (entries.length > 1) {
            removeParent.remove();
            updateRemoveButtons(removeButtonContainer.id);
        }
});

// Confirmation before form submission
window.confirmSubmit = function () {
    return confirm("Are You Happy with all the Details?");
};

// Run once at start to hide any extra remove buttons
document.addEventListener('DOMContentLoaded', function () {
    updateRemoveButtons('placeOfOrigin');
    updateRemoveButtons('artistName');
});

// Form validation function
function validateForm() {
    // Let HTML5 validation handle it
    return true;
}