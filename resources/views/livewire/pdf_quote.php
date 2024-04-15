<?php
// Start output buffering
ob_start();

// Include the main TCPDF library (search for installation path).
require_once('../tcpdf/tcpdf.php');

// Function to retrieve the user ID
function getUserId($userId) {
    // Check if the user ID is set
    if (!empty($userId)) {
        // Retrieve the user ID
        return $userId;
    } else {
        // Handle the case when the user ID is not provided
        die("User ID not provided.");
    }
}

// Get the user ID from the URL parameters
$user_id = getUserId($_GET['userId']);

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "htdb"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Quotation');
$pdf->SetSubject('Quotation');
$pdf->SetKeywords('Quotation, PDF, example');

// Set default footer data
$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// Set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Set font
$pdf->SetFont('helvetica', '', 10);

// Add a page
$pdf->AddPage();

// Fetch orders data from the database
$query = "SELECT * FROM orders WHERE UserId = '$user_id'";
$result = mysqli_query($conn, $query);

// Initialize HTML content
$html = '<h1>Quotation</h1>';

// Check if there are any orders for the user
if ($result && mysqli_num_rows($result) > 0) {
    // Initialize HTML content for orders table
    $html .= '<table border="1">';
    $html .= '<tr><th>Description</th><th>Amount</th></tr>';

    // Loop through each order and add it to the HTML content
    while ($row = mysqli_fetch_assoc($result)) {
        // Build the description string
        $description = "Order ID: {$row['id']}, Product: {$row['product']}, Quantity: {$row['quantity']}";

        // Add the order row to the HTML content
        $html .= '<tr>';
        $html .= '<td>' . $description . '</td>';
        $html .= '<td>Dummy Amount</td>';
        $html .= '</tr>';
    }

    // Close the orders table
    $html .= '</table>';
} else {
    // Handle case when no orders are found
    $html .= '<p>No orders found.</p>';
}

// Print HTML content to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Close PDF document
$pdfContent = $pdf->Output('quotation.pdf', 'S');

// Clear output buffer
ob_end_clean();

// Send PDF file to browser
header('Content-Type: application/pdf');
echo $pdfContent;
?>
