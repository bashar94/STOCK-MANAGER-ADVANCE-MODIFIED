<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * última edición: 22/03/2015
 * Ricardo Ramírez R.
 * Adan Rivera - 12/08/2016
 */

    /* Site configuration */
$lang['site_config']                            = "Configuración del Sitio";
$lang['site_name']                              = "Nombre del Sitio";
$lang['default_currency']                       = "Moneda Por Omisión";
$lang['accounting_method']                      = "Método de Costeo";
$lang['default_email']                          = "Correo Por Omisión";
$lang['default_customer_group']                 = "Grupo de Clientes Por Omisión";
$lang['maintenance_mode']                       = "Modo Mantenimiento";
$lang['theme']                                  = "Tema";
$lang['login_captcha']                          = "Captcha en Login";
$lang['rows_per_page']                          = "Filas por Página";
$lang['dateformat']                             = "Formato de Fecha";
$lang['timezone']                               = "Zona horaria";
$lang['reg_ver']                                = "Verificación del Registro";
$lang['allow_reg']                              = "Permitir Registro";
$lang['reg_notification']                       = "Notificación del Registro";
$lang['calendar']                               = "Calendario";
$lang['private']                                = "Privado";
$lang['shared']                                 = "Compartido";
$lang['default_warehouse']                      = "Almacén Por Omisión";
$lang['restrict_user']                          = "Restringir Usuario";

    /* Products */
$lang['product_tax']                            = "Impuesto del Producto";
$lang['racks']                                  = "Ubicación";
$lang['product_variants']                       = "Variantes del Producto";
$lang['product_expiry']                         = "Expiración de Producto";
$lang['image_size']                             = "Tamaño de la Imágen";
$lang['thumbnail_size']                         = "Tamaño de la Miniatura";
$lang['watermark']                              = "Marca de Agua";

    /* Ventas */
$lang['over_selling']                           = "Sobre ventas";
$lang['reference_format']                       = "Formato de la Referencia";
$lang['prefix_month_year_no']                   = "Prefijo/Año/Mes/Secuencia (SL/2015/08/001)";
$lang['prefix_year_no']                         = "Prefijo/Año/Secuencia (SL/2015/001)";
$lang['product_level_discount']                 = "Descuento a Nivel de Producto";
$lang['bc_fix']                                 = "Dijitos fijar la entrada de código de barras";
$lang['item_addition']                          = "Método de adición en Compra de Artículo";
$lang['add_new_item']                           = "Adicionar nuevo artículo a la venta";
$lang['increase_quantity_if_item_exist']        = "Incrementar la cantidad del artículo, si ya existe en la venta";
$lang['invoice_view']                           = "Ver factura";

    /* Prefijos */
$lang['prefix']                                 = "Prefijo";
$lang['sales_prefix']                           = "Prefijo Referencia Ventas";
$lang['return_prefix']                          = "Prefijo Devolución de Ventas";
$lang['payment_prefix']                         = "Prefijo Referencia de Pagos";
$lang['delivery_prefix']                        = "Prefijo Referencia Despacho";
$lang['quote_prefix']                           = "Prefijo Referencia Cotización";
$lang['purchase_prefix']                        = "Prefijo Referencia Compras";
$lang['transfer_prefix']                        = "Prefijo Referencia Traslados";

    /* Money and Number Format */
$lang['money_number_format']                    = "Formato de Decimales y Moneda";
$lang['decimals']                               = "Decimales";
$lang['decimals_sep']                           = "Separador de Decimales";
$lang['thousands_sep']                          = "Separador de Miles";
$lang['dot']                                    = "Punto";
$lang['comma']                                  = "Coma";
$lang['space']                                  = "Espacio";

    /* Email */
$lang['email_protocol']                         = "Protocolo de Correo";
$lang['smtp_host']                              = "Host SMTP";
$lang['smtp_user']                              = "Usuario SMTP";
$lang['smtp_pass']                              = "Contraseña SMTP";
$lang['smtp_port']                              = "Puerto SMTP";

$lang['update_settings']                        = "Actualizar Ajustes";
$lang['setting_updated']                        = "Ajustes actializados correctamente";

    /* Others */
