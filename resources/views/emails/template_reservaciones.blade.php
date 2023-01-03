@component('mail::message')
# Estimado Usuario  {{$name}}

{{$body}}.<br>


@component('mail::button', ['url' => 'https://futplaycompany.com'])
Visitar Sitio Web
@endcomponent
{{$footer}},<br>
Futplay Company
@endcomponent
