<?php

include('./../../layout/header.php');

include_once('./../../database/database.php');
$dbConn = new DbConnection();

?>

<!-- Page Content -->
<div class="mx-4 min-height-container">
    <h1>Paintings</h1>
    <button type="button" class="btn btn-dark mb-3" data-bs-toggle="modal" data-bs-target="#new-painting-button" action="new-painting"><i class="fas fa-plus"></i></button>
    <?php
    $paintings = $dbConn->painting->get();
    if (!empty($paintings)) : ?>
        <table class="table table-sm listing-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Dimensions</th>
                    <th>Medium</th>
                    <th>Medium (Français)</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Thumbnail</th>
                    <th>Date Added</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paintings as $painting) : ?>
                    <tr painting-id="<?php echo $painting->id; ?>">
                        <td column-name="id" painting-id="<?php echo $painting->id; ?>"><?php echo $painting->id; ?></td>
                        <td column-name="title" painting-id="<?php echo $painting->id; ?>"><?php echo $painting->name; ?></td>
                        <td column-name="dimensions" painting-id="<?php echo $painting->id; ?>"><?php echo $painting->dimensions; ?></td>
                        <td column-name="medium" painting-id="<?php echo $painting->id; ?>"><?php echo $painting->medium; ?></td>
                        <td column-name="medium_fr" painting-id="<?php echo $painting->id; ?>"><?php echo $painting->medium_fr; ?></td>
                        <td column-name="location" painting-id="<?php echo $painting->id; ?>"><?php echo $painting->location; ?></td>
                        <td column-name="status" painting-id="<?php echo $painting->id; ?>" value="<?php echo $painting->status; ?>"><?php echo ($painting->status == 1) ? 'Available' : 'Unavailable' ; ?></td>
                        <td column-name="thumbnail" painting-id="<?php echo $painting->id; ?>"><img src="../../../<?php echo $painting->location; ?>" alt="<?php echo $painting->name; ?>" style="width: 60px; height: 80px;"></td>
                        <td column-name="date_added" painting-id="<?php echo $painting->id; ?>"><?php echo $painting->date_added; ?></td>
                        <td column-name="action-edit" painting-id="<?php echo $painting->id; ?>">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit-painting-button" action="edit-painting" painting-id="<?php echo $painting->id; ?>" id="edit-painting"><i painting-id="<?php echo $painting->id; ?>" class="fas fa-pencil-alt"></i></button>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-painting-button" action="delete-painting" painting-id="<?php echo $painting->id; ?>"><i class="far fa-trash-alt" painting-id="<?php echo $painting->id; ?>"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php
    else :
    ?>
        <div class="mt-4">No data found.</div>
    <?php
    endif;
    ?>
</div>

<!-- Footer -->
<?php include('./../../layout/footer.php'); ?>