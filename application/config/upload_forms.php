<?php
/**
 * Upload Configuration untuk Form Master
 * 
 * File: application/config/upload_forms.php
 * 
 * Konfigurasi untuk upload file di form master
 */

// Allowed file types
define('ALLOWED_FILE_TYPES', 'pdf|jpg|jpeg|png|doc|docx');

// Maximum file size (in KB)
define('MAX_FILE_SIZE_KB', 5120); // 5MB

// Upload directory
define('UPLOAD_DIR', 'uploads/forms/');

// Upload path absolute
define('UPLOAD_PATH', FCPATH . UPLOAD_DIR);

/**
 * Get upload configuration
 * 
 * Usage: $config = get_upload_config();
 * 
 * @return array
 */
function get_upload_config() {
	return [
		'upload_path' => UPLOAD_PATH,
		'allowed_types' => ALLOWED_FILE_TYPES,
		'max_size' => MAX_FILE_SIZE_KB,
		'encrypt_name' => TRUE,
		'remove_spaces' => TRUE,
		'overwrite' => FALSE
	];
}

/**
 * Validate file upload
 * 
 * @param array $file $_FILE element
 * @return array
 */
function validate_file_upload($file) {
	$errors = [];

	if (empty($file['name'])) {
		$errors[] = 'File tidak dipilih';
		return $errors;
	}

	// Check file size
	if ($file['size'] > (MAX_FILE_SIZE_KB * 1024)) {
		$errors[] = 'Ukuran file terlalu besar. Max: ' . MAX_FILE_SIZE_KB . 'KB';
	}

	// Check file type
	$allowed_types = explode('|', ALLOWED_FILE_TYPES);
	$file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

	if (!in_array($file_ext, $allowed_types)) {
		$errors[] = 'Tipe file tidak diizinkan. Allowed: ' . ALLOWED_FILE_TYPES;
	}

	// Check MIME type (additional security)
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mime_type = finfo_file($finfo, $file['tmp_name']);
	finfo_close($finfo);

	$allowed_mimes = [
		'pdf' => 'application/pdf',
		'jpg' => ['image/jpeg'],
		'jpeg' => ['image/jpeg'],
		'png' => ['image/png'],
		'doc' => ['application/msword'],
		'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document']
	];

	if ($file_ext === 'doc' || $file_ext === 'docx') {
		// Office files can have multiple MIME types
		if (!in_array($mime_type, $allowed_mimes[$file_ext])) {
			$errors[] = 'File terlihat corrupt atau tidak valid';
		}
	}

	return $errors;
}

/**
 * Get human readable file size
 * 
 * @param int $bytes
 * @return string
 */
function format_file_size($bytes) {
	$units = ['B', 'KB', 'MB', 'GB'];
	$bytes = max($bytes, 0);
	$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
	$pow = min($pow, count($units) - 1);
	$bytes /= (1 << (10 * $pow));

	return round($bytes, 2) . ' ' . $units[$pow];
}

/**
 * Get file icon based on extension
 * 
 * @param string $filename
 * @return string (Font Awesome icon class)
 */
function get_file_icon($filename) {
	$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

	$icons = [
		'pdf' => 'fa-file-pdf text-danger',
		'doc' => 'fa-file-word text-primary',
		'docx' => 'fa-file-word text-primary',
		'xls' => 'fa-file-excel text-success',
		'xlsx' => 'fa-file-excel text-success',
		'jpg' => 'fa-file-image text-info',
		'jpeg' => 'fa-file-image text-info',
		'png' => 'fa-file-image text-info',
		'gif' => 'fa-file-image text-info'
	];

	return isset($icons[$ext]) ? $icons[$ext] : 'fa-file text-secondary';
}

// EOF
