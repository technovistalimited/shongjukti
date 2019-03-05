<?php
/**
 * ---------------------------------------------------------------------
 * Configurations for Shongjukti
 * ---------------------------------------------------------------------
 */

return [
	/**
	 * Maximum Upload Size.
	 *
	 * Maximum size of upload per file.
	 *
	 * Accepts: integer
	 *
	 * Default: (integer) 5000000 - 5mb in bytes
	 * ---------------------------------------------------------------------
	 */
	'upload_max_size' => 5000000,  // 5mb in bytes

	/**
	 * Default File Extensions.
	 *
	 * Default accepted file extensions are mentioned here.
	 * Will be applicable when per attachment extensions
	 * are not available.
	 *
	 * Accepts: string
	 *
	 * Default: (string) 'jpg, gif, png, pdf'
	 * ---------------------------------------------------------------------
	 */
	'default_extensions' => 'jpg, gif, png, pdf',

	/**
	 * Attachment Scopes.
	 *
	 * Before using the plugin there should be a scope
	 * mentioned here. For each of the scope there
	 * will be CRUD for adding attachment types.
	 *
	 * Accepts: array
	 *
	 * Default: (array) ['demo-application' => 'Demo Application']
	 * ---------------------------------------------------------------------
	 */
	'attachment_scopes' => [
			'demo-application' => 'Demo Application'
		]
];
