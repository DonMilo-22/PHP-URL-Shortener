# PHP URL Shortener

Acortador local de URLs, desarrollado con PHP y SQLite sin framework.

Guarda un código corto y redirige al destino cuando se abre el enlace generado.

## Funciones actuales

- URLs HTTP/HTTPS validadas y persistencia SQLite.
- Códigos aleatorios con comprobación de colisiones.
- Alias personalizados únicos de 3 a 24 caracteres: letras, números, `_` o `-`.
- Tarjeta con alias, dominio de destino y cantidad de caracteres ahorrados.
- Botón para copiar y acción para iniciar otro acortamiento.
- Conservación de datos del formulario tras errores de validación.

## Requisitos

PHP 8.1 o superior, extensión PDO SQLite y permisos de escritura en `data/`.

## Instalación y uso

```bash
git clone https://github.com/DonMilo-22/PHP-URL-Shortener.git
cd PHP-URL-Shortener
php -S localhost:8000 -t public
```

Abre [http://localhost:8000](http://localhost:8000), escribe una URL y opcionalmente un alias. El enlace tendrá la forma `http://localhost:8000/?c=ALIAS`.

## Almacenamiento y límites

La base `data/links.sqlite` se crea automáticamente, en una ruta relativa al código del proyecto. Los enlaces locales solo funcionan donde el servidor es accesible. Las redirecciones existentes usan HTTP 302; un código desconocido devuelve 404.

El servidor integrado de PHP sirve para desarrollo. Una publicación abierta requiere configurar la URL base, protección contra abuso y límites de solicitudes. No hay cuentas, caducidad ni estadísticas de clics. El botón de copiar depende de los permisos y soporte de Clipboard API del navegador.

## Comprobaciones

```bash
php -l public/index.php
php -l src/Database.php
```

Estos comandos comprueban sintaxis. Revisa manualmente crear un alias, abrirlo y rechazar un alias duplicado.

## Autor y licencia

Desarrollado por [DonMilo-22](https://github.com/DonMilo-22).

Licencia: MIT.

## Actualización 2026-10-12

- Added an `Open destination` shortcut beside each newly created short link.

## Actualización adicional 2026-10-12

- The copy-link action now shows a visible message if clipboard access fails.

## Historial

Consulta [CHANGELOG.md](CHANGELOG.md) para ver las actualizaciones.

## Actualización 2026-10-14

- If clipboard access is blocked, the app now opens a manual-copy prompt for the generated short URL.
