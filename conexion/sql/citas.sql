-- 1. Crear la base de datos

-- 2. Crear tabla pacientes
CREATE TABLE pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    telefono VARCHAR(20),
    fecha_nacimiento DATE
);

-- 3. Crear tabla medicos
CREATE TABLE medicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    especialidad VARCHAR(100) NOT NULL,
    tarifa_por_hora DECIMAL(10,2) NOT NULL
);

-- 4. Crear tabla citas (con cálculos en PHP)
CREATE TABLE citas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    medico_id INT NOT NULL,
    fecha DATE NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    duracion INT NOT NULL, -- en minutos, calculado en PHP
    costo_total DECIMAL(10,2) NOT NULL, -- calculado en PHP
    estado VARCHAR(20) DEFAULT 'programada',

    FOREIGN KEY (paciente_id) REFERENCES pacientes(id) ON DELETE CASCADE,
    FOREIGN KEY (medico_id) REFERENCES medicos(id) ON DELETE CASCADE
);

-- 5. Insertar pacientes
INSERT INTO pacientes (nombre, correo, telefono, fecha_nacimiento) VALUES
('Pedro Gómez', 'pedro.gomez@email.com', '0991234567', '1990-05-15'),
('Lucía Ramos', 'lucia.ramos@email.com', '0987654321', '1985-11-30');

-- 6. Insertar médicos
INSERT INTO medicos (nombre, especialidad, tarifa_por_hora) VALUES
('Dr. Juan Pérez', 'Cardiología', 50.00),
('Dra. Ana Torres', 'Pediatría', 40.00);

-- 7. Insertar citas (duración y costo calculados en PHP)
-- Ejemplo 1: Pedro con Dr. Juan, 2025-08-15 de 09:00 a 10:00 → duración 60 min, costo 50
-- Ejemplo 2: Lucía con Dra. Ana, 2025-08-16 de 14:00 a 14:30 → duración 30 min, costo 20

INSERT INTO citas (paciente_id, medico_id, fecha, hora_inicio, hora_fin, duracion, costo_total) VALUES
(1, 1, '2025-08-15', '09:00:00', '10:00:00', 60, 50.00),
(2, 2, '2025-08-16', '14:00:00', '14:30:00', 30, 20.00);

-- 8. Consulta para ver todas las citas con nombres y cálculos
SELECT 
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
JOIN medicos ON citas.medico_id = medicos.id;