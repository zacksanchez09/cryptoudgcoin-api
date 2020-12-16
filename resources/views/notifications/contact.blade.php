@component('mail::message')
# ¡Hola! <br> Se ha enviado un mensaje a través del formulario de contacto.

# Datos de la persona: <br>
Nombre: {{ $name }} <br>
Correo electrónico: {{ $email }} <br>
Asunto: {{ $subject }} <br>
Mensaje: {{ $message }}

¡Saludos! <br><br>
CryptoUDGCoin
@endcomponent
