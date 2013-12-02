/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbar = [
		{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ]},
		{ name: 'document', items : [ 'Source' ]},
		{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', '-', 'RemoveFormat' ]},
		{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList' ] },
    { name: 'insert' , items: [ 'Table','Image']},
    { name: 'styles', items: ['Format'] }
	];
	config.allowedContent = true;
  config.autoParagraph = false;
	config.removeDialogTabs = 'image:advanced;link:advanced';
  config.format_tags = 'h1;h2;h3;h4;h5';
};
