@component('mail::message')
Atención,

El Laboratorio de Vigilancia de la Calidad del Agua de la
Autoridad Autónoma de Majes – AUTODEMA, acaba de actualizar la matriz de parámetros ambientales de los embalses/cuerpos
de agua del Sistema Chili Regulado y Colca-Siguas, con fecha {{ Carbon\Carbon::parse($sampling->sampling_date)->format('d/m/Y') }}. Solicitamos
revisar la plataforma con su usuario correspondiente. Ante cualquier duda comunicarse al
correo: lvca.vigilancia@autodema.gob.pe>
<br>
@if($note)
<b>Notas del muestreo:</b><br>
{!! nl2br($note) !!}<br>
@endif
@if($sampling_point)
<b>Punto de Muestreo:</b><br>
{!! nl2br($sampling_point) !!}<br>
@endif
@if($dominant)
<b>Clase dominante:</b><br>
{!! nl2br($dominant) !!}<br>
@endif
<b>Alerta:</b><br>
@php
$size_green = 30;
$size_yellow = 30;
$size_red = 30;
if($alert == \App\Sampling::GREEN_ALERT){
    $size_green+=10;
}elseif($alert == \App\Sampling::YELLOW_ALERT){
    $size_yellow+=10;
}elseif($alert == \App\Sampling::RED_ALERT){
    $size_red+=10;
}
@endphp
<div>
<div style="width: {{ $size_green }}px;height: {{ $size_green }}px;background-color: rgb(20,200,20);border-radius: 100%;display: inline-block"></div>
<div style="width: {{ $size_yellow }}px;height: {{ $size_yellow }}px;background-color: rgb(210,161,19);border-radius: 100%;display: inline-block"></div>
<div style="width: {{ $size_red }}px;height: {{ $size_red }}px;background-color: rgb(200,20,20);border-radius: 100%;display: inline-block"></div>
</div>
<br>
<br>
<table class="table table-bordered" border="1" style="border-collapse: collapse; width: 100%">
<thead>
<tr style="background-color: #000; color: #fff">
<th scope="col">Parámetros en {{ $samplingPoint->name }}</th>
<th scope="col">Valor</th>
<th scope="col">ECA</th>
@if($showTransition == 'true')
<th scope="col">ECA de transición</th>
@endif
</tr>
</thead>
<tbody>
@foreach($parametersVerified as $index => $parameter)
<tr>
<td style="padding: 2px;">{{ $parameter->parameter_name }} (<b>{!! $parameter->parameter_symbol !!} </b>)</td>
<td style="padding: 2px;">
@if($parameter->state == \App\Sampling::NORMAL_PARAMETER)
<span style="color:#00a400;">{{ $parameter->value }}</span>
@elseif($parameter->state == \App\Sampling::NEAR_BELLOW_LIMIT || $parameter->state == \App\Sampling::NEAR_UPPER_LIMIT)
<span style="color:#d1b400;">{{ $parameter->value }}</span>
@elseif($parameter->state == \App\Sampling::BELLOW_LIMIT || $parameter->state == \App\Sampling::UPPER_LIMIT || $parameter->state == \App\Sampling::DIFFERENT_THAN_ALLOWED  )
<span style="color:#d70000;">{{ $parameter->value }}</span>
@endif
</td>
<td style="padding: 2px;">
@if($parameter->eca_type == \App\Sampling::ECA_MIN_MAX)
Min: {{ $parameter->min_value }}<br>
Max: {{ $parameter->max_value }}
@elseif($parameter->eca_type == \App\Sampling::ECA_MIN)
Min: {{ $parameter->min_value }}<br>
@elseif($parameter->eca_type == \App\Sampling::ECA_MAX)
Max: {{ $parameter->max_value }}
@elseif($parameter->eca_type == \App\Sampling::ECA_ALLOWED)
Valor permitido: {{ $parameter->allowed_value }}
@elseif($parameter->eca_type == \App\Sampling::ECA_NULL)
Sin restricción
@endif
</td>
@if($showTransition == 'true')
<td style="padding: 2px;">
@isset($parametersTransitionVerifiedToSend[$index])
@if($parametersTransitionVerifiedToSend[$index]->eca_type == \App\Sampling::ECA_MIN_MAX)
Min: {{ $parametersTransitionVerifiedToSend[$index]->min_value }}<br>
Max: {{ $parametersTransitionVerifiedToSend[$index]->max_value }}
@elseif($parametersTransitionVerifiedToSend[$index]->eca_type == \App\Sampling::ECA_MIN)
Min: {{ $parametersTransitionVerifiedToSend[$index]->min_value }}<br>
@elseif($parametersTransitionVerifiedToSend[$index]->eca_type == \App\Sampling::ECA_MAX)
Max: {{ $parametersTransitionVerifiedToSend[$index]->max_value }}
@elseif($parametersTransitionVerifiedToSend[$index]->eca_type == \App\Sampling::ECA_ALLOWED)
Valor permitido: {{ $parametersTransitionVerifiedToSend[$index]->allowed_value }}
@elseif($parametersTransitionVerifiedToSend[$index]->eca_type == \App\Sampling::ECA_NULL)
Sin restricción
@endif
@else
Sin restricción
@endisset
</td>
@endif
</tr>
@endforeach
</tbody>
</table>
@component('mail::button', ['url' => route('samplings.listPoint', $samplingPoint->id ) ])
Ir a sistema
@endcomponent

Gracias,<br>

{{ env("APP_NAME", "AUTODEMA") }}
@endcomponent
