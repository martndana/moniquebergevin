$(document).ready(function () {
    $('header nav.navbar li.active').removeClass('active');
    $('header nav.navbar a[href="' + location.pathname + '"]').closest('li').addClass('active');

        /***
     * Handle the opening of the edit painting modal form
     */
    let editModalButton = $('[action="edit-painting"]');
    let editModalButtonClose = $('#edit-painting-modal-close-button');
    let editModalButtonUpdate = $('#edit-painting-modal-update-button');

    editModalButton.on('click', handleEditModalOpen);
    editModalButtonClose.on('click', handleEditModalClose);
    editModalButtonUpdate.on('click', handleEditModalUpdate);

    /**
     * Handles the opening of the new painting modal form
     */
    let newModalButton = $('[action="new-painting"]');
    let newModalButtonClose = $('#new-painting-modal-close-button');
    let newModalButtonSave = $('#new-painting-modal-save-button');

    newModalButton.on('click', handleNewModalOpen);
    newModalButtonClose.on('click', handleNewModalClose);
    newModalButtonSave.on('click', handleNewModalSave);

    /***
     * Handle the opening of the delete painting modal
     */
    let deleteModalButton = $('[action="delete-painting"]');
    let deleteModalButtonClose = $('#delete-painting-modal-close-button');
    let deleteModalButtonConfirm = $('#delete-painting-modal-confirm-button');

    deleteModalButton.on('click', handleDeleteModalOpen);
    deleteModalButtonClose.on('click', handleDeleteModalClose);
    deleteModalButtonConfirm.on('click', handleDeleteModalConfirm);
});

function toggleFileSelector() {
    if ($('#toggleFileSelector').html() == 'Change Image...') {
        $('#fileLocation').show();
        $('#toggleFileSelector').html('Cancel Image Change');
    } else {
        $('#fileLocation').hide();
        $('#toggleFileSelector').html('Change Image...');
    }
}

/****
 * Handle the opening of the edit painting modal.
 *
 * @param event
 */
 function handleEditModalOpen(event) {
    let editModalForm = $('#edit-painting-button');
    let editModalButtonUpdate = $('#edit-painting-modal-update-button');
    editModalButtonUpdate.attr('disabled', 'disabled');

    // listener to changes on the input fields to enable update button
    let formInputs = document.querySelectorAll('#edit-painting-button input');
    formInputs.forEach((input) => {
        input.addEventListener("input", handleChangeOnEditFormInput);
    });
    let formSelects = document.querySelectorAll('#edit-painting-button select');
    formSelects.forEach((select) => {
        select.addEventListener("input", handleChangeOnEditFormInput);
    });

    let button = event.target;
    let paintingId = button.getAttribute('painting-id');
    let title = $('td[column-name="title"][painting-id="' + paintingId + '"]').text().trim();
    let dimensions = $('td[column-name="dimensions"][painting-id="' + paintingId + '"]').text().trim();
    let medium = $('td[column-name="medium"][painting-id="' + paintingId + '"]').text().trim();
    let mediumFr = $('td[column-name="medium_fr"][painting-id="' + paintingId + '"]').text().trim();
    let location = $('td[column-name="location"][painting-id="' + paintingId + '"]').text().trim();
    let status = $('td[column-name="status"][painting-id="' + paintingId + '"]').attr('value');
    
    // fill in the input fields with the current values
    editModalForm.find('#inputTitle').val(title).attr('original', title);
    editModalForm.find('#inputDimensions').val(dimensions).attr('original', dimensions);
    editModalForm.find('#inputMedium').val(medium).attr('original', medium);
    editModalForm.find('#inputMediumFr').val(mediumFr).attr('original', mediumFr);
    editModalForm.find('#inputLocation').html(location).attr('original', location);
    editModalForm.find('#inputStatus').val(status).attr('original', status);
    editModalForm.find('#thumbnailImage').css({ 'background-image': 'url("./../../../' + location + '")' }).attr('original', location);
    editModalButtonUpdate.attr('painting-id', paintingId);

    // clear errors.
    $('#edit-form-errors').html('');

}

