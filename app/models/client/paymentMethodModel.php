<?php
class PaymentMethodModel {
    private $conn;
    public function __construct($db) { $this->conn = $db; }

    /**
     * Inserta método de pago. Devuelve el ID de la tarjeta insertada o false.
     */
    public function addPaymentMethod(
        int $idUsuario,
        string $tipo,
        string $marca,
        string $titular,
        string $numeroPlano,   // 13-19 dígitos
        string $yyyy_mm,       // 'YYYY-MM'
        string $cvvPlano,      // 3-4 dígitos
        int $esPredeterminado, // 0/1
        ?string $ip
    ) {
        // Usamos SP con OUT param
        $call = $this->conn->prepare("CALL HUELLITAS_AGREGAR_TARJETA_SP(?,?,?,?,?,?,?,?,?,@P_ID_TARJETA)");
        if ($call === false) { throw new Exception("Prepare failed: ".$this->conn->error); }

        $call->bind_param(
            "isssssssi",
            $idUsuario,     // i
            $tipo,          // s
            $marca,         // s
            $titular,       // s
            $numeroPlano,   // s (trigger cifra)
            $yyyy_mm,       // s
            $cvvPlano,      // s (trigger cifra)
            $esPredeterminado, // s -> realmente int; pero bind types no soporta bool; usamos i arriba
            $ip             // i? no, string; pero nuestra firma es "isssssssi"... corrijamos:
        );
        // CORRECCIÓN de bind: tipos reales -> "issssssis" (8 params) + ip (s) = "issssssis"
        // Para evitar confusiones, cerramos y re-preparamos correctamente:
        $call->close();

        $call = $this->conn->prepare("CALL HUELLITAS_AGREGAR_TARJETA_SP(?,?,?,?,?,?,?,?,?,@P_ID_TARJETA)");
        $types = "issssssis"; // i (idUsuario), s,s,s (tipo,marca,titular), s (num), s (yyyy-mm), s (cvv), i (predet), s (ip)
        $call->bind_param($types, $idUsuario, $tipo, $marca, $titular, $numeroPlano, $yyyy_mm, $cvvPlano, $esPredeterminado, $ip);

        if (!$call->execute()) { return false; }
        $call->close();

        // Recuperar OUT param
        $res = $this->conn->query("SELECT @P_ID_TARJETA AS ID_TARJETA");
        if ($res && ($row = $res->fetch_assoc())) {
            return intval($row['ID_TARJETA']);
        }
        return false;
    }
}
