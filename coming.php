<?php
  $db = new SQLite3('rsvp.db');
  $i = 0;
  function resultSetToArray($queryResultSet){
      $multiArray = array();
      $count = 0;
      while($row = $queryResultSet->fetchArray(SQLITE3_ASSOC)){
          foreach($row as $i=>$value) {
              $multiArray[$count][$i] = $value;
          }
          $count++;
      }
      return $multiArray;
  }
  $query = 'SELECT name, dd FROM attendees';
  $result = $db->query($query);
  $entries = resultSetToArray($result);
  $db->close();
?>
<!doctype html>
<html lang="en">
  <head>
    <title>🍔🌭🥩</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/css/bulma.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
  </head>
  <body>
    <section class="hero is-fullheight">
      <!-- Hero content: will be in the middle -->
      <div class="hero-body">
        <div class="container">
          <h1 class="title">
            Attendees
          </h1>
          <table class="table">
            <thead>
              <tr>
                <th>Name</th>
                <th><abbr title="Designated Driver">DD</abbr></th>
              </tr>
            </thead>
            <tbody>
              <?php while($i!=count($entries)) { echo "<tr><td>" . $entries[$i]['name'] . "</td><td>" . $entries[$i]['dd'] . "</td></tr>"; $i++; } ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </body>
