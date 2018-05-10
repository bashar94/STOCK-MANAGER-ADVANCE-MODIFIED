<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Module: General Language File for common lang keys
 * Language: Thai
 *
 * Last edited:
 * 30th April 2015
 *
 * Package:
 * Stock Manage Advance v3.0
 *
 * You can translate this file to your language.
 * For instruction on new language setup, please visit the documentations.
 * You also can share your language files by emailing to saleem@tecdiary.com
 * Thank you
 */

/* --------------------- CUSTOM FIELDS ------------------------ */
/*
* Below are custome field labels
* Please only change the part after = and make sure you change the the words in between "";
* $lang['bcf1']                         = "Biller Custom Field 1";
* Don't change this                     = "You can change this part";
* For support email contact@tecdiary.com Thank you!
*/

$lang['bcf1']                           = "Biller Custom Field 1";
$lang['bcf2']                           = "Biller Custom Field 2";
$lang['bcf3']                           = "Biller Custom Field 3";
$lang['bcf4']                           = "Biller Custom Field 4";
$lang['bcf5']                           = "Biller Custom Field 5";
$lang['bcf6']                           = "Biller Custom Field 6";
$lang['pcf1']                           = "Product Custom Field 1";
$lang['pcf2']                           = "Product Custom Field 2";
$lang['pcf3']                           = "Product Custom Field 3";
$lang['pcf4']                           = "Product Custom Field 4";
$lang['pcf5']                           = "Product Custom Field 5";
$lang['pcf6']                           = "Product Custom Field 6";
$lang['ccf1']                           = "Customer Custom Field 1";
$lang['ccf2']                           = "Customer Custom Field 2";
$lang['ccf3']                           = "Customer Custom Field 3";
$lang['ccf4']                           = "Customer Custom Field 4";
$lang['ccf5']                           = "Customer Custom Field 5";
$lang['ccf6']                           = "Customer Custom Field 6";
$lang['scf1']                           = "Supplier Custom Field 1";
$lang['scf2']                           = "Supplier Custom Field 2";
$lang['scf3']                           = "Supplier Custom Field 3";
$lang['scf4']                           = "Supplier Custom Field 4";
$lang['scf5']                           = "Supplier Custom Field 5";
$lang['scf6']                           = "Supplier Custom Field 6";

/* ----------------- DATATABLES LANGUAGE ---------------------- */
/*
* Below are datatables language entries
* Please only change the part after = and make sure you change the the words in between "";
* 'sEmptyTable'                     => "No data available in table",
* Don't change this                 => "You can change this part but not the word between and ending with _ like _START_;
* For support email support@tecdiary.com Thank you!
*/

$lang['datatables_lang']        = array(
    'sEmptyTable'                   => "No data available in table",
    'sInfo'                         => "Showing _START_ to _END_ of _TOTAL_ entries",
    'sInfoEmpty'                    => "Showing 0 to 0 of 0 entries",
    'sInfoFiltered'                 => "(filtered from _MAX_ total entries)",
    'sInfoPostFix'                  => "",
    'sInfoThousands'                => ",",
    'sLengthMenu'                   => "Show _MENU_ ",
    'sLoadingRecords'               => "Loading...",
    'sProcessing'                   => "Processing...",
    'sSearch'                       => "Search",
    'sZeroRecords'                  => "No matching records found",
    'oAria'                                     => array(
      'sSortAscending'                => ": activate to sort column ascending",
      'sSortDescending'               => ": activate to sort column descending"
      ),
    'oPaginate'                                 => array(
      'sFirst'                        => "<< First",
      'sLast'                         => "Last >>",
      'sNext'                         => "Next >",
      'sPrevious'                     => "< Previous",
      )
    );

/* ----------------- Select2 LANGUAGE ---------------------- */
/*
* Below are select2 lib language entries
* Please only change the part after = and make sure you change the the words in between "";
* 's2_errorLoading'                 => "The results could not be loaded",
* Don't change this                 => "You can change this part but not the word between {} like {t};
* For support email support@tecdiary.com Thank you!
*/

