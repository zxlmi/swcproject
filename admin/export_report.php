<?php

ob_start(); // Buffer output to prevent header issues
require '../admin/db_connect.php';
require '../tcpdf/tcpdf.php'; // Include TCPDF library

date_default_timezone_set('Asia/Kuala_Lumpur'); // Set timezone Malaysia

// Create new PDF document
$pdf = new TCPDF();
$pdf->AddPage();

$pdf->SetFont('helvetica', '', 10); // Kecilkan font untuk muat lebih banyak data

// PDF title
$pdf->SetFillColor(0, 123, 255);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('', 'B', 20);
$pdf->Cell(0, 15, 'Order Report', 0, 1, 'C', true);
$pdf->Ln(5);
$pdf->SetFont('', '', 10);

// Reset text color to black for table content
$pdf->SetTextColor(0, 0, 0);

// Fetch order data
$query = "SELECT o.id, o.name, o.email, o.mobile, o.status, o.order_date, p.name AS product_name, ol.qty, p.price
          FROM orders o
          JOIN order_list ol ON o.id = ol.order_id
          JOIN product_list p ON ol.product_id = p.id";

$result = $conn->query($query);

// Build the table with styling
$html = '<style>
            table { border-collapse: collapse; width: 100%; }
            th { background-color: #007bff; color: #fff; padding: 6px; }
            td { padding: 6px; border: 1px solid #ccc; text-align: center; color: #000; }
            .pending { color: #ff9800; font-weight: bold; }
            .completed { color: #4caf50; font-weight: bold; }
            .cancelled { color: #f44336; font-weight: bold; }
         </style>';

$html .= '<table border="1" cellpadding="3">
            <tr>
                <th width="5%">ID</th>
                <th width="15%">Customer Name</th>
                <th width="15%">Email</th>
                <th width="10%">Mobile</th>
                <th width="15%">Product</th>
                <th width="5%">Qty</th>
                <th width="8%">Price</th>
                <th width="8%">Total</th>
                <th width="9%">Status</th>
                <th width="10%">Order Date</th>
            </tr>';

$total_revenue = 0;

while ($row = $result->fetch_assoc()) {
    $total_price = $row['qty'] * $row['price'];
    $total_revenue += $total_price;

    $statusClass = ['pending', 'completed', 'cancelled'][$row['status']];
    $statusText = ['Pending', 'Completed', 'Cancelled'][$row['status']];

    $orderDate = date('d-m-Y h:i A', strtotime($row['order_date']));

    $html .= '<tr>
                <td>' . $row['id'] . '</td>
                <td>' . $row['name'] . '</td>
                <td>' . $row['email'] . '</td>
                <td>' . $row['mobile'] . '</td>
                <td>' . $row['product_name'] . '</td>
                <td>' . $row['qty'] . '</td>
                <td>$' . number_format($row['price'], 2) . '</td>
                <td>$' . number_format($total_price, 2) . '</td>
                <td class="' . $statusClass . '">' . $statusText . '</td>
                <td>' . $orderDate . '</td>
            </tr>';
}

$html .= '</table>';
$html .= '<h3>Total Revenue: $' . number_format($total_revenue, 2) . '</h3>';

$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF
$pdf->Output('order_report.pdf', 'D');

$conn->close();
?>
