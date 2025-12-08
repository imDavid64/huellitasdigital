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
-- NOMBRE: HUELLITAS_ANTES_INSERTAR_USUARIO_TR
-- DESCRIPCIÓN: Trigger para encriptar contraseña automáticamente al insertar usuario
-- ==========================================
DROP TRIGGER IF EXISTS HUELLITAS_ANTES_INSERTAR_USUARIO_TR;
DELIMITER //
CREATE TRIGGER HUELLITAS_ANTES_INSERTAR_USUARIO_TR
BEFORE INSERT ON huellitas_usuarios_tb
FOR EACH ROW
BEGIN
    DECLARE V_SALT VARCHAR(100);
    
    -- GENERAR SALT ÚNICO PARA CADA USUARIO
    SET V_SALT = HUELLITAS_GENERAR_SALT_FN();
    SET NEW.USUARIO_SALT = V_SALT;
    
    -- ENCRIPTAR CONTRASEÑA
    IF NEW.USUARIO_CONTRASENNA IS NOT NULL THEN
        SET NEW.USUARIO_CONTRASENNA_ENCRIPTADA = HUELLITAS_ENCRIPTAR_CONTRASENNA_FN(
            NEW.USUARIO_CONTRASENNA, 
            V_SALT
        );
        -- LIMPIAR CONTRASEÑA EN TEXTO PLANO (OPCIONAL POR SEGURIDAD)
        SET NEW.USUARIO_CONTRASENNA = NULL;
    END IF;
END//
DELIMITER ;

-- ==========================================
-- NOMBRE: HUELLITAS_ANTES_ACTUALIZAR_USUARIO_TR
-- DESCRIPCIÓN: Trigger para encriptar contraseña automáticamente al actualizar usuario
-- ==========================================
DROP TRIGGER IF EXISTS HUELLITAS_ANTES_ACTUALIZAR_USUARIO_TR;
DELIMITER //
CREATE TRIGGER HUELLITAS_ANTES_ACTUALIZAR_USUARIO_TR
BEFORE UPDATE ON huellitas_usuarios_tb
FOR EACH ROW
BEGIN
    -- SI SE ESTÁ ASIGNANDO UNA NUEVA CONTRASEÑA (NO NULA)
    IF NEW.USUARIO_CONTRASENNA IS NOT NULL THEN
        -- GENERAR NUEVO SALT
        SET NEW.USUARIO_SALT = HUELLITAS_GENERAR_SALT_FN();
        
        -- ENCRIPTAR NUEVA CONTRASEÑA
        SET NEW.USUARIO_CONTRASENNA_ENCRIPTADA = HUELLITAS_ENCRIPTAR_CONTRASENNA_FN(
            NEW.USUARIO_CONTRASENNA, 
            NEW.USUARIO_SALT
        );
        
        -- LIMPIAR CONTRASEÑA EN TEXTO PLANO
        SET NEW.USUARIO_CONTRASENNA = NULL;
    END IF;
END//
DELIMITER ;

-- ==========================================
-- NOMBRE: HUELLITAS_ANTES_INSERTAR_TARJETA_TR
-- DESCRIPCIÓN: Trigger para encriptar automáticamente datos de tarjeta al insertar
-- ==========================================
DROP TRIGGER IF EXISTS HUELLITAS_ANTES_INSERTAR_TARJETA_TR;
DELIMITER //
CREATE TRIGGER HUELLITAS_ANTES_INSERTAR_TARJETA_TR
BEFORE INSERT ON huellitas_tarjetas_tb
FOR EACH ROW
BEGIN
    -- SOLO ENCRIPTACIÓN, SIN VALIDACIONES DE FECHA
    IF NEW.NUMERO_TARJETA_ENCRIPTADO IS NOT NULL THEN
        SET NEW.NUMERO_TARJETA_ENCRIPTADO = HUELLITAS_ENCRIPTAR_DATO_FN(
            NEW.NUMERO_TARJETA_ENCRIPTADO, 'CLAVE_NUMERO_TARJETA'
        );
    END IF;
    
    IF NEW.CVV_ENCRIPTADO IS NOT NULL THEN
        SET NEW.CVV_ENCRIPTADO = HUELLITAS_ENCRIPTAR_DATO_FN(
            NEW.CVV_ENCRIPTADO, 'CLAVE_CVV'
        );
    END IF;
    
    IF NEW.ULTIMOS_CUATRO_DIGITOS IS NULL AND NEW.NUMERO_TARJETA_ENCRIPTADO IS NOT NULL THEN
        SET NEW.ULTIMOS_CUATRO_DIGITOS = RIGHT(NEW.NUMERO_TARJETA_ENCRIPTADO, 4);
    END IF;
