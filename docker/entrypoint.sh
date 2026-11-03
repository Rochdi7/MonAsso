#!/bin/sh
set -e

# storage/ é um volume persistente: as views Blade compiladas sobrevivem ao
# deploy e ficam com mtime mais novo que os fontes da imagem, então o Laravel
# nunca as recompila. Limpar no boot garante que o código novo apareça.
rm -f /var/www/storage/framework/views/*.php

exec "$@"