function handleEditModalClose() {
    let editModalForm = $('#edit-painting-button');
    editModalForm.find('#inputTitle').val('').attr('original', '');
    editModalForm.find('#inputDimensions').val('').attr('original', '');
    editModalForm.find('#inputMedium').val('').attr('original', '');
    editModalForm.find('#inputMediumFr').val('').attr('original', '');
    editModalForm.find('#inputLocation').val('').attr('original', '');
    editModalForm.find('#inputStatus').val('').attr('original', '');
    editModalForm.find('#thumbnailImage').css('background-image', '').attr('original', '');
    let editModalButtonUpdate = $('#edit-painting-modal-update-button');
    editModalButtonUpdate.attr('disabled', 'disabled');
    editModalButtonUpdate.attr('painting-id', '');

    // clear errors.
    $('#edit-form-errors').html('');
}

function handleEditModalUpdate(event) {
    let button = event.target;
    let paintingId = button.getAttribute('painting-id');
    let editModalForm = $('#edit-painting-button');
    let title = editModalForm.find('#inputTitle').val();
    let dimensions = editModalForm.find('#inputDimensions').val();
    let medium = editModalForm.find('#inputMedium').val();
    let medium_fr = editModalForm.find('#inputMediumFr').val();
    let location = editModalForm.find('#inputLocation').val();
    let status = editModalForm.find('#inputStatus').val();

    let params = { paintingId, title, dimensions, medium, medium_fr, location, status };
    let url = './../../controller/painting/update.php';

    let request = $.ajax({
        method: "POST",
        url,
        data: params
    })

    request.done(function (response) {
        if (response.success) {
            let data = response.payload.data;
            let row = $('table tbody tr[painting-id="' + paintingId + '"]');
            let title = row.find('td[column-name="title"]');
            let dimensions = row.find('td[column-name="dimensions"]');
            let medium = row.find('td[column-name="medium"]');
            let mediumFr = row.find('td[column-name="medium_fr"]');
            let location = row.find('td[column-name="location"]');
            let status = row.find('td[column-name="status"]');

            title.text(data.title);
            dimensions.text(data.dimensions);
            medium.text(data.medium);
            mediumFr.text(renderDate(data.medium_fr));
            location.text(data.location);
            status.attr('value', data.status).text((data.status == 1)? "Available" : "Unavailable");

            $('#edit-painting-modal-close-button').click();

            row.animate({
                'backgroundColor': '#f6ee00',
                'fontWeight': 'bolder',
            }, 200, "linear", function () {
                row.animate({
                    'backgroundColor': '#fff',
                    'fontWeight': 'regular',
                }, 3000, "linear"
                )
            }
            );

        }
        else {
            let errorCanvas = document.getElementById('edit-form-errors');
            errorCanvas.innerHTML = '';

            let alert = document.createElement('div');
            alert.classList.add('alert', 'alert-danger');
            alert.setAttribute('role', 'alert');
            alert.innerHTML = (response.payload && response.payload.message)
                ? response.payload.message
                : response.toString();
            errorCanvas.appendChild(alert);
        }
    });

}

function handleChangeOnEditFormInput(event) {

    // assign the update button to variable
    let editModalButtonUpdate = document.getElementById('edit-painting-modal-update-button');

    // check all the form
    let errors = [];
    let changed = 0;
    let form = document.querySelector('#edit-painting-button form');
    // sweep inputs
    let inputs = form.querySelectorAll('input');
    inputs.forEach((input) => {
        // check if not empty in the case is required
        if (input.getAttribute('type').match(/text/) && input.value.trim() == '' && input.required) {
            errors.push(input.getAttribute('for') + ' is empty.');
        }
        // check if different from original
        if (input.getAttribute('original').toLowerCase() != input.value.trim().toLowerCase()) {
            changed++;
        }
    });

    let dropdowns = form.querySelectorAll('select');
    dropdowns.forEach((dropdown) => {
        // check if not empty in the case is required
        if (dropdown.value.trim() == '' && dropdown.required) {
            errors.push(dropdown.getAttribute('for') + ' is empty.');
        }
        // check if different from original
        if (dropdown.getAttribute('original').toLowerCase() != dropdown.value.trim().toLowerCase()) {
            changed++;
        }
    });

    if (changed == 0) {
        errors.push('There are no changes in the form.');
    }

    let errorCanvas = document.getElementById('edit-form-errors');
    errorCanvas.innerHTML = '';

    if (errors.length > 0) {
        editModalButtonUpdate.disabled = true;
        // assign error canvas to variable

        errors.forEach(error => {
            let alert = document.createElement('div');
            alert.classList.add('alert', 'alert-danger');
            alert.setAttribute('role', 'alert');
            alert.innerHTML = error;
            errorCanvas.appendChild(alert);
        })
    } else {
        editModalButtonUpdate.disabled = false;
    }
}

