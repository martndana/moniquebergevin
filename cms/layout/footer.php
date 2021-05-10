
<!-- Modal EDIT PAINTING -->
<div class="modal fade" id="edit-painting-button" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Painting Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="saveChangesForm" class="row g-3">
                    <div class="col-6">
                        <div class="">
                            <label for="title" class="form-label">Title<sup>*</sup></label>
                            <input type="text" class="form-control" id="inputTitle" name="inputTitle" for="title" required>
                        </div>
                        <div class="">
                            <label for="dimensions" class="form-label">Dimensions<sup>*</sup></label>
                            <input type="text" class="form-control" id="inputDimensions" name="inputDimensions" for="dimensions">
                        </div>
                        <div class="">
                            <label for="medium" class="form-label">Medium<sup>*</sup></label>
                            <input type="text" class="form-control" id="inputMedium" name="inputMedium" for="medium" required>
                        </div>
                        <div class="">
                            <label for="medium_fr" class="form-label">Medium (français)<sup>*</sup></label>
                            <input type="text" class="form-control" id="inputMediumFr" name="inputMediumFr" for="medium_fr" required>
                        </div>
                        <div class="">
                            <label for="status" class="form-label">Status<sup>*</sup></label>
                            <select id="inputStatus" name="inputStatus" for="status" class="form-select" required>
                                <option value="" selected>Choose...</option>
                                <option value="1">Available</option>
                                <option value="2">Unavailable</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6 text-bottom">
                        <div id="thumbnailImage" class="thumbnail"></div>
                        <div id="toggleFileSelector" class="col-12 ml-2 smallify hyper text-right" onclick="toggleFileSelector()">Change Image...</div>
                    </div>
                    <div class="col-md-12 row">
                        <label id="locationLabel" for="location" class="form-label">Location: </label>
                        <input type="file" class="form-control form-margin" id="fileLocationUpdate" name="inputLocationUpdate" />
                        <input type="text" class="text-truncate col-8 smallify" id="inputLocation" name="inputLocation" for="location" hidden></input>
                    </div>
                </form>

                    <div class="col-md-12" id="edit-form-result"></div>
                    
            </div>
            <div class="modal-footer">
                <span><sup>*</sup>required</span>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="edit-painting-modal-close-button">Close</button>
                <button type="button" class="btn btn-primary" id="edit-painting-modal-update-button" disabled>Update</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal New PAINTING -->
<div class="modal fade" id="new-painting-button" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">New Painting Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="saveForm" name="saveForm" enctype="multipart/form-data" class="row g-3">
                    <div class="col-8">
                        <label for="title" class="form-label">Title<sup>*</sup></label>
                        <input type="text" class="form-control" id="inputTitleNew" name="inputTitleNew" for="title" required>
                    </div>
                    <div class="col-4">
                        <label for="dimensions" class="form-label">Dimensions<sup>*</sup></label>
                        <input type="text" class="form-control" id="inputDimensionsNew" name="inputDimensionsNew" for="dimensions">
                    </div>
                    <div class="col-6">
                        <div class="col-md-12">
                            <label for="medium" class="form-label">Medium<sup>*</sup></label>
                            <input type="text" class="form-control" id="inputMediumNew" name="inputMediumNew" for="medium" required>
                        </div>
                        <div class="col-md-12">
                            <label for="medium_fr" class="form-label">Medium (français)<sup>*</sup></label>
                            <input type="text" class="form-control" id="inputMediumFrNew" name="inputMediumFrNew" for="medium_fr" required>
                        </div>
                    </div >
                    <div class="col-6">
                        <label for="status" class="form-label">Status<sup>*</sup></label>
                        <select id="inputStatusNew" name="inputStatusNew" for="status" class="form-select" required>
                            <option value="" selected>Choose...</option>
                            <option value="1">Available</option>
                            <option value="2">Unavailable</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="location" class="form-label">Location<sup>*</sup></label>
                        <input type="file" class="form-control" id="inputLocationNew" name="inputLocationNew" for="location" required>
                    </div>
                </form>
                <div class="my-2" id="saveResult"></div>
            </div>
            <div class="modal-footer">
                <span><sup>*</sup>required</span>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="new-painting-modal-close-button">Close</button>
                <button type="button" class="btn btn-primary" id="new-painting-modal-save-button">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal DELETE PAINTING -->
