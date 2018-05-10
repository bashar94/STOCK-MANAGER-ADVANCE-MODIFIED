<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Module: General Language File for common lang keys
 * Language: English
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
    'sEmptyTable'                   => "Không có dữ liệu trong bảng",
    'sInfo'                         => "Showing _START_ to _END_ of _TOTAL_ entries",
    'sInfoEmpty'                    => "Showing 0 to 0 of 0 entries",
    'sInfoFiltered'                 => "(filtered from _MAX_ total entries)",
    'sInfoPostFix'                  => "",
    'sInfoThousands'                => ",",
    'sLengthMenu'                   => "Hiện _MENU_ ",
    'sLoadingRecords'               => "Đang tải...",
    'sProcessing'                   => "Đang xử lý...",
    'sSearch'                       => "Tìm kiếm",
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
    'formatInputTooShort'           => "Hãy gõ {n} hoặc nhiều ký tự gợi ý",
    'formatInputTooLong_s'          => "Hãy xóa {n} ký tự",
    'formatInputTooLong_p'          => "Please delete {n} characters",
    'formatSelectionTooBig_s'       => "You can only select {n} item",
    'formatSelectionTooBig_p'       => "You can only select {n} items",
    'formatLoadMore'                => "Loading more results...",
    'formatAjaxError'               => "Ajax request failed",
    'formatSearching'               => "Đang tìm..."
    );


/* ----------------- SMA GENERAL LANGUAGE KEYS -------------------- */

