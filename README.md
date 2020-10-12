# ChatVideoCallLaravel

<br>

Chat and Video Call using Laravel 7.0, Redis y Laravel Echo Server

<br>
Demo de chat en tiempo real y video llamada

<br>
<br>

# Pasos
1. Clonar el repositorio
2. cp .env.exmaple .env
<br>
BROADCAST_DRIVER=redis<br>
CACHE_DRIVER=file<br>
QUEUE_CONNECTION=sync<br>
SESSION_DRIVER=file<br>
SESSION_LIFETIME=120<br>
3. composer install
4. npm install

# Chat and VideoCall
1. Iniciar Redis: redis-server /usr/local/etc/redis.conf
2. Iniciar Laravel Echo Server: npx laravel-echo-server start
3. Iniciar Servidor en Laravel: php artisan serve
4. Por defecto el proyecto funcionará en la siguiente ruta: http://127.0.0.1:8000

<br>
<br>

Para video llamada desde diferentes redes usar servidores TURN y STUNT

# Demo
https://chatvideocall.oneprotech.com

<br>

![Image](screenshots/chatvideocall1.png)<br>
![Image](screenshots/chatvideocall2.png)<br>
![Image](screenshots/chatvideocall3.png)<br>
![Image](screenshots/chatvideocall4.png)<br>