<div class="modal fade" id="delete-painting-button" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete Painting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="delete-painting-modal-confirm-button">Confirm</button>
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="delete-painting-modal-close-button">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal EDIT UPCOMING -->
<div class="modal fade" id="edit-upcoming-button" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Upcoming Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="saveChangesFormUpcoming" class="row g-3">
                    <div class="col-md-12">
                        <div class="">
                            <label for="desc" class="form-label">Description<sup>*</sup></label>
                            <textarea class="form-control" id="inputDescEditUpcoming" name="inputDescEditUpcoming" for="description" rows="4" columns="30" required></textarea>
                        </div>
                        <div class="col-md-12">
                            <label for="desc_fr" class="form-label">Description (Français)<sup>*</sup></label>
                            <textarea class="form-control" id="inputDescFrEditUpcoming" name="inputDescFrEditUpcoming" for="desc_fr" rows="4" columns="30" required></textarea>
                        </div>
                        <div class="col-6">
                            <label for="status" class="form-label">Status<sup>*</sup></label>
                            <select id="inputStatusEditUpcoming" name="inputStatusEditUpcoming" for="status" class="form-select" required>
                                <option value="" selected>Choose...</option>
                                <option value="1">Available</option>
                                <option value="2">Unavailable</option>
                            </select>
                        </div>
                    </div>
                </form>

                    <div class="col-md-12" id="edit-form-result-upcoming"></div>
                    
            </div>
            <div class="modal-footer">
                <span><sup>*</sup>required</span>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="edit-upcoming-modal-close-button">Close</button>
                <button type="button" class="btn btn-primary" id="edit-upcoming-modal-update-button" disabled>Update</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal New UPCOMING -->
<div class="modal fade" id="new-upcoming-button" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">New Upcoming Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="saveFormUpcoming" name="saveFormUpcoming" enctype="multipart/form-data" class="row g-3">
                    <div class="col-md-12">
                        <label for="desc" class="form-label">Description<sup>*</sup></label>
                        <textarea class="form-control" id="inputDescNewUpcoming" name="inputDescNewUpcoming" for="desc" row="4" columns="30" required></textarea>
                    </div>
                    <div class="col-md-12">
                        <label for="desc_fr" class="form-label">Description (Français)<sup>*</sup></label>
                        <textarea class="form-control" id="inputDescFrNewUpcoming" name="inputDescFrNewUpcoming" for="desc_fr" row="4" columns="30" required></textarea>
                    </div >
                    <div class="col-6">
                        <label for="status" class="form-label">Status<sup>*</sup></label>
                        <select id="inputStatusNewUpcoming" name="inputStatusNewUpcoming" for="status" class="form-select" required>
                            <option value="" selected>Choose...</option>
                            <option value="1">Available</option>
                            <option value="2">Unavailable</option>
                        </select>
                    </div>
                </form>
                <div class="my-2" id="saveResultUpcoming"></div>
            </div>
            <div class="modal-footer">
                <span><sup>*</sup>required</span>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="new-upcoming-modal-close-button">Close</button>
                <button type="button" class="btn btn-primary" id="new-upcoming-modal-save-button">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal DELETE UPCOMING -->
<div class="modal fade" id="delete-upcoming-button" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete Upcoming Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="delete-upcoming-modal-confirm-button">Confirm</button>
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="delete-upcoming-modal-close-button">Close</button>
            </div>
        </div>
    </div>
</div>

<footer class="bg-light mt-5 text-center py-3">Copyright &copy; <b>Monique Bergevin</b></footer>

</body>

</html>