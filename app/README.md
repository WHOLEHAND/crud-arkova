# ARKOVA

ARKOVA es una aplicación web desarrollada como parte de la Práctica Profesional del estudiante Jesús Vielma para optar al título universitario Ingeniería de Sistemas.

La aplicación está diseñada para gestionar de manera eficaz un respaldo de los reportes técnicos y movimiento de bienes generados por la Gerencia de Tecnología en la Asociación Civil Bibliotecas Virtuales de Aragua.  

Este archivo proporciona un resumen de las herramientas, dependencias y referencias empleadas durante el desarrollo del proyecto.  

---

## Herramientas utilizadas

### Backend
- **PHP** v8.2.12: Lenguaje principal para la lógica del sistema y manejo de solicitudes al servidor.
- **MySQL**: Motor de base de datos relacional utilizado para almacenar la información del sistema.

### Frontend
- **HTML5**: Para estructurar las páginas del sistema.
- **CSS3**: Para aplicar estilos personalizados y animaciones.
- **JavaScript**: Para añadir interactividad, gestionar solicitudes AJAX, y mejorar la experiencia del usuario.

### Frameworks y Librerías
- **Bootstrap** v5.3.3: Framework CSS utilizado para diseño responsivo y estilos visuales generales.
- **FPDF** v1.86: Generación de archivos PDF desde el sistema.
- **PhpSpreadsheet** v3.4: Creación y manipulación de archivos Excel.
- **jQuery**:
  - **v3.6.0.min.js**: Usado para la integración con Google Charts.
  - **v3.5.1.js**: Compatibilidad con la librería DataTables.
- **DataTables** v1.10.21: Para tablas dinámicas y manejo avanzado de datos tabulares.
- **html2canvas** v1.4.1: Permite generar capturas de pantalla de los gráficos.
- **Font Awesome** v6.6.0 Web Free: Biblioteca de iconos utilizada en el diseño del sistema.

---

## Notas importantes sobre las dependencias

- Las siguientes herramientas están alojadas **localmente** en las carpetas del proyecto:
  - Bootstrap.
  - FPDF.
  - PhpSpreadsheet.
  - Font Awesome.

- Estas dependencias requieren conexión a Internet para funcionar:
  - **html2canvas**.
  - **jQuery** (Google Charts y DataTables).

Esta información sirve como referencia en caso de necesitar restaurar las dependencias o solucionar problemas en el futuro.  

---

## Requisitos del sistema

### Hardware y Software (Referencia)
Este sistema fue desarrollado y probado en el siguiente entorno:

- **Hardware**:
  - Laptop: VIT.
  - Modelo: P1420.
  - Procesador: Intel®Celeron® N3450 @ 1.10GHz.
  - Memoria RAM: 8GB DDR3L.
  - Almacenamiento SSD: 1TB.
  - Pantalla: LED 14" (1366x768).

- **Software**:
  - Sistema Operativo: Windows 10 Pro (64 Bits) versión 22H2.
  - XAMPP v3.3.0:
    - Apache/2.4.58 (Win64).
    - OpenSSL/3.1.3.
    - PHP/8.2.12.

### Compatibilidad
El sistema debería ser compatible con equipos que cumplan con los siguientes mínimos:  
- **Servidor Web**: Apache o Nginx.  
- **PHP**: Versión 8.2 o superior.  
- **Base de Datos**: MySQL u otro compatible con consultas SQL estándar.  

---

## Instrucciones generales

1. Clonar o copiar los archivos del proyecto a la carpeta raíz del servidor web.
2. Importar el archivo SQL incluido para inicializar la base de datos.
3. Asegurarse de configurar correctamente las credenciales de conexión a la base de datos en el archivo de configuración (`/config/database.php`).
4. Verificar que las dependencias alojadas localmente estén en sus respectivas rutas:
   - `/assets/` para Bootstrap y Font Awesome.
   - `/libs/` para FPDF y PhpSpreadsheet.

Para configuraciones adicionales, consulta la documentación técnica incluida en el proyecto.

---

## Contacto

Cualquier consulta sobre este sistema puede ser dirigida a:  
Jesús Vielma - [sr.wholehand@gmail.com].

---

### Licencia

[Indica la licencia del proyecto, si aplica].