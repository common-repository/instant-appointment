<?php
/**
 * Si elle n'inexiste pas, on créée la table SQL "reservations" après l'activation du thème
 */
global $wpdb;
$charset_collate = $wpdb->get_charset_collate();

$table_name = $wpdb->prefix . 'insapp_appointment';

$sql = "CREATE TABLE IF NOT EXISTS $table_name (
	id mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	event_id mediumint(9) DEFAULT NULL,
	service_id mediumint(9) DEFAULT NULL,
	customer_id mediumint(9) DEFAULT NULL,
	employe_id mediumint(9) DEFAULT NULL,
	description varchar(45) DEFAULT NULL,
	cout decimal(10,2) DEFAULT NULL,
	date_rdv date DEFAULT NULL,
	heure_rdv time DEFAULT NULL,
	statut_rdv varchar(45) DEFAULT NULL,
	create_date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
	update_date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL
) $charset_collate;";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

dbDelta($sql);

$sql = "CREATE TABLE IF NOT EXISTS insapp_notification (
	id int(9) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	title varchar(45) NOT NULL,
	msg text(150) null,
	statut varchar(45) DEFAULT NULL,
	customer_id int(9) DEFAULT NULL,
	photographe_id int(9) DEFAULT NULL,
	reception varchar(45)  DEFAULT NULL,
	create_date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
	update_date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL
) $charset_collate;";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

dbDelta($sql);


$sql = "CREATE TABLE IF NOT EXISTS insapp_appointment_agenda (
    id int(9) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    date_event date DEFAULT NULL,
    user_id int(9) DEFAULT NULL, 
    star_time varchar(45) DEFAULT NULL
) $charset_collate;";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

dbDelta($sql);

$sql = "CREATE TABLE IF NOT EXISTS insapp_chat_messages (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        sender_id bigint(20) NOT NULL,
        receiver_id bigint(20) NOT NULL,
        smsmessage text NOT NULL,
		conversation_id bigint(20) NOT NULL,
        timestamp datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
) $charset_collate;";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

dbDelta($sql);

$sql = "CREATE TABLE IF NOT EXISTS insapp_chat_conversations (
	id mediumint(9) NOT NULL AUTO_INCREMENT,
	sender_id bigint(20) NOT NULL,
	receiver_id bigint(20) NOT NULL,
	status varchar(20) DEFAULT 'actif',
	timestamp datetime DEFAULT CURRENT_TIMESTAMP,
      
	PRIMARY KEY (id)
) $charset_collate;";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

dbDelta($sql);

$sql = "CREATE TABLE IF NOT EXISTS insapp_user_account_connected(
	id mediumint(9) NOT NULL AUTO_INCREMENT,
	user_id bigint(20) NOT NULL,
	account_id varchar(40) NOT NULL,
	connect_status boolean ,
	PRIMARY KEY (id)
) $charset_collate;";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

dbDelta($sql);

?>