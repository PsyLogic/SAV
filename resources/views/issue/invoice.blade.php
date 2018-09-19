<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Issue Invoice</title>
    
    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }

    .invoice-box table tr td{
        padding-top:5px;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ asset('/images/logo_stg_telecom.png') }}" style="width:25%;">
                            </td>
                            
                            <td style="float:right;">
                                <br>
                                Created: January 1, 2015<br>
                                <br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>
                    Client
                </td>
                
                <td>
                    Commercial
                </td>
            </tr>
            
            <tr class="details">
                <td>
                    <table>
                        <tbody>
                            <tr>
                                <th>Full name:</th>
                                <td>Adam Smith</td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td>+212 660 262 3666</td>
                            </tr>
                            <tr>
                                <th>Addresse:</th>
                                <td>High way 212, Alpha reomeo</td>
                            </tr>
                            <tr>
                                <th>City:</th>
                                <td>California</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                
                <td>
                    <table>
                        <tbody>
                            <tr>
                                <th>Full name:</th>
                                <td>Adam Smith</td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td>+212 668 287 854</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>
                    Device Information
                </td>
                
                <td>
                    Date Information
                </td>
            </tr>

            <tr class="details">
                <td>
                    <table>
                        <tbody>
                            <tr>
                                <th>Model:</th>
                                <td>X1</td>
                            </tr>
                            <tr>
                                <th>IMEI 1:</th>
                                <td>123456789123456</td>
                            </tr>
                            <tr>
                                <th>IMEI 2:</th>
                                <td>987654321654123</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <table>
                        <tbody>
                            <tr>
                                <th>Delivered at:</th>
                                <td>02/02/2019</td>
                            </tr>
                            <tr>
                                <th>Received at:</th>
                                <td>04/02/2019</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td colspan="2">
                    Initial Device status
                </td>
            </tr>

            <tr class="details">
                <td class="" style="text-align:center;" colspan="2">
                    <img src="https://via.placeholder.com/150?text=Picture+1" alt="..." width="150" height="150" class="img-thumbnail img-fluid">
                    <img src="https://via.placeholder.com/150?text=Picture+1" alt="..." width="150" height="150" class="img-thumbnail img-fluid">
                    <img src="https://via.placeholder.com/150?text=Picture+1" alt="..." width="150" height="150" class="img-thumbnail img-fluid">
                </td>
            </tr>

            <tr class="heading">
                <td>
                    SAV Information
                </td>
                
                <td>
                    Device Information
                </td>
            </tr>

            <tr class="details">
                <td>
                    <table>
                        <tbody>
                            <tr>
                                <th>Full Name:</th>
                                <td>Jhon Doe</td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td>+212 665 878 548</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <table>
                        <tbody>
                            <tr>
                                <th>Diagnostic:</th>
                                <td>Hardware</td>
                            </tr>
                            <tr>
                                <th>Problems:</th>
                                <td>
                                    <ul>
                                        <li>Microphone broken</li>
                                        <li>Screen broken</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th>Solutions:</th>
                                <td>
                                    <ul>
                                        <li>Mic Fixed</li>
                                        <li>Screen replaced</li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td colspan="2">
                    Final Device status
                </td>
            </tr>

            <tr class="details">
                <td class="" style="text-align:center;" colspan="2">
                    <img src="https://via.placeholder.com/150?text=Picture+1" alt="..." width="150" height="150" class="img-thumbnail img-fluid">
                    <img src="https://via.placeholder.com/150?text=Picture+1" alt="..." width="150" height="150" class="img-thumbnail img-fluid">
                    <img src="https://via.placeholder.com/150?text=Picture+1" alt="..." width="150" height="150" class="img-thumbnail img-fluid">
                </td>
            </tr>
            
           
        </table>
    </div>
</body>
</html>