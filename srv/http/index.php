<?php
// Report all PHP errors (see changelog)
error_reporting(E_ALL);
ini_set("display_errors", "On");

function checked($gpio) {
    if (isset($_POST['submit'])) {
        if (isset($_POST['gpio']) && in_array($gpio, $_POST['gpio'])) {
            return 'checked="1"';
        } else {
            return '';
        }
    } else {
        if (gpread($gpio) == 0) {
            return 'checked="1"';
        } else {
            return '';
        }
    }
}

function gpread($gpio) {
    return system('gpio read '.$gpio);
}

$valid_passwords = array ("fishtank" => "molly");
$valid_users = array_keys($valid_passwords);

$user = $_SERVER['PHP_AUTH_USER'];
$pass = $_SERVER['PHP_AUTH_PW'];

$validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);

if (!$validated) {
  header('WWW-Authenticate: Basic realm="Aquarium Authentication"');
  header('HTTP/1.0 401 Unauthorized');
  die ("Not authorized");
}

if (isset($_POST['submit'])) {
    for ($i = 0; $i <= 3; $i++) {
        if (isset($_POST['gpio']) && in_array($i, $_POST['gpio'])) {
            file_put_contents('data/gpio'.$i, 0);
            system('gpio write '.$i.' 0');
        } else {
            system('gpio write '.$i.' 1');
            file_put_contents('data/gpio'.$i, 1);
        }
    }
    header('Location: index.php');
}

?>

<!DOCTYPE html>

<html>

<head>
    <title>Fish Tank Control</title>
    <meta name="viewport" content="width=50%, initial-scale=2.0, minimum-scale=1.0">
    <style>
        img {
            max-width: 100%;
        }
    </style>
</head>

<body>
<form action="index.php" method="post" style="">
    <input type="checkbox" name="gpio[]" value="0" <?php echo checked(0) ?>> Lights<br/>
    <input type="checkbox" name="gpio[]" value="1" <?php echo checked(1) ?>> 1<br/>
    <input type="checkbox" name="gpio[]" value="2" <?php echo checked(2) ?>> 2<br/>
    <input type="checkbox" name="gpio[]" value="3" <?php echo checked(3) ?>> 3<br/>

    <p>Water temperature: <strong><?php echo file_get_contents('data/temperature'); ?></strong>C</p>

    <input type="submit" value="Submit" name="submit">
</form>

<br/>
<h2>Lights</h2>
<img src="data/light-1d.png" />
<img src="data/light-1w.png" />

<h2>Temperature</h2>
<img src="data/temperature-1d.png" />
<img src="data/temperature-1w.png" />

</body>

</html>
