<?php
 $updated_article_id=(int)$_GET['id'];

if (!empty($_SESSION['data'])) {
    $data = $_SESSION['data'];
    unset($_SESSION['data']);
}

?>
<h2 class="text-center" >Update Article </h2>

<form method="POST" action="<?php echo './../views/index.php?controller=Article&action=update&id='.$updated_article_id ?>">

    <label for="title">Title:</label><br>
    <input type="text" class="form-control" id="title" name="title" value="<?php echo $data['title'] ?? $updated_article['title']  ?>" ><br>

    <label for="author">author:</label><br>
    <select id="author"  class="form-control"  name="author" >
        <?php

            foreach ($authors as $auth)
                if($updated_article['author_id']===$auth['id']){
                    echo "<option selected='selected' value=".$auth['id'] . "  >" .$auth['name'] . "</option>";
                }else{
                    echo "<option value=".$auth['id'] . ">" .$auth['name'] . "</option>";

                }

        ?>
    </select><br>

    <label for="body">Body:</label><br>
    <textarea  id="body"  class="form-control" name="body"  ><?php echo $data['body'] ??  $updated_article['body'] ?></textarea><br>

    <button type="submit" name="update" value="update" class="btn btn-warning px-2 py-3">Update</button>
</form>

<?php
if (isset( $data))
    echo $data['error'] ?'<div  class="alert alert-danger w-50 mx-auto mt-2 text-center" role="alert">'. $data['error'].'</div>' : '' ;
?>

