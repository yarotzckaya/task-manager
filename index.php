<?php
session_start();

if($_SESSION["id"]) :
// this page will be available only for logged in users
  ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Tasks</title>
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    <header>
      <div class="collapse bg-dark" id="navbarHeader">
        <div class="container">
          <div class="row">
            <div class="col-sm-8 col-md-7 py-4">
              <h4 class="text-white">What is it?</h4>
              <p class="text-muted">This is a small pure-PHP project that I made for practice.</p>
            </div>
            <div class="col-sm-4 offset-md-1 py-4">
              <h4 class="text-white"> <?php 
                echo "Hello, " . $_SESSION['username'];
              ?></h4>
              <ul class="list-unstyled">
                <li><a href="logout.php" class="text-white">Logout</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container d-flex justify-content-between">
          <a href="/task_manager-markup/index.php" class="navbar-brand d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
            <strong>Tasks</strong>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
      </div>
    </header>

    <main role="main">

      <section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading">Task-manager</h1>
          <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don't simply skip over it entirely.</p>
          <p>
            <a href="http://localhost/task_manager-markup/create.php" class="btn btn-primary my-2">Добавить запись</a>
          </p>
        </div>
      </section>

      <div class="album py-5 bg-light">
       
        <div class="container"> 
          <div class="row">
         
          <?php 

            $pdo = new PDO('mysql:host=localhost;dbname=task-manager', 'root', '');
            $statement = $pdo->prepare('SELECT * from posts WHERE user_id =:user_id');     // select only the posts that belong to the current user
            $statement->bindValue(':user_id', $_SESSION['id']);

            $statement->execute();
            $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
          
               foreach($posts as $post){
                ?>
                          <div class="col-md-4 col-lg-5">
                            <div class="card mb-4 shadow-sm">
                              <img class="card-img-top" src="<?php echo $post['filePath']; ?>">
                              <div class="card-body">
                                <p class="card-text"><?php echo $post['title']; ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                  <div class="btn-group">
                                    <a href="post.php?id=<?php echo $post['id']?>" class="btn btn-sm btn-outline-secondary">View</a>
                                    <a href="edit.php?id=<?php echo $post['id']?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <a href="delete.php?id=<?php echo $post['id']?>" class="btn btn-sm btn-outline-secondary" onclick="confirm('are you sure?')">Delete</a>
                                  </div>
                                </div>
                              </div>
                           </div>
                         </div>
                   
                <?php  
                }
                 ?>
                </div>
        </div>
      </div>
    </main>

    <footer class="text-muted">
      <div class="container">
        <p>Album example is &copy; Bootstrap, but please download and customize it for yourself!</p>
        <p>New to Bootstrap? <a href="../../">Visit the homepage</a> or read our <a href="../../getting-started/">getting started guide</a>.</p>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.js"></script>
  </body>
</html>

<?php 

  else :

    $errorMessage = "You are not logged in! ";
    include 'errors.php';
    exit;

    ?>
 <?php endif;
?>
