<?php
if (!empty($_SESSION['data'])) {
    $data = $_SESSION['data'];
    unset($_SESSION['data']);
}
?>



        <h2 class="text-center my-2" >Sign Up </h2>

        <form method="POST" action="./../views/index.php?controller=Auth&action=register">

            <label for="name">Name:</label><br>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $data['name'] ?? '';?>" ><br>

            <label for="email">Email :</label><br>
            <input type="text" class="form-control" id="email" name="email" value="<?php echo $data['email']  ?? '';?>"><br>

            <label for="password">Password :</label><br>
            <input type="password" class="form-control" id="password" name="password" value="<?php echo $data['password']  ?? '';?>"><br>

            <label for="author">Confirm Password :</label><br>
            <input type="password" class="form-control" id="confirm-password" name="confirm-password" value="<?php echo $data['confirm-password'] ?? ''; ?>" ><br>

            <button type="submit" name="register" value="register" class="btn btn-primary">Sign Up</button>
        </form>
        <p> have an account? <a href="./index.php?controller=Auth&action=loginView">Log In</a></p>

        <?php
        if (isset( $data['error']))
            echo $data['error'] ?'<div  class="alert alert-danger w-50 mx-auto mt-2 text-center" role="alert">'. $data['error'].'</div>' : '' ;
        ?>



