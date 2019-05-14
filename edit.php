<?php
session_start();
if($_SESSION["id"]) :
// this page will be available only for logged in users
  // var_dump($_SESSION);
  // var_dump($_GET);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Edit Task</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    
    <style>
      
    </style>
  </head>

  <?php 


            $pdo = new PDO('mysql:host=localhost;dbname=task-manager', 'root', '');
            $sql = 'SELECT * from posts WHERE user_id =' . $_SESSION['id'] . ' AND id=' . $_GET['id'];     // select only the posts that belong to the current user
            $statement = $pdo->prepare($sql);
            $statement = $pdo->query($sql);
            $post = $statement->fetch(PDO::FETCH_ASSOC);
?>
  <body>
    <div class="form-wrapper text-center">
      <form class="form-signin" action="update.php">
        <img class="mb-4" src="assets/img/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Редактировать запись</h1>
        <label for="inputEmail" class="sr-only">Название</label>
        <input type="text" id="inputEmail" class="form-control" placeholder="Название" required value="<?php echo $post['title'];?>">
        <label for="inputEmail" class="sr-only">Описание</label>
        <textarea name="description" class="form-control" cols="30" rows="10" placeholder="Описание"><?php echo $post['text'];?></textarea>
        <input type="file">
        <img src="<?php echo $post['filePath'];?>" alt="" width="300" class="mb-3">
        <button class="btn btn-lg btn-success btn-block" type="submit">Редактировать</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2018-2019</p>
      </form>
    </div>
  </body>
</html>

<?php 

  else :

    $errorMessage = "You are not logged in! ";
    include 'errors.php';
    exit;

    endif;
?>
