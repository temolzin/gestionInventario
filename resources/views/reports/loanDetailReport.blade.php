<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Préstamo</title>
    <style>
        html,
        body {
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
            justify-content: flex-start;
            padding: 20px;
        }

        .content {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 28px;
            margin: 0;
            text-align: center;
            flex-grow: 1;
        }

        .header p {
            margin: 5px 0;
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
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
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

        h3 {
            text-align: center;
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
        <div class="d-flex justify-content-between align-items-center py-2 px-3">
            <div class="logo ms-3">
                @if ($authUser->department->hasMedia('departmentGallery'))
                    <img src="{{ $authUser->department->getFirstMediaUrl('departmentGallery') }}"
                        alt="Foto de {{ $authUser->department->name }}" class="img-fluid" style="max-width: 150px;">
                @else
                    <img src='img/logo.png' alt="Foto por defecto" class="img-fluid" style="max-width: 150px;">
                @endif
            </div>
            <div class="header-info">
                <h1>Reporte de Préstamo</h1>
                <p><strong>ID de Préstamo:</strong> {{ $loan->id }}</p>
                <p><strong>Estudiante:</strong> {{ $loan->student->name }} {{ $loan->student->last_name }}</p>
                <p><strong>Detalles:</strong> {{ $loan->detail }}</p>
                <p><strong>Estado:</strong> {{ $loan->status }}</p>
                <p><strong>Laboratorio:</strong> {{ $authUser->department->name ?? 'No especificado' }}</p>
                <p><strong>Fecha de Creación:</strong> {{ $loan->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
        <h3>Materiales Prestados:</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loan->materials as $material)
                    <tr>
                        <td>{{ $material->name }}</td>
                        <td>{{ $material->pivot->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="info_Eabajo">
        <a class="text_infoE" href="https://inventio.rootheim.com/"><strong>Inventio</strong></a>
        <a class="text_infoE" href="https://rootheim.com/">powered by<strong> Root Heim Company </strong></a><img
            src="img/rootheim.png" width="15px" height="15px">
    </div>
</body>

</html>
