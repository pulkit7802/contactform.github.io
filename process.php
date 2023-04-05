<?php
// Replace YOUR_SECRET_KEY with your Google reCaptcha secret key
$secret = "6Le_e14lAAAAAGvWQ0Mb6U_tfWJaY5j12AQJDObk";
$response = $_POST["g-recaptcha-response"];

$url = "https://www.google.com/recaptcha/api/siteverify";
$data = array(
 "secret" => $secret,
 "response" => $response
);

$options = array(
 "http" => array(
  "header"  => "Content-type: application/x-www-form-urlencoded\r\n",
  "method"  => "POST",
  "content" => http_build_query($data)
 )
);

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$verify = json_decode($result);

if ($verify->success) {
 $name = $_POST['name'];
 $email = $_POST['email'];
 $message = $_POST['message'];
 $to = "youremail@example.com";
 $subject = "New Contact Form Submission";
 $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
 $headers = "From: $email";

 mail($to, $subject, $body, $headers);

 echo "<script>alert('Thank you for your message. We will get back to you soon.');</script>";
 echo "<script>window.location = 'contact.php';</script>";
} else {
 echo "<script>alert('Invalid Captcha. Please try again.');</script>";
 echo "<script>window.location = 'contact.php';</script>";
}
?>