$lang['image_width']                            = "Ancho de la Imágen";
$lang['image_height']                           = "Alto de la Imágen";
$lang['thumbnail_width']                        = "Ancho de la Miniatura";
$lang['thumbnail_height']                       = "Alto de la Miniatura";
$lang['invoice_tax']                            = "Impuesto de la Orden";
$lang['detect_barcode']                         = "Detectar Código de Barras";
$lang['product_serial']                         = "Series de Producto";
$lang['product_discount']                       = "Descuento Producto";
$lang['overselling_will_only_work_with_AVCO_accounting_method_only']= "Sobrevender solo funciona con Costo Promedio, hemos cambiado por usted el Método de Costeo a Costo.";
$lang['accounting_method_change_alert']         = "Está a punto de cambier el Método de Costeo y esto complicará sus cuentas antiguas. Le sujerimos hacer el cambio solo el primer día del mes.";
$lang['logo_uploaded']                          = "Logo correctamente cargado";
$lang['auto_detect_barcode']                    = "Auto Detectar Código de Barras";

    /* Change Logo */
$lang['site_logo']                              = "Logo del Sitio";
$lang['biller_logo']                            = "Logo del vendedor";
$lang['upload_logo']                            = "Actualizar Logo";

    /* Currencies */
$lang['add_currency']                           = "Añadir Moneda";
$lang['edit_currency']                          = "Editar Moneda";
$lang['delete_currency']                        = "Borrar Moneda";
$lang['delete_currencies']                      = "Borrar Monedas";
$lang['currency_code']                          = "Código de la Moneda";
$lang['currency_name']                          = "Nombre de la Moneda";
$lang['exchange_rate']                          = "Tasa de Cambio";
$lang['new_currency']                           = "Añadir Moneda";
$lang['currency_added']                         = "Moneda correctamente añadida";
$lang['currency_updated']                       = "Moneda correctamente actualizada";
$lang['currency_deleted']                       = "Moneda correctamente borrada";
$lang['currencies_deleted']                     = "Monedas correctamente borradas";

    /* Customer Groups */
$lang['add_customer_group']                     = "Añadir Grupo de Clientes";
$lang['edit_customer_group']                    = "Editar Grupo de Clientes";
$lang['delete_customer_group']                  = "Borrar Grupo de Clientes";
$lang['delete_customer_groups']                 = "Borrar Grupo de Clientes";
$lang['percentage']                             = "Porcentaje";
$lang['group_name']                             = "Nombre del Grupo";
$lang['group_percentage']                       = "Porcentaje para el Grupo (sin el signo %)";
$lang['customer_group_added']                   = "Grupo de Clientes correctamente añadido";
$lang['customer_group_updated']                 = "Grupo de Clientes correctamente actualizado";
$lang['customer_group_deleted']                 = "Grupo de Clientes correctamente borrado";
$lang['customer_groups_deleted']                = "Grupos de Clientes correctamente borrados";

    /* Categories */
$lang['add_category']                           = "Añadir Categoría";
$lang['edit_category']                          = "Editar Categoría";
$lang['delete_category']                        = "Borrar Categoría";
$lang['delete_categories']                      = "Borrar Categorías";
$lang['category_code']                          = "Código de la Categoría";
$lang['category_name']                          = "Nombre de la Categoría";
$lang['category_added']                         = "Categoría correctamente añadida";
$lang['category_updated']                       = "Categoría correctamente actualizada";
$lang['category_deleted']                       = "Categoría correctamente borrada";
$lang['categories_deleted']                     = "Categorías correctamente borradas";
$lang['category_image']                         = "Imágen de la Categoría";
$lang['list_subcategories']                     = "Lista de Sub Categorías";
$lang['add_subcategory']                        = "Añadir Sub Categoría";
$lang['edit_subcategory']                       = "Editar Sub Categoría";
$lang['delete_subcategory']                     = "Borrar Sub Categoría";
$lang['delete_subcategories']                   = "Borrar Sub Categorías";
$lang['main_category']                          = "Categoría Principal";
$lang['subcategory_code']                       = "Código de la Sub Categoría";
$lang['subcategory_name']                       = "Nombre de la Sub Categoría";
$lang['subcategory_added']                      = "Sub Categoría correctamente añadida";
$lang['subcategory_updated']                    = "Sub Categoría correctamente actualizada";
$lang['subcategory_deleted']                    = "Sub Categoría correctamente borrada";
$lang['subcategories_deleted']                  = "Sub Categorías correctamente borradas";

    /* Tax Rates */