/********************************************************************
 * NEW PAINTING SECTION
 ********************************************************************/
function handleNewModalOpen(event) {
    let newModalForm = $('#new-painting-button');
}

function handleNewModalClose(event) {
    clearForm();
}

function handleNewModalSave(event) {
    let button = event.target;
    let paintingId = button.getAttribute('painting-id');
    let newModalForm = $('#new-painting-button');
    let title = newModalForm.find('#inputTitleNew').val();
    let dimensions = newModalForm.find('#inputDimensionsNew').val();
    let medium = newModalForm.find('#inputMediumNew').val();
    let medium_fr = newModalForm.find('#inputMediumFrNew').val();
    let location = newModalForm.find('#inputLocationNew').val();
    let file = newModalForm.find('#inputLocationNew').prop('files')[0];
    let fileName = file.name;
    let fileSize =file.size;
    let status = newModalForm.find('#inputStatusNew').val();
    console.log(fileName + " - " + fileSize);

    let params = { paintingId, title, dimensions, medium, medium_fr, location, fileName, fileSize, status };

    // Validation
    let err = false;
    let errMessage = "The following information is either missing or invalid: <br>";
    newModalForm.find('#inputTitleNew').removeClass('alert-danger');
    newModalForm.find('#inputDimensionsNew').removeClass('alert-danger');
    newModalForm.find('#inputMediumNew').removeClass('alert-danger');
    newModalForm.find('#inputMediumFrNew').removeClass('alert-danger');
    newModalForm.find('#inputLocationNew').removeClass('alert-danger');
    newModalForm.find('#inputStatusNew').removeClass('alert-danger');

    if (title === "") {
        err = true;
        errMessage += "- Title<br>";
        newModalForm.find('#inputTitleNew').addClass('alert-danger');
    }

    if (dimensions === "") {
        err = true;
        errMessage += "- Dimensions<br>";
        newModalForm.find('#inputDimensionsNew').addClass('alert-danger');
    }

    if (medium === "") {
        err = true;
        errMessage += "- Medium<br>";
        newModalForm.find('#inputMediumNew').addClass('alert-danger');
    }

    if (medium_fr === "") {
        err = true;
        errMessage += "- Medium (français)<br>";
        newModalForm.find('#inputMediumFrNew').addClass('alert-danger');
    }

    if (location === "") {
        err = true;
        errMessage += "- Location<br>";
        newModalForm.find('#inputLocationNew').addClass('alert-danger');
    }

    if (status === "") {
        err = true;
        errMessage += "- Status<br>";
        newModalForm.find('#inputStatusNew').addClass('alert-danger');
    }

    if (err) {
        $('#saveResult').html(errMessage);
        $('#saveResult').addClass('alert alert-danger');
    } else {
        $('#new-painting-modal-save-button').hide();
        $.ajax({
            method: 'POST',
            url: './../../controller/painting/new.php',
            // contentType: false,
            // processType: false,
            data: params,

            success: function (result) {
                if (result.success) {
                    displaySuccess(result.response);
                } else {
                    displayFail(result.error);
                }
            },

            error: () => {
                displayFail("An error occured when attempting to connect with the server.  <br>Please try again later.", "Unknown Error");
            }
        }) // End of ajax

    } // End of validation checks 

}

