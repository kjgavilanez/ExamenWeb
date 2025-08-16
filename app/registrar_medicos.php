<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Paciente</title>
    <link rel="stylesheet" href="../public/lib/bootstrap-5.3.5-dist/css/bootstrap.min.css">
</head>
<body style="background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%); min-height:100vh; font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-4 p-4" style="background: #fff;">
                    <div class="mb-4">
                        <h1 class="mb-0 text-center" style="font-weight:700; letter-spacing:1px; color:#2d3748;">Registrar Médico</h1>
                    </div>
                    <form action="guardarMedico.php" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="id" class="form-label">ID</label>
                                <input type="text" class="form-control" id="id" name="id" value="" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label for="especialidad" class="form-label">Especialidad</label>
                                <input type="text" class="form-control" id="especialidad" name="especialidad" required>
                            </div>
                            <div class="col-md-6">
                                <label for="tarifa_por_hora" class="form-label">Tarifa por Hora</label>
                                <input type="number" step="0.01" class="form-control" id="tarifa_por_hora" name="tarifa_por_hora" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg" style="border-radius:8px;">Registrar Médico</button>
                            <a href="../index.html" class="btn btn-outline-secondary btn-lg" style="border-radius:8px;">Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>