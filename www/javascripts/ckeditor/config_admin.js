/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'links' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	groups: [ 'mode', 'document', 'doctools' ]},
		{ name: 'others' },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list'] },
		{ name: 'colors' },
    { name: 'insert' }
	];

	config.removeButtons = 'Underline,Subscript,Superscript';

	config.allowedContent = true;
  config.autoParagraph = false;

	config.removeDialogTabs = 'image:advanced;link:advanced';
};
