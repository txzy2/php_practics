<?php
include_once 'detected.php';

$input = $_POST['input'] ?? '';
$input = htmlspecialchars($input);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>String Detection</title>

  <link rel="stylesheet" href="style/index.css">
</head>
<body>

    <h2>Detect Cyrillic words</h2>

    <form method="post">
      <input type="text" name="input" required />

      <button type='submit'>Submit</button>
    </form> 

    <?php
    if (!empty($input)) {
        echo "<div class='result'><span class='bold'>" . $input . "</span> " . Str::getRes($input) . "</div>";
    }
?>

</body>
</html>
