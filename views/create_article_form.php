<?php

//session_start();
if (!empty($_SESSION['data'])) {
    $data = $_SESSION['data'];
    unset($_SESSION['data']);
}
?>

<h2 class="text-center" >Create Article </h2>

<form method="POST" action="./../views/index.php?controller=Article&action=add">

    <label for="title">Title:</label><br>
    <input type="text" class="form-control" id="title" name="title" value="<?php echo $data['title'] ?? "" ;?>"><br>

    <label for="author">author:</label><br>
    <select id="author"  class="form-control"  name="author">
        <?php

        foreach ($authors as $auth)
            echo "<option value=".$auth['id'] . ">" .$auth['name'] . "</option>";
        ?>
    </select><br>

    <label for="body">Body:</label><br>
    <textarea  id="body"  class="form-control" name="body" ><?php echo $data['body'] ??"";?></textarea><br>

    <button type="submit" name="create" value="create" class="btn btn-primary">Create</button>
</form>

<?php
    if (isset( $data['error']))
        echo $data['error'] ?'<div  class="alert alert-danger w-50 mx-auto mt-2 text-center" role="alert">'. $data['error'].'</div>' : '' ;
?>