END//
DELIMITER ;

-- ==========================================
-- NOMBRE: HUELLITAS_ANTES_ACTUALIZAR_TARJETA_TR
-- DESCRIPCIÓN: Trigger para encriptar automáticamente datos de tarjeta al actualizar
-- ==========================================
DROP TRIGGER IF EXISTS HUELLITAS_ANTES_ACTUALIZAR_TARJETA_TR;
DELIMITER //
CREATE TRIGGER HUELLITAS_ANTES_ACTUALIZAR_TARJETA_TR
BEFORE UPDATE ON huellitas_tarjetas_tb
FOR EACH ROW
BEGIN
    -- SOLO ENCRIPTACIÓN, SIN VALIDACIONES DE FECHA
    IF NEW.NUMERO_TARJETA_ENCRIPTADO != OLD.NUMERO_TARJETA_ENCRIPTADO THEN
        SET NEW.NUMERO_TARJETA_ENCRIPTADO = HUELLITAS_ENCRIPTAR_DATO_FN(
            NEW.NUMERO_TARJETA_ENCRIPTADO, 'CLAVE_NUMERO_TARJETA'
        );
        SET NEW.ULTIMOS_CUATRO_DIGITOS = RIGHT(NEW.NUMERO_TARJETA_ENCRIPTADO, 4);
    END IF;
    
    IF NEW.CVV_ENCRIPTADO != OLD.CVV_ENCRIPTADO THEN
        SET NEW.CVV_ENCRIPTADO = HUELLITAS_ENCRIPTAR_DATO_FN(
            NEW.CVV_ENCRIPTADO, 'CLAVE_CVV'
        );
    END IF;
END//
DELIMITER ;

-- ==========================================
-- NOMBRE: HUELLITAS_VALIDAR_TARJETA_TR
-- DESCRIPCIÓN: Trigger para Validar Fechas de Tarjetas (integridad lógica)
-- ==========================================
DROP TRIGGER IF EXISTS HUELLITAS_VALIDAR_TARJETA_TR;
DELIMITER //
CREATE TRIGGER HUELLITAS_VALIDAR_TARJETA_TR
BEFORE INSERT ON huellitas_tarjetas_tb
FOR EACH ROW
BEGIN
    -- VALIDAR QUE LA TARJETA NO ESTÉ VENCIDA ANTES DE INSERTAR
    IF NEW.FECHA_VENCIMIENTO < CURDATE() THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = '❌ NO SE PUEDE REGISTRAR UNA TARJETA VENCIDA.';
    END IF;
END//
DELIMITER ;


-- ==========================================
-- NOMBRE: HUELLITAS_DISMINUIR_STOCK_TR
-- DESCRIPCIÓN: Trigger para Control de Stock Automático
-- ==========================================
DROP TRIGGER IF EXISTS HUELLITAS_DISMINUIR_STOCK_TR;
DELIMITER //
CREATE TRIGGER HUELLITAS_DISMINUIR_STOCK_TR
AFTER INSERT ON huellitas_detalle_factura_tb
FOR EACH ROW
BEGIN
    -- DISMINUIR EL STOCK DEL PRODUCTO DESPUÉS DE REGISTRAR UN DETALLE DE FACTURA
    UPDATE huellitas_productos_tb
    SET PRODUCTO_STOCK = PRODUCTO_STOCK - NEW.CANTIDAD
    WHERE ID_PRODUCTO_PK = NEW.ID_PRODUCTO_FK;

    -- VALIDAR QUE EL STOCK NO SEA NEGATIVO
    IF (SELECT PRODUCTO_STOCK FROM huellitas_productos_tb WHERE ID_PRODUCTO_PK = NEW.ID_PRODUCTO_FK) < 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = '⚠️ EL STOCK DEL PRODUCTO NO PUEDE SER NEGATIVO.';
    END IF;
