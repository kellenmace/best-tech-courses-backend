/* global jQuery, btcRequireTermsData */

/**
 * Require taxonomy terms.
 */
window.btcRequireTerms = window.btcRequireTerms || {};
( function( window, $, app ) {
	var $c = {};

	// Cache selectors.
	app.cache = function() {
		$c.body                       = $( document.body );
		$c.publishingActionsContainer = $( '#major-publishing-actions' );
		$c.loadingSpinner             = $( '.spinner', $c.publishingActionsContainer );
	};

	// Do we meet the requirements?
	app.meetsRequirements = function() {
		return !! $c.publishingActionsContainer.length && !! btcRequireTermsData;
	};

	// Combine all events.
	app.bindEvents = function() {
		$c.body.on( 'submit.edit-post', '#post', app.handleFormSubmit );
	};

	// Constructor.
	app.init = function() {
		app.cache();

		if ( app.meetsRequirements() ) {
			app.bindEvents();
		}
	};

	app.isTermRequired = function( taxonomy ) {
		return btcRequireTermsData[ taxonomy ].postTypes.includes( btcRequireTermsData.currentPostType );
	};

	app.isTermCountValid = function( taxonomy ) {
		if ( 'confirmationStatus' === taxonomy ) {
			return app.getCheckedTermCount( 'confirmationStatus' ) < 2;
		}

		// Applies to courseId and userId taxonomies.
		return 1 === app.getCheckedTermCount( taxonomy );
	};

	app.getCheckedTermCount = function( taxonomy ) {
		return app.getUniqueIds( btcRequireTermsData[ taxonomy ].slug ).length;
	};

	app.getUniqueIds = function( taxonomy ) {
		const checkedBoxes = [...document.querySelectorAll('#taxonomy-' + taxonomy + ' input[type="checkbox"]')].filter(input => input.checked);
		return [...new Set( checkedBoxes.map(input => input.value) )];
	};

	app.displayAlert = function( taxonomy ) {
		window.alert( app.getAlertMessage( taxonomy ) );
	};

	app.getAlertMessage = function( taxonomy ) {
		if ( 'confirmationStatus' === taxonomy ) {
			return 'Only one status may be set.';
		}

		const termDisplayText = 'courseId' === taxonomy ? 'Course ID' : 'User ID';

		if ( 0 === app.getCheckedTermCount( taxonomy ) ) {
			return 'A ' + termDisplayText + ' is required.';
		}

		return 'Only one ' + termDisplayText + ' may be set.';
	};

	app.hideLoadingSpinner = function() {
		$c.loadingSpinner.hide();
	};

	app.removeDisabledButtonsClass = function() {
		$c.publishingActionsContainer.find( ':button, :submit, a.submitdelete, #post-preview' ).removeClass( 'disabled' );
	};

	// Some function.
	app.handleFormSubmit = function() {
		const terms = [ 'confirmationStatus', 'courseId', 'userId' ];
		let fieldsValid = true;

		terms.forEach( term => {
			if ( app.isTermRequired( term ) && ! app.isTermCountValid( term ) ) {
				app.displayAlert(term);
				fieldsValid = false;
			}
		} );

		if ( ! fieldsValid ) {
			app.hideLoadingSpinner();
			app.removeDisabledButtonsClass();
		}

		return fieldsValid;
	};

	// Engage!
	$( document ).ready( app.init );

})( window, jQuery, btcRequireTerms );
