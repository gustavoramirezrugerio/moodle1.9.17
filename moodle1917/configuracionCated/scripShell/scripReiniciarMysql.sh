#! /bin/bash
# Las líneas que empiezan por "#" son comentarios
# La primera línea o #! /bin/bash asegura que se interpreta como
# un script de bash, aunque se ejecute desde otro shell.

echo "Reinicar Mysql en 3 segundos"
#sleep 3s
#service mysql stop
/etc/init.d/mysql start
echo "Terminamos de reinicar MySql"
