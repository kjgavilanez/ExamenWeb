<?php
require_once '../conexion/db.php';

$where = [];
$params = [];
if (!empty($_GET['busqueda'])) {
	$busqueda = trim($_GET['busqueda']);
	if (is_numeric($busqueda)) {
		$where[] = 'citas.id = :busqueda_id';
		$params[':busqueda_id'] = $busqueda;
	} else {
		$where[] = '(pacientes.nombre LIKE :busqueda_pacientes OR medicos.nombre LIKE :busqueda_medicos)';
		$params[':busqueda_pacientes'] = "%$busqueda%";
		$params[':busqueda_medicos'] = "%$busqueda%";
	}
}

$sql = "SELECT 
	citas.id,
	pacientes.nombre AS paciente,
	medicos.nombre AS medico,
	medicos.especialidad,
	citas.fecha,
	citas.hora_inicio,
	citas.hora_fin,
	citas.duracion,
	citas.costo_total,
	citas.estado
FROM citas
JOIN pacientes ON citas.paciente_id = pacientes.id
JOIN medicos ON citas.medico_id = medicos.id";
if ($where) {
	$sql .= ' WHERE ' . implode(' AND ', $where);
}
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$citas = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Si es petición AJAX, solo devuelve la tabla
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
	echo '<table class="table table-striped" id="tabla-citas">';
	echo '<thead><tr>';
	echo '<th>ID</th><th>Paciente</th><th>Médico</th><th>Especialidad</th><th>Fecha</th><th>Hora de Inicio</th><th>Hora de Fin</th><th>Duración</th><th>Costo Total</th><th>Estado</th>';
	echo '</tr></thead><tbody>';
	foreach ($citas as $cita) {
		$dataCita = htmlspecialchars(json_encode($cita, JSON_HEX_APOS | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8');
		echo '<tr class="fila-cita" data-cita="' . $dataCita . '" title="Descargar PDF de ' . htmlspecialchars($cita['paciente']) . '" style="cursor:pointer;transition:background 0.2s;">';
		echo '<td>' . $cita['id'] . '</td>';
		echo '<td>' . htmlspecialchars($cita['paciente']) . '</td>';
		echo '<td>' . htmlspecialchars($cita['medico']) . '</td>';
		echo '<td>' . htmlspecialchars($cita['especialidad']) . '</td>';
		echo '<td>' . htmlspecialchars($cita['fecha']) . '</td>';
		echo '<td>' . htmlspecialchars($cita['hora_inicio']) . '</td>';
		echo '<td>' . htmlspecialchars($cita['hora_fin']) . '</td>';
		echo '<td>' . htmlspecialchars($cita['duracion']) . '</td>';
		echo '<td>' . htmlspecialchars($cita['costo_total']) . '</td>';
		echo '<td>' . htmlspecialchars($cita['estado']) . '</td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
	exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Consultas de Citas</title>
	<link rel="stylesheet" href="../public/lib/bootstrap-5.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/consultas_citas.css">
    <script src="../public/lib/bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>

</head>
<body style="background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%); min-height:100vh; font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;">
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-lg-10">
				<div class="card shadow-lg border-0 rounded-4 p-4" style="background: #fff;">
					<div class="mb-4">
						<h1 class="mb-0 text-center" style="font-weight:700; letter-spacing:1px; color:#2d3748;">Consultas de Citas</h1>
					</div>
					<form method="get" class="row g-3 mb-4" id="form-busqueda">
						<div class="col-md-12">
							<label for="busqueda" class="form-label fw-semibold">Buscar por ID de cita, nombre de paciente o nombre de médico</label>
							<input type="text" class="form-control form-control-lg" id="busqueda" name="busqueda" value="<?= htmlspecialchars($_GET['busqueda'] ?? '') ?>" placeholder="Ejemplo: 1, Pedro Gómez, Juan Pérez" style="border-radius: 8px;">
						</div>
					</form>
					<div id="tabla-citas-container">
						<div class="table-responsive rounded-3 shadow-sm">
							<table class="table table-hover align-middle mb-0" id="tabla-citas" style="background:#f8fafc;">
								<thead class="table-light">
									<tr>
										<th>ID</th>
										<th>Paciente</th>
										<th>Médico</th>
										<th>Especialidad</th>
										<th>Fecha</th>
										<th>Hora de Inicio</th>
										<th>Hora de Fin</th>
										<th>Duración</th>
										<th>Costo Total</th>
										<th>Estado</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($citas as $cita): ?>
										<tr class="fila-cita" data-cita='<?= json_encode($cita, JSON_HEX_APOS | JSON_HEX_QUOT) ?>' title="Descargar PDF de <?= htmlspecialchars($cita['paciente']) ?>" style="cursor:pointer;transition:background 0.2s;">
											<td><?= $cita['id'] ?></td>
											<td><?= htmlspecialchars($cita['paciente']) ?></td>
											<td><?= htmlspecialchars($cita['medico']) ?></td>
											<td><?= htmlspecialchars($cita['especialidad']) ?></td>
											<td><?= htmlspecialchars($cita['fecha']) ?></td>
											<td><?= htmlspecialchars($cita['hora_inicio']) ?></td>
											<td><?= htmlspecialchars($cita['hora_fin']) ?></td>
											<td><?= htmlspecialchars($cita['duracion']) ?></td>
											<td><?= htmlspecialchars($cita['costo_total']) ?></td>
											<td><?= htmlspecialchars($cita['estado']) ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="d-flex justify-content-end mt-4 gap-2">
						<a href="listar_citas.php" class="btn btn-outline-secondary btn-lg" style="border-radius:8px;">Volver a Listar Citas</a>
						<a href="../index.html" class="btn btn-outline-secondary btn-lg" style="border-radius:8px;">Volver al Inicio</a>
					</div>
				</div>
			</div>
		</div>
	</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
	// Inicializa tooltips de Bootstrap
	const activarTooltips = () => {
		const tooltipTriggerList = [].slice.call(document.querySelectorAll('.fila-cita'));
		tooltipTriggerList.forEach(function (el) {
			new bootstrap.Tooltip(el);
		});
	};
	const form = document.getElementById('form-busqueda');
	const tablaContainer = document.getElementById('tabla-citas-container');
	// Búsqueda en tiempo real
	document.getElementById('busqueda').addEventListener('input', function() {
		const busqueda = this.value;
		fetch('consultas_citas.php?busqueda=' + encodeURIComponent(busqueda), {
			headers: { 'X-Requested-With': 'XMLHttpRequest' }
		})
		.then(res => res.text())
		.then(html => {
			tablaContainer.innerHTML = html;
			agregarEventosFilas();
			activarTooltips();
		});
	});

	function agregarEventosFilas() {
		document.querySelectorAll('.fila-cita').forEach(function(fila) {
			fila.addEventListener('click', function() {
				const datos = JSON.parse(this.getAttribute('data-cita'));
				mostrarModalCita(datos);
			});
		});
	}
	agregarEventosFilas();
	activarTooltips();

	// Modal dinámico
	function mostrarModalCita(datos) {
		let modal = document.getElementById('modal-cita');
		if (!modal) {
			modal = document.createElement('div');
			modal.id = 'modal-cita';
			modal.className = 'modal fade';
			modal.tabIndex = -1;
			modal.innerHTML = `
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Detalle de la Cita</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
					</div>
					<div class="modal-body" id="modal-cita-body"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
						<button type="button" class="btn btn-primary" id="btn-imprimir">Imprimir</button>
						<button type="button" class="btn btn-success" id="btn-pdf">Descargar PDF</button>
					</div>
				</div>
			</div>`;
			document.body.appendChild(modal);
		}
		// Rellenar datos
		const body = modal.querySelector('#modal-cita-body');
		body.innerHTML = `
			<div id="cita-detalle" style="max-width:500px;margin:auto;padding:24px;border:1px solid #ddd;border-radius:8px;background:#fff;">
				<h3 class="text-center mb-4" style="font-weight:bold;">CLINICA CENTRAL RIO</h3>
				<hr>
				<table class="table table-borderless mb-4">
					<tbody>
						<tr><th>ID:</th><td>${datos.id}</td></tr>
						<tr><th>Paciente:</th><td>${datos.paciente}</td></tr>
						<tr><th>Médico:</th><td>${datos.medico}</td></tr>
						<tr><th>Especialidad:</th><td>${datos.especialidad}</td></tr>
						<tr><th>Fecha:</th><td>${datos.fecha}</td></tr>
						<tr><th>Hora de Inicio:</th><td>${datos.hora_inicio}</td></tr>
						<tr><th>Hora de Fin:</th><td>${datos.hora_fin}</td></tr>
						<tr><th>Duración:</th><td>${datos.duracion}</td></tr>
						<tr><th>Costo Total:</th><td>${datos.costo_total}</td></tr>
						<tr><th>Estado:</th><td>${datos.estado}</td></tr>
					</tbody>
				</table>
				<div class="mt-5 d-flex flex-column align-items-end" style="min-width:240px;">
					<span style="font-weight:bold;">Firma del doctor:</span>
					<div style="height:40px;width:220px;display:flex;align-items:end;">
						<div style="flex:1;border-bottom:1px solid #333;"></div>
					</div>
					<span style="font-size:14px;">${datos.medico}</span>
				</div>
			</div>
		`;
		// Eventos imprimir/pdf
		modal.querySelector('#btn-imprimir').onclick = function() {
			const detalle = document.getElementById('cita-detalle');
			const win = window.open('', '', 'width=800,height=600');
			win.document.write('<html><head><title>Imprimir Cita</title>');
			win.document.write('<link rel="stylesheet" href="../public/lib/bootstrap-5.3.5-dist/css/bootstrap.min.css">');
			win.document.write('<style>body{background:#fff;} h3{text-align:center;} table{width:100%;} th{text-align:left;width:40%;} td{width:60%;} .firma{text-align:right;margin-top:40px;}</style>');
			win.document.write('</head><body >');
			win.document.write(detalle.outerHTML);
			win.document.write('</body></html>');
			win.document.close();
			win.print();
		};
		modal.querySelector('#btn-pdf').onclick = function() {
			html2pdf().set({ margin: 10, filename: `cita_${datos.id}.pdf`, html2canvas: { scale: 2 }, jsPDF: {orientation: 'portrait'} }).from(document.getElementById('cita-detalle')).save();
		};
		// Mostrar modal
		const bsModal = new bootstrap.Modal(modal);
		bsModal.show();
	}
});
</script>
</body>
</html>
