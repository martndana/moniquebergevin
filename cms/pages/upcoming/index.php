<?php


// Load the header
include('./../../layout/header.php');

// Establish database connection
include_once('./../../database/database.php');
$dbConn = new DbConnection();

?>

<!-- Page Content -->
<div class="mx-4 min-height-container">
    <h1>Upcoming Events</h1>
    <button type="button" class="btn btn-dark mb-3" data-bs-toggle="modal" data-bs-target="#new-upcoming-button" action="new-upcoming"><i class="fas fa-plus"></i></button>
    <?php
    $upcomings = $dbConn->upcoming->get();
    if (!empty($upcomings)) : ?>
        <table class="table table-sm listing-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Description</th>
                    <th>Description (Français)</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($upcomings as $upcoming) : ?>
                    <tr upcoming-id="<?php echo $upcoming->id; ?>">
                        <td column-name="id" upcoming-id="<?php echo $upcoming->id; ?>"><?php echo $upcoming->id; ?></td>
                        <td column-name="description" upcoming-id="<?php echo $upcoming->id; ?>"><?php echo $upcoming->description; ?></td>
                        <td column-name="description_fr" upcoming-id="<?php echo $upcoming->id; ?>"><?php echo $upcoming->description_fr; ?></td>
                        <td column-name="status" upcoming-id="<?php echo $upcoming->id; ?>" value="<?php echo $upcoming->status; ?>"><?php echo ($upcoming->status == 1) ? 'Available' : 'Unavailable' ; ?></td>
                        <td column-name="action-edit" upcoming-id="<?php echo $upcoming->id; ?>">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit-upcoming-button" action="edit-upcoming" upcoming-id="<?php echo $upcoming->id; ?>" id="edit-upcoming"><i upcoming-id="<?php echo $upcoming->id; ?>" class="fas fa-pencil-alt"></i></button>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-upcoming-button" action="delete-upcoming" upcoming-id="<?php echo $upcoming->id; ?>"><i class="far fa-trash-alt" upcoming-id="<?php echo $upcoming->id; ?>"></i></button>
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