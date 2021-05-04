
<!-- Modal EDIT PAINTING -->
<div class="modal fade" id="edit-painting-button" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Painting Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3">
                    <div class="col-6">
                        <div class="">
                            <label for="title" class="form-label">Title<sup>*</sup></label>
                            <input type="text" class="form-control" id="inputTitle" for="title" required>
                        </div>
                        <div class="">
                            <label for="dimensions" class="form-label">Dimensions<sup>*</sup></label>
                            <input type="text" class="form-control" id="inputDimensions" for="dimensions">
                        </div>
                        <div class="">
                            <label for="medium" class="form-label">Medium<sup>*</sup></label>
                            <input type="text" class="form-control" id="inputMedium" for="medium" required>
                        </div>
                        <div class="">
                            <label for="medium_fr" class="form-label">Medium (français)<sup>*</sup></label>
                            <input type="text" class="form-control" id="inputMediumFr" for="medium_fr" required>
                        </div>
                        <div class="">
                            <label for="status" class="form-label">Status<sup>*</sup></label>
                            <select id="inputStatus" for="status" class="form-select" required>
                                <option value="" selected>Choose...</option>
                                <option value="1">Available</option>
                                <option value="2">Unavailable</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div>
                            <img id="thumbnailImage" src="" alt="" />
                        </div>
                    </div>
                    <div class="col-md-12 row">
                        <label for="location" class="form-label">Location: </label>
                        <input type="file" class="form-control" id="fileLocation" name="location" />
                        <div class="text-truncate col-8 smallify" id="inputLocation" for="location"></div>
                        <div id="toggleFileSelector" class="col-4 ml-2 smallify hyper" onclick="toggleFileSelector()">Change Image...</div>
                    </div>

                    <div class="col-md-12" id="edit-form-errors">
                        <div class="alert alert-danger" role="alert">
                            No changes made!
                        </div>
                    </div>
                </form>
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
                <form id="saveForm" class="row g-3">
                    <div class="col-6">
                        <div class="">
                            <label for="title" class="form-label">Title<sup>*</sup></label>
                            <input type="text" class="form-control" id="inputTitleNew" for="title" required>
                        </div>
                        <div class="">
                            <label for="dimensions" class="form-label">Dimensions<sup>*</sup></label>
                            <input type="text" class="form-control" id="inputDimensionsNew" for="dimensions">
                        </div>
                        <div class="">
                            <label for="medium" class="form-label">Medium<sup>*</sup></label>
                            <input type="text" class="form-control" id="inputMediumNew" for="medium" required>
                        </div>
                        <div class="">
                            <label for="medium_fr" class="form-label">Medium (français)<sup>*</sup></label>
                            <input type="text" class="form-control" id="inputMediumFrNew" for="medium_fr" required>
                        </div>
                        <div class="">
                            <label for="status" class="form-label">Status<sup>*</sup></label>
                            <select id="inputStatusNew" for="status" class="form-select" required>
                                <option value="" selected>Choose...</option>
                                <option value="1">Available</option>
                                <option value="2">Unavailable</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div>
                            <img id="thumbnailImageNew" src="" alt="" />
                        </div>
                    </div>
                    <div class="">
                        <label for="location" class="form-label">Location<sup>*</sup></label>
                        <input type="file" class="form-control" id="inputLocationNew" for="location" required>
                    </div>
                </form>
                <div class="my-2" id="saveResult"></div>
            </div>
            <div class="modal-footer">
                <span><sup>*</sup>required</span>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="new-painting-modal-close-button">Close</button>
                <button type="button" class="btn btn-primary" id="new-painting-modal-update-button" disabled>Save</button>
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

<footer class="bg-light mt-5 text-center py-3">Copyright &copy; <b>Monique Bergevin</b></footer>

</body>

</html>