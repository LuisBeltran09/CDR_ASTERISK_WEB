# CDR_ASTERISK_WEB

## *Visor de regsitro de llamadas para asterisk*

Basado en un consulta a una base de datos ya sea interna o externa donde se guardan las llamadas de asterisk.

La consulta se hace a traves de un **[PDO](https://www.php.net/manual/es/pdo.connections.php)**, aplicando también algunos filtros a la consulta en función del calldate o la fecha y hora de la llamada, ya sea por las llamadas realizadas la semana actual, por meses o llamadas en el año actual. 

Además tiene algunos estilos y funciones con BOOTSTRAP(css y js).

***

### Requisitos previos

-Asterisk configurado para guardar el registro de llamadas en una base de datos

***

### Instalación

-Clonas el repo a tu servidor WEB O LAMP, renombras el archivo "config.php.sample" por "config.php" y  modificas la configuración de tu base de datos en el mismo. 


![](images/CDR_WEB.png)




