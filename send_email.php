<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    // Set the recipient email address.
    $recipient = "sasa_sec@yahoo.com"; // Your Yahoo email

    // Set the email subject
    if (empty($subject)) {
        $email_subject = "New Contact from SASA Security Website";
    } else {
        $email_subject = "Website Contact: " . $subject;
    }

    // Build the email content.
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // Build the email headers.
    // Important: Setting a "From" address that matches your domain improves deliverability.
    // Replace 'noreply@yourdomain.com' with an actual email address from your sasa-security.com domain if possible.
    // Otherwise, use something like "contact@yourdomain.com"
    $email_headers = "From: Your Website <info@sasa-security.com>"; // IMPORTANT: Change this!
    $email_headers .= "\r\nReply-To: $email"; // Allows you to reply directly to the sender

    // Send the email.
    if (mail($recipient, $email_subject, $email_content, $email_headers)) {
        // Success! Redirect to a thank you page or show a success message.
        header("Location: index.html?success=1#contact"); // You can create a dedicated success page
        exit;
    } else {
        // Failed. Redirect to an error page or show an error message.
        header("Location: index.html?success=0#contact"); // Indicate failure
        exit;
    }

} else {
    // Not a POST request, redirect to the form.
    header("Location: index.html");
    exit;
}
?>