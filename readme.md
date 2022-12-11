# Prueba Tecnica Desarrollo 1

Esta configurado por defecto un listado de 2 proyectos y 3 repositorios ubicado en el directorio <repositories>
- library1
- library2
- library4

Proyectos
- proyecto1
- proyecto2

## Images pré configuradas

Esta pensado como un comando de terminal que podria usarse desde los hooks de GIT (post-commit)
y que el mismo realice la llamada al script de php

ejempl:
**php bootstrap.php https://localhost/repositories/library1.git 889546413c97d dev repositories/library4**

Parametros:
- urlGit
- commitId
- branch
- repositorio(opcional) solo para ejecucion de formal manual y temporal hasta definir donde se debera obtener el nombre del repositorio
donde se realizo el commit.

Se ha realizado en PHP 8. La carpeta Docker es opcional, las clases se encuentra en el directorio /src.
