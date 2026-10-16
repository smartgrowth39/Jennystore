<?php
include "connect.php";

if(isset($_POST['submit_review']))
{

$product_id = $_POST['product_id'];
$name = $_POST['reviewer_name'];
$email = $_POST['reviewer_email'];
$rating = $_POST['rating'];
$review = $_POST['review_text'];

$query = "INSERT INTO reviews(product_id,reviewer_name,reviewer_email,rating,review_text,review_date)
VALUES('$product_id','$name','$email','$rating','$review',NOW())";

mysqli_query($connect,$query);

header("Location: product-detail.php?id=$product_id");

}
?>