function displaySuccess(response) {
    $('#saveForm').hide();
    $('#saveResult').removeClass('alert alert-danger');

    // Appending a new row to the top of the tbody element
    let newRow = '<tr painting-id="' + response.id + '">' +
        '<td column-name="id" painting-id="' + response.id + '">' + response.id + '</td>' +
        '<td column-name="title" painting-id="' + response.id + '">' + response.title + '</td>' +
        '<td column-name="dimensions" painting-id="' + response.id + '">' + response.dimensions + '</td>' +
        '<td column-name="medium" painting-id="' + response.id + '">' + response.medium + '</td>' +
        '<td column-name="medium_fr" painting-id="' + response.id + '">' + response.mediumFr + '</td>' +
        '<td column-name="location" painting-id="' + response.id + '">' + response.location + '</td>' +
        '<td column-name="status" painting-id="' + response.id + '">' + response.status + '</td>' +
        '<td column-name="action-edit" painting-id="' + response.id + '">' +
        '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit-painting-button" action="edit-painting" painting-id="' + response.id + '">Edit</button> ' +
        '<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-painting-button" action="delete-painting" painting-id="' + response.id + '">Delete</button></td>' +
        '</tr>';


    $('tbody').prepend(newRow);

    let row = $('table tbody tr[painting-id="' + response.id + '"]');

    let paintingName = response.title;
    $('#saveResult').html(paintingName + " has been added to the painting list.");

    let editModalButton = $('[action="edit-painting"]');
    editModalButton.on('click', handleEditModalOpen);

    let deleteModalButton = $('[action="delete-painting"]');
    deleteModalButton.on('click', handleDeleteModalOpen);

    row.animate({
        'backgroundColor': '#49AD49',
        'fontWeight': 'bolder',
    }, 200, "linear", function () {
        row.animate({
            'backgroundColor': '#fff',
            'fontWeight': 'regular',
        }, 500, "linear"
        )
    }
    );
}

function displayFail(response) {
    $('#saveForm').hide();
    $('#saveResult').addClass('alert alert-danger');
    $('#saveResult').html(response);
}

function clearForm() {

    let newModalForm = $('#new-painting-button');

    // Show Hidden Elements
    $('#new-painting-modal-save-button').show();
    $('#saveForm').show();

    // Remove Markup
    newModalForm.find('#inputTitleNew').removeClass('alert-danger');
    newModalForm.find('#inputDimensionsNew').removeClass('alert-danger');
    newModalForm.find('#inputMediumNew').removeClass('alert-danger');
    newModalForm.find('#inputMediumFrNew').removeClass('alert-danger');
    newModalForm.find('#inputLocationNew').removeClass('alert-danger');
    newModalForm.find('#inputStatusNew').removeClass('alert-danger');

    // Clear Contents
    newModalForm.find('#inputTitleNew').val("");
    newModalForm.find('#inputDimensionsNew').val("");
    newModalForm.find('#inputMediumNew').val("");
    newModalForm.find('#inputMediumFrNew').val("");
    newModalForm.find('#inputLocationNew').val("");
    newModalForm.find('#inputStatusNew').val("");

    $('#saveResult').html('')
    $('#saveResult').removeClass('alert alert-danger');

}

/********************************************************************
 * DELETE PAINTING SECTION
 ********************************************************************/
function handleDeleteModalConfirm(event) {
    let button = event.target;
    let modal = document.getElementById('delete-painting-button');
    let modalCloseButton = document.getElementById('delete-painting-modal-close-button');
    let paintingId = button.getAttribute('painting-id');


    // parameters to delete painting
    let params = { paintingId };
    let url = './../../controller/painting/delete.php';

    // call delete method
    let request = $.ajax({
        method: "POST",
        url,
        data: params
    });

    request.done(function (response) {
        if (response.success) {
            modalCloseButton.click();
            let row = $('tr[painting-id="' + paintingId + '"]');
            row.animate({
                'backgroundColor': '#ff6363',
                'fontWeight': 'bolder',
            }, 200, "linear", function () {
                row.animate({
                    'backgroundColor': '#fff',
                    'fontWeight': 'regular',
                }, 200, "linear", function () {
                    row.remove();
                }
                )
            }
            );
        } else {
            let modalBody = document.querySelector('#delete-painting-button .modal-body .alert[role="alert"]');
            modalBody.innerHTML = response;
        }
    });

}

function handleDeleteModalOpen(event) {
    let deleteButton = event.target;
    let modalBody = document.querySelector('#delete-painting-button .modal-body');
    let paintingId = deleteButton.getAttribute('painting-id');
    let paintingTitle = $('td[column-name="title"][painting-id="' + paintingId + '"]').text().trim();
    let alert = document.createElement('div');
    alert.classList.add('alert', 'alert-danger');
    alert.setAttribute('role', 'alert');
    alert.innerHTML = 'This action will permanently delete the ' + paintingTitle + ' painting from the database.  Please confirm.';
    modalBody.innerHTML = "";
    modalBody.appendChild(alert);
    // inject paintingid on confirm button
    let confirmpaintingDeleteButton = document.getElementById('delete-painting-modal-confirm-button');
    confirmpaintingDeleteButton.setAttribute('painting-id', paintingId);
}

function handleDeleteModalClose() {
    console.log('handleDeleteModalClose');
}