<?php
// These lines load the PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Adjust the paths below based on where you placed the PHPMailer 'src' folder
// For example, if 'src' is directly in your website root:
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    // Check that data was sent to the mailer.
    if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid submission.
        header("Location: index.html?success=0#contact");
        exit;
    }

    // --- GoDaddy SMTP Settings (CONFIRMED FROM YOUR IMAGE) ---
    $smtpHost = 'smtpout.secureserver.net'; // Confirmed from your image
    $smtpPort = 465;                        // Confirmed from your image
    $smtpUsername = 'info@sasa-security.com'; // Use either info@sasa-security.com or main@sasa-security.com
    $smtpPassword = '@sasateam123'; // VERY IMPORTANT: Replace with your actual password

    // Email details
    $recipientEmail = 'sasa_sec@yahoo.com'; // Your Yahoo email you want messages sent to
    $fromEmail = 'info@sasa-security.com'; // MUST be one of your GoDaddy email addresses (e.g., info@sasa-security.com or main@sasa-security.com)
    $fromName = 'SASA Security Website';

    // Set the email subject
    $email_subject = "Website Contact: " . (empty($subject) ? "New Inquiry" : $subject);

    // Build the email content.
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    $mail = new PHPMailer(true); // Enable exceptions

    try {
        //Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = $smtpHost;                              // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = $smtpUsername;                          // SMTP username
        $mail->Password   = $smtpPassword;                          // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Use SMTPS (SSL) for port 465
        $mail->Port       = $smtpPort;                              // TCP port to connect to

        //Recipients
        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($recipientEmail);     // Add a recipient
        $mail->addReplyTo($email, $name);       // Add a reply-to address, so you can directly reply to the sender

        //Content
        $mail->isHTML(false);                                  // Set email format to plain text (HTML not needed for simple contact form)
        $mail->Subject = $email_subject;
        $mail->Body    = $email_content;

        $mail->send();
        // Success! Redirect to a thank you page or show a success message.
        header("Location: index.html?success=1#contact");
        exit;

    } catch (Exception $e) {
        // Log the error for debugging purposes (check your server's error logs)
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        // Redirect to an error page or show an error message.
        header("Location: index.html?success=0#contact");
        exit;
    }

} else {
    // Not a POST request, redirect to the form.
    header("Location: index.html");
    exit;
}
?>