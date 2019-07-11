<?php
  $config = json_decode(file_get_contents("config.json"), true);
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
      <div class="hero-body">
        <div class="container has-text-centered">
          <div class="columns is-centered">
            <div class="column is-narrow">
              <table class="table">
                <thead>
                  <tr>
                    <th>Name</th>
                    <?php if($config["alcohol"] == true) { echo '<th><abbr title="Designated Driver">DD</abbr></th>'; } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php if($config["alcohol"] == true) { while($i!=count($entries)) { echo "<tr><td><b>" . $entries[$i]['name'] . "</b></td><td>" . $entries[$i]['dd'] . "</td></tr>"; $i++; }} ?>
                  <?php if($config["alcohol"] == false) { while($i!=count($entries)) { echo "<tr><td><b>" . $entries[$i]['name'] . "</b></td></tr>"; $i++; }} ?>
                </tbody>
              </table>
              <hr />
              <h1 class="title">
                <?php echo $i; ?> attendees
              </h1>
              <h2>Not on this list? <a href=".">Sign up!</a></h2>
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
