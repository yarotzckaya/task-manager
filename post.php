<?php

require_once 'functions.php';

session_start();
if($_SESSION["id"]) :

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Show</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
    </style>
  </head>

<?php 

$id = $_GET['id'];

$pdo = connect();
$statement = $pdo->prepare('SELECT * from posts where id=:id AND user_id=:user_id');
$statement->bindValue(':id', $id);
$statement->bindValue(':user_id', $_SESSION['id']);

$statement->execute();

$post = $statement->fetch(PDO::FETCH_ASSOC);      // достаем все строки

if(!$post){
  showErrorMessage("This post does not exist");
}

?>

  <body>
    <div class="form-wrapper text-center">
      <img src="<?php echo $post['filePath']; ?>" alt="" width="400">
      <h2><?php echo $post['title']; ?></h2>
      <p>
        <?php echo $post['text']; ?>
      </p>
    </div>
  </body>
</html>

<?php 

  else :

    showErrorMessage("You are not logged in");

    endif;
?>
