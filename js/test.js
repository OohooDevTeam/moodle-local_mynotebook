	$(document).ready(function(){

		$('#load').click(function(){

			$('#dialog').remove();
//			$('body').append('<div id="dialog" \/>');
			$('body').append('<div id="dialog" />');
			$('#dialog').dialog({
				autoOpen: false,
				bgiframe: true,
				resizable: false,
				width: 845,
				position: ['center','top'],
				overlay: { backgroundColor: '#000', opacity: 0.5 },
				open: function(e, ui){

				},
				beforeclose: function(event, ui) {
					//console.log('ui: ', ui);
					tinyMCE.get('editor').remove();
					$('#editor').remove();
				}

			});

			$('#dialog').dialog('option', 'title', 'Edit');
			$('#dialog').dialog('option', 'modal', true);
			$('#dialog').dialog('option', 'buttons', {
				'Cancel': function() {
					$(this).dialog('close');
				},
				'OK': function() {
					var content = tinyMCE.get('editor').getContent();
					$('#content').html(content);
					$(this).dialog('close');
				}
			});

//			$('#dialog').html('<textarea name="editor" id="editor"><\/textarea>');
			$('#dialog').html('<textarea name="editor" id="editor"></textarea>');
			$('#dialog').dialog('open');
			tinyMCE.init({
				mode : "textareas",
				theme : "advanced",
				plugins : "safari,pagebreak,style,layer,table,save,advhr,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
				theme_advanced_buttons1 : "pagebreak,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
				theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
				theme_advanced_buttons3 : "tablecontrols",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_statusbar_location : "bottom",
				theme_advanced_resizing : true,
				extended_valid_elements: "style[*]",
				width: "800",
				height: "600",


				setup : function(ed) {
					ed.onInit.add(function(ed) {
						//alert('Editor is done: ' + ed.id);
						tinyMCE.get('editor').setContent($('#content').html());
						tinyMCE.execCommand('mceRepaint');
					});

					/*
					ed.onPreInit.add(function(ed) {
						alert("preinit");
						console.debug('PreInit: ' + ed.id);
					});
					*/

					/*
					ed.onChange.add(function(ed, l) {
						alert('Editor contents was modified. Contents: ' + l.content);
					});
					*/

					/*
					ed.onEvent.add(function(ed, e) {
						console.debug('Editor event occured: ' + e.target.nodeName);
					});
					*/
				}


		 	});
			return false;

	});



	});