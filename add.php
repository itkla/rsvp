<?php
  date_default_timezone_set("Pacific/Honolulu");
  $db = new SQLite3('rsvp.db');
  // capture ip addresses to check for duplicates. NOT YET IMPLEMENTED
  $ip = $_SERVER['REMOTE_ADDR'];
  if(isset($_POST['name'])) {
    $name = ucfirst($_POST['name']);
    $dd = $_POST['dd'];
    if($dd == "on") {
      $dd = "Yes";
    } else {
      $dd = "No";
    }
    $query = "SELECT * FROM attendees WHERE name = '$name'";
    $result = $db->query($query) or die("Could not process query.");
    $rows = ($result->fetchArray());
    if($rows>0) {
      header("Location: ./?status=duplicate");
    } else {
      $date = date("d/m/Y h:i:sa");
      $db->exec("INSERT INTO attendees (name, dd, time, ip) VALUES ('$name', '$dd', '$date', '$ip')");
      header("Location: ./?status=okay&name=$name");
    }
    /*
    $db->exec("INSERT INTO attendees (name, dd) VALUES ('$name', '$dd')");
    header("Location: ../?status=okay&name=$name&dd=$dd");
    */
  }
  $db->close();
  unset($db);
?>
