<?php

if (!isset($_GET['dvd'])) {
  header('Location: index.php');
  exit();
}

$host = 'itp460.usc.edu';
$dbname = 'dvd';
$user = 'student';
$pw = 'ttrojan';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pw);

$artist = $_GET['artist'];
$dvd = $_GET['dvd'];

$adjusted = "%" . $dvd . "%";

// $sql = "
//   SELECT title, genre, format, rating
//   FROM dvds
//   INNER JOIN dvds
//   ON dvds.genre_id = genres.id
//   WHERE title LIKE ?
// ";

$sql = "
  SELECT dvds.title, genres.genre_name, formats.format_name, ratings.rating_name
  FROM dvds
  INNER JOIN genres
  ON dvds.genre_id = genres.id
  INNER JOIN formats
  ON dvds.format_id = formats.id
  INNER JOIN ratings
  ON dvds.rating_id = ratings.id
  WHERE dvds.title LIKE ?
";

$statement = $pdo->prepare($sql);
$statement->bindParam(1, $adjusted);
$statement->execute();
$dvds = $statement->fetchAll(PDO::FETCH_OBJ);
// var_dump($dvds);

// echo $dvds[0]['title'];
// echo $dvds[0]->title;

?>

<div class="container">
  <h1>
    You searched for: <?php echo $dvd ?>
  </h1>
</div>


<?php  

if (!$dvds) {
  echo "<h1>Nothing was found <a href=" . '"/index.php' . '"' . ">Go Back</a></h1>";
}

?>





<!DOCTYPE html>
<html>
<head>
  <title>DVD Results</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>

  <div class="container">
    <table class="table">
    <tr>
      <th>Title</th>
      <th>Genre</th>
      <th>Format</th>
      <th>Rating</th>
    </tr>


    <?php foreach ($dvds as $my_dvd) : ?>
      
      <?php echo "<tr>" ?>
      
      <?php echo "<td>" .  $my_dvd->title . "</td>" ?>
      <?php echo "<td>" .  $my_dvd->genre_name . "</td>" ?>
      <?php echo "<td>" .  $my_dvd->format_name . "</td>" ?>
      <?php echo "<td>" .  "<a href=" . '"/ratings.php?rating=' . $my_dvd->rating_name . '">' . $my_dvd->rating_name . "</a>" . "</td>" ?>

      <?php echo "</tr>" ?>

    <?php endforeach; ?>

  </table>

  </div>

</body>
</html>


<!-- foreach ($dvds as $song) {
  echo $song->title;
  echo '<br />';
} -->
