//Edit generes 
// Add a new place of origin textfield
window.addNewLocation = function () {
    const container = document.getElementById('placeOfOrigin');
    const wrapper = document.createElement('div');
    wrapper.className = 'form-group origin-entry';
    wrapper.innerHTML = `
        <input type="text" name="placeOfOrigin[]" placeholder="Enter another place..." class="form-control" required />
        <button type="button" class="remove-btn">Remove</button>
    `;
    container.appendChild(wrapper);
    updateRemoveButtons('placeOfOrigin');
};

// Add a new artist textfield
window.addArtist = function () {
    const container = document.getElementById('artistName');
    const wrapper = document.createElement('div');
    wrapper.className = 'form-group origin-entry';
    wrapper.innerHTML = `
        <input type="text" name="artistName[]" placeholder="Enter another artist..." class="form-control" required />
        <button type="button" class="remove-btn">Remove</button>
    `;
    container.appendChild(wrapper);
    updateRemoveButtons('artistName');
};

//function to remove too many/ accidental textboxes 
function updateRemoveButtons(containerId) {
    const container = document.getElementById(containerId);
    const entries = container.querySelectorAll('.origin-entry');
    const showRemove = entries.length > 1;//checks if ther is more than one remove button 

    entries.forEach(entry => {// only if there more than 1 remove button
        const btn = entry.querySelector('.remove-btn'); //selects the first button 
        if (btn) {
            btn.style.display = showRemove ? 'inline' : 'none';//display the button inline with the new textbox set none
        }
    });
}

// Remove an entry if more than one exists
document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('remove-btn')) { //checks for the existance of the remove-btn
        const parent = e.target.closest('.origin-entry');//finds the first instasnce of the parent of the remove button
        const container = parent.parentElement;//finds the entries within the parent container 
        const entries = container.querySelectorAll('.origin-entry');

        if (entries.length > 1) {
            parent.remove();
            updateRemoveButtons(container.id);
        }
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