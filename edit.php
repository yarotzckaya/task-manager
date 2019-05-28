<?php
session_start();
if($_SESSION["id"]) :
// this page will be available only for logged in users
 
 // check if the post exists

$id = $_GET['id'];

$pdo = new PDO('mysql:host=localhost;dbname=task-manager', 'root', '');

$statement = $pdo->prepare('SELECT * from posts where id=:id AND user_id=:user_id');
$statement->bindValue(':id', $id);
$statement->bindValue(':user_id', $_SESSION['id']);

$statement->execute();

$post = $statement->fetch(PDO::FETCH_ASSOC);      // достаем все строки

$_POST['post_id'] = $_GET['id'];

if(!$post){
  $errorMessage = "This post does not exist.";
  include 'errors.php';
  exit;
}

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

  <body>
    <div class="form-wrapper text-center">
      <form class="form-signin" action="update.php" method="post" enctype="multipart/form-data">
        <img class="mb-4" src="assets/img/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Edit task</h1>
        <label for="inputEmail" class="sr-only">Title</label>
        <input type="text" id="title" name="title" class="form-control" placeholder="Название" value="<?php echo $post['title'];?>">
        <label for="inputEmail" class="sr-only">Description</label>
        <textarea name="text" class="form-control" cols="30" rows="10" placeholder="Описание"><?php echo $post['text'];?></textarea>
        <input type="file" name="file" id="file" value="<?php echo $post['filePath'];?>">

        <input type="hidden" name="post_id" id="post_id" value="<?php echo $_GET['id']; ?>">

        <img src="<?php echo $post['filePath'];?>" alt="" width="300" class="mb-3">
        <button class="btn btn-lg btn-success btn-block" type="submit">Edit</button>
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
