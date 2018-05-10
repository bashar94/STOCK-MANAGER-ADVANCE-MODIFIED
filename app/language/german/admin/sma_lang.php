<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Module: General Language File for common lang keys
 * Language: German
 * Translation Version: 3.0.2.4
 *
 * Last edited:
 * 1th February 2016
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

$lang['bcf1']               = "Verkäufer benutzerdefiniertes Feld 1";
$lang['bcf2']               = "Verkäufer benutzerdefiniertes Feld 2";
$lang['bcf3']               = "Verkäufer benutzerdefiniertes Feld 3";
$lang['bcf4']               = "Verkäufer benutzerdefiniertes Feld 4";
$lang['bcf5']               = "Verkäufer benutzerdefiniertes Feld 5";
$lang['bcf6']               = "Verkäufer benutzerdefiniertes Feld 6";
$lang['pcf1']               = "Produkt benutzerdefiniertes Feld 1";
$lang['pcf2']               = "Produkt benutzerdefiniertes Feld 2";
$lang['pcf3']               = "Produkt benutzerdefiniertes Feld 3";
$lang['pcf4']               = "Produkt benutzerdefiniertes Feld 4";
$lang['pcf5']               = "Produkt benutzerdefiniertes Feld 5";
$lang['pcf6']               = "Produkt benutzerdefiniertes Feld 6";
$lang['ccf1']               = "Kunde benutzerdefiniertes Feld 1";
$lang['ccf2']               = "Kunde benutzerdefiniertes Feld 2";
$lang['ccf3']               = "Kunde benutzerdefiniertes Feld 3";
$lang['ccf4']               = "Kunde benutzerdefiniertes Feld 4";
$lang['ccf5']               = "Kunde benutzerdefiniertes Feld 5";
$lang['ccf6']               = "Kunde benutzerdefiniertes Feld 6";
$lang['scf1']               = "Lieferant benutzerdefiniertes Feld 1";
$lang['scf2']               = "Lieferant benutzerdefiniertes Feld 2";
$lang['scf3']               = "Lieferant benutzerdefiniertes Feld 3";
$lang['scf4']               = "Lieferant benutzerdefiniertes Feld 4";
$lang['scf5']               = "Lieferant benutzerdefiniertes Feld 5";
$lang['scf6']               = "Lieferant benutzerdefiniertes Feld 6";

/* ----------------- DATATABLES LANGUAGE ---------------------- */
/*
* Below are datatables language entries
* Please only change the part after = and make sure you change the the words in between "";
* 'sEmptyTable'                     => "No data available in table",
* Don't change this                 => "You can change this part but not the word between and ending with _ like _START_;
* For support email support@tecdiary.com Thank you!
*/

