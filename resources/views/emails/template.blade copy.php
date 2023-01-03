@component('mail::message')
# Bienvenido {{$name}}

Codigo de seguridad de verificación de cambio de contraseña, utilice el siguiente codigo {{$body}}.<br>


@component('mail::button', ['url' => 'https://dev-coding.com'])
Visitar Sitio Web
@endcomponent
Gracias,<br>
//{{ config('app.name') }}
@endcomponent