$lang['tax_rate']                               = "Tasa de Impuesto";
$lang['add_tax_rate']                           = "Añadir Tasa de Impuesto";
$lang['edit_tax_rate']                          = "Editar Tasa de Impuesto";
$lang['delete_tax_rate']                        = "Borrar Tasa de Impuesto";
$lang['delete_tax_rates']                       = "Borrar Tasa de Impuestos";
$lang['fixed']                                  = "Fijo";
$lang['type']                                   = "Tipo";
$lang['rate']                                   = "Tasa";
$lang['tax_rate_added']                         = "Tasa de Impuesto correctamente añadida";
$lang['tax_rate_updated']                       = "Tasa de Impuesto correctamente actualizada";
$lang['tax_rate_deleted']                       = "Tasa de Impuesto correctamente borrada";
$lang['tax_rates_deleted']                      = "Tasas de Impuesto correctamente borradas";

    /* Warehouse */
$lang['warehouse']                              = "Almacén";
$lang['add_warehouse']                          = "Añadir Almacén";
$lang['edit_warehouse']                         = "Editar Almacén";
$lang['delete_warehouse']                       = "Borrar Almacén";
$lang['delete_warehouses']                      = "Borrar Almacenes";
$lang['code']                                   = "Código";
$lang['name']                                   = "Nombre";
$lang['map']                                    = "Mapa";
$lang['map_image']                              = "Imágne del Mapa";
$lang['warehouse_map']                          = "Mapa del Almacén";
$lang['warehouse_added']                        = "Almacén correctamente añadido";
$lang['warehouse_updated']                      = "Almacén correctamente actualizado";
$lang['warehouse_deleted']                      = "Almacén correctamente borrado";
$lang['warehouses_deleted']                     = "Almacenes correctamente borrados";

    /* Email Templates */
$lang['mail_message']                           = "Mensaje de Correo";
$lang['activate_email']                         = "Correo de Activación";
$lang['forgot_password']                        = "Olvido la contraseña";
$lang['short_tags']                             = "Etiquetas cortas";
$lang['message_successfully_saved']             = "Mensaje correctamente guardado";

$lang['group']                                  = "Grupo de Usuarios";
$lang['groups']                                 = "Grupos de Usuarios";
$lang['add_group']                              = "Añadir Grupo de Usuarios";
$lang['create_group']                           = "Añadir Grupo";
$lang['edit_group']                             = "Editar Grupo de Usuarios";
$lang['delete_group']                           = "Borrar Grupo de Usuarios";
$lang['delete_groups']                          = "Borrar Grupos de Usuarios";
$lang['group_id']                               = "ID de Grupo de Usuarios";
$lang['description']                            = "Descripción";
$lang['group_description']                      = "Descripción del Grupo";
$lang['change_permissions']                     = "Cambiar Permisos";
$lang['group_added']                            = "Grupo de Usuarios correctamente añadido";
$lang['group_updated']                          = "Grupo de Usuarios correctamente actualizado";
$lang['group_deleted']                          = "Grupo de Usuarios correctamente borrado";
$lang['groups_deleted']                         = "Grupos de Usuarios correctamente borrados";
$lang['permissions']                            = "Permisos";
$lang['set_permissions']                        = "Conjunto de Permisos";
$lang['module_name']                            = "Nombre del Módulo";
$lang['misc']                                   = "Miscelaneos";

$lang['paypal']                                 = "Paypal";
$lang['paypal_settings']                        = "Ajustes de Paypal";
$lang['activate']                               = "Activar";
$lang['paypal_account_email']                   = "Correo de la cuenta de Paypal";
$lang['fixed_charges']                          = "Cargos fijos";
$lang['account_email_tip']                      = "Por favor escriba la dirección de correo de su cuenta de paypal";
$lang['fixed_charges_tip']                      = "Cualquier cargo fijo extra para todos sus pagos a travéz de ésta pasarela";
$lang['extra_charges_my']                       = "Porcentaje de cargos extra para su país.";
$lang['extra_charges_my_tip']                   = "Porcentaje de cargos extra para todos los pagos desde su país.";
$lang['extra_charges_others']                   = "Porcentaje de cargos extra para otros países.";
$lang['extra_charges_others_tip']               = "Porcentaje de cargos extra para todos los pagos desde otros países.";
$lang['ipn_link']                               = "Enlace IPN";
$lang['ipn_link_tip']                           = "Añadir este enlace a su cuenta de paypal para activar este IPN.";
$lang['paypal_setting_updated']                 = "Ajustes de paypal correctamente actualizados";
$lang['skrill']                                 = "Skrill";
$lang['skrill_account_email']                   = "Correo de la cuenta de Skrill";
$lang['skrill_email_tip']                       = "Por favor escriba la cuenta de correo de su cuenta de skrill";
$lang['secret_word']                            = "Palabra Secreta";
$lang['paypal_setting_updated']                 = "Ajustes de Paypal correctamente actualizados";
$lang['skrill_settings']                        = "Ajustes de Skrill";
$lang['secret_word_tip']                        = "Por favor escriba su palabra secreta de skrill";

