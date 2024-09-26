<?php

namespace App;

use App\Traits\GoogleApi;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use GoogleApi;

    const QUOTATION = 1;
    const CONTRACT = 2;
    const WORK_ORDER = 3;

    const QUOTATION_TEMPLATE = "115_IX481_O34tGUjW6CWqkBrxYvZW7WmtJ3QstMENKE";
    const CONTRACT_TEMPLATE = "1-_OtmmLzNXVt6yPow861BEoHrjYSDNFCP1LeYNFj820";
    const WORK_ORDER_TEMPLATE = "1-_R_tO3u-QTbPlTdJIJigExSVdEMEcd1lqyZRuIAlDA";

    const DOCS = 1;
    const SHEETS = 2;
    const SLIDES = 3;

    const DOCS_GOOGLE_URL = "document";
    const SHEETS_GOOGLE_URL = "spreadsheets";
    const SLIDES_GOOGLE_URL = "slides";

    const FOR_REVISION = 1;
    const REVISED = 2;
    const APPROVED = 3;
    const PRINTED = 4;
    const FOR_DELETION = 5;

    const RETRYS = 10;

    //TEXTS
    const EMPRESA = "##EMPRESA##";
    const RUC = "##RUC##";
    const DIRECCION = "##DIRECCION##";
    const NOMBRES_CONTACTO = "##NOMBRES##";
    const APELLIDOS_CONTACTO = "##APELLIDOS##";
    const NOMBRE_COMPLETO_CONTACTO = "##CONTACTO##";
    const CORREO_CONTACTO = "##CORREO_CONTACTO##";
    const SERVICIO = "##SERVICIO##";
    const SERVICIO_TOTAL = "##SERVICIO_TOTAL##";
    const DESCRIPCION = "##DESCRIPCION##";
    const OPORTUNIDAD = "##NOMBRE_OPORTUNIDAD##";
    const GERENTE = "##GERENTE##";
    const DNI_GERENTE = "##DNI_GERENTE##";
    const USUARIO_PROPIETARIO = "##USUARIO_PROPIETARIO##";
    const ID_OPORTUNIDAD = "##ID_OPORTUNIDAD##";
    const CODIGO_COTIZACION = "##REF_COTIZACION##";
    const PRIMERA_LETRA_EMPRESA = "##PRIMERA_LETRA_EMPRESA##";
    const INICIAL_USUARIO = "##INICIAL_USUARIO##";
    const PRECIO = "##PRECIO##";
    const IGV = "##IGV##";
    const PRECIO_IGV = "##PRECIO_IGV##";
    const CODIGO_ORDEN_TRABAJO = "##CODIGO_ORDEN_TRABAJO##";

    const FECHA = "##FECHA##";
    const FECHA_FORMATO = "##FECHA_FORMATO##";
}
