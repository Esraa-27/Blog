

<div class="d-flex align-items-center justify-content-center h-100  ">

    <div class=" text-center ">
            <?php
            if(!empty($_SESSION['message'])) {
                $message = $_SESSION['message'];
                echo '<h1 class="display-1 fw-bold">404</h1>'.
                    '<p class="fs-3"> '.$message.'</p>'.
                    '<p class="lead">you can go to <a href="./index.php?controller=Article&action=index">Articles</a></p>';
            }else{
                echo '<h1 class="display-1 fw-bold">404</h1>'.
                '<p class="fs-3"> <span class="text-danger">Opps!</span> Page not found.</p>'.
                '<p class="lead">The page you’re looking for doesn’t exist.</p>';
        }?>

    </div>
</div>
