<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reporte de Préstamos de Solicitante</title>
        <style>
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
            body {
                background-image: url('img/backgroundReport.png');
                font-family: Arial, sans-serif;
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            .content {
                width: 80%;
                margin: 30px auto;
                padding: 20px;
                background: rgba(255, 255, 255, 0.9);
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
            }
            .table-container {
                width: 100%;
                margin: 0 auto;
            }
            .table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            .table th, .table td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: center;
            }
            .table th {
                background-color: #000;
                color: #fff;
                font-weight: bold;
            }
            .table td {
                font-size: 12px;
            }
            .header-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
            }
            .header {
                text-align: left;
            }
            .header h1 {
                font-size: 28px;
                margin: 0;
            }
            .logo {
                width: 150px;
                height: auto;
                margin-bottom: 30px;
                margin-top: 30px;
                float: right;
                margin-left: 10%;
                margin-right: 40px;
            }
            .logo img {
                width: 100%;
                height: auto;
                max-width: 150px;
                border-radius: 8px;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            }
            .info_Eabajo {
                text-align: center;
                margin-top: 20px;
                padding: 10px;
                position: absolute;
                bottom: 5px;
                left: 20px;
                right: 20px;
            }
            .text_infoE {
                text-align: center;
                font-size: 12pt;
                font-family: 'Montserrat', sans-serif;
                color: black;
                text-decoration: none;
                display: inline-block;
            }
        </style>
    </head>
    <body>
        <div class="content">
            <div class="logo">
                @if ($authUser->department->hasMedia('departmentGallery'))
                    <img src="{{ $authUser->department->getFirstMediaUrl('departmentGallery') }}"
                        alt="Foto de {{ $authUser->department->name }}">
                @else
                    <img src='img/logo.png' alt="Logo por defecto">
                @endif
            </div>
            <div class="header">
                <h1>Reporte de Préstamos de Solicitante</h1>
                <p><strong>Solicitante:</strong> {{ $student->name }} {{ $student->last_name }}</p>
                <p><strong>Fecha Inicial:</strong> {{ $startDate ?? 'No especificada' }}</p>
                <p><strong>Fecha Final:</strong> {{ $endDate ?? 'No especificada' }}</p>
                <p><strong>Laboratorio:</strong> {{ $authUser->department->name ?? 'No especificado' }}</p>
            </div>
            <h3>Préstamos Realizados:</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Préstamo</th>
                        <th>Fecha</th>
                        <th>Material</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loans as $loan)
                        @php
                            $materialCount = $loan->materials->count();
                        @endphp
                        @foreach ($loan->materials as $index => $material)
                            <tr>
                                @if ($index === 0)
                                    <td rowspan="{{ $materialCount }}">{{ $loan->id }}</td>
                                    <td rowspan="{{ $materialCount }}">{{ $loan->created_at->format('d/m/Y') }}</td>
                                @endif
                                <td>{{ $material->name }}</td>
                                <td>{{ $material->pivot->quantity }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="info_Eabajo">
            <a class="text_infoE" href="https://inventio.rootheim.com/"><strong>Inventio</strong></a>
            <a class="text_infoE" href="https://rootheim.com/">powered by<strong> Root Heim Company</strong></a>
            <img src="img/rootheim.png" width="15px" height="15px">
        </div>
    </body>
</html>