END//
DELIMITER ;

-- ==========================================
-- NOMBRE: HUELLITAS_ALERTA_BAJO_STOCK_TR
-- DESCRIPCIÓN: Envía notificaciones a todos los administradores cuando un producto tiene bajo stock.
-- ==========================================
DROP TRIGGER IF EXISTS HUELLITAS_ALERTA_BAJO_STOCK_TR;
DELIMITER //
CREATE TRIGGER HUELLITAS_ALERTA_BAJO_STOCK_TR
AFTER UPDATE ON huellitas_productos_tb
FOR EACH ROW
BEGIN
    -- NOTIFICAR SOLO CUANDO EL STOCK CAE POR DEBAJO O IGUAL A 5
    -- Y ANTES ESTABA POR ENCIMA (EVITA NOTIFICACIONES REPETIDAS)
    IF NEW.PRODUCTO_STOCK <= 5
       AND (OLD.PRODUCTO_STOCK IS NULL OR OLD.PRODUCTO_STOCK > 5) THEN

        INSERT INTO huellitas_notificaciones_tb
        (
            ID_USUARIO_FK,
            ID_ESTADO_FK,
            TITULO_NOTIFICACION,
            MENSAJE_NOTIFICACION,
            TIPO_NOTIFICACION,
            PRIORIDAD,
            URL_REDIRECCION
        )
        SELECT
            U.ID_USUARIO_PK,
            1, -- ACTIVA
            CONCAT('STOCK BAJO: ', NEW.PRODUCTO_NOMBRE),
            CONCAT('EL PRODUCTO "', NEW.PRODUCTO_NOMBRE, '" TIENE SOLO ',
                   NEW.PRODUCTO_STOCK, ' UNIDADES EN INVENTARIO.'),
            'SISTEMA',
            'ALTA',
            CONCAT('/index.php?controller=adminProduct&action=edit&id=', NEW.ID_PRODUCTO_PK)
        FROM huellitas_usuarios_tb U
        JOIN huellitas_rol_usuario_tb R
              ON R.ID_ROL_USUARIO_PK = U.ID_ROL_USUARIO_FK
        WHERE R.DESCRIPCION_ROL_USUARIO = 'Administrador';
    END IF;
END//
DELIMITER ;

-- ==========================================
-- NOMBRE: HUELLITAS_ALERTA_BAJO_STOCK_INS_TR
-- DESCRIPCIÓN: Envía notificaciones a todos los administradores cuando se agregar un producto con bajo stock.
-- ==========================================
DROP TRIGGER IF EXISTS HUELLITAS_ALERTA_BAJO_STOCK_INS_TR;
DELIMITER //
CREATE TRIGGER HUELLITAS_ALERTA_BAJO_STOCK_INS_TR
AFTER INSERT ON huellitas_productos_tb
FOR EACH ROW
BEGIN
    -- NOTIFICAR CUANDO UN NUEVO PRODUCTO SE INSERTA CON STOCK BAJO (≤ 5)
    IF NEW.PRODUCTO_STOCK <= 5 THEN
        INSERT INTO huellitas_notificaciones_tb
        (
            ID_USUARIO_FK,
            ID_ESTADO_FK,
            TITULO_NOTIFICACION,
            MENSAJE_NOTIFICACION,
            TIPO_NOTIFICACION,
            PRIORIDAD,
            URL_REDIRECCION
        )
        SELECT
            U.ID_USUARIO_PK,
            1, -- ACTIVA
            CONCAT('STOCK BAJO: ', NEW.PRODUCTO_NOMBRE),
            CONCAT('EL PRODUCTO "', NEW.PRODUCTO_NOMBRE, '" TIENE SOLO ',
                   NEW.PRODUCTO_STOCK, ' UNIDADES EN INVENTARIO.'),
            'SISTEMA',
            'ALTA',
            CONCAT('/index.php?controller=adminProduct&action=edit&id=', NEW.ID_PRODUCTO_PK)
        FROM huellitas_usuarios_tb U
        JOIN huellitas_rol_usuario_tb R
              ON R.ID_ROL_USUARIO_PK = U.ID_ROL_USUARIO_FK
        WHERE R.DESCRIPCION_ROL_USUARIO = 'Administrador';
    END IF;
