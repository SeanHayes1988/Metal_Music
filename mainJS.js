/*document.getElementById('notable_bands').addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('remove-btn')) {
        const container = document.getElementById('notable_bands');
        const allGroups = container.querySelectorAll('.form-group');
        if (allGroups.length > 1) {
            const formGroup = e.target.closest('.form-group');
            formGroup.remove();
        } else {
            alert('You must keep at least one band input.');
        }
    }
});

document.getElementById('place_of_origin').addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('remove-btn')) {
        const container = document.getElementById('place_of_origin');
        const allGroups = container.querySelectorAll('.form-group');
        if (allGroups.length > 1) {
            const formGroup = e.target.closest('.form-group');
            formGroup.remove();
        } else {
            alert('You must keep at least one place of origin input.');
        }
    }
});


function addEntry() {
    const container = document.getElementById('place_of_origin');

    const wrapper = document.createElement('div');
    wrapper.className = 'form-group';

    wrapper.innerHTML = `
        <input type="text" name="place_of_origin[]" placeholder="Enter here..." class="form-control" required />
        <button type="button" class="remove-btn">Remove</button>
    `;

    container.appendChild(wrapper);
}

function addFn() {
    const container = document.getElementById('notable_bands');

    const wrapper = document.createElement('div');
    wrapper.className = 'form-group';

    wrapper.innerHTML = `
        <input type="text" name="notable_bands[]" placeholder="Enter here..." class="form-control" required />
        <button type="button" class="remove-btn">Remove</button>
    `;

    container.appendChild(wrapper);
}
  function removeThis(button) {
    const parent = button.parentElement;
    const input = parent.querySelector('input');
    if (input) {
        input.remove();  // removes only the input, keeps the button visible
    }
}
*/

  // Add new place_of_origin input group
  function addEntry() {
    const container = document.getElementById('place_of_origin');
    const wrapper = document.createElement('div');
    wrapper.className = 'form-group';
    wrapper.innerHTML = `
      <input type="text" name="place_of_origin[]" placeholder="Enter here..." class="form-control" required />
      <button type="button" class="remove-btn">Remove</button>
    `;
    container.appendChild(wrapper);
  }

  // Add new notable_bands input group
  function addFn() {
    const container = document.getElementById('notable_bands');
    const wrapper = document.createElement('div');
    wrapper.className = 'form-group';
    wrapper.innerHTML = `
      <input type="text" name="notable_bands[]" placeholder="Enter here..." class="form-control" required />
      <button type="button" class="remove-btn">Remove</button>
    `;
    container.appendChild(wrapper);
  }

  // Delegated event listener for remove buttons in place_of_origin
  document.getElementById('place_of_origin').addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-btn')) {
      const container = this;
      const allGroups = container.querySelectorAll('.form-group');
      if (allGroups.length > 1) {
        e.target.closest('.form-group').remove();
      } else {
        alert('You must keep at least one place of origin input.');
      }
    }
  });

  // Delegated event listener for remove buttons in notable_bands
  document.getElementById('notable_bands').addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-btn')) {
      const container = this;
      const allGroups = container.querySelectorAll('.form-group');
      if (allGroups.length > 1) {
        e.target.closest('.form-group').remove();
      } else {
        alert('You must keep at least one band input.');
      }
    }
  });