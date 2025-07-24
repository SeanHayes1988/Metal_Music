document.addEventListener("DOMContentLoaded", function () {
    // Add a new place of origin text box
    window.addNewLocation = function () {
        const container = document.getElementById('placeOfOrigin');
        const wrapper = document.createElement('div');
        wrapper.className = 'form-group';
        wrapper.innerHTML = `
            <input type="text" name="placeOfOrigin[]" placeholder="Enter another place here..." class="form-control" required />
            <button type="button" class="remove-btn">Remove</button>
        `;
        container.appendChild(wrapper);
    };

    // Add a new notable bands text box
    window.addArtist = function () {
        const container = document.getElementById('artistName');
        const wrapper = document.createElement('div');
        wrapper.className = 'form-group';
        wrapper.innerHTML = `
            <input type="text" name="artistName[]" placeholder="Enter another artist..." class="form-control" required />
            <button type="button" class="remove-btn">Remove</button>
        `;
        container.appendChild(wrapper);
    };

    // Remove functionality for any .remove-btn
    document.body.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-btn')) {
            const group = e.target.closest('.form-group');
            const container = e.target.closest('#placeOfOrigin, #artistName, #artists');

            if (container && container.id === 'artists') {
                const groups = container.querySelectorAll('.form-group');
                if (groups.length > 1) {
                    group.remove();
                } else {
                    alert('At least one artist must be added to the list!');
                }
            } else {
                group.remove(); // Remove normally for other sections
            }
        }
    });
});