END//
DELIMITER ;



/*----------------- DESCOMENTAR Y EJECUTAR CUANDO YA SE PUEDAN REGISTRAR ORDENES DE COMPRA -----------------*/
/*
-- ==========================================
-- NOMBRE: HUELLITAS_VALIDAR_COMENTARIO_TR
-- DESCRIPCIÓN: Trigger para Validar Comentarios de Productos
-- ==========================================
DROP TRIGGER IF EXISTS HUELLITAS_VALIDAR_COMENTARIO_TR;
DELIMITER //
CREATE TRIGGER HUELLITAS_VALIDAR_COMENTARIO_TR
BEFORE INSERT ON huellitas_productos_comentarios_tb
FOR EACH ROW
BEGIN
    DECLARE V_EXISTE_COMPRA INT;

    -- VERIFICAR QUE EL USUARIO HAYA COMPRADO EL PRODUCTO ANTES DE COMENTAR
    SELECT COUNT(*) INTO V_EXISTE_COMPRA
    FROM huellitas_detalle_factura_tb DF
    INNER JOIN huellitas_facturaciones_tb F ON DF.ID_FACTURA_FK = F.ID_FACTURA_PK
    WHERE DF.ID_PRODUCTO_FK = NEW.ID_PRODUCTO_FK
      AND F.ID_USUARIO_FK = NEW.ID_USUARIO_FK;

    -- BLOQUEAR COMENTARIOS DE USUARIOS SIN COMPRA PREVIA
    IF V_EXISTE_COMPRA = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = '❌ SOLO LOS CLIENTES QUE HAYAN COMPRADO EL PRODUCTO PUEDEN COMENTAR.';
    END IF;
END//
DELIMITER ;

*/

-- ==========================================
-- NOMBRE: HUELLITAS_PEDIDOS_CANCELACION_TRG
-- DESCRIPCIÓN: Trigger para cancelar el estado del pedido a cancelado
-- ==========================================
DROP TRIGGER IF EXISTS HUELLITAS_PEDIDOS_CANCELACION_TRG;
DELIMITER $$
CREATE TRIGGER HUELLITAS_PEDIDOS_CANCELACION_TRG
AFTER UPDATE ON HUELLITAS_PEDIDOS_TB
FOR EACH ROW
BEGIN
    DECLARE v_estado_cancelado INT;
    DECLARE v_cliente_id INT;

    -- Buscar ID del estado CANCELADO
    SELECT ID_ESTADO_PK INTO v_estado_cancelado
    FROM HUELLITAS_ESTADO_TB
    WHERE ESTADO_DESCRIPCION = 'CANCELADO'
    LIMIT 1;

    -- Solo ejecutar si el cambio es hacia CANCELADO y no viene del SP
    IF NEW.ID_ESTADO_FK = v_estado_cancelado
       AND OLD.ID_ESTADO_FK <> v_estado_cancelado
       AND (@TRIGGER_ORIGIN IS NULL OR @TRIGGER_ORIGIN != 'CANCEL_SP') THEN

        SET @TRIGGER_ORIGIN = 'TRIGGER';

        -- Llamar al SP pasando el usuario real del pedido
        CALL HUELLITAS_CANCELAR_PEDIDO_SP(NEW.ID_PEDIDO_PK, NEW.ID_USUARIO_FK);

        SET @TRIGGER_ORIGIN = NULL;
    END IF;
