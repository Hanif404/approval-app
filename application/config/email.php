<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['protocol']   = getenv('MAIL_PROTOCOL');
$config['smtp_host']  = getenv('MAIL_HOST');
$config['smtp_port']  = getenv('MAIL_PORT');
$config['smtp_crypto'] = getenv('MAIL_CRYPTO');
$config['smtp_user']  = getenv('MAIL_USERNAME');
$config['smtp_pass']  = getenv('MAIL_PASSWORD');
$config['from_email'] = getenv('MAIL_FROM_EMAIL');
$config['from_name']  = getenv('MAIL_FROM_NAME');
$config['mailtype']   = 'html';
$config['charset']    = 'utf-8';
