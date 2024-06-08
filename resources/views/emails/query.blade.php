<!DOCTYPE html>
<html>
<head>
    <title>New Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .message {
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="text-align: center;">New Ticket</h2>
           <h3>Sender Details</h3>
        <table>
           
            <tr>
                <td>Miller Legal Name</td>
                <td>{{ $miller_legal_name }}</td>
            </tr>
           
            <!--<tr>-->
            <!--    <td>Contact Person Name</td>-->
            <!--    <td>{{ $contact_person_name }}</td>-->
            <!--</tr>-->
            <tr>
                <td>Miller Contact No</td>
                <td>{{ $contact_person_no }}</td>
            </tr>
            </table>
            <h3>Sender Query</h3>
            <table>
            <tr>
                <td>Subject</td>
                <td>{{ $subject }}</td>
            </tr>
            <tr>
                <td>Propertior Name (Distributor)</td>
                <td>{{ $propertior_name }}</td>
            </tr>
            <tr>
                <td>Legal Name (Distributor)</td>
                <td>{{ $distributor_legal_name }}</td>
            </tr>
            <tr>
                <td>Contact No. (Distributor)</td>
                <td>{{ $mobile }}</td>
            </tr>
            <tr>
                <td>Address (Distributor)</td>
                <td>{{ $address }}</td>
            </tr>
            
        </table>
        <div class="message">
            <p><strong>Message:</strong></p>
            <p>{{ $messages }}</p>
        </div>
        <p style="text-align: center;">Thank you.</p>
    </div>
</body>
</html>