$lang['home']                               = "Trang chủ";
$lang['dashboard']                          = "Bảng điều khiển";
$lang['username']                           = "Tài khoản";
$lang['password']                           = "Mật khẩu";
$lang['first_name']                         = "Họ";
$lang['last_name']                          = "Tên";
$lang['confirm_password']                   = "Xác nhận mật khẩu";
$lang['email']                              = "Email";
$lang['phone']                              = "Điện thoại";
$lang['company']                            = "Công ty";
$lang['product_code']                       = "Mã sản phẩm";
$lang['product_name']                       = "Tên sản phẩm";
$lang['cname']                              = "Tên khách hàng";
$lang['barcode_symbology']                  = "Ký tự mã vạch";
$lang['product_unit']                       = "Đơn vị SP";
$lang['product_price']                      = "Giá bán";
$lang['contact_person']                     = "Người liên hệ";
$lang['email_address']                      = "Địa chỉ Email";
$lang['address']                            = "Địa chỉ";
$lang['city']                               = "Tỉnh/TP";
$lang['today']                              = "Hôm nay";
$lang['welcome']                            = "Chào mừng";
$lang['profile']                            = "Hồ sơ";
$lang['change_password']                    = "Đổi mật khẩu";
$lang['logout']                             = "Thoát";
$lang['notifications']                      = "Thông báo";
$lang['calendar']                           = "Lịch";
$lang['messages']                           = "Tin nhắn";
$lang['styles']                             = "Giao diện";
$lang['language']                           = "Ngôn ngữ";
$lang['alerts']                             = "Cảnh báo";
$lang['list_products']                      = "DS sản phẩm";
$lang['add_product']                        = "Thêm sản phẩm";
$lang['print_barcodes']                     = "In Mã vạch";
$lang['print_labels']                       = "In Nhãn";
$lang['import_products']                    = "Import sản phẩm";
$lang['update_price']                       = "Cập nhật giá";
$lang['damage_products']                    = "Sản phẩm hư hỏng";
$lang['sales']                              = "Bán hàng";
$lang['list_sales']                         = "DS đơn hàng";
$lang['add_sale']                           = "Thêm đơn hàng";
$lang['deliveries']                         = "Giao hàng";
$lang['gift_cards']                         = "Gift Cards";
$lang['quotes']                             = "Báo giá";
$lang['list_quotes']                        = "DS báo giá";
$lang['add_quote']                          = "Thêm báo giá";
$lang['purchases']                          = "Nhập hàng";
$lang['list_purchases']                     = "DS nhập hàng";
$lang['add_purchase']                       = "Thêm nhập hàng";
$lang['add_purchase_by_csv']                = "Thêm bằng CSV";
$lang['transfers']                          = "Chuyển kho";
$lang['list_transfers']                     = "DS chuyển kho";
$lang['add_transfer']                       = "Thêm chuyển kho";
$lang['add_transfer_by_csv']                = "Thêm bằng CSV";
$lang['people']                             = "Người dùng";
$lang['list_users']                         = "DS người dùng";
$lang['new_user']                           = "Thêm người dùng";
$lang['list_billers']                       = "DS NV bán hàng";
$lang['add_biller']                         = "Thêm NV bán hàng";
$lang['list_customers']                     = "DS khách hàng";
$lang['add_customer']                       = "Thêm khách hàng";
$lang['list_suppliers']                     = "DS nhà cung cấp";
$lang['add_supplier']                       = "Thêm nhà cung cấp";
$lang['settings']                           = "Cài đặt";
$lang['system_settings']                    = "Cài đặt hệ thống";
$lang['change_logo']                        = "Đổi Logo";
$lang['currencies']                         = "Tiền tệ";
$lang['attributes']                         = "Biến thể sản phẩm";
$lang['customer_groups']                    = "Nhóm khách hàng";
$lang['categories']                         = "Danh mục SP";
$lang['subcategories']                      = "Danh mục con";
$lang['tax_rates']                          = "Thuế suất";
$lang['warehouses']                         = "Kho hàng";
$lang['email_templates']                    = "Mẫu Email";
$lang['group_permissions']                  = "Phân quyền nhóm";
$lang['backup_database']                    = "Sao lưu dữ liệu";
$lang['reports']                            = "Báo cáo";
$lang['overview_chart']                     = "Tổng quan chung";
$lang['warehouse_stock']                    = "Biểu đồ tồn kho";
$lang['product_quantity_alerts']            = "Cảnh báo số lượng SP";
$lang['product_expiry_alerts']              = "Cảnh báo SP hết hạn";
$lang['products_report']                    = "Báo cáo sản phẩm";
$lang['daily_sales']                        = "Doanh số theo ngày";
$lang['monthly_sales']                      = "Doanh số theo tháng";
$lang['sales_report']                       = "Báo cáo doanh số";
$lang['payments_report']                    = "Báo cáo thanh toán";
$lang['profit_and_loss']                    = "Lợi nhuận và chi phí";
$lang['purchases_report']                   = "Báo cáo nhập hàng";
$lang['customers_report']                   = "Thống kê KH";
$lang['suppliers_report']                   = "Thống kê nhà cung cấp";
$lang['staff_report']                       = "Thống kê NV";
$lang['your_ip']                            = "Địa chỉ IP của bạn";
$lang['last_login_at']                      = "Đăng nhập gần đây";
$lang['notification_post_at']               = "Thông báo đăng tại";
$lang['quick_links']                        = "Liên kết nhanh";
$lang['date']                               = "Ngày";
$lang['reference_no']                       = "Số tham chiếu";
$lang['products']                           = "Sản phẩm";
$lang['customers']                          = "Khách hàng";
$lang['suppliers']                          = "Nhà cung cấp";
$lang['users']                              = "Người dùng";
$lang['latest_five']                        = "5 dữ liệu mới nhất";
$lang['total']                              = "Tổng";
$lang['payment_status']                     = "Trạng thái thanh toán";
$lang['paid']                               = "Đã thanh toán";
$lang['customer']                           = "Khách hàng";
$lang['status']                             = "Trạng thái";
$lang['amount']                             = "Số lượng";
$lang['supplier']                           = "Nhà cung cấp";
$lang['from']                               = "Từ";
$lang['to']                                 = "Tới";
$lang['name']                               = "Tên";
$lang['create_user']                        = "Thêm người dùng";
$lang['gender']                             = "Giới tính";
$lang['biller']                             = "Người bán hàng";
$lang['select']                             = "Chọn";
$lang['warehouse']                          = "Kho hàng";
$lang['active']                             = "Kích hoạt";
$lang['inactive']                           = "Hủy kích hoạt";
$lang['all']                                = "Tất cả";
$lang['list_results']                       = "Vui lòng sử dụng bảng dưới đây để điều hướng hoặc lọc các kết quả. Bạn có thể tải về bảng như excel và pdf.";
$lang['actions']                            = "Tác vụ";
$lang['pos']                                = "POS";
$lang['access_denied']                      = "Từ chối truy cập! Bạn không có quyền truy cập vào các trang yêu cầu. Nếu bạn nghĩ rằng, đó là do nhầm lẫn, xin vui lòng liên hệ quản trị.";
$lang['add']                                = "Thêm";
$lang['edit']                               = "Sửa";
$lang['delete']                             = "Xóa";
$lang['view']                               = "Xem";
$lang['update']                             = "Cập nhật";
$lang['save']                               = "Save";
$lang['login']                              = "Đăng nhập";
$lang['submit']                             = "Gửi";
$lang['no']                                 = "Không";
$lang['yes']                                = "Có";
$lang['disable']                            = "Tắt";
$lang['enable']                             = "Mở";
$lang['enter_info']                         = "Vui lòng điền vào các thông tin dưới đây. Các mục đánh dấu * là các mục bắt buộc phải nhập vào.";
$lang['update_info']                        = "Vui lòng cập nhật thông tin dưới đây. Các mục đánh dấu * là các mục bắt buộc phải nhập vào.";
$lang['no_suggestions']                     = "Không thể tải các dữ liệu cho các đề xuất, hãy kiểm tra đầu vào của bạn";
$lang['i_m_sure']                           = 'Vâng tôi chắc chắn';
$lang['r_u_sure']                           = 'Bạn có chắc không?';
$lang['export_to_excel']                    = "Xuất ra file Excel";
$lang['export_to_pdf']                      = "Xuất ra file PDF";
$lang['image']                              = "Ảnh";
$lang['sale']                               = "Bán";
$lang['quote']                              = "Bảng báo giá";
$lang['purchase']                           = "Mua";
$lang['transfer']                           = "Chuyển kho";
$lang['payment']                            = "Thanh toán";
$lang['payments']                           = "Các khoản thanh toán";
$lang['orders']                             = "Đơn đặt hàng";
$lang['pdf']                                = "PDF";
$lang['vat_no']                             = "Số VAT";
$lang['country']                            = "Quốc gia";
$lang['add_user']                           = "Thêm người dùng";
$lang['type']                               = "Loại";
$lang['person']                             = "Person";
$lang['state']                              = "Huyện";
$lang['postal_code']                        = "Mã bưu chính";
$lang['id']                                 = "ID";
$lang['close']                              = "Đóng";
$lang['male']                               = "Nam";
$lang['female']                             = "Nữ";
$lang['notify_user']                        = "Thông báo tới thành viên";
$lang['notify_user_by_email']               = "Thông tới tới thành viên bằng email";
$lang['billers']                            = "Người bán";
$lang['all_warehouses']                     = "Tất cả kho hàng";
$lang['category']                           = "Danh mục";
$lang['product_cost']                       = "Giá nhập";
$lang['quantity']                           = "Số lượng";
$lang['loading_data_from_server']           = "Đang tải dữ liệu từ máy chủ";
$lang['excel']                              = "Excel";
$lang['print']                              = "In";
$lang['ajax_error']                         = "Ajax lỗi xảy ra, hãy thử lại.";
$lang['product_tax']                        = "Thuế sản phẩm";
$lang['order_tax']                          = "Thuế mua hàng";
$lang['upload_file']                        = "Upload File";
$lang['download_sample_file']               = "Tải file mẫu";
$lang['csv1']                               = "The first line in downloaded csv file should remain as it is. Please do not change the order of columns.";
$lang['csv2']                               = "The correct column order is";
$lang['csv3']                               = "&amp; you must follow this. If you are using any other language then English, please make sure the csv file is UTF-8 encoded and not saved with byte order mark (BOM)";
$lang['import']                             = "Nhập khẩu";
$lang['note']                               = "Ghi chú";
$lang['grand_total']                        = "Tổng cộng";
$lang['download_pdf']                       = "Tải về dạng PDF";
$lang['no_zero_required']                   = "The %s field is required";
$lang['no_product_found']                   = "Không có sản phẩm";
$lang['pending']                            = "Đang xử lý";
$lang['sent']                               = "Gửi";
$lang['completed']                          = "Hoàn thành";
$lang['shipping']                           = "Phí vận chuyển";
$lang['add_product_to_order']               = "Hãy thêm sản phẩm vào danh sách đặt hàng";
$lang['order_items']                        = "Order Items";
$lang['net_unit_cost']                      = "Đơn vị giá nhập";
$lang['net_unit_price']                     = "Đơn vị giá bán";
$lang['expiry_date']                        = "Ngày hết hạn";
$lang['subtotal']                           = "Thành tiền";
$lang['reset']                              = "Làm lại";
$lang['items']                              = "Mục";
$lang['au_pr_name_tip']                     = "Hãy bắt đầu gõ mã/tên cho các đề xuất hoặc chỉ quét mã vạch";
$lang['no_match_found']                     = "Không có kết quả phù hợp được tìm thấy! Sản phẩm có thể không có trong kho.";
$lang['csv_file']                           = "CSV File";
$lang['document']                           = "Tài liệu đính kèm";
$lang['product']                            = "Sản phẩm";
$lang['user']                               = "Người dùng";
$lang['created_by']                         = "Tạo bởi";
$lang['loading_data']                       = "Đang tải dữ liệu bảng từ máy chủ";
$lang['tel']                                = "Điện thoại";
$lang['ref']                                = "Tham chiếu";
$lang['description']                        = "Mô tả";
$lang['code']                               = "Mã";
$lang['tax']                                = "Tax";
$lang['unit_price']                         = "Đơn giá";
$lang['discount']                           = "Chiết khấu";
$lang['order_discount']                     = "Chiết khấu đơn hàng";
$lang['total_amount']                       = "Tổng cộng";
$lang['download_excel']                     = "Tải về dạng Excel";
$lang['subject']                            = "Tiêu đề";
$lang['cc']                                 = "CC";
$lang['bcc']                                = "BCC";
$lang['message']                            = "Tin nhắn";
$lang['show_bcc']                           = "Hiện/Ẩn BCC";
$lang['price']                              = "Giá";
$lang['add_product_manually']               = "Thêm sản phẩm thủ công";
$lang['currency']                           = "Tiền tệ";
$lang['product_discount']                   = "Sản phẩm giảm giá";
$lang['email_sent']                         = "Gửi email thành công";
$lang['add_event']                          = "Thêm sự kiện";
$lang['add_modify_event']                   = "Thêm/Sửa đổi các tổ chức sự kiện";
$lang['adding']                             = "Đang thêm...";
$lang['delete']                             = "Xóa";
$lang['deleting']                           = "Đang xóa...";
$lang['calendar_line']                      = "Vui lòng click ngày để thêm/sửa đổi sự kiện.";
$lang['discount_label']                     = "Chiết khấu (5/5%)";
$lang['product_expiry']                     = "Sản phẩm hết hạn";
$lang['unit']                               = "Đơn vị";
$lang['cost']                               = "Chi phí";
$lang['tax_method']                         = "Tax Method";
$lang['inclusive']                          = "Bao gồm";
$lang['exclusive']                          = "Không bao gồm";
$lang['expiry']                             = "Hạn sử dụng";
$lang['customer_group']                     = "Nhóm khách hàng";
$lang['is_required']                        = "là bắt buộc";
$lang['form_action']                        = "Mẫu thao tác";
$lang['return_sales']                       = "Đơn hàng hoàn";
$lang['list_return_sales']                  = "DS đơn hàng hoàn";
$lang['no_data_available']                  = "Không có dữ liệu";
$lang['disabled_in_demo']                   = "Chúng tôi rất xin lỗi nhưng tính năng này bị vô hiệu hóa trong demo.";
$lang['payment_reference_no']               = "Số tham chiếu thanh toán";
$lang['gift_card_no']                       = "Mã số thẻ giảm giá";
$lang['paying_by']                          = "Thanh toán bằng";
$lang['cash']                               = "Tiền mặt";
$lang['gift_card']                          = "Thẻ giảm giá";
$lang['CC']                                 = "Thẻ tín dụng";
$lang['cheque']                             = "Séc";
$lang['cc_no']                              = "Số thẻ tín dụng";
$lang['cc_holder']                          = "Tên chủ thẻ";
$lang['card_type']                          = "Loại thẻ";
$lang['Visa']                               = "Visa";
$lang['MasterCard']                         = "MasterCard";
$lang['Amex']                               = "Amex";
$lang['Discover']                           = "Discover";
$lang['month']                              = "Tháng";
$lang['year']                               = "Năm";
$lang['cvv2']                               = "CVV2";
$lang['cheque_no']                          = "Số séc";
$lang['Visa']                               = "Visa";
$lang['MasterCard']                         = "MasterCard";
$lang['Amex']                               = "Amex";
$lang['Discover']                           = "Discover";
$lang['send_email']                         = "Gửi Email";
$lang['order_by']                           = "Đặt hàng bởi";
$lang['updated_by']                         = "Cập nhật bởi";
$lang['update_at']                          = "Cập nhật lúc";
$lang['error_404']                          = "404 Page Not Found ";
$lang['default_customer_group']             = "Nhóm khách hàng mặc định";
$lang['pos_settings']                       = "POS Settings";
$lang['pos_sales']                          = "POS Sales";
$lang['seller']                             = "Người bán";
$lang['ip:']                                = "IP:";
$lang['sp_tax']                             = "Thuế bán hàng";
$lang['pp_tax']                             = "Thuế mua sản phẩm";
$lang['overview_chart_heading']             = "Biểu đồ tổng quan kho hàng tính bao gồm doanh số bán hàng hàng tháng đã có thuế, thuế bán hàng (cột), nhập hàng (dòng) và giá trị hiện tại của kho hàng theo giá nhập và giá bán (hình tròn). Bạn có thể lưu các biểu đồ dạng jpg, png và pdf.";
$lang['stock_value']                        = "Giá trị tồn kho";
$lang['stock_value_by_price']               = "Giá trị tính theo giá bán";
$lang['stock_value_by_cost']                = "Giá trị tính theo giá nhập";
$lang['sold']                               = "Đã bán";
$lang['purchased']                          = "Nhập hàng";
$lang['chart_lable_toggle']                 = "Bạn có thể thay đổi các biểu đồ bằng cách nhấp chuột và các ghi chú. Nhấp chuột vào một ghi chú bất kỳ để hiện/ẩn nó trên biểu đố.";
$lang['register_report']                    = "Báo cáo đăng ký";
$lang['sEmptyTable']                        = "Không có dữ liệu trong bảng";
$lang['upcoming_events']                    = "Sự kiện sắp tới";
$lang['clear_ls']                           = "Xóa dữ liệu đã lưu";
$lang['clear']                              = "Xóa";
$lang['edit_order_discount']                = "Sửa chiết khấu đơn hàng";
$lang['product_variant']                    = "Biến thể sản phẩm";
$lang['product_variants']                   = "Các biến thể sản phẩm";
$lang['prduct_not_found']                   = "Không có sản phẩm";
$lang['list_open_registers']                = "List Open Registers";
$lang['delivery']                           = "Giao hàng";
$lang['serial_no']                          = "Số Srial";
$lang['logo']                               = "Logo";
$lang['attachment']                         = "Đính kèm";
$lang['balance']                            = "Dư nợ";
$lang['nothing_found']                      = "Không tìm thấy bản ghi phù hợp";
$lang['db_restored']                        = "Khôi phục dữ liệu thành công.";
$lang['backups']                            = "Backups";
$lang['best_seller']                        = "Bán chạy nhất";
$lang['chart']                              = "Biểu đồ";
$lang['received']                           = "Đã nhận";
$lang['returned']                           = "Trở lại";
$lang['award_points']                       = 'Điểm thưởng';
$lang['expenses']                           = "Chi phí";
$lang['add_expense']                        = "Thêm chi phí";
$lang['other']                              = "Khách";
$lang['none']                               = "Không có";
$lang['calculator']                         = "Máy tính";
$lang['updates']                            = "Cập nhật";
$lang['update_available']                   = "Bản cập nhật mới có sẵn, cập nhật ngay bây giờ.";
$lang['please_select_customer_warehouse']   = "Vui lòng chọn khách hàng/kho hàng";
$lang['variants']                           = "Biến thể";
$lang['add_sale_by_csv']                    = "Thêm bằng CSV";
$lang['categories_report']                  = "Báo cáo danh mục";
$lang['adjust_quantity']                    = "Điều chỉnh số lượng";
$lang['quantity_adjustments']               = "Điều chỉnh số lượng";
$lang['partial']                            = "Từng phần";
$lang['unexpected_value']                   = "Unexpected value provided!";
$lang['select_above']                       = "Vui lòng chọn ở trên đầu";
$lang['no_user_selected']                   = "Không có người dùng được chọn, xin vui lòng chọn một người dùng";
$lang['due']                                = "Nợ";
$lang['ordered']                            = "Ordered";
$lang['profit']                             = "Lợi nhuận";
$lang['unit_and_net_tip']                   = "Calculated on unit (with tax) and net (without tax) i.e <strong>unit(net)</strong> for all sales";
$lang['expiry_alerts']                      = "Cảnh báo hạn sử dụng";
$lang['quantity_alerts']                    = "Số lượng cảnh báo";
$lang['products_sale']                      = "Doanh thu sản phẩm";
$lang['products_cost']                      = "Chi phí sản phẩm";
$lang['day_profit']                         = "Lợi nhuận/Chi phí hôm nay";
$lang['get_day_profit']                     = "Bạn có thể click vào ngày để xem lợi nhuận/chi phí của ngày hôm nay.";
$lang['please_select_these_before_adding_product'] = "Vui lòng chọn các mục này trước khi thêm sản phẩm bất kỳ";
$lang['combine_to_pdf']                     = "Combine to pdf";
$lang['print_barcode_label']                = "In mã vạch/nhãn";
$lang['list_gift_cards']                    = "DS thẻ giảm giá";
$lang['today_profit']                       = "Lợi nhuận hôm nay";
$lang['adjustments']                        = "Điều chỉnh";


