<?php
if (!empty($_SESSION['data'])) {
    $data = $_SESSION['data'];
    unset($_SESSION['data']);
}
?>



<h2 class="text-center my-2" >Log In</h2>

        <form method="POST" action="./../views/index.php?controller=Auth&action=login">

            <label for="email">Email :</label><br>
            <input type="text" class="form-control" id="email" name="email" value="<?php echo $data['email']  ?? '';?>" ><br>

            <label for="password">Password :</label><br>
            <input type="password" class="form-control" id="password" name="password" value="<?php echo $data['password']  ?? '';?>"><br>

            <button type="submit" name="login" value="login" class="btn btn-primary">Log In</button>
        </form>
        <p>Need an account ? <a href="./index.php?controller=Auth&action=registerView">Sign Up</a></p>


        <?php
        if (isset( $data['error']))
            echo $data['error'] ?'<div  class="alert alert-danger w-50 mx-auto mt-2 text-center" role="alert">'. $data['error'].'</div>' : '' ;
        ?>


