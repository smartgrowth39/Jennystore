
<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<?php

if(isset($_POST['backup'])){

    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "jenny_store";

    $filename = "backup_" . date("Y-m-d_H-i-s") . ".sql";

    header('Content-Type: application/sql');
    header('Content-Disposition: attachment; filename="'.$filename.'"');

    $mysqldump = "C:\\xampp\\mysql\\bin\\mysqldump";

    $command = "$mysqldump --host=$host --user=$user --password=$pass $dbname";

    passthru($command);
    exit;
}
?>