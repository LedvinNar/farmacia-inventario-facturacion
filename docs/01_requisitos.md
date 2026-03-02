# Sistema de Control de Inventario y Facturación de Farmacia
## Alcance y funcionalidades (mínimo 15)

### Roles del sistema
- Administrador: acceso total y configuración del sistema.
- Vendedor: ventas, facturación, clientes, consulta de inventario.
- Consulta: solo lectura (inventario, productos, reportes permitidos).

### Módulos principales
1. Seguridad (Autenticación, Roles y Permisos)
2. Catálogo (Productos, Categorías, Laboratorios/Marcas)
3. Inventario (Entradas, Ajustes, Kardex/Movimientos, Stock mínimo)
4. Ventas y Facturación (Caja, Factura imprimible, Detalle de venta)
5. Compras (Proveedores, Compras, Detalle de compra)
6. Reportes (mínimo 8, exportables a Excel)
7. Dashboard (mínimo 3 gráficos basados en BD)
8. Respaldo y restauración (backup/restore desde interfaz)
9. APIs (endpoints para frontend-backend, seguro y estructurado)

### Funcionalidades (15+)
F01. Iniciar sesión (login) con validación de credenciales.
F02. Cerrar sesión (logout) y control de sesión activa.
F03. Administración de usuarios (crear/editar/desactivar) con contraseña cifrada.
F04. Administración de roles (Admin, Vendedor, Consulta) y asignación a usuarios.
F05. Gestión de permisos por rol (autorizar/revocar acceso a módulos).
F06. CRUD de productos con validaciones (código, nombre, precio, stock, vencimiento opcional).
F07. CRUD de categorías de productos.
F08. CRUD de laboratorios/marcas.
F09. CRUD de proveedores.
F10. Registro de compras (maestro-detalle) que incrementa el inventario.
F11. Registro de ventas/facturación (maestro-detalle) que descuenta inventario.
F12. Generación de factura imprimible al realizar una venta.
F13. Control de inventario: alertas de stock mínimo y listado de productos críticos.
F14. Kardex/Movimientos de inventario (entradas, salidas, ajustes) con fechas.
F15. Reportes parametrizados por fechas (ventas, compras, inventario, productos).
F16. Exportación de reportes a Excel.
F17. Dashboard con gráficos: ventas por mes, productos más vendidos, stock crítico.
F18. Respaldo (backup) de la base de datos desde interfaz.
F19. Restauración (restore) de la base de datos desde interfaz.

> Nota del profesor: agregar 20 registros por cada tabla para evidenciar datos reales.
