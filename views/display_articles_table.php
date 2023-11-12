
<h2 class="text-center" >Display Article </h2>
<div>
    <a  href="./index.php?controller=Article&action=createView" class="btn btn-primary" >Create</a>
</div>
<table class="table table-striped table-dark w-75 ">

    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Body</th>
            <th scope="col">Author</th>
            <th scope="col">Actions </th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach($articles as $article){
            echo " <tr>";
            echo " <td>" . $article['id'] . "</td>";
            echo " <td>" . $article['title'] . "</td>";
            echo " <td>" . $article['body'] . "</td>";
            foreach ($authors as $author) {
                  if ($author['id'] == $article['author_id']) {
                       echo " <td>". $author['name'] .  "</td>";
                  }else{
                       echo null ;
                  }
            }

            echo ' <td>'.
                '<a  href="http://localhost/Blog/views/index.php?controller=Article&action=updateView&id='.$article['id'].'" class="btn btn-warning mx-1">Update</a> '.
                '<a  href="http://localhost/Blog/views/index.php?controller=Article&action=deleteView&id='.$article['id'].'"  class="btn btn-danger mx-1" >Delete</a> '.
                '</td>';
            echo " </tr>";

        }
    ?>
</tbody>
</table>