$lang['auto_update_rate']                       = "Auto Actualizar Tasa";
$lang['product_variants_feature_x']             = "La característica de variaciones en Producto no trabajará con ésta opción";
$lang['group_permissions_updated']              = "Grupo permisos correctamente actualizado";
$lang['tax_invoice']                            = "Factura de Impuesto";
$lang['standard']                               = "Estandar";
$lang['logo_image_tip']                         = "Tamaño máximp del archivo es de 1024KB y (ancho=300px) x (alto=80px).";
$lang['biller_logo_tip']                        = "Por favor edite el facturador despues de cargar el nuevo logo y seleccionar el logo actualizado.";


$lang['default_biller']                         = "vendedores por default";
$lang['group_x_b_deleted']                      = "Action failed, there are some users assigned to this group";
$lang['profit_loss']                            = "Profit and/or Loss";
$lang['staff']                                  = "Personal";
$lang['stock_chartr']                           = "Grafico De Inventario";
$lang['rtl_support']                            = "RTL Support";
$lang['backup_on']                              = "Backup taken on ";
$lang['restore']                                = "Restore";
$lang['download']                               = "Download";
$lang['file_backups']                           = "File Backups";
$lang['backup_files']                           = "Backup Files";
$lang['database_backups']                       = "Database Backups";
$lang['db_saved']                               = "Database successfully saved.";
$lang['db_deleted']                             = "Database successfully deleted.";
$lang['backup_deleted']                         = "Backup successfully deleted.";
$lang['backup_saved']                           = "Backup successfully saved.";
$lang['backup_modal_heading']                   = "Backing up your files";
$lang['backup_modal_msg']                       = "Please wait, this could take few minutes.";
$lang['restore_modal_heading']                  = "Restoring the backup files";
$lang['restore_confirm']                        = "This action cannot be undone. Are you sure about this restore?";
$lang['delete_confirm']                         = "This action cannot be undone. Are you sure about this delete?";
$lang['restore_heading']                        = "Please backup before restoring to any older version.";
$lang['full_backup']                            = 'Full Backup';
$lang['database']                               = 'Database';
$lang['files_restored']                         = 'Files successfully restored';
$lang['variants']                               = "Variantes";
$lang['add_variant']                            = "Agregar Variante";
$lang['edit_variant']                           = "Editar Variante";
$lang['delete_variant']                         = "Eliminar Variante";
$lang['delete_variants']                        = "Eliminar Variantes";
$lang['variant_added']                          = "Accion de variante Completada Agregado";
$lang['variant_updated']                        = "Accion de variante Completada Actualizado";
$lang['variant_deleted']                        = "Accion de variante Completada Eliminado";
$lang['variants_deleted']                       = "Accion de variante Completada Eliminadas";
$lang['customer_award_points']                  = 'Customer Award Points';
$lang['staff_award_points']                     = 'Staff Award Points';
$lang['each_spent']                             = 'Each <i class="fa fa-arrow-down"></i> spent is equal to';
$lang['each_in_sale']                           = 'Each <i class="fa fa-arrow-down"></i> in sale is equal to';
$lang['mailpath']                               = "Mail Path";
$lang['smtp_crypto']                            = "SMTP Crypto";
$lang['random_number']                          = "Random Number";
$lang['sequence_number']                        = "Sequence Number";
$lang['update_heading']                         = "";
$lang['update_successful']                      = "Articulo Actualizado";
$lang['using_latest_update']                    = "You are using the latest version.";
$lang['version']                                = "Version";
$lang['install']                                = "Install";
$lang['changelog']                              = "Change Log";
$lang['expense_prefix']                         = "Prefijo de Gasto";
$lang['purchase_code']                          = "Purchase Code";
$lang['envato_username']                        = "Username";

$lang['adjust_quantity']                        = "Ajustar Cantidad";