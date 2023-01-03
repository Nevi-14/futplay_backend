@component('mail::message')
# Bienvenido {{$name}}

Codigo de seguridad de verificación de cambio de contraseña, utilice el siguiente codigo {{$body}}.<br>


@component('mail::button', ['url' => 'https://futplaycompany.com'])
Visitar Sitio Web
@endcomponent
Gracias,<br>
Futplay Company
@endcomponent