$lang['datatables_lang']        = array(
    'sEmptyTable'                   => "Keine Daten in der Tabelle verfügbar",
    'sInfo'                         => "Zeige _START_ bis _END_ der _TOTAL_ Einträge",
    'sInfoEmpty'                    => "Zeige 0 bis 0 von 0 Einträgen",
    'sInfoFiltered'                 => "(gefiltert von insgesamt _MAX_ Einträgen)",
    'sInfoPostFix'                  => "",
    'sInfoThousands'                => ",",
    'sLengthMenu'                   => "Anzeigen _MENU_ ",
    'sLoadingRecords'               => "Laden...",
    'sProcessing'                   => "Verarbeitung...",
    'sSearch'                       => "Suche",
    'sZeroRecords'                  => "Keine übereinstimmenden Aufzeichnungen gefunden",
    'oAria'                                     => array(
      'sSortAscending'                => ": zu aktivieren, um Spalte aufsteigend zu sortieren",
      'sSortDescending'               => ": zu aktivieren, um Spalte absteigend zu sortieren"
      ),
    'oPaginate'                                 => array(
      'sFirst'                        => "<< Erste",
      'sLast'                         => "Letzte >>",
      'sNext'                         => "Nächster >",
      'sPrevious'                     => "< Zurück",
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
    'formatMatches_s'               => "Ein Ergebnis ist verfügbar, drücken Sie Enter, um es auszuwählen.",
    'formatMatches_p'               => "Ergebnisse stehen zur Verfügung, verwenden Sie die Pfeiltasten nach oben oder nach unten zum Navigieren.",
    'formatNoMatches'               => "Keine Treffer gefunden",
    'formatInputTooShort'           => "Bitte geben Sie {n} oder mehr Buchstaben ein",
    'formatInputTooLong_s'          => "Bitte löschen Sie {n} Buchstabe",
    'formatInputTooLong_p'          => "Bitte löschen Sie {n} Buchstaben",
    'formatSelectionTooBig_s'       => "Sie können nur {n} Artikel auswählen",
    'formatSelectionTooBig_p'       => "Sie können nur {n} Artikel auswählen",
    'formatLoadMore'                => "Lade Mehre Ergebnisse ...",
    'formatAjaxError'               => "Ajax Anfrage gescheitert",
    'formatSearching'               => "Suche..."
    );


/* ----------------- SMA GENERAL LANGUAGE KEYS -------------------- */

$lang['home']                               = "Home";
$lang['dashboard']                          = "Dashboard";
$lang['username']                           = "Benutzername";
$lang['password']                           = "Passwort";
$lang['first_name']                         = "Vorname";
$lang['last_name']                          = "Nachname";
$lang['confirm_password']                   = "Passwort bestätigen";
$lang['email']                              = "Email";
$lang['phone']                              = "Telefon";
$lang['company']                            = "Firma";
$lang['product_code']                       = "Artikelnummer";
$lang['product_name']                       = "Produktname";
$lang['cname']                              = "Kunden Namen";
$lang['barcode_symbology']                  = "Barcode Symbologie";
$lang['product_unit']                       = "Produkt Einheit";
$lang['product_price']                      = "Produktpreis";
$lang['contact_person']                     = "Kontakt Person";
$lang['email_address']                      = "Email Addresse";
$lang['address']                            = "Addresse";
$lang['city']                               = "Stadt";
$lang['today']                              = "Heute";
$lang['welcome']                            = "Willkommen";
$lang['profile']                            = "Profil";
$lang['change_password']                    = "Kennwort ändern";
$lang['logout']                             = "Ausloggen";
$lang['notifications']                      = "Benachrichtigungen";
$lang['calendar']                           = "Kalender";
$lang['messages']                           = "Nachrichten";
$lang['styles']                             = "Styles";
$lang['language']                           = "Sprache";
$lang['alerts']                             = "Warnmeldungen";
$lang['list_products']                      = "Liste der Produkte";
$lang['add_product']                        = "Produkt hinzufügen";
$lang['print_barcodes']                     = "Drucken Barcodes";
$lang['print_labels']                       = "Drucken Etiketten";
$lang['import_products']                    = "Produkte importieren";
$lang['update_price']                       = "Produkt Preis aktualisieren";
$lang['damage_products']                    = "Informationen der Schäden";
$lang['sales']                              = "Verkäufe";
$lang['list_sales']                         = "Liste der Verkäufe";
$lang['add_sale']                           = "Neuer Verkauf";
$lang['deliveries']                         = "Lieferungen";
$lang['gift_cards']                         = "Geschenkkarte";
$lang['quotes']                             = "Angebote";
$lang['list_quotes']                        = "Liste der Angebote";
$lang['add_quote']                          = "Angebot hinzufügen";
$lang['purchases']                          = "Käufe";
$lang['list_purchases']                     = "Liste der Einkäufe";
$lang['add_purchase']                       = "Neuer Einkauf";
$lang['add_purchase_by_csv']                = "Einkauf hinzufügen per CSV";
$lang['transfers']                          = "Übertragungen";
$lang['list_transfers']                     = "Liste aller Transfers";
$lang['add_transfer']                       = "Transfer hinzufügen";
$lang['add_transfer_by_csv']                = "Transfer hinzufügen per CSV";
$lang['people']                             = "Menschen";
$lang['list_users']                         = "Liste der Benutzer";
$lang['new_user']                           = "Neuer Benutzer";
$lang['list_billers']                       = "Liste der Verkäufer";
$lang['add_biller']                         = "Verkäufer hinzufügen";
$lang['list_customers']                     = "Liste der Kunden";
$lang['add_customer']                       = "Kunden hinzufügen";
$lang['list_suppliers']                     = "Liste der Lieferanten";
$lang['add_supplier']                       = "Lieferant hinzufügen";
$lang['settings']                           = "Einstellungen";
$lang['system_settings']                    = "System Einstellungen";
$lang['change_logo']                        = "Logo ändern";
$lang['currencies']                         = "Währungen";
$lang['attributes']                         = "Produkt Varianten";
$lang['customer_groups']                    = "Kunden Gruppe";
$lang['categories']                         = "Kategorien";
$lang['subcategories']                      = "Unterkategorien";
$lang['tax_rates']                          = "Steuersätze";
$lang['warehouses']                         = "Lager";
$lang['email_templates']                    = "E-Mail Vorlagen";
$lang['group_permissions']                  = "Gruppenberechtigungen";
$lang['backup_database']                    = "Datenbank sichern";
$lang['reports']                            = "Berichte";
$lang['overview_chart']                     = "Übersichtsdiagramm";
$lang['warehouse_stock']                    = "Lagerbestand Tabelle";
$lang['product_quantity_alerts']            = "Produkt Menge Benachrichtigungen";
$lang['product_expiry_alerts']              = "Produktverfalls Benachrichtigungen";
$lang['products_report']                    = "Produkt Bericht";
$lang['daily_sales']                        = "Tägliche Verkäufe";
$lang['monthly_sales']                      = "Monatlicher Umsatz";
$lang['sales_report']                       = "Verkaufszahlen";
$lang['payments_report']                    = "Zahlungen Bericht";
$lang['profit_and_loss']                    = "Gewinn und/oder Verlust";
$lang['purchases_report']                   = "Einkäufe Bericht";
$lang['customers_report']                   = "Kunden Bericht";
$lang['suppliers_report']                   = "Lieferanten Bericht";
$lang['staff_report']                       = "Personalbericht";
$lang['your_ip']                            = "Deine IP Adresse";
$lang['last_login_at']                      = "Letzter Login am";
$lang['notification_post_at']               = "Mitteilung geschrieben am";
$lang['quick_links']                        = "Nützliche Links";
$lang['date']                               = "Datum";
$lang['reference_no']                       = "Referenznummer";
$lang['products']                           = "Produkte";
$lang['customers']                          = "Kunden";
$lang['suppliers']                          = "Lieferanten";
$lang['users']                              = "Benutzer";
$lang['latest_five']                        = "Jeweils fünf";
$lang['total']                              = "Gesamt";
$lang['payment_status']                     = "Zahlungsstatus";
$lang['paid']                               = "Bezahlt";
$lang['customer']                           = "Kunde";
$lang['status']                             = "Status";
$lang['amount']                             = "Menge";
$lang['supplier']                           = "Lieferant";
$lang['from']                               = "Von";
$lang['to']                                 = "Zu";
$lang['name']                               = "Name";
$lang['create_user']                        = "Benutzer hinzufügen";
$lang['gender']                             = "Geschlecht";
$lang['biller']                             = "Verkäufer";
$lang['select']                             = "Auswählen";
$lang['warehouse']                          = "Lager";
$lang['active']                             = "Aktiv";
$lang['inactive']                           = "Inactiv";
$lang['all']                                = "Alle";
$lang['list_results']                       = "Bitte benutzen Sie die folgende Tabelle um zu navigieren oder die Ergebnisse zu filtern. Sie können die Tabelle als CSV, Excel und PDF herunterladen.";
$lang['actions']                            = "Aktionen";
$lang['pos']                                = "POS";
$lang['access_denied']                      = "Zugang verweigert! Sie haben keinen Anspruch auf die angeforderte Seite zuzugreifen. Wenn Sie denken, es ist falsch, kontaktieren Sie bitte Administrator.";
$lang['add']                                = "Hinzufügen";
$lang['edit']                               = "Bearbeiten";
$lang['delete']                             = "Löschen";
$lang['view']                               = "Ansicht";
$lang['update']                             = "Aktualisieren";
$lang['save']                               = "Speichern";
$lang['login']                              = "Einloggen";
$lang['submit']                             = "Weiter";
$lang['no']                                 = "Nein";
$lang['yes']                                = "Ja";
$lang['disable']                            = "Deaktivieren";
$lang['enable']                             = "Aktivieren";
$lang['enter_info']                         = "Bitte geben Sie folgenden Informationen ein. Felder mit * sind Pflichtfelder.";
$lang['update_info']                        = "Bitte aktualisieren Sie die nachstehenden Informationen. Felder mit * sind Pflichtfelder.";
$lang['no_suggestions']                     = "Nicht möglich Ihre Daten für ihren Vorschlag zu erhalten, Bitte überprüfen Sie Ihre Eingabe";
$lang['i_m_sure']                           = 'Ja ich bin mir sicher';
$lang['r_u_sure']                           = 'Bist du sicher?';
$lang['export_to_excel']                    = "Export in Excel-Datei";
$lang['export_to_pdf']                      = "Export in PDF-Datei";
$lang['image']                              = "Bild";
$lang['sale']                               = "Verkauf";
$lang['quote']                              = "Angebot";
$lang['purchase']                           = "Kaufen";
$lang['transfer']                           = "Transfer";
$lang['payment']                            = "Zahlung";
$lang['payments']                           = "Zahlungen";
$lang['orders']                             = "Bestellungen";
$lang['pdf']                                = "PDF";
$lang['vat_no']                             = "Umsatzsteuer-Identifikationsnummer";
$lang['country']                            = "Land";
$lang['add_user']                           = "Benutzer hinzufügen";
$lang['type']                               = "Typ";
$lang['person']                             = "Person";
$lang['state']                              = "Staat";
$lang['postal_code']                        = "Postleitzahl";
$lang['id']                                 = "ID";
$lang['close']                              = "Schließen";
$lang['male']                               = "Mann";
$lang['female']                             = "Frau";
$lang['notify_user']                        = "Benutzer benachrichtigen";
$lang['notify_user_by_email']               = "Benachrichtigen Sie Benutzer per E-Mail";
$lang['billers']                            = "Verkäufer";
$lang['all_warehouses']                     = "Alle Lager";
$lang['category']                           = "Kategorie";
$lang['product_cost']                       = "Produkt Kosten";
$lang['quantity']                           = "Menge";
$lang['loading_data_from_server']           = "Laden Daten vom Server";
$lang['excel']                              = "Excel";
$lang['print']                              = "Drucken";
$lang['ajax_error']                         = "Ajax Fehler aufgetreten, versuchen Sie es erneut.";
$lang['product_tax']                        = "Produkt MwSt.";
$lang['order_tax']                          = "Auftrag MwSt.";
$lang['upload_file']                        = "Datei hochladen";
$lang['download_sample_file']               = "Beispieldatei herunterladen";
$lang['csv1']                               = "Die erste Zeile in der CSV-Datei sollte zum heruntergeladen bleiben wie sie ist, bitte nicht die Reihenfolge der Spalten ändern...";
$lang['csv2']                               = "Die richtige Reihenfolge der Spalten ist";
$lang['csv3']                               = "&amp; müssen sich daran halten. Wenn Sie eine andere Sprache verwenden, als Englisch, stellen sie bitte sicher, dass die CSV-Datei in UTF-8 kodiert ist und nicht mit Bytereihenfolgemarkierung (BOM) gespeichert wird.";
$lang['import']                             = "Importieren";
$lang['note']                               = "Hinweis";
$lang['grand_total']                        = "Endsumme";
$lang['download_pdf']                       = "Herunterladen als PDF";
$lang['no_zero_required']                   = "Das Feld %s ist erforderlich";
$lang['no_product_found']                   = "Kein Produkt gefunden";
$lang['pending']                            = "anstehend";
$lang['sent']                               = "Gesendet";
$lang['completed']                          = "Fertiggestellt";
$lang['shipping']                           = "Versandkosten";
$lang['add_product_to_order']               = "Bitte fügen Sie einen Artikel der Liste hinzu, um zu bestellen";
$lang['order_items']                        = "Auftragspositionen";
$lang['net_unit_cost']                      = "Netto Verkaufskosten";
$lang['net_unit_price']                     = "Netto Stückpreis";
$lang['expiry_date']                        = "Ablaufdatum";
$lang['subtotal']                           = "Zwischensumme";
$lang['reset']                              = "Zurücksetzen";
$lang['items']                              = "Artikel";
$lang['au_pr_name_tip']                     = "Bitte starten Sie die Eingabe mit Code/Name für Anregungen, oder einfach Barcode-Scanner benutzen";
$lang['no_match_found']                     = "Kein passendes Ergebnis gefunden! Artikel könnten in dem ausgewählten Lager ausverkauft sein.";
$lang['csv_file']                           = "CSV Datei";
$lang['document']                           = "Anlage beifügen";
$lang['product']                            = "Produkt";
$lang['user']                               = "Benutzer";
$lang['created_by']                         = "Erstellt von";
$lang['loading_data']                       = "Lade Daten vom Server";
$lang['tel']                                = "Telefon-Nummer";
$lang['ref']                                = "Referenz";
$lang['description']                        = "Beschreibung";
$lang['code']                               = "Code";
$lang['tax']                                = "MwSt.";
$lang['unit_price']                         = "Einheitspreis";
$lang['discount']                           = "Rabatt";
$lang['order_discount']                     = "Bestell-Rabatt";
$lang['total_amount']                       = "Gesamtbetrag";
$lang['download_excel']                     = "Herunterladen als Excel";
$lang['subject']                            = "Betreff";
$lang['cc']                                 = "CC";
$lang['bcc']                                = "BCC";
$lang['message']                            = "Nachricht";
$lang['show_bcc']                           = "Einblenden/ausblenden BCC";
$lang['price']                              = "Preis";
$lang['add_product_manually']               = "Fügen Sie Artikel manuell hinzu";
$lang['currency']                           = "Währung";
$lang['product_discount']                   = "Produkt-Rabatt";
$lang['email_sent']                         = "E-Mail erfolgreich gesendet";
$lang['add_event']                          = "Veranstaltung hinzufügen";
$lang['add_modify_event']                   = "Hinzufügen/ändern der Veranstaltung";
$lang['adding']                             = "hinzufügen...";
$lang['delete']                             = "Löschen";
$lang['deleting']                           = "Löschen ...";
$lang['calendar_line']                      = "Bitte klicken Sie auf das Datum, um Ereignisses hinzuzufügen oder zu ändern.";
$lang['discount_label']                     = "Rabatt (5/5%)";
$lang['product_expiry']                     = "Produkt-Ablauf";
$lang['unit']                               = "Einheit";
$lang['cost']                               = "Kosten";
$lang['tax_method']                         = "Steuerlichen Methode";
$lang['inclusive']                          = "Inclusiv";
$lang['exclusive']                          = "Exclusiv";
$lang['expiry']                             = "Ablauf";
$lang['customer_group']                     = "Kundengruppe";
$lang['is_required']                        = "Wird benötigt";
$lang['form_action']                        = "Formularaktion";
$lang['return_sales']                       = "Retourenumsatz";
$lang['list_return_sales']                  = "Liste Retourenumsatz";
$lang['no_data_available']                  = "Keine Daten verfügbar";
$lang['disabled_in_demo']                   = "Es tut uns leid, aber diese Funktion ist im Demo deaktiviert.";
$lang['payment_reference_no']               = "Zahlungsreferenznummer";
$lang['gift_card_no']                       = "Geschenkkartennummer";
$lang['paying_by']                          = "Zahlung mit";
$lang['cash']                               = "Bar";
$lang['gift_card']                          = "Geschenkkarte";
$lang['CC']                                 = "Kreditkarte";
$lang['cheque']                             = "Check";
$lang['cc_no']                              = "Kreditkartennummer";
$lang['cc_holder']                          = "Name des Karteninhabers";
$lang['card_type']                          = "Kartentyp";
$lang['Visa']                               = "Visa";
$lang['MasterCard']                         = "MasterCard";
$lang['Amex']                               = "Amex";
$lang['Discover']                           = "Discover";
$lang['month']                              = "Monat";
$lang['year']                               = "Jahr";
$lang['cvv2']                               = "CVV2";
$lang['cheque_no']                          = "Check Nummer";
$lang['Visa']                               = "Visa";
$lang['MasterCard']                         = "MasterCard";
$lang['Amex']                               = "Amex";
$lang['Discover']                           = "Discover";
$lang['send_email']                         = "E-Mail gesendet";
$lang['order_by']                           = "Bestellt von";
$lang['updated_by']                         = "Aktualisiert durch";
$lang['update_at']                          = "Aktualisiert am";
$lang['error_404']                          = "404 Seite nicht gefunden ";
$lang['default_customer_group']             = "Standard Kundengruppe";
$lang['pos_settings']                       = "POS-Einstellungen";
$lang['pos_sales']                          = "POS-Verkäufe";
$lang['seller']                             = "Verkäufer";
$lang['ip:']                                = "IP:";
$lang['sp_tax']                             = "Verkauft Produktsteuer";
$lang['pp_tax']                             = "Gekaufte Produktsteuer";
$lang['overview_chart_heading']             = "Bestand Übersicht Chart einschließlich monatlichen Umsatz mit Produktsteuern und Auftragssteuern (Spalten), Einkäufe (Linie) und aktuellen Bestandswerten von Kosten- und Preis (pie). Sie können die Grafik als jpg, png und pdf speichern.";
$lang['stock_value']                        = "Bestandswert";
$lang['stock_value_by_price']               = "Bestandswert nach Preis";
$lang['stock_value_by_cost']                = "Bestandswert nach Einkaufspreis";
$lang['sold']                               = "Verkauft";
$lang['purchased']                          = "Gekauft";
$lang['chart_lable_toggle']                 = "Sie können das Diagramm ändern, indem Sie auf die Diagrammlegende klicken. Klicken Sie oben auf jede Legende um das Diagramm ein- und auszublenden.";
$lang['register_report']                    = "Benutzer Bericht";
$lang['sEmptyTable']                        = "Keine Daten in der Tabelle verfügbar";
$lang['upcoming_events']                    = "Kommende Veranstaltungen";
$lang['clear_ls']                           = "Alle lokal gespeicherten Daten löschen,";
$lang['clear']                              = "Leeren";
$lang['edit_order_discount']                = "Bearbeite Bestell-Rabatt";
$lang['product_variant']                    = "Produktvariante";
$lang['product_variants']                   = "Produktvarianten";
$lang['prduct_not_found']                   = "Produkt wurde nicht gefunden";
$lang['list_open_registers']                = "Liste der offenen Registriere";
$lang['delivery']                           = "Lieferung";
$lang['serial_no']                          = "Seriennummer";
$lang['logo']                               = "Logo";
$lang['attachment']                         = "Anhang";
$lang['balance']                            = "Balance";
$lang['nothing_found']                      = "Keine übereinstimmenden Aufzeichnungen gefunden";
$lang['db_restored']                        = "Datenbank erfolgreich wiederhergestellt.";
$lang['backups']                            = "Datensicherungen";
$lang['best_seller']                        = "Bester Verkäufer";
$lang['chart']                              = "Chart";
$lang['received']                           = "Empfangen";
$lang['returned']                           = "zurückgegeben";
$lang['award_points']                       = 'Punkte vergeben';
$lang['expenses']                           = "Aufwand";
$lang['add_expense']                        = "Aufwand hinzufügen";
$lang['other']                              = "Andere";
$lang['none']                               = "Keine";
$lang['calculator']                         = "Rechner";
$lang['updates']                            = "Aktualisierungen";
$lang['update_available']                   = "Neues Update ist verfügbar, aktualisieren Sie bitte jetzt.";
$lang['please_select_customer_warehouse']   = "Bitte wählen Sie Kunde/Lager";
$lang['variants']                           = "Varianten";
$lang['add_sale_by_csv']                    = "Hinzufügen Verkauf von CSV";
$lang['categories_report']                  = "Kategorien Bericht";
$lang['adjust_quantity']                    = "Menge anpassen";
$lang['quantity_adjustments']               = "Mengenanpassungen";
$lang['partial']                            = "Teilweise";
$lang['unexpected_value']                   = "Unerwarteter Wert zur Verfügung gestellt!";
$lang['select_above']                       = "Bitte zuerst hier oben auswählen";
$lang['no_user_selected']                   = "Kein Benutzer ausgewählt, wählen Sie bitte mindestens einen Benutzer";
$lang['sale_details']                       = "Verkauf Details";
$lang['due']                                = "Ausstehend";
$lang['ordered']                            = "Geordert";
$lang['profit']                             = "Gewinn";
$lang['unit_and_net_tip']                   = "Auf Einheit (mit Steuern) und netto (ohne Steuern) berechnet, d.h. <strong> Einheit (netto) </strong> für alle Umsätze";
$lang['expiry_alerts']                      = "Ablauf Benachrichtigungen";
$lang['quantity_alerts']                    = "Warnmengen";
$lang['products_sale']                      = "Produkte' Einnahmen";
$lang['products_cost']                      = "Produkte' Kosten";
$lang['day_profit']                         = "Tages Gewinn und/oder Verlust";
$lang['get_day_profit']                     = "Sie können auf das Datum klicken, um den Tages Gewinn und/oder Verlust Bericht anzuzeigen.";
$lang['combine_to_pdf']                     = "Kombinieren zu pdf";
$lang['print_barcode_label']                = "Drucken Barcode/Etiketten";
$lang['list_gift_cards']                    = "Liste Geschenkkarten";
$lang['today_profit']                       = "Heutige Gewinn";
$lang['adjustments']                        = "Anpassungen";
$lang['download_xls']                       = "Download als XLS";
$lang['browse']                             = "Durchsuchen ...";
$lang['transferring']                       = "Übertragen";
$lang['supplier_part_no']                   = "Anbieterbenennung";
$lang['deposit']                            = "Anzahlung";
$lang['ppp']                                = "Paypal Pro";
$lang['stripe']                             = "Stripe";
$lang['amount_greater_than_deposit']        = "Menge ist größer als Kunden Anzahlung, bitte versuchen Sie es mit niedrigeren Betrag als Kunden Anzahlung.";
$lang['stamp_sign']                         = "Stempel &amp; Unterschrift";
$lang['product_option']                     = "Produktvarianten";
$lang['Cheque']                             = "Check";
$lang['sale_reference']                     = "Verkauf Referenz";
$lang['surcharges']                         = "Zusatzkosten";
$lang['please_wait']                        = "Please wait...";

$lang['please_select_these_before_adding_product'] = "Bitte wählen Sie dieses, bevor Sie irgendein Produkt hinzufügen";
