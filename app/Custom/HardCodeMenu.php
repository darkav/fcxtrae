<?php
namespace App\Custom;
class HardCodeMenu
{
    public static function get_menu()
    {
        return [
                    ["modulo" => "Dashboard", "programas" => [
                        ["programa" => "Dashboard", "icono" => "mif-dashboard","link" => "/dashboard"],
                        ["programa" => "Documentos", "icono" => "mif-file-empty","link" => "/migrado"]
                    ]],

                    ["modulo" => "Parametros", "programas" => [
                        ["programa" => "Compañias", "icono" => "mif-home","link" => "/compania"],
                        ["programa" => "Extracción", "icono" => "mif-filter","link" => "/extraccion"],
                    ]],
                    ["modulo" => "Procesos", "programas" => [
                        ["programa" => "Subir Fichero SRI", "icono" => "mif-upload", "link" => "/upload-manual"],
                        ["programa" => "Servicios", "icono" => "mif-install", "link" => "/upload-service"],
                    ]],
                    ["modulo" => "Integraciones", "programas" => [
                        ["programa" => "SYSPRO", "icono" => "mif-shareable", "link" => "/link-syspro"],
                        ["programa" => "Fichero", "icono" => "mif-drive", "link" => "/link-fichero"],
                    ]]
                ];
    }
}
?>