$lang['select2_lang']               = array(
    'formatMatches_s'               => "One result is available, press enter to select it.",
    'formatMatches_p'               => "results are available, use up and down arrow keys to navigate.",
    'formatNoMatches'               => "No matches found",
    'formatInputTooShort'           => "Please type {n} or more characters",
    'formatInputTooLong_s'          => "Please delete {n} character",
    'formatInputTooLong_p'          => "Please delete {n} characters",
    'formatSelectionTooBig_s'       => "You can only select {n} item",
    'formatSelectionTooBig_p'       => "You can only select {n} items",
    'formatLoadMore'                => "Loading more results...",
    'formatAjaxError'               => "Ajax request failed",
    'formatSearching'               => "Searching..."
    );


/* ----------------- SMA GENERAL LANGUAGE KEYS -------------------- */

$lang['home']                               = "หน้าแรก";
$lang['dashboard']                          = "หน้าปัด";
$lang['username']                           = "ผู้ใช้";
$lang['password']                           = "รหัสผ่าน";
$lang['first_name']                         = "ชื่อ";
$lang['last_name']                          = "นามสกุล";
$lang['confirm_password']                   = "ยืนยันรหัสผ่าน";
$lang['email']                              = "อีเมลล์";
$lang['phone']                              = "โทรศัพท์";
$lang['company']                            = "บริษัท";
$lang['product_code']                       = "รหัสสินค้า";
$lang['product_name']                       = "ชื่อสินค้า";
$lang['cname']                              = "ชื่อลูกค้า";
$lang['barcode_symbology']                  = "สัญญลักษณ์บาร์โค๊ด";
$lang['product_unit']                       = "จำนวนสินค้า";
$lang['product_price']                      = "ราคาสินค้า";
$lang['contact_person']                     = "บุคคลที่สามารถติดต่อ";
$lang['email_address']                      = "อีเมลล์";
$lang['address']                            = "ที่อยู่";
$lang['city']                               = "เมือง";
$lang['today']                              = "วันนี้";
$lang['welcome']                            = "ยินดีต้อนรับ";
$lang['profile']                            = "ประวัติ";
$lang['change_password']                    = "เปลี่ยนรหัสผ่าน";
$lang['logout']                             = "ลงชื่อออก";
$lang['notifications']                      = "การแจ้งเตือน";
$lang['calendar']                           = "ปฏิทิน";
$lang['messages']                           = "ข้อความ";
$lang['styles']                             = "รูปแบบ";
$lang['language']                           = "ภาษา";
$lang['alerts']                             = "การแจ้งเตือน";
$lang['list_products']                      = "รายการสินค้า";
$lang['add_product']                        = "เพิ่มสินค้า";
$lang['print_barcodes']                     = "พิมพ์บาร์โค๊ด";
$lang['print_labels']                       = "พิมพ์ตาราง";
$lang['import_products']                    = "นำเข้าสินค้า";
$lang['update_price']                       = "ปรับปรุงรคา";
$lang['damage_products']                    = "สินค้าเสียหาย";
$lang['sales']                              = "ขาย";
$lang['list_sales']                         = "รายการขาย";
$lang['add_sale']                           = "เพิ่มการขาย";
$lang['deliveries']                         = "การส่งมอบ";
$lang['gift_cards']                         = "คูปอง";
$lang['quotes']                             = "จำนวน";
$lang['list_quotes']                        = "รายการจำนวน";
$lang['add_quote']                          = "เพิ่มจำนวน";
$lang['purchases']                          = "การสั่งซื้อ";
$lang['list_purchases']                     = "รายการสั่งซื้อ";
$lang['add_purchase']                       = "เพิ่มการสั่งซื้อ";
$lang['add_purchase_by_csv']                = "เพิ่มการสั่งซื้อโดยเอ็กเซลล์";
$lang['transfers']                          = "การขนส่ง";
$lang['list_transfers']                     = "รายการการขนส่ง";
$lang['add_transfer']                       = "เพิ่มการขนส่ง";
$lang['add_transfer_by_csv']                = "เพิ่มการขนส่งโดยเอ็กเซลล์";
$lang['people']                             = "ผู้คน";
$lang['list_users']                         = "รายการผู้ใช้";
$lang['new_user']                           = "เพิ่มผู้ใช้";
$lang['list_billers']                       = "รายการผู้รับ";
$lang['add_biller']                         = "เพิ่มผู้รับ";
$lang['list_customers']                     = "รายการลูกค้าทั้งหมด";
$lang['add_customer']                       = "เพิ่มลูกค้า";
$lang['list_suppliers']                     = "รายการลูกค้า";
$lang['add_supplier']                       = "เพิ่มผู้จัดจำหน่าย";
$lang['settings']                           = "ตั้งค่า";
$lang['system_settings']                    = "ตั้งค่าระบบ";
$lang['change_logo']                        = "เปลี่ยนโลโก้";
$lang['currencies']                         = "สกุลเงิน";
$lang['attributes']                         = "ความหลากหลายของ สินค้า";
$lang['customer_groups']                    = "กลุ่มลูกค้า";
$lang['categories']                         = "ประเภท";
$lang['subcategories']                      = "หมวดหมู่";
$lang['tax_rates']                          = "อัตราภาษี";
$lang['warehouses']                         = "โกดังสินค้า";
$lang['email_templates']                    = "ต้นแบบอีเมลล์";
$lang['group_permissions']                  = "สิทธิ์ ของกลุ่ม";
$lang['backup_database']                    = "สำรองข้อมูล";
$lang['reports']                            = "รายงาน";
$lang['overview_chart']                     = "แผนภูมิ ภาพรวม";
$lang['warehouse_stock']                    = "แผนภูมิสต็อกสินค้า";
$lang['product_quantity_alerts']            = "แจ้งเตือนจำนวนสินค้า";
$lang['product_expiry_alerts']              = "แจ้งเตือนวันหมดอายุสินค้า";
$lang['products_report']                    = "รายงานสินค้า";
$lang['daily_sales']                        = "ยอดขายรายวัน";
$lang['monthly_sales']                      = "ยอดขายรายเดือน";
$lang['sales_report']                       = "รายงานการขาย";
$lang['payments_report']                    = "รายงานการจ่าย";
$lang['profit_and_loss']                    = "กำไรขาดทุน";
$lang['purchases_report']                   = "รายงานการสั่งซื้อ";
$lang['customers_report']                   = "การสั่งซื้อ ลูกค้า";
$lang['suppliers_report']                   = "การสั่งซื้อผู้จัดจำหน่าย";
$lang['staff_report']                       = "รายงานบุคคลากร";
$lang['your_ip']                            = "ที่อยู่ IP ของคุณ";
$lang['last_login_at']                      = "ครั้งสุดท้ายลงชื่อเข้าใช้";
$lang['notification_post_at']               = "ประกาศที่โพส";
$lang['quick_links']                        = "ลิ้งค์ที่ใช้บ่อย";
$lang['date']                               = "วันที่";
$lang['reference_no']                       = "เลขที่อ้างอิง";
$lang['products']                           = "สินค้า";
$lang['customers']                          = "ลูกค้า";
$lang['suppliers']                          = "ผู้จัดจำหน่าย";
$lang['users']                              = "ผู้ใช้";
$lang['latest_five']                        = "ล่าสุด";
$lang['total']                              = "ทั้งหมด";
$lang['payment_status']                     = "สถานะการจ่ายเงิน";
$lang['paid']                               = "การชำระเงิน";
$lang['customer']                           = "ลูกค้า";
$lang['status']                             = "สถานะ";
$lang['amount']                             = "จำนวนเงิน";
$lang['supplier']                           = "ผู้จัดจำหน่าย";
$lang['from']                               = "จาก";
$lang['to']                                 = "ถึง";
$lang['name']                               = "ชื่อ";
$lang['create_user']                        = "เพิ่มผู้ใช้งาน";
$lang['gender']                             = "เพศ";
$lang['biller']                             = "ผู้รับ";
$lang['select']                             = "เลือก";
$lang['warehouse']                          = "โกดังสินค้า";
$lang['active']                             = "เชื่อมต่อ";
$lang['inactive']                           = "ไม่มีการเชื่อมต่อ";
$lang['all']                                = "ทั้งหมด";
$lang['list_results']                       = "กรุณา ใช้ตาราง ด้านล่างนี้เพื่อ นำทาง หรือกรอง ผลการค้นหา. คุณสามารถดาวโหลดตารางเป็นไฟล์ excel และ pdf.";
$lang['actions']                            = "ดำเนินงาน";
$lang['pos']                                = "รายงานการขาย";
$lang['access_denied']                      = "ปฏิเสธการเข้าใช้! คุณไม่ได้ มีสิทธิที่จะ เข้าถึงหน้าเว็บ ที่ร้องขอ. หากคุณคิดว่า มันเป็น ความผิดพลาด โปรด ติดต่อ ผู้ดูแลระบบ.";
$lang['add']                                = "เพิ่ม";
$lang['edit']                               = "แก้ไข";
$lang['delete']                             = "ลบ";
$lang['view']                               = "ดู";
$lang['update']                             = "ปรับปรุง";
$lang['save']                               = "บันทึก";
$lang['login']                              = "ลงชื่อเข้าใช้";
$lang['submit']                             = "ส่ง";
$lang['no']                                 = "ไม่";
$lang['yes']                                = "ใช่";
$lang['disable']                            = "ปิดใช้งาน";
$lang['enable']                             = "เปิดใช้งาน";
$lang['enter_info']                         = "กรุณากรอก ข้อมูลด้านล่าง. .ป้ายชื่อ สาขา ที่มีเครื่องหมาย * จำเป็นต้องใส่.";
$lang['update_info']                        = "โปรดอัปเดต ข้อมูลด้านล่างนี้.ป้ายชื่อ สาขา ที่มีเครื่องหมาย * จำเป็นต้องใส่.";
$lang['no_suggestions']                     = "ไม่สามารถ ที่จะได้รับ ข้อมูล ข้อเสนอแนะ โปรดตรวจสอบการ ป้อนข้อมูลของคุณ";
$lang['i_m_sure']                           = 'ใช่ \'ฉันมั่นใจ';
$lang['r_u_sure']                           = 'คุณแน่ใจ?';
$lang['export_to_excel']                    = "ส่งออกเป็นไฟล์Excel";
$lang['export_to_pdf']                      = "ส่งออกเป็นไฟล์PDF";
$lang['image']                              = "รูปภาพ";
$lang['sale']                               = "ขาย";
$lang['quote']                              = "จำนวน";
$lang['purchase']                           = "ใบสั่งซื้้อ";
$lang['transfer']                           = "การขนส่ง";
$lang['payment']                            = "ช่องทางการชำระเงิน";
$lang['payments']                           = "ช่องทางการชำระเงินทั้งหมด";
$lang['orders']                             = "ใบสั่ง";
$lang['pdf']                                = "PDF";
$lang['vat_no']                             = "เลขประจำตัวผู้เสียภาษี";
$lang['country']                            = "เมือง";
$lang['add_user']                           = "เพิ่มผู้ใช้";
$lang['type']                               = "ชนิด";
$lang['person']                             = "ผู้คน";
$lang['state']                              = "ประเทศ";
$lang['postal_code']                        = "รหัสไปรษณีย์";
$lang['id']                                 = "ไอดี";
$lang['close']                              = "ปิด";
$lang['male']                               = "เพศชาย";
$lang['female']                             = "เพศหญิง";
$lang['notify_user']                        = "แจ้งผู้ใช้";
$lang['notify_user_by_email']               = "แจ้งผู้ใช้ทางอีเมลล์";
$lang['billers']                            = "ผู้รับทั้งหมด";
$lang['all_warehouses']                     = "โกดังสินค้าทั้งหมด";
$lang['category']                           = "ประเภท";
$lang['product_cost']                       = "ต้นทุนสินค้า";
$lang['quantity']                           = "จำนวน";
$lang['loading_data_from_server']           = "โหลดข้อมูลจากเซอร์เวอร์";
$lang['excel']                              = "เอ้กเซลล์";
$lang['print']                              = "พิมพ์";
$lang['ajax_error']                         = "Ajax เกิดข้อผิดพลาด,โปรดลองอีกครั้ง.";
$lang['product_tax']                        = "สินค้า ภาษี";
$lang['order_tax']                          = "ใบสั่ง ภาษี";
$lang['upload_file']                        = "อัพโหลด ไฟล์";
$lang['download_sample_file']               = "ดาวโหลดตัวอย่างไฟล์";
$lang['csv1']                               = "บรรทัดแรก ใน การดาวน์โหลด ไฟล์ CSV ควรจะอยู่อย่างที่มันเป็น กรุณาอย่า เปลี่ยนลำดับ ของคอลัมน์.";
$lang['csv2']                               = "ลำดับคอลัมน์ที่ถูกต้อง";
$lang['csv3']                               = "&amp; คุณต้องทำตามนี้. ถ้าคุณกำลังใช้ ภาษาอื่น ๆ , โปรดตรวจสอบ ไฟล์ CSV เป็น UTF- 8 เท่านั้น และ ไม่ได้ถูกบันทึก ที่มีเครื่องหมาย (BOM)";
$lang['import']                             = "นำเข้า";
$lang['note']                               = "อื่นๆ";
$lang['grand_total']                        = "ทั้งหมด";
$lang['download_pdf']                       = "ดาวโหลดเป็น PDF";
$lang['no_zero_required']                   = "เขตข้อมูล%";
$lang['no_product_found']                   = "ไม่พบสินค้า";
$lang['pending']                            = "รอดำเนินการ";
$lang['sent']                               = "ส่ง";
$lang['completed']                          = "เรียบร้อย";
$lang['shipping']                           = "การนำเข้าส่งออกสินค้า";
$lang['add_product_to_order']               = "โปรดเพิ่มสินค้าในรายการ";
$lang['order_items']                        = "สินค้าสังเพิ่ม";
$lang['net_unit_cost']                      = "ราคาต้นทุนต่อชิ้น";
$lang['net_unit_price']                     = "ราคาขายต่อชิ้น";
$lang['expiry_date']                        = "วันหมดอายุ";
$lang['subtotal']                           = "ยอดรวม";
$lang['reset']                              = "เริ่มใหม่";
$lang['items']                              = "สินค้า";
$lang['au_pr_name_tip']                     = "กรุณา เริ่มพิมพ์ รหัส / ชื่อ เพื่อขอคำแนะนำ หรือเพียงแค่ สแกน บาร์โค้ด";
$lang['no_match_found']                     = "ผล การจับคู่ ไม่พบสินค้า ! สินค้าอาจจะ หมดสต็อก ในคลังสินค้า ที่เลือก.";
$lang['csv_file']                           = "CSV ไฟล์";
$lang['document']                           = "เอกสารแนบ";
$lang['product']                            = "สินต้า";
$lang['user']                               = "ผู้ใช้";
$lang['created_by']                         = "จัดทำโดย";
$lang['loading_data']                       = "กำลังโหลด ข้อมูลตาราง จากเซิร์ฟเวอร์";
$lang['tel']                                = "เบอร์โทรศัพท์";
$lang['ref']                                = "อ้างอิง";
$lang['description']                        = "คำอธิบาย";
$lang['code']                               = "รหัส";
$lang['tax']                                = "ภาษี";
$lang['unit_price']                         = "ราคาขายต่อชิ้น";
$lang['discount']                           = "ส่วนลด";
$lang['order_discount']                     = "รายการสั่ง ส่วนลด";
$lang['total_amount']                       = "รวมจำนวนราคา";
$lang['download_excel']                     = "ดาวโหลด เอ็กเซลล์";
$lang['subject']                            = "เรื่อง";
$lang['cc']                                 = "CC";
$lang['bcc']                                = "BCC";
$lang['message']                            = "ข้อความ";
$lang['show_bcc']                           = "แสดง/ซอน BCC";
$lang['price']                              = "ราคา";
$lang['add_product_manually']               = "เพิ่มสินค้าแบบกำหนดเอง";
$lang['currency']                           = "สกุลเงิน";
$lang['product_discount']                   = "สินค้าลดราคา";
$lang['email_sent']                         = "ส่งอีเมลล์ เรียบร้อยแล้ว";
$lang['add_event']                          = "เพิ่มกิจกรรมา";
$lang['add_modify_event']                   = "เพิ่ม / เพิ่มเติม กิจกรรม";
$lang['adding']                             = "กำลังเพิ่ม...";
$lang['delete']                             = "ลบ";
$lang['deleting']                           = "กำลังลบ...";
$lang['calendar_line']                      = "โปรดคลิกเพิ่มวันที่สำหรับกิจกรรม.";
$lang['discount_label']                     = "ส่วนลด (5/5%)";
$lang['product_expiry']                     = "สินค้า_วันหมดอายุ";
$lang['unit']                               = "จำนวน";
$lang['cost']                               = "ต้นทุน";
$lang['tax_method']                         = "ภาษี";
$lang['inclusive']                          = "รวม";
$lang['exclusive']                          = "สิทธิพิเศษเพียงผู้เดียว";
$lang['expiry']                             = "วันหมดอายุ";
$lang['customer_group']                     = "กลุ่มลูกค้า";
$lang['is_required']                        = "จำเป็น";
$lang['form_action']                        = "ฟอร์มการดำเนินการ";
$lang['return_sales']                       = "ส่งคืนการขาย";
$lang['list_return_sales']                  = "รายยการส่งคืนการขาย";
$lang['no_data_available']                  = "ไม่มีข้อมูลที่สามารถใช้งานได้";
$lang['disabled_in_demo']                   = "เราต้องขออภัยที่ คุณลักษณะนี้ ถูกปิดใช้งาน ในการใช้งานแบบสาธิต.";
$lang['payment_reference_no']               = "อ้างอิงการชำระเงิน";
$lang['gift_card_no']                       = "เลขที่คูปอง";
$lang['paying_by']                          = "จ่ายเงินโดย";
$lang['cash']                               = "เงินสด";
$lang['gift_card']                          = "คูปอง";
$lang['CC']                                 = "บัตรเคอรดิต";
$lang['cheque']                             = "เช็ค";
$lang['cc_no']                              = "หมายเลขบัตรเครดิต";
$lang['cc_holder']                          = "ชื่อเจ้าของ";
$lang['card_type']                          = "ชนิดของบัตร";
$lang['Visa']                               = "วีซ่า";
$lang['MasterCard']                         = "มาสเตอร์การ์ด";
$lang['Amex']                               = "เอเม็กซ์";
$lang['Discover']                           = "ค้";
$lang['month']                              = "เดือน";
$lang['year']                               = "ปี";
$lang['cvv2']                               = "CVV2";
$lang['cheque_no']                          = "เช็คเลขที่";
$lang['Visa']                               = "วีซ่า";
$lang['MasterCard']                         = "มาสเตอร์การ์ด";
$lang['Amex']                               = "เอเม็กซ์";
$lang['Discover']                           = "ค้นพบ";
$lang['send_email']                         = "ส่่งอีเมลล์";
$lang['order_by']                           = "ใบสั่ง โดย";
$lang['updated_by']                         = "ปรับปรุงโดย";
$lang['update_at']                          = "ปรับปรุงที่";
$lang['error_404']                          = "404 ไม่พบเพจ ";
$lang['default_customer_group']             = "กลุ่มลูกค้า";
$lang['pos_settings']                       = "การตั้งค่าณจุดขาย";
$lang['pos_sales']                          = "ยอดขาย ณจุดขาย";
$lang['seller']                             = "ผู้ขาย";
$lang['ip:']                                = "ไอพี:";
$lang['sp_tax']                             = "มูลค่าภาษีขายสินค้า";
$lang['pp_tax']                             = "มูลค่าภาษีสินค้า";
$lang['overview_chart_heading']             = "ภาพรวม สต็อก รวมทั้ง ยอดขายรายเดือน ที่มีภาษี และ ภาษี การสั่งซื้อ ( คอลัมน์ ), ใบสั่งซื้อ(line) และมูลค่าสต็อกกับราคาต้นทุน (pie). คุณสามารถบันทึกเป็น jpg, png และ pdf.";
$lang['stock_value']                        = "มูลค่าสต็อก";
$lang['stock_value_by_price']               = "มูลค่าสต็อก โดย ราคา";
$lang['stock_value_by_cost']                = "มูลค่าสต็อก โดย ต้นทุน";
$lang['sold']                               = "หมด";
$lang['purchased']                          = "สั่งซื้อ";
$lang['chart_lable_toggle']                 = "คุณสามารถเปลี่ยนแผนภูมิ โดย  โดยคลิกที่แผนภูมิ.คลิกเพื่อแสดง/ซ่อนแผนภูมิ.";
$lang['register_report']                    = "รายงานการลงทะเบียน";
$lang['sEmptyTable']                        = "ไม่มีข้อมูลในตาราง";
$lang['upcoming_events']                    = "กิจกรรมที่กำลังจะเกิดขึ้น";
$lang['clear_ls']                           = "ล้างข้อมูลที่เซฟ";
$lang['clear']                              = "ล้าง";
$lang['edit_order_discount']                = "แก้ไขส่วนลด";
$lang['product_variant']                    = "ความหลากหลายของสินค้า";
$lang['product_variants']                   = "ความหลากหายของสินค้าทั้งหมด";
$lang['prduct_not_found']                   = "ไม่พบสินค้า";
$lang['list_open_registers']                = "รายการลงทะเบียน";
$lang['delivery']                           = "การจัดส่ง";
$lang['serial_no']                          = "ซีเรียล นัมเบอร์";
$lang['logo']                               = "โลโก้";
$lang['attachment']                         = "สิ่งที่แนบมา";
$lang['balance']                            = "สมดุล";
$lang['nothing_found']                      = "ไม่พบข้อมูบที่ตรงกัน";
$lang['db_restored']                        = "ประสบความสำเร็จใน การเรียกคืน ฐานข้อมูล.";
$lang['backups']                            = "สำรองข้อมูล";
$lang['best_seller']                        = "สินค้าขายดี";
$lang['chart']                              = "แผนภูมิ";
$lang['received']                           = "การรับ";
$lang['returned']                           = "การส่งคืน";
$lang['award_points']                       = 'รางวัลที่ได้รับ';
$lang['expenses']                           = "ค่าใช้จ่าย";
$lang['add_expense']                        = "เพิ่มค่าใช้จ่าย";
$lang['other']                              = "อื่นๆ";
$lang['none']                               = "ไม่มี";
$lang['calculator']                         = "เครื่องคิดเลข";
$lang['updates']                            = "ปรับปรุง";
$lang['update_available']                   = "อัพเดทตอนนี้.";
$lang['please_select_customer_warehouse']   = "โปรดเลือกลูกค้า/โกดังสินค้า";
$lang['variants']                           = "ประเภทที่หลากหลาย";
$lang['add_sale_by_csv']                    = "เพิ่มการขาย โดยเอ็กเซลล์";
$lang['categories_report']                  = "รายขายยอดขายตามประเภท";
$lang['adjust_quantity']                    = "ปรับจำนวน สินค้า";
$lang['quantity_adjustments']               = "การปรับจำนวนสินค้า";
$lang['partial']                            = "บางส่วน";
$lang['unexpected_value']                   = "มูลค่าที่ไม่คาดคิด!";
$lang['select_above']                       = "โปรดเลือกเดังกล่าวป็นครั้งแรก";
$lang['no_user_selected']                   = "ยังไม่ได้เลือกผู้ใช้งาน,โปรดเลือกผู้ใช้งานอย่างน้อยหนึ่งชื่อ";
$lang['due']                                = "เนื่องจาก";
$lang['ordered']                            = "ออเดอร์";
$lang['profit']                             = "กำไร";
$lang['unit_and_net_tip']                   = "จากการคำนวณ ในหน่วย ( ที่มีภาษี ) สุทธิ (ไม่รวม ภาษี )<strong>จำนวน(net)</strong> สำหรับการขายทั้งหมด";
$lang['expiry_alerts']                      = "การแจ้งเตือนหมดอายุ";
$lang['quantity_alerts']                    = "การแจ้งเตือนจำนวน";
$lang['products_sale']                      = "สินค้า' รายได้";
$lang['products_cost']                      = "สินค้า' ต้นทุน";
$lang['day_profit']                         = "กำไรต่อวัน/หรือ ขาดทุน";
$lang['get_day_profit']                     = "คุณสามารถคลิกที่ วัน ที่จะได้รับ ผลกำไร วัน และ / หรือรายงาน การสูญเสีย.";
$lang['print_barcode_label']                = "พิมพ์บาร์โค๊ด / พิมพ์ตาราง";
$lang['list_gift_cards']                    = "คูปอง";

$lang['please_select_these_before_adding_product'] = "กรุณาเลือกสิ่งเหล่านี้ก่อนเพิ่มสินค้า";
