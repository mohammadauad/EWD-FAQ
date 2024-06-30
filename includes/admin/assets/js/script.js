
const { __ } = wp.i18n;
console.log('Translation Data:', wp.i18n.getLocaleData('ewd-faq'));
console.log(wp.i18n.getLocaleData());

; (function ($) {

	$(function () {

		$(document).ready(function(){
			$('#post').on('focusout', '#title', function(){
				verifierTitreVide();
			});
			function verifierTitreVide() {
				var titre = $('#title').val();
				var titreField = $('#titlewrap');
				var boutonEnregistrer = $('#publish');
				if (titre === '') {
					titreField.addClass('champ-titre-vide');
					boutonEnregistrer.prop('disabled', true);
				} else {
					titreField.removeClass('champ-titre-vide');
					boutonEnregistrer.prop('disabled', false);
				}
			}
			$('#post').on('submit', function(){
				verifierTitreVide();
			});
		});
		

		// jQuery(document).ready(function($) {
	
		// });



		// Initialize existing editors on page load
		function initializeExistingEditors() {
			$('#faq_questions_responses textarea').each(function(index, element) {
				var textareaId = $(element).attr('id');
				initializeWysiwyg(textareaId);
				$(this).parents('.faq-item').show();
			});
		}
		        // Initialize existing WYSIWYG editors on page load
				initializeExistingEditors();

	});
})(jQuery);


function initializeWysiwyg(elementId) {
    wp.editor.initialize(elementId, {
        tinymce: {
            wpautop: true,
            plugins: 'wordpress,wpautoresize,wpeditimage,wpgallery,wplink,wpdialogs,wpview',
            toolbar1: 'formatselect,bold,italic,strikethrough,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker',
            toolbar2: 'styleselect,undo,redo,unlink,wp_fullscreen',
            wpautop: true,
            mediaButtons: true,
            quicktags: true,
            mediaButtons: true,
            extended_valid_elements: 'a[href|target=_blank],p,br,strong/b,em/i,span[!class],ul,ol,li,table,tr,td',
            valid_children: '+body[style], +div[style], +span[style]',
            remove_linebreaks: false,
            forced_root_block: '',
            force_br_newlines: true,
            force_p_newlines: false
        },
        quicktags: true,
        mediaButtons: true
    });
}


document.addEventListener('DOMContentLoaded', function () {

	if (typeof(document.getElementById('add_faq_item')) != 'undefined' && document.getElementById('add_faq_item') != null)
{
	document.getElementById('add_faq_item').addEventListener('click', function () {
		var container = document.getElementById('faq_questions_responses_bloc');
		var count = container.children.length;
		var newItem = document.createElement('div');
		newItem.className = 'faq-item';
		newItem.innerHTML = '<div class="faq-item-b"><div class="faq-item-question"><label>Question:</label>' +
							'<textarea id="wysiwyg_editor_question_' + count + '" class="wysiwyg-textarea" name="_mxef_faqs[' + count + '][question]" rows="3" cols="50"></textarea></div>' +
							'<div class="faq-item-response"><label>Réponse:</label>' +
							'<textarea id="wysiwyg_editor_response_' + count + '" class="wysiwyg-textarea" name="_mxef_faqs[' + count + '][response]" rows="5" cols="50"></textarea></div></div>' +
							'<div class="faq-item-b"><button type="button" class="remove_faq_item">'+ __('Retirer', 'ewd-faq') +'</button></div>';
							
		container.appendChild(newItem);
		initializeWysiwyg('wysiwyg_editor_question_' + count);
		initializeWysiwyg('wysiwyg_editor_response_' + count);

		newItem.style.display = "block";

	});
}
if (typeof(document.getElementById('faq_questions_responses_bloc')) != 'undefined' && document.getElementById('faq_questions_responses_bloc') != null)
{
	document.getElementById('faq_questions_responses_bloc').addEventListener('click', function (event) {
		if (event.target.classList.contains('remove_faq_item')) {
			event.target.parentNode.parentNode.remove();

		}
	});
}
});