END$$
DELIMITER ;

-- ==========================================
-- NOMBRE: HUELLITAS_CLIENTE_GENERAR_CODIGO_GLOBAL_TRG
-- DESCRIPCIÓN: Trigger para asignar automáticamente un código global único al registrar un cliente
-- ==========================================
DROP TRIGGER IF EXISTS HUELLITAS_CLIENTE_GENERAR_CODIGO_GLOBAL_TRG;
DELIMITER //
CREATE TRIGGER HUELLITAS_CLIENTE_GENERAR_CODIGO_GLOBAL_TRG
BEFORE INSERT ON HUELLITAS_CLIENTES_TB
FOR EACH ROW
BEGIN
    IF NEW.CODIGO_CLIENTE IS NULL OR NEW.CODIGO_CLIENTE = '' THEN
        SET NEW.CODIGO_CLIENTE = GENERAR_CODIGO_GLOBAL_HUELLITAS_FN();
    END IF;
END //
DELIMITER ;

-- ==========================================
-- NOMBRE: HUELLITAS_USUARIO_GENERAR_CODIGO_GLOBAL_TRG
-- DESCRIPCIÓN: Trigger para asignar automáticamente un código global único al registrar un usuario
-- ==========================================
DROP TRIGGER IF EXISTS HUELLITAS_USUARIO_GENERAR_CODIGO_GLOBAL_TRG;
DELIMITER //
CREATE TRIGGER HUELLITAS_USUARIO_GENERAR_CODIGO_GLOBAL_TRG
BEFORE INSERT ON HUELLITAS_USUARIOS_TB
FOR EACH ROW
BEGIN
    IF NEW.CODIGO_USUARIO IS NULL OR NEW.CODIGO_USUARIO = '' THEN
        SET NEW.CODIGO_USUARIO = GENERAR_CODIGO_GLOBAL_HUELLITAS_FN();
    END IF;
END //
DELIMITER ;

-- ==========================================
-- NOMBRE: HUELLITAS_MASCOTA_GENERAR_CODIGO_GLOBAL_TRG
-- DESCRIPCIÓN: Trigger para asignar automáticamente un código global único al registrar un mascota
-- ==========================================
DROP TRIGGER IF EXISTS HUELLITAS_MASCOTA_GENERAR_CODIGO_TRG;
DELIMITER //
CREATE TRIGGER HUELLITAS_MASCOTA_GENERAR_CODIGO_TRG
BEFORE INSERT ON HUELLITAS_MASCOTA_TB
FOR EACH ROW
BEGIN
    IF NEW.CODIGO_MASCOTA IS NULL OR NEW.CODIGO_MASCOTA = '' THEN
        SET NEW.CODIGO_MASCOTA = GENERAR_CODIGO_MASCOTA_FN();
    END IF;
END //
DELIMITER ;

-- ==========================================
-- NOMBRE: HUELLITAS_HISTORIAL_GENERAR_CODIGO_TRG
-- DESCRIPCIÓN: Trigger para asignar automáticamente un código al registrar historial medico
-- ==========================================
DROP TRIGGER IF EXISTS HUELLITAS_HISTORIAL_GENERAR_CODIGO_TRG;
DELIMITER //
CREATE TRIGGER HUELLITAS_HISTORIAL_GENERAR_CODIGO_TRG
BEFORE INSERT ON HUELLITAS_HISTORIALES_MEDICOS_TB
FOR EACH ROW
BEGIN
    IF NEW.CODIGO_HISTORIAL IS NULL OR NEW.CODIGO_HISTORIAL = '' THEN
        SET NEW.CODIGO_HISTORIAL = GENERAR_CODIGO_HISTORIAL_FN();
    END IF;
