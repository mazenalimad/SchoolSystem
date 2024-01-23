<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        include('libraries.php');
    ?>

    <title>Students</title>
    <link rel="icon" href="Pictures/img.jpg" type="image/x-icon"/>
</head>
<body>
    <?php
        require_once('dbconnect.php');

        
    ?>
<!--Card-->
<div class="card indigo text-center z-depth-2 light-version py-4 px-5">

  <form>
  </form>
  <!--Card-->
<div class="card indigo text-center z-depth-2 light-version py-4 px-5">

<form class="md-form" action="#">
  <div class="file-field">
    <div class="btn btn-outline-white waves-effect btn-sm float-left">
      <span>Choose file<i class="fas fa-cloud-upload-alt ml-3" aria-hidden="true"></i></span>
      <input type="file">
    </div>
    <div class="file-path-wrapper">
      <input class="file-path validate text-white" type="text" placeholder="Upload your file">
    </div>
  </div>
</form>

<hr class="w-100 my-4">

<form class="md-form" action="#">
  <div class="file-field">
    <div class="btn btn-outline-white btn-rounded waves-effect btn-sm float-left">
      <span>Choose files<i class="fas fa-cloud-upload-alt ml-3" aria-hidden="true"></i></span>
      <input type="file" multiple>
    </div>
    <div class="file-path-wrapper">
      <input class="file-path validate text-white" type="text" placeholder="Upload one or more files">
    </div>
  </div>
</form>

</div>
<!--/.Card-->
<!--Card-->
<div class="card mdb-color lighten-4 text-center z-depth-2 light-version py-4 px-5">

<form class="md-form" class="mb-3">
  <div class="file-field">
    <a class="btn-floating peach-gradient mt-0 float-left">
      <i class="fas fa-paperclip" aria-hidden="true"></i>
      <input type="file">
    </a>
    <div class="file-path-wrapper">
      <input class="file-path validate" type="text" placeholder="Upload your file">
    </div>
  </div>
</form>

<form class="md-form" class="mb-3">
  <div class="file-field">
    <a class="btn-floating peach-gradient mt-0 float-left">
      <i class="fas fa-paperclip" aria-hidden="true"></i>
      <input type="file">
    </a>
    <div class="file-path-wrapper">
      <input class="file-path validate" type="text" placeholder="Upload your file">
    </div>
  </div>
</form>

<form class="md-form">
  <div class="file-field">
    <a class="btn-floating peach-gradient mt-0 float-left">
      <i class="fas fa-paperclip" aria-hidden="true"></i>
      <input type="file">
    </a>
    <div class="file-path-wrapper">
      <input class="file-path validate" type="text" placeholder="Upload your file">
    </div>
  </div>
</form>

</div>
<!--/.Card-->
</body>
</html>