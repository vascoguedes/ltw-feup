
<?php 
  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/user.class.php');

  $db = getDatabaseConnection();
  if ($_SESSION['csrf'] === $_GET['csrf']) {
    $available = User::checkAvailability($db, htmlspecialchars($_GET['Email']), htmlspecialchars($_GET['Username']));

    if ($available != 'AVAILABLE') {
      echo json_encode($available);
    } else {
        User::createUser($db, htmlspecialchars($_GET['Username']), password_hash($_GET['Password'], PASSWORD_DEFAULT), htmlspecialchars($_GET['Email']), htmlspecialchars($_GET['Address']), htmlspecialchars($_GET['Phone_number']), htmlspecialchars($_GET['Birthdate']));
        echo json_encode('SUCCESS');
    }
  }
?>