END //
DELIMITER ;


-- ==========================================
-- NOMBRE: HUELLITAS_MASCOTA_VALIDATE_OWNER_INSERT_TRG
-- DESCRIPCIÓN: Trigger validar el propietario de la mascota antes de un insert
-- ==========================================
DROP TRIGGER IF EXISTS HUELLITAS_MASCOTA_VALIDATE_OWNER_INSERT_TRG;
DELIMITER //
CREATE TRIGGER HUELLITAS_MASCOTA_VALIDATE_OWNER_INSERT_TRG
BEFORE INSERT ON HUELLITAS_MASCOTA_TB
FOR EACH ROW
BEGIN
    IF (NEW.ID_USUARIO_FK IS NULL AND NEW.ID_CLIENTE_FK IS NULL) OR
       (NEW.ID_USUARIO_FK IS NOT NULL AND NEW.ID_CLIENTE_FK IS NOT NULL) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Debe especificar SOLO cliente o SOLO usuario como dueño de la mascota.';
    END IF;
END //
DELIMITER ;

-- ==========================================
-- NOMBRE: HUELLITAS_MASCOTA_VALIDATE_OWNER_UPDATE_TRG
-- DESCRIPCIÓN: Trigger validar el propietario de la mascota antes de un update
-- ==========================================
DROP TRIGGER IF EXISTS HUELLITAS_MASCOTA_VALIDATE_OWNER_UPDATE_TRG;
DELIMITER //
CREATE TRIGGER HUELLITAS_MASCOTA_VALIDATE_OWNER_UPDATE_TRG
BEFORE UPDATE ON HUELLITAS_MASCOTA_TB
FOR EACH ROW
BEGIN
    IF (NEW.ID_USUARIO_FK IS NULL AND NEW.ID_CLIENTE_FK IS NULL) OR
       (NEW.ID_USUARIO_FK IS NOT NULL AND NEW.ID_CLIENTE_FK IS NOT NULL) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Debe especificar SOLO cliente o SOLO usuario como dueño de la mascota.';
    END IF;
END //
DELIMITER ;


-- ==========================================
-- NOMBRE: HUELLITAS_COMPROBANTE_RECHAZADO_MAX_INTENTOS_TRG
-- DESCRIPCIÓN: Trigger validar el propietario de la mascota antes de un update
-- ==========================================
DROP TRIGGER IF EXISTS HUELLITAS_COMPROBANTE_RECHAZADO_MAX_INTENTOS_TRG;
DELIMITER $$
CREATE TRIGGER HUELLITAS_COMPROBANTE_RECHAZADO_MAX_INTENTOS_TRG
AFTER UPDATE ON HUELLITAS_COMPROBANTES_PAGO_TB
FOR EACH ROW
BEGIN
    DECLARE v_intentos INT DEFAULT 0;
    
    -- Solo actuar si el comprobante fue RECHAZADO en esta actualización
    IF NEW.ESTADO_VERIFICACION = 'RECHAZADO' THEN
    
        -- Obtener intentos actuales de ese comprobante
        SET v_intentos = NEW.INTENTOS;

        -- Si alcanzó el límite (3 intentos)
        IF v_intentos >= 3 THEN
        
            -- Cambiar estado del pedido a CANCELADO
            UPDATE HUELLITAS_PEDIDOS_TB
            SET ID_ESTADO_FK = 6 
            WHERE ID_PEDIDO_PK = NEW.ID_PEDIDO_FK;

        END IF;
    END IF;

END$$
DELIMITER ;

