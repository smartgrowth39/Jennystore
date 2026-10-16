<?php
include "connect.php";

// same function jo tum use kar rahe ho
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

// if (isset($_POST['remove'])) {

//     $cart_id = $_POST['cart_id'];
//     $ip = get_client_ip();

//     mysqli_query(
//         $connect,
//         "DELETE FROM add_to_cart 
//          WHERE cart_id='$cart_id' 
//          AND ip_address='$ip'"
//     );

//     header("Location: cart.php");
//     exit;
// }

if(isset($_POST['remove'])){

    $cart_id = $_POST['cart_id'];

    mysqli_query($connect,"
    DELETE FROM add_to_cart
    WHERE cart_id='$cart_id'
    ");

    echo "<script>
    window.location='cart.php';
    </script>";

}
?>