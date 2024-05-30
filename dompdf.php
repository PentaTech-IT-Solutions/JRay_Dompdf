<?php
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

require_once __DIR__ . '/vendor/autoload.php'; // Adjust the path as needed

$options = new Options;
$options->setIsRemoteEnabled(true);

@include('db_con.php');

// if (isset($_GET['id'])) {
$result = $pdo->prepare("SELECT * FROM team WHERE id = ?");
$result->execute([$_GET['id']]);
$member = $result->fetch(PDO::FETCH_ASSOC);
// }

// Assuming $member is fetched from the database as in your existing code

// Create an instance of Dompdf class
$dompdf = new Dompdf([
    "chroot" => __DIR__
]);

// HTML content for PDF
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Member Details PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .member {
            margin: 20px;
        }
        /* Add any styling you want for the PDF here */
    </style>
</head>
<body>
    <div class="member">
        <img src="uploads/' . $member['file'] . '" width="250px" height="250px">
        <div>' . $member['firstname'] . ' ' . $member['lastname'] . '</div>
        <div>' . $member['job'] . '</div>
        <div>' . $member['department'] . '</div>
        <div>' . $member['description'] . '</div>        
    </div>

      


</body>
</html>
';

// Load HTML content into Dompdf
$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render PDF (optional: increase rendering time and quality)
$dompdf->render();

// Output PDF to browser
$dompdf->stream("member_details.pdf", array("Attachment" => false));
