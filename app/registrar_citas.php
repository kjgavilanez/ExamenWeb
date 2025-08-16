<?php
require_once '../conexion/db.php';
//obtener pacientes
$pacientes = $pdo->query("SELECT * FROM pacientes")->fetchAll(PDO::FETCH_ASSOC);

//obtener medicos
$medicos = $pdo->query("SELECT * FROM medicos")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Cita</title>
    <link rel="stylesheet" href="../public/lib/bootstrap-5.3.5-dist/css/bootstrap.min.css">
</head>
<body style="background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%); min-height:100vh; font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-4 p-4" style="background: #fff;">
                    <div class="mb-4">
                        <h1 class="mb-0 text-center" style="font-weight:700; letter-spacing:1px; color:#2d3748;">Registrar Cita</h1>
                    </div>
                    <form action="guardarCitas.php" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="id" class="form-label">ID</label>
                                <input type="text" class="form-control" id="id" name="id" value="" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="fecha" name="fecha" required>
                            </div>
                            <div class="col-md-6">
                                <label for="paciente_id" class="form-label">Paciente</label>
                                <select name="paciente_id" id="paciente_id" class="form-select" required>
                                    <option value="">Seleccione un Paciente</option>
                                    <?php foreach ($pacientes as $paciente): ?>
                                        <option value="<?= $paciente['id'] ?>"><?= $paciente['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="medico_id" class="form-label">Médico</label>
                                <select name="medico_id" id="medico_id" class="form-select" required>
                                    <option value="">Seleccione un Médico</option>
                                    <?php foreach ($medicos as $medico): ?>
                                        <option value="<?= $medico['id'] ?>"><?= $medico['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="hora_inicio" class="form-label">Hora de Inicio</label>
                                <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
                            </div>
                            <div class="col-md-6">
                                <label for="hora_fin" class="form-label">Hora de Fin</label>
                                <input type="time" class="form-control" id="hora_fin" name="hora_fin" required>
                            </div>
                            <div class="col-md-6">
                                <label for="duracion" class="form-label">Duración (minutos)</label>
                                <input type="number" class="form-control" id="duracion" name="duracion" required readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="costo_total" class="form-label">Costo Total</label>
                                <input type="number" step="0.01" class="form-control" id="costo_total" name="costo_total" required readonly>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg" style="border-radius:8px;">Registrar Cita</button>
                            <a href="../index.html" class="btn btn-outline-secondary btn-lg" style="border-radius:8px;">Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Guardar tarifas de médicos en JS
        const tarifasMedicos = {};
        <?php
        $medicos = $pdo->query('SELECT id, tarifa_por_hora FROM medicos')->fetchAll(PDO::FETCH_ASSOC);
        foreach ($medicos as $medico) {
            echo "tarifasMedicos[{$medico['id']}] = {$medico['tarifa_por_hora']};\n";
        }
        ?>
    </script>
    <script src="../public/js/citas_utils.js"></script>
    <script>
        agregarListenersCita(tarifasMedicos);
    </script>
</body>
</html>