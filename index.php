<?php
  if(!file_exists("rsvp.db")) {
    echo "Please run <b>php install</b> from the command line.\n";
    exit;
  }
  $db = new SQLite3('rsvp.db');
  $config = json_decode(file_get_contents("config.json"), true);
  $query = "SELECT COUNT(*) as count FROM attendees";
  $rows = $db->query($query);
  $row = ($rows->fetchArray());
  $numRows = $row['count'];
  $db->close();
  $status = $_GET["status"];
  if(isset($_GET["name"])) {
    $name = $_GET["name"];
  } else {
    $name = "";
  };
?>
<!doctype html>
<html lang="en">
  <head>
    <title><?php echo $config['html_title']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/css/bulma.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $config["ga_key"]; ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', '<?php echo $config["ga_key"]; ?>');
    </script>
  </head>
  <body>
    <section class="hero is-fullheight">
      <div class="hero-body">
        <div class="container has-text-centered">
          <h1 class="title">
            <?php if($status == "") { echo $config['event']; } elseif($status == "okay") { echo "<p style='font-size:80px; color:hsl(141, 71%,  48%)' class='animated jackInTheBox is-large is-success'><i class='fas fa-check'></i></p>You're all set, $name."; } elseif($status == "duplicate") { echo "<p style='font-size:80px; color:hsl(348, 100%, 61%)' class='animated shake is-large'><i class='fas fa-times'></i></p>You're already on the list"; } elseif($status=="noname") { echo "<p class='animated shake is-large'>❌</p>You didn't give me your name";}; ?>
          </h1>
          <h2 class="subtitle">
            <?php if($status == "") { echo $config['details']; } elseif($status == "okay") { echo "Changed your mind? Let minnow ASAP."; } elseif($status == "duplicate") { echo "Is your ego so big that you need to sign yourself up twice?"; } elseif($status == "noname") { echo "How am I going to know who you are? I'm not a fuckin' wizard, you know."; }; ?>
          </h2>
          <?php
            if($status != "okay" && $config["alcohol"] == true){
              echo '<form action="add.php" method="post">
              <input type="checkbox" name="dd">
              I volunteer to be a designated driver.
                <div class="field has-addons has-addons-centered">
                  <div class="control">
                    <input class="input is-rounded is-large is-success" type="text" name="name" placeholder="First name" required>
                  </div>
                  <div class="control">
                    <input type="submit" class="button is-success is-rounded is-large" value="👍"></input>
                  </div>
                </div>
        			</form>';
            } elseif($status != "okay" && $config["alcohol"] == false) {
              echo '<form action="add.php" method="post">
                <div class="field has-addons has-addons-centered">
                  <div class="control">
                    <input class="input is-rounded is-large is-success" type="text" name="name" placeholder="First name" required>
                  </div>
                  <div class="control">
                    <input type="submit" class="button is-success is-rounded is-large" value="👍"></input>
                  </div>
                </div>
        			</form>';
            }
          ?>
          <super><a href="coming.php">See who's coming <?php echo "($numRows 🙋‍)"; ?></a></super>
        </div>
      </div>
    </section>
  </body>
</html>
<!-- made with <3 by Hunter. -->
