-- ===========================
-- 1. INSERTAR NORMAS
-- ===========================
INSERT INTO norma (id_norma, nombre, descripcion, created_at, updated_at) VALUES
(1, 'ISO 27001', 'Gestión de Seguridad de la Información', NOW(), NOW()),
(2, 'ISO 27002', 'Controles de Seguridad de la Información', NOW(), NOW()),
(3, 'ISO 27003', 'Guía de implementación del SGSI', NOW(), NOW()),
(4, 'COBIT 4.1', 'Gobierno y gestión de TI', NOW(), NOW());

-- ===========================
-- 2. INSERTAR TAREAS POR NORMA
-- ===========================
INSERT INTO tarea (id_tarea, id_norma, nombre, descripcion, created_at, updated_at) VALUES
-- ISO 27001
(1, 1, 'Análisis de riesgos', 'Identificar riesgos de seguridad', NOW(), NOW()),
(2, 1, 'Gestión documental', 'Estructurar políticas y procedimientos', NOW(), NOW()),

-- ISO 27002
(3, 2, 'Controles de acceso', 'Definir permisos y roles', NOW(), NOW()),
(4, 2, 'Seguridad física', 'Controlar accesos al entorno físico', NOW(), NOW()),

-- ISO 27003
(5, 3, 'Implementación SGSI', 'Fases de implementación', NOW(), NOW()),
(6, 3, 'Definición de alcance', 'Objetivos y límites del SGSI', NOW(), NOW()),

-- COBIT 4.1
(7, 4, 'PO1 Definir Plan Estratégico', 'Plan de TI alineado al negocio', NOW(), NOW()),
(8, 4, 'AI2 Adquirir Aplicaciones', 'Ciclo de adquisición de software', NOW(), NOW());

-- ===========================
-- 3. INSERTAR PREGUNTAS POR TAREA
-- ===========================
INSERT INTO pregunta (id_pregunta, id_tarea, texto, tipo_cia, peso, created_at, updated_at) VALUES
-- Tarea 1 – ISO 27001
(1, 1, '¿Se identifican los riesgos de forma periódica?', 'integridad', 0.30, NOW(), NOW()),
(2, 1, '¿Existe registro formal de los riesgos?', 'confidencialidad', 0.40, NOW(), NOW()),

-- Tarea 2 – ISO 27001
(3, 2, '¿Se mantienen políticas actualizadas?', 'disponibilidad', 0.50, NOW(), NOW()),

-- Tarea 3 – ISO 27002
(4, 3, '¿Los roles tienen permisos adecuados?', 'confidencialidad', 0.40, NOW(), NOW()),
(5, 3, '¿Se revisan los accesos cada 6 meses?', 'integridad', 0.25, NOW(), NOW()),

-- Tarea 4 – ISO 27002
(6, 4, '¿Hay controles de acceso físico?', 'disponibilidad', 0.20, NOW(), NOW()),

-- Tarea 5 – ISO 27003
(7, 5, '¿La organización sigue un plan de implementación SGSI?', 'integridad', 0.30, NOW(), NOW()),

-- Tarea 6 – ISO 27003
(8, 6, '¿El alcance del SGSI está documentado?', 'confidencialidad', 0.30, NOW(), NOW()),

-- Tarea 7 – COBIT
(9, 7, '¿Existe un plan estratégico de TI?', 'disponibilidad', 0.40, NOW(), NOW()),

-- Tarea 8 – COBIT
(10, 8, '¿Se evalúan soluciones antes de adquirirlas?', 'integridad', 0.35, NOW(), NOW());