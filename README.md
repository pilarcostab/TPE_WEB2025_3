# TPE_WEB2025_3
A - Maite Kuhn - 45.291.821 - maikuhn@live.com
B - Pilar Costa Bauer - 

BASE URL http://localhost/TPE_WEB2025_3

# ENDPOINTS:

# A
-Ordenar propiedades por cualquier campo de manera ascendente o descendente (GET) :
{base_url}/propiedades?columna=precio&orden=asc

-Actualizar una propiedad (PUT):
{base_url}/propiedades/:id

-Paginado (GET):
{base_url}/propiedades?pagina=1&limite=3

-Ordenamiento y paginado (GET):
{base_url}/propiedades?columna=habitaciones&orden=desc&pagina=2&limite=3

-Obtener propiedad por ID (GET):
{base_url}/propiedades/:id

# B

-Obtener un propietario por ID (GET)
{base_url}/propietarios/{id}

-Insertar un nuevo propietario:
{base_url}/propietarios

-Filtrar propietarios por cualquier campo:
{base_url}/propietarios?telefono=1234






