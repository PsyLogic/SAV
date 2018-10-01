<!doctype html>
<html>

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <title>Issue Reports</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 15px;
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

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .invoice-box table tr td {
            padding-top: 5px;
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

        .btn {
            cursor: pointer;
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: .25rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            color: #fff;
            background-color: #343a40;
            border-color: #343a40;
            float: right;
        }
    </style>
    <script>
        function printReport(e){
            var element = document.getElementById('print');
            element.style.display='none';
            window.print();
            element.style.display='';
        }
    </script>
</head>

<body>
    <div class='invoice-box'>
        <button class="btn" id="print" onclick="printReport()">Imprimé</button>
        <table cellpadding='0' cellspacing='0'>
            <tr class='top'>
                <td colspan='2'>
                    <table>
                        <tr>
                            <td class='title'>
                                <img src='{{ asset('/images/logo_stg_telecom.png') }}' style='width:25%;'>
                            </td>

                            <td style='float:right;'>
                                <br>
                                Générer le: {{ now()->format('d/m/Y') }}<br>
                                <br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class='heading'>
                <td>
                    Client
                </td>

                <td>
                    Commercial
                </td>
            </tr>

            <tr class='details'>
                <td>
                    <table>
                        <tbody>
                            <tr>
                                <th>Prénom et Nom:</th>
                                <td>{{ $issue->client['full_name'] }}</td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td>{{ $issue->client['tel'] }}</td>
                            </tr>
                            <tr>
                                <th>Addresse:</th>
                                <td>{{ $issue->client['address'] }}</td>
                            </tr>
                            <tr>
                                <th>City:</th>
                                <td>{{ $issue->client['city'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>

                <td>
                    <table>
                        <tbody>
                            <tr>
                                <th>Full name:</th>
                                <td>{{ $issue->commercial->full_name }}</td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td>{{ $issue->commercial->phone }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            <tr class='heading'>
                <td>
                    Informations sur le périphérique
                </td>

                <td>
                    Les dates d'Information
                </td>
            </tr>

            <tr class='details'>
                <td>
                    <table>
                        <tbody>
                            <tr>
                                <th>Model:</th>
                                <td>{{ $issue->client['model'] }}</td>
                            </tr>
                            <tr>
                                <th>IMEI 1:</th>
                                <td>{{ $issue->imei }}</td>
                            </tr>
                            <tr>
                                <th>IMEI 2:</th>
                                <td>{{ $issue->client['imei2'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <table>
                        <tbody>
                            <tr>
                                <th>Livré à:</th>
                                <td>{{ $issue->delivered_at }}</td>
                            </tr>
                            <tr>
                                <th>Reçu à:</th>
                                <td>{{ $issue->received_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            <tr class='heading'>
                <td colspan='2'>
                    État initial du périphérique
                </td>
            </tr>

            <tr class='details'>
                <td class='' style='text-align:center;' colspan='2'>

                    @foreach ($issue->imagesBefore as $image)
                    <img src="{{ $image->getImageUrl() }}" alt='...' width='150' height='150' class='img-thumbnail img-fluid'>
                    @endforeach
                </td>
            </tr>

            <tr class='heading'>
                <td>
                    SAV Information
                </td>

                <td>
                    Informations sur le périphérique
                </td>
            </tr>

            <tr class='details'>
                <td>
                    <table>
                        <tbody>
                            <tr>
                                <th>Prénom et Nom:</th>
                                <td>{{ $issue->user->name }}</td>
                            </tr>
                            {{-- <tr>
                                <th>Téléphone:</th>
                                <td>{{ $issue->user->name }}</td>
                            </tr> --}}
                        </tbody>
                    </table>
                </td>
                <td>
                    <table>
                        <tbody>
                            <tr>
                                <th>Diagnostique:</th>
                                <td>{{ $issue->diagnostic }}</td>
                            </tr>
                            <tr>
                                <th>Problèmes:</th>
                                <td>
                                    <ul>
                                        @foreach ($issue->problems as $problem)
                                        <li> {{ $problem->content }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th>Solutions:</th>
                                <td>
                                    <ul>
                                        @foreach ($issue->solutions as $solution)
                                        <li> {{ $solution->content }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th>Frais:</th>
                                <td>
                                    {{ $issue->fees_DH }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            <tr class='heading'>
                <td colspan='2'>
                    État du périphérique final
                </td>
            </tr>

            <tr class='details'>
                <td class='' style='text-align:center;' colspan='2'>
                    @foreach ($issue->imagesAfter as $image)
                    <img src="{{ $image->getImageUrl() }}" alt='...' width='150' height='150' class='img-thumbnail img-fluid'>
                    @endforeach
                </td>
            </tr>


        </table>
    </div>
</body>

</html>
