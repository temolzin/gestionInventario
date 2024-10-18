<!DOCTYPE html>  
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Inventario</title>
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
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="d-flex justify-content-between align-items-center py-2 px-3">
            <div class="logo ms-3">
                @if ($authUser->department->hasMedia('departmentGallery'))
                    <img src="{{ $authUser->department->getFirstMediaUrl('departmentGallery') }}" alt="Photo of {{ $authUser->department->name }}" class="img-fluid" style="max-width: 150px;">
                @else
                    <img src='img/logo.png' alt="Default Photo" class="img-fluid" style="max-width: 150px;">
                @endif
            </div>
            <div class="header-info">
                <h1>Inventory Report</h1>
                <p><strong>Start Date:</strong> {{ $startDate ?? 'No especificada' }}</p>
                <p><strong>End Date:</strong> {{ $endDate ?? 'No especificada' }}</p>
                <p><strong>Area:</strong> {{ $authUser->department->name ?? 'No especificado' }}</p>
            </div>
        </div>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>PRODUCT</th>
                        <th>QTY.</th>
                        <th>DATE</th>
                        <th>STATE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inventories as $inventory)
                        @foreach($inventory->materials as $material)
                            <tr>
                                <td>{{ $inventory->id }}</td>
                                <td>{{ $material->name }}</td>
                                <td>x{{ $material->pivot->quantity }}</td>
                                <td>{{ $inventory->created_at->format('d/m/Y') }}</td>
                                <td>{{ $inventory->status }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
