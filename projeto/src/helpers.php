<?php
function formatDateTimeBR($value, $format = 'd/m/Y H:i')
{
    if (!$value) {
        return '';
    }
    try {
        $dt = new DateTime($value);
    } catch (Exception $e) {
        // Se já for timestamp inteiro
        if (is_numeric($value)) {
            $dt = (new DateTime())->setTimestamp((int)$value);
        } else {
            return $value;
        }
    }
    try {
        $tz = new DateTimeZone('America/Sao_Paulo');
        $dt->setTimezone($tz);
    } catch (Exception $e) {
        // fallback: não alterar timezone
    }
    return $dt->format($format);
}
