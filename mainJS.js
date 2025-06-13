function addPlaceOfOrigin() {
    const container = document.getElementById('place-of-origin-container');
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'place_of_origin[]';
    container.appendChild(input);
    container.appendChild(document.createElement('br'));
}

function addNotableBands() {
    const container = document.getElementById('notable-bands-container');
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'notable_bands[]';
    container.appendChild(input);
    container.appendChild(document.createElement('br'));
}

  function addFn() {
          var entry="<input type='text' name='notable_bands[]' placeholder='Enter here...' class='form-control' required='required'/>";
            var element=document.createElement("div");
            element.setAttribute('class', 'form-group');
            element.innerHTML=entry;
            document.getElementById('notable_bands').appendChild(element);
        }

function addEntry(){
            var entry="<input type='text' name='place_of_origin[]' placeholder='Enter here...' class='form-control' required='required'/>";
            var element=document.createElement("div");
            element.setAttribute('class', 'form-group');
            element.innerHTML=entry;
            document.getElementById('place_of_origin').appendChild(element);
    }

