-- ==========================================
-- Orden de creacion de tablas para la base de datos HUELLITAS
-- 1 HUELLITAS_TABLAS.sql
-- 2 HUELLITAS_FUNCIONES.sql
-- 3 HUELLITAS_TRIGGERS.sql
-- 4 HUELLITAS_PROCEDIMIENTOS.sql
-- 5 HUELLITAS_VISTAS.sql
-- 6 HUELLITAS_PRUEBAS.sql
-- ==========================================
use HUELLITASDIGITAL;
-- ==========================================
-- NOMBRE: HUELLITAS_TARJETAS_SEGURAS_VW
-- DESCRIPCIÓN: Vista segura para mostrar información de tarjetas sin datos sensibles
-- ==========================================
DELIMITER //
CREATE VIEW HUELLITAS_TARJETAS_SEGURAS_VW AS
SELECT 
    ID_TARJETA_PK, ID_USUARIO_FK, TIPO_TARJETA, MARCA_TARJETA,
    NOMBRE_TITULAR, ULTIMOS_CUATRO_DIGITOS,
    CONCAT('**/', RIGHT(DATE_FORMAT(FECHA_VENCIMIENTO, '%m/%Y'), 2)) AS FECHA_VENCIMIENTO_ENMASCARADA,
    ES_PREDETERMINADO, FECHA_REGISTRO, ESTA_ACTIVO
FROM huellitas_tarjetas_tb
WHERE ESTA_ACTIVO = TRUE;
//
DELIMITER ;

-- ==========================================
-- NOMBRE: HUELLITAS_DESCUENTOS_VIGENTES_VW
-- DESCRIPCIÓN: Vista para mostrar descuentos vigentes con precios calculados
-- ==========================================
CREATE VIEW HUELLITAS_DESCUENTOS_VIGENTES_VW AS
SELECT 
    D.ID_DESCUENTO_PK,
    P.ID_PRODUCTO_PK,
    P.PRODUCTO_NOMBRE,
    P.PRODUCTO_PRECIO_UNITARIO AS PRECIO_ORIGINAL,
    D.PORCENTAJE_DESCUENTO,
    HUELLITAS_CALCULAR_PRECIO_CON_DESCUENTO_FN(P.ID_PRODUCTO_PK, P.PRODUCTO_PRECIO_UNITARIO) AS PRECIO_CON_DESCUENTO,
    D.FECHA_CREACION AS FECHA_INICIO,  -- FECHA CREACIÓN COMO INICIO
    D.FECHA_FIN,
    DATEDIFF(D.FECHA_FIN, CURDATE()) AS DIAS_RESTANTES,
    CASE 
        WHEN D.FECHA_FIN >= CURDATE() THEN 'ACTIVO'
        ELSE 'VENCIDO'
    END AS ESTADO
FROM huellitas_descuentos_tb D
JOIN huellitas_productos_tb P ON D.ID_PRODUCTO_FK = P.ID_PRODUCTO_PK
WHERE D.ID_ESTADO_FK = 1
AND D.FECHA_FIN >= CURDATE();

-- ==========================================
-- NOMBRE: HUELLITAS_COMENTARIOS_PRODUCTOS_VW
-- DESCRIPCIÓN: Vista para mostrar descuentos vigentes con precios calculados
-- ==========================================
CREATE VIEW HUELLITAS_COMENTARIOS_PRODUCTOS_VW AS
SELECT 
    C.ID_COMENTARIO_PK,
    P.PRODUCTO_NOMBRE,
    U.USUARIO_NOMBRE,
    U.USUARIO_IMAGEN_URL,
    C.CALIFICACION_TIPO,
    C.COMENTARIO_TEXTO,
    C.FECHA_CREACION
FROM huellitas_productos_comentarios_tb C
INNER JOIN huellitas_productos_tb P ON C.ID_PRODUCTO_FK = P.ID_PRODUCTO_PK
INNER JOIN huellitas_usuarios_tb U ON C.ID_USUARIO_FK = U.ID_USUARIO_PK
WHERE C.ID_ESTADO_FK = 1
ORDER BY C.FECHA_CREACION DESC;

-- ==========================================
-- NOMBRE: VW_PRODUCTO_RATING
-- DESCRIPCIÓN: Vista para la calificación promedio de un producto
-- ==========================================
DROP VIEW IF EXISTS HUELLITAS_PRODUCTO_RATING_VW;
CREATE VIEW HUELLITAS_PRODUCTO_RATING_VW AS
SELECT 
    ID_PRODUCTO_FK AS PRODUCTO_ID,
    COUNT(*) AS TOTAL_COMENTARIOS,
    AVG(CALIFICACION_TIPO) AS PROMEDIO_ESTRELLAS
FROM huellitas_productos_comentarios_tb
WHERE ID_ESTADO_FK = 1
GROUP BY ID_PRODUCTO_FK;
