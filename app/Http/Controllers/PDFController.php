<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Cemeteries;
use TCPDF;

class PDFController extends Controller
{
    public function generatePDF($userId)
    {
        // Fetch all orders for the user
        $orders = Orders::where('UserId', $userId)->get();

        // Initialize TCPDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Quotation');
        $pdf->SetSubject('Quotation');
        $pdf->SetKeywords('Quotation, PDF, TCPDF');

        // Add a page
        $pdf->AddPage();

        // Initialize HTML content
        $html = '<h1 style="text-align: center; color: #5482C4; font-size: 30px;">Quotation</h1>';

        // Check if there are any orders for the user
        if ($orders->isNotEmpty()) {
            // Initialize HTML content for orders table
            $html .= '<table border="1" cellpadding="5" cellspacing="0" style="margin-top: 20px;">'; // Adjust margin-top as needed
            $html .= '<tr style="background-color: #5482C4; color: white;">';
            $html .= '<th style="text-align: center; width: 70%;">Description</th>';
            $html .= '<th style="text-align: center; width: 30%;">Amount</th>';
            $html .= '</tr>';

            // Loop through each order and add it to the HTML content
            foreach ($orders as $order) {
                // Fetch cemetery name from the cemetery table
                $cemetery = Cemeteries::find($order->CemeteryID);
                $cemeteryName = $cemetery ? $cemetery->CemeteryName : '';

                // Build the description string
                $description = "-Grave purchase from $cemeteryName cemetery, Area: {$order->RowID}, Grave Number: {$order->GraveNum}";

                // Add the order row to the HTML content
                $html .= '<tr>';
                $html .= '<td style="width: 70%; font-size: 10px;">' . $description . '</td>'; // Adjust width for description column
                $html .= '<td style="width: 30%; font-size: 10px;">Dummy Amount</td>'; // Adjust width for amount column
                $html .= '</tr>';
            }

            // Close the table
            $html .= '</table>';
        } else {
            // Handle case when no orders are found for the user
            $html .= '<p>No orders found for this user.</p>';
        }

        // Add HTML content to the PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Close PDF document
        $pdfContent = $pdf->Output('quotation.pdf', 'S');

        // Send PDF file to browser
        header('Content-Type: application/pdf');
        echo $pdfContent;
    }
}