-- ==========================================
-- NOMBRE: HUELLITAS_CITA_AGENDADA_TRG
-- DESCRIPCIÓN: Genera notificación al agendar una cita
-- ==========================================
DROP TRIGGER IF EXISTS HUELLITAS_CITA_AGENDADA_TRG;
DELIMITER $$
CREATE TRIGGER HUELLITAS_CITA_AGENDADA_TRG
AFTER INSERT ON HUELLITAS_CITAS_TB
FOR EACH ROW
BEGIN
    DECLARE v_usuario_id INT;

    -- Si la cita se agendó para un usuario registrado
    IF NEW.CODIGO_USUARIO IS NOT NULL AND NEW.CODIGO_USUARIO <> '' THEN

        -- Obtener el ID del usuario según su código
        SELECT ID_USUARIO_PK INTO v_usuario_id
        FROM HUELLITAS_USUARIOS_TB
        WHERE CODIGO_USUARIO = NEW.CODIGO_USUARIO
        LIMIT 1;

        -- Crear la notificación solo si existe el usuario
        IF v_usuario_id IS NOT NULL THEN

            INSERT INTO HUELLITAS_NOTIFICACIONES_TB (
                ID_USUARIO_FK,
                ID_ESTADO_FK,
                TITULO_NOTIFICACION,
                MENSAJE_NOTIFICACION,
                TIPO_NOTIFICACION,
                PRIORIDAD,
                URL_REDIRECCION
            )
            VALUES (
                v_usuario_id,
                1, -- ACTIVA
                'Nueva Cita Agendada',
                CONCAT(
                    'Su cita ha sido agendada para el día ',
                    DATE_FORMAT(NEW.FECHA_INICIO, '%d/%m/%Y'),
                    ' a las ',
                    DATE_FORMAT(NEW.FECHA_INICIO, '%H:%i'),
                    '.'
                ),
                'CITA',
                'MEDIA',
                '/index.php?controller=appointment&action=misCitas'
            );

        END IF;

    END IF;

END$$
DELIMITER ;

-- ==========================================
-- NOMBRE: HUELLITAS_CITA_CANCELADA_TRG
-- DESCRIPCIÓN: Trigger para generar notificación al cancelar cita
-- ==========================================
DROP TRIGGER IF EXISTS HUELLITAS_CITA_CANCELADA_TRG;
DELIMITER $$
CREATE TRIGGER HUELLITAS_CITA_CANCELADA_TRG
AFTER UPDATE ON HUELLITAS_CITAS_TB
FOR EACH ROW
BEGIN
    DECLARE v_estado_cancelado INT;
    DECLARE v_usuario_id INT;

    -- Obtener ID del estado CANCELADO
    SELECT ID_ESTADO_PK INTO v_estado_cancelado
    FROM HUELLITAS_ESTADO_TB
    WHERE ESTADO_DESCRIPCION = 'CANCELADO'
    LIMIT 1;

    -- Ejecutar solo si la cita cambia a estado CANCELADO
    IF NEW.ID_ESTADO_FK = v_estado_cancelado AND OLD.ID_ESTADO_FK <> v_estado_cancelado THEN

        -- Buscar el usuario dueño de la cita usando CODIGO_USUARIO
        SELECT ID_USUARIO_PK INTO v_usuario_id
        FROM HUELLITAS_USUARIOS_TB
        WHERE CODIGO_USUARIO = NEW.CODIGO_USUARIO
        LIMIT 1;

        -- Si se encontró el usuario, generar notificación
        IF v_usuario_id IS NOT NULL THEN

            INSERT INTO HUELLITAS_NOTIFICACIONES_TB (
                ID_USUARIO_FK,
                ID_ESTADO_FK,
                TITULO_NOTIFICACION,
                MENSAJE_NOTIFICACION,
                TIPO_NOTIFICACION,
                PRIORIDAD,
                URL_REDIRECCION
            )
            VALUES (
                v_usuario_id,
                1, -- ACTIVA
                'Cita Cancelada',
                CONCAT(
                    'Su cita programada para el día ',
                    DATE_FORMAT(NEW.FECHA_INICIO, '%d/%m/%Y a las %H:%i'),
                    ' ha sido cancelada.'
                ),
                'CITA',
                'MEDIA',
                '/index.php?controller=appointment&action=misCitas'
            );

        END IF;
    END IF;

END$$
DELIMITER ;





