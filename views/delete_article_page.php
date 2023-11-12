<?php
$deleted_article_id=(int)$_GET['id'];
?>

<div class="d-flex justify-content-center align-items-center " >
    <div class="modal-dialog " role="document" >

        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Delete Action </h3>

            </div>
            <div class="modal-body">
                Are you sure you want to delete this item ?
            </div>
            <div class="modal-footer">
                <form method="post" action="<?php echo './../views/index.php?controller=Article&action=delete&id=' .$deleted_article_id ?>" >
                    <button type="button" class="btn btn-secondary"><a href='./../views/index.php?controller=Article&action=index' >Close</a></button>

                    <button type="submit" class="btn btn-danger" name="confirm_delete" value="yes" >Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
