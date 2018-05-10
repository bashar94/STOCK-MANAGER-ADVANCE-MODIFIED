<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Script: pos_lang.php
 * Language: Brazilian Portuguese Language File
 * 
 * Last edited:
 * 10 de Maio de 2016
 *
 * Package:
 * Stock Manage Advance v3.0.2.8
 *
 * Translated by:
 * Robson Gonçalves (POP Computadores) robson@popcomputadores.com.br
 *
 * License:
 * GPL v3 or above
 *
 * You can translate this file to your language. 
 * For instruction on new language setup, please visit the documentations. 
 * You also can share your language files by emailing to saleem@tecdiary.com 
 * Thank you 
 */


// For quick cash buttons -  if you need to format the currency please do it according to you system settings
$lang['quick_cash_notes']               = array('10', '20', '50', '100', '500', '1000', '5000');

$lang['pos_module'] 				= "Módulo PDV";
$lang['cat_limit'] 					= "Exibir Categorias";
$lang['pro_limit'] 					= "Exibir Produtos";
$lang['default_category'] 			= "Categoria Padrão";
$lang['default_customer'] 			= "Cliente Padrão";
$lang['default_biller'] 			= "Financeiro Padrão";
$lang['pos_settings'] 				= "Opções do PDV";
$lang['barcode_scanner'] 			= "Leitura de Cód. de Barras";
$lang['x'] 							= "X";
$lang['qty'] 						= "Qtd.";
$lang['total_items'] 				= "Qtd. de Itens";
$lang['total_payable'] 				= "Total à Pagar";
$lang['total_sales'] 				= "Total de Vendas";
$lang['tax1'] 						= "Impostos";
$lang['total_x_tax'] 				= "Total";
$lang['cancel'] 					= "Cancelar";
$lang['payment'] 					= "Finalizar Venda";
$lang['pos'] 						= "PDV";
$lang['p_o_s'] 						= "Ponto de Venda";
$lang['today_sale'] 				= "Vendas de Hoje";
$lang['daily_sales'] 				= "Vendas Diárias";
$lang['monthly_sales'] 				= "Vendas Mensais";
$lang['pos_settings'] 				= "Opções do PDV";
$lang['loading'] 					= "Carregando...";
$lang['display_time'] 				= "Mostrar data";
$lang['pos_setting_updated'] 		= "As Configurações do PDV foram salvas com sucesso. Por favor atualize a página para carregar a novas definições.";
$lang['pos_setting_updated_payment_failed'] 	= "As Configurações do PDV foi gravada com sucesso, mas as configurações dos gatways de pagamento falhou. Por favor, tente novamente";
$lang['tax_request_failed'] 		= "Falha na solicitação, há algum problema com a taxa de imposto!";
$lang['pos_error'] 					= "Ocorreu um erro no cálculo. Por favor, adicione os produtos novamente. Obrigado!";
$lang['qty_limit'] 					= "Você alcançou o limite de quantidade 999.";
$lang['max_pro_reached'] 			= "Máximo permitido Atingido! Por favor, adicione para pagamento esta fatura e abra uma nova fatura para os itens seguintes. Obrigado!";
$lang['code_error'] 				= "Falha de solicitação, por favor, verifique o código e tente novamente!";
$lang['x_total'] 					= "Por favor, adicione produtos antes de finalizar. Obrigado!";
$lang['paid_l_t_payable'] 			= "O Valor PAGO é menor do que o valor á Pagar.";
$lang['suspended_sales'] 			= "Vendas Suspendidas";
$lang['sale_suspended'] 			= "Venda suspendida com Sucesso";
$lang['sale_suspend_failed'] 		= "Falha ao suspender esta venda. Por favor tente novamente!";
$lang['add_to_pos'] 				= "Adicionar esta venda na tela do PDV";
$lang['delete_suspended_sale'] 		= "Excluir venda suspendida";
$lang['save'] 						= "Salvar";
$lang['discount_request_failed'] 	= "Falha na solicitação, há algum problema com o desconto!";
$lang['saving'] 					= "Salvando...";
$lang['paid_by'] 					= "Forma de Pagto.";
$lang['paid'] 						= "Valor Pago";
$lang['ajax_error'] 				= "Falha na solicitação, Por favor tente novamente!";
$lang['close'] 						= "Fechar";
$lang['finalize_sale'] 				= "Finalizar Venda";
$lang['cash_sale'] 					= "Pagto. em Dinheiro";
$lang['cc_sale'] 					= "Pagto. em Cartão";
$lang['ch_sale'] 					= "Pagto. em Boleto";
$lang['sure_to_suspend_sale'] 		= "Tem certeza de que deseja suspender a venda?";
$lang['leave_alert'] 				= "Você vai perder os dados desta venda. Pressione OK para sair e Cancelar para permanecer na página.";
$lang['sure_to_cancel_sale'] 		= "Tem certeza de que deseja Cancelar esta Venda?";
$lang['sure_to_submit_sale'] 		= "Tem certeza de que deseja Enviar esta Venda?";
$lang['alert_x_sale'] 				= "Tem certeza de que deseja Excluir esta Venda Suspendida?";
$lang['suspended_sale_deleted'] 	= "Venda Suspendida excluída com sucesso";
$lang['item_count_error'] 			= "Ocorreu um erro durante a contagem total de itens. Por favor tente novamente!!";
$lang['x_suspend'] 					= "Por favor, adicione produtos antes de suspender uma venda. Obrigado!";
$lang['x_cancel'] 					= "Não existe nenhum produto. Obrigado!";
$lang['yes'] 						= "Sim";
$lang['no1'] 						= "Nº";
$lang['suspend'] 					= "Suspender";
$lang['order_list'] 				= "Lista de Pedidos";
$lang['print'] 						= "Imprimir";
$lang['cf_display_on_bill'] 		= "Campo personalizado à exibir no Recibo do PDV";
$lang['cf_title1'] 					= "Campo personalizado 1 Título";
$lang['cf_value1'] 					= "Campo personalizado 1 Valor";
$lang['cf_title2'] 					= "Campo personalizado 2 Título";
$lang['cf_value2'] 					= "Campo personalizado 2 Valor";
$lang['cash'] 						= "Dinheiro";
$lang['cc'] 						= "Cartão de Crédito";
$lang['cheque'] 					= "Boleto";
$lang['cc_no'] 						= "Nº do Cartão";
$lang['cc_holder'] 					= "Nome do Titular";
$lang['cheque_no'] 					= "Nº do Boleto";
$lang['email_sent'] 				= "E-mail Enviado com Sucesso!";
$lang['email_failed']				= "A Função de envio de e-mail falhou!";
$lang['back_to_pos'] 				= "Voltar para o PDV";
$lang['shortcuts'] 					= "Atalhos";
$lang['shortcut_key'] 				= "Tecla de Atalho";
$lang['shortcut_keys'] 				= "Teclas de Atalhos";
$lang['keyboard'] 					= "Teclado";
$lang['onscreen_keyboard'] 			= "Teclado na Tela";
$lang['focus_add_item'] 			= "Focar em Adicionar Entrada de item";
$lang['add_manual_product'] 		= "Adicionar Item Manual para venda";
$lang['customer_selection'] 		= "Entrada de Cliente";
$lang['toggle_category_slider'] 	= "Alternar Categorias";
$lang['toggle_subcategory_slider'] 	= "Alternar sub-categorias";
$lang['cancel_sale'] 				= "Cancelar";
$lang['suspend_sale'] 				= "Suspender";
$lang['print_items_list'] 			= "Imprimir Lista de itens";
$lang['finalize_sale'] 				= "Finalizar";
$lang['open_hold_bills'] 			= "Abrir Vendas Suspensas";
$lang['search_product_by_name_code'] 	= "Scanear/Procurar Produto pelo Nome/Código";
$lang['receipt_printer'] 			= "Impressora de Recibos";
$lang['cash_drawer_codes'] 			= "Cód. para Abertura da Gaveta do Caixa";
$lang['pos_list_printers'] 			= "Lista de Impressoras de PDV (separadas por ,)";
$lang['custom_fileds'] 				= "Os campos personalizados para o Recibo";
$lang['shortcut_heading'] 			= "Ctrl, Shift e Alt com qualquer outra letra (Ctrl+Shift+A). As teclas de função (F1 - F12) são suportadas também. ";
$lang['product_button_color'] 		= "Cor do Botão do Produto";
$lang['edit_order_tax'] 			= "Editar Taxa do Pedido";
$lang['select_order_tax'] 			= "Selecione uma Taxa para Pedido";
$lang['paying_by'] 					= "Modo do Pagamento";
$lang['paypal_pro'] 				= "Paypal Pro";
$lang['stripe'] 					= "Stripe";
$lang['swipe'] 						= "Swipe";
$lang['card_type'] 					= "Tipo de Cartão";
$lang['Visa'] 						= "Visa";
$lang['MasterCard'] 				= "MasterCard";
$lang['Amex'] 						= "Amex";
$lang['Discover'] 					= "Discover";
$lang['month'] 						= "Mês";
$lang['year'] 						= "Ano";
$lang['cvv2'] 						= "Cód. de Segurança";
$lang['total_paying'] 				= "Total Pago";
$lang['balance'] 					= "Saldo";
$lang['serial_no'] 					= "Nº Serial";
$lang['product_discount'] 			= "Desconto de Produtos";
$lang['max_reached'] 				= "Max. permissão de limite atingido.";
$lang['add_more_payments'] 			= "Adicionar mais pagamentos";
$lang['sell_gift_card'] 			= "Usar Vale-Compra";
$lang['gift_card'] 					= "Vale-Compra";
$lang['product_option'] 			= "Opção do Produto";
$lang['card_no'] 					= "Nº do Cartão";
$lang['value']                    	= "Valor";
$lang['paypal']						= "Paypal";
$lang['sale_added'] 				= "Venda pelo PDV adicionada com sucesso";
$lang['invoice']					= "Fatura";
$lang['vat']              		    = "CNPJ / CPF";
$lang['web_print']                  = "Web Print";
$lang['ajax_request_failed'] 		= "A requisição Ajax falhou, por favor, tente novamente";
$lang['pos_config'] 				= "Configuração do PDV";
$lang['default']                	= "Padrão";
$lang['primary']                    = "Primário";
$lang['info']                  		= "Info";
$lang['warning']                  	= "Avisos";
$lang['danger']                   	= "Perigo";
$lang['enable_java_applet'] 		= "Ativar Java Applet";
$lang['update_settings'] 			= "Atualizar as Configurações";
$lang['open_register']              = "Abrir Caixa";
$lang['close_register']             = "Fechar Caixa";
$lang['cash_in_hand']               = "Dinheiro em Caixa";
$lang['total_cash']                 = "Total em Dinheiro";
$lang['total_cheques']              = "Total em Cheques";
$lang['total_cc_slips'] 			= "Total de Cartão de Crédito Slips";
$lang['CC'] 						= "Cartão de Crédito";
$lang['register_closed'] 			= "Caixa fechado com sucesso";
$lang['register_not_open'] 			= "O seu Caixa não está aberto. Digite a quantidade de dinheiro que você tem no caixa e clique em Abrir Caixa";
$lang['welcome_to_pos'] 			= "Bem-vindo ao PDV";
$lang['tooltips']                   = "Dicas de ferramentas";
$lang['previous']                   = "Anterior";
$lang['next']                       = "Próxima";
$lang['payment_gateways'] 			= "Gateways de Pagamento";
$lang['stripe_secret_key'] 			= "Secret Key Stripe";
$lang['stripe_publishable_key'] 	= "Stripe Publicável Key";
$lang['APIUsername']                = "Paypal Pro API Username";
$lang['APIPassword']                = "Paypal Pro API Password";
$lang['APISignature']               = "Paypal Pro API Signature";
$lang['view_bill']                  = "Ver Fatura";
$lang['view_bill_screen']           = "Ver Fatura na Tela";
$lang['opened_bills'] 				= "Faturas em Aberto";
$lang['leave_opened']               = "Manter Aberta";
$lang['delete_bill'] 				= "Excluir Fatura";
$lang['delete_all'] 				= "Excluir Tudo";
$lang['transfer_opened_bills'] 		= "Transferência de faturas abertas";
$lang['paypal_empty_error'] 		= "A Transação do Paypal falhou (erro de array vazio retornado)";
$lang['payment_failed'] 			= "<strong>O Pagamento falhou!</strong> ";
$lang['pending_amount'] 			= "Valor Pendente";
$lang['available_amount'] 			= "Qtd. Disponível";
$lang['stripe_balance'] 			= "Saldo em Stripe";
$lang['paypal_balance'] 			= "Saldo no Paypal";
$lang['view_receipt'] 				= "Ver Recibo";
$lang['rounding']                  	= "Arredondamento";
$lang['ppp']                       	= "Paypal Pro";
$lang['delete_sale'] 				= "Excluir Venda";
$lang['return_sale'] 				= "Devolução";
$lang['edit_sale'] 					= "Editar Venda";
$lang['email_sale'] 				= "E-mail de Venda";
$lang['add_delivery'] 				= "Adicionar Entrega";
$lang['add_payment'] 				= "Adicionar Pagamento";
$lang['view_payments'] 				= "Ver Pagamentos";
$lang['no_meil_provided'] 			= "Nenhum endereço fornecido";
$lang['payment_added'] 				= "Pagamento adicionado com sucesso";
$lang['suspend_sale'] 				= "Suspender a Venda";
$lang['reference_note'] 			= "Ref. da Nota";
$lang['type_reference_note'] 		= "Digite uma nota de referência e envie para suspender essa venda";
$lang['change']                         = "Troco";
$lang['quick_cash']                     = "Troco Rápido";
$lang['sales_person']                   = "Vendas Associadas";
$lang['no_opeded_bill']                 = "Nenhuma Fatura em Aberto";
$lang['please_update_settings']         = "Atualize as configurações antes de utilizar o PDV";
$lang['order']                          = "Pedido";
$lang['bill']                           = "Faturar";
$lang['due']                            = "À Pagar";
$lang['paid_amount']                    = "Valor Pago";
$lang['due_amount']                     = "Valor à Pagar";
$lang['edit_order_discount']            = "Edit Order Discount";
$lang['sale_note']                      = "Obs. da Venda";
$lang['staff_note']                     = "Obs. do Responsável pela Venda";
$lang['list_open_registers']            = "Lista de Caixas Abertos";
$lang['open_registers']                 = "Caixas Abertos";
$lang['opened_at']                      = "Aberto em";
$lang['all_registers_are_closed']       = "Todos os Caixas estão fechados";
$lang['review_opened_registers']        = "Reveja todos os Caixas abertos na tabela abaixo";
$lang['suspended_sale_loaded']          = "Pedido Suspenso carregado com sucesso";
$lang['incorrect_gift_card']            = "O Número do Cupom está incorreto ou já venceu";
$lang['gift_card_not_for_customer']     = "O Número deste Cupom não é para este Cliente.";
$lang['delete_sales']                   = "Vendas Excluídas";
$lang['click_to_add']                   = "Clique no botão abaixo para abrir";
$lang['tax_summary']                    = "Resumo Fiscal";
$lang['qty']                            = "Qtd.";
$lang['tax_excl']                       = "Sem Impostos";
$lang['tax_amt']                        = "Valor dos Impostos";
$lang['total_tax_amount']               = "Total dos Impostos";
$lang['tax_invoice']                    = "IMPOSTOS DA FATURA";
$lang['char_per_line']                  = "Caracteres por linha";
$lang['delete_code']                    = "Cód. Pin do PDV";
$lang['quantity_out_of_stock_for_%s']   = "Sem estoque para %s";
$lang['refunds']                        = "Reembolsos";
$lang['register_details']               = "Detalhes do Registro";
$lang['payment_note']                   = "Nota de Pagamento";
$lang['to_nearest_005']                 = "Para mais próximo de 0.05";
$lang['to_nearest_050']                 = "Para mais próximo de 0.50";
$lang['to_nearest_number']              = "Para o número anterior (inteiro)";
$lang['to_next_number']                 = "Para o próximo número (inteiro)";
$lang['update_heading']                 = "Esta página irá ajudá-lo a verificar e instalar as atualizações facilmente com único clique. <strong>Se houver mais de 1 atualização disponível, atualizá-las uma por uma a partir da primeira (menor versão)</strong>.";
$lang['update_successful']              = "Ítem Atualizado com Sucesso";
$lang['using_latest_update']            = "Você está usando a Última Versão.";
$lang['sale_details_modal']             = "Detalhes da Venda Modal";
$lang['bill_x_found']                   = "Pedido suspenso não encontrado, por favor verifique a lista de vendas suspensas para abrir qualquer pedido suspenso";
$lang['after_sale_page']                = "Após a página de Venda";
$lang['receipt']                        = "Recibo";
$lang['default']                        = "Recibo";
$lang['item_order']                     = "Item do Pedido";
$lang['default']                        = "Padrão";
