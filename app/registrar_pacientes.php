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
                        <h1 class="mb-0 text-center" style="font-weight:700; letter-spacing:1px; color:#2d3748;">Registrar Paciente</h1>
                    </div>
                    <form action="guardarPaciente.php" method="POST">
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
                                <label for="correo" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" required>
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg" style="border-radius:8px;">Registrar Paciente</button>
                            <a href="../index.html" class="btn btn-outline-secondary btn-lg" style="border-radius:8px;">Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>