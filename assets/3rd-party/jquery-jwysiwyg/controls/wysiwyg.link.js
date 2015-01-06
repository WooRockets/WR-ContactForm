/**
 * Controls: Link plugin
 *
 * Depends on jWYSIWYG
 *
 * By: Esteban Beltran (academo) <sergies@gmail.com>
 */
(function ($) {
	"use strict";

	if (undefined === $.wysiwyg) {
		throw "wysiwyg.link.js depends on $.wysiwyg";
	}

	if (!$.wysiwyg.controls) {
		$.wysiwyg.controls = {};
	}

	/*
	* Wysiwyg namespace: public properties and methods
	*/
	$.wysiwyg.controls.link = {
		init: function (Wysiwyg) {
			var self = this, adialog, elements, dialog, url, a, selection,
				formLinkHtml, dialogReplacements, key, translation, regexp,
				baseUrl, img;

			dialogReplacements = {
				legend: "Insert Link",
				url   : "Link URL",
				title : "Link Title",
				target: "Link Target",
				submit: "Insert Link",
				reset: "Cancel"
			};

			formLinkHtml = '<form class="wysiwyg" id="wysiwyg-linkInsert"><fieldset>' +
				'<div class="form-row"><label>{url}:</label><div class="form-row-value"><input type="text" name="linkhref" value="" /></div></div>' +
				'<div class="form-row"><label>{title}:</label><div class="form-row-value"><input type="text" name="linktitle" value="" /></div></div>' +
				'<div class="form-row"><label>{target}:</label><div class="form-row-value"><input type="text" name="linktarget" value="" /></div></div>' +
				'<div class="form-row form-row-last"><label></label><div class="form-row-value"><input type="submit" class="wysiwyg-standard-btn" value="{submit}"/> ' +
				'<input type="reset" class="wysiwyg-standard-btn" value="{reset}"/></div></div></fieldset></form>';

			for (key in dialogReplacements) {
				if ($.wysiwyg.i18n) {
					translation = $.wysiwyg.i18n.t(dialogReplacements[key], "dialogs.link");

					if (translation === dialogReplacements[key]) { // if not translated search in dialogs 
						translation = $.wysiwyg.i18n.t(dialogReplacements[key], "dialogs");
					}

					dialogReplacements[key] = translation;
				}

				regexp = new RegExp("{" + key + "}", "g");
				formLinkHtml = formLinkHtml.replace(regexp, dialogReplacements[key]);
			}

			a = {
				self: Wysiwyg.dom.getElement("a"), // link to element node
				href: "http://",
				title: "",
				target: ""
			};

			if (a.self) {
				a.href = a.self.href ? a.self.href : a.href;
				a.title = a.self.title ? a.self.title : "";
				a.target = a.self.target ? a.self.target : "";
			}

			adialog = new $.wysiwyg.dialog(Wysiwyg, {
				"title"   : dialogReplacements.legend,
				"content" : formLinkHtml,
				"open"    : function (e, dialog) {
					dialog.find("input[name=linkhref]").val(a.href);
					dialog.find("input[name=linktitle]").val(a.title);
					dialog.find("input[name=linktarget]").val(a.target);
					dialog.find("form#wysiwyg-linkInsert").submit(function (e) {
						e.preventDefault();
						var url = dialog.find("input[name=linkhref]").val(),
						    title = dialog.find("input[name=linktitle]").val(),
						    target = dialog.find("input[name=linktarget]").val(),
						    baseUrl,
						    img;

						if (Wysiwyg.options.controlLink.forceRelativeUrls) {
							baseUrl = window.location.protocol + "//" + window.location.hostname;
							if (0 === url.indexOf(baseUrl)) {
								url = url.substr(baseUrl.length);
							}
						}

						if (a.self) {
							if ("string" === typeof (url)) {
								if (url.length > 0) {
									// to preserve all link attributes
									$(a.self).attr("href", url).attr("title", title).attr("target", target);
								} else {
									$(a.self).replaceWith(a.self.innerHTML);
								}
							}
						} else {
							//Do new link element
							selection = Wysiwyg.getRangeText();
							img = Wysiwyg.dom.getElement("img");

							if ((selection && selection.length > 0) || img) {
								if ("string" === typeof (url)) {
									if (url.length > 0) {
										Wysiwyg.editorDoc.execCommand("createLink", false, url);
									} else {
										Wysiwyg.editorDoc.execCommand("unlink", false, null);
									}
								}

								a.self = Wysiwyg.dom.getElement("a");

								$(a.self).attr("href", url).attr("title", title);

								/**
								 * @url https://github.com/akzhan/jwysiwyg/issues/16
								 */
								$(a.self).attr("target", target);
							} else if (Wysiwyg.options.messages.nonSelection) {
								window.alert(Wysiwyg.options.messages.nonSelection);
							}
						}

						Wysiwyg.saveContent();

						adialog.close();
						return false;
					});
					dialog.find("input:reset").click(function (e) {
						e.preventDefault;
						adialog.close();
						return false;
					});
				}
			});

			adialog.open();

			$(Wysiwyg.editorDoc).trigger("editorRefresh.wysiwyg");
		}
	};

	$.wysiwyg.createLink = function (object, url, title) {
		return object.each(function () {
			var oWysiwyg = $(this).data("wysiwyg"),
				selection;

			if (!oWysiwyg) {
				return this;
			}

			if (!url || url.length === 0) {
				return this;
			}

			selection = oWysiwyg.getRangeText();
			// ability to link selected img - just hack
			var internalRange = oWysiwyg.getInternalRange();
			var isNodeSelected = false;
			if (internalRange && internalRange.extractContents) {
				var rangeContents = internalRange.cloneContents();
				if (rangeContents!=null && rangeContents.childNodes && rangeContents.childNodes.length>0)
					isNodeSelected = true;
			}
			
			if ( (selection && selection.length > 0) || isNodeSelected ) {
				if ($.browser.msie) {
					oWysiwyg.ui.focus();
				}
				oWysiwyg.editorDoc.execCommand("unlink", false, null);
				oWysiwyg.editorDoc.execCommand("createLink", false, url);
			} else {
				if (title) {
					oWysiwyg.insertHtml('<a href="'+url+'">'+title+'</a>');
				} else {
					if (oWysiwyg.options.messages.nonSelection) 
						window.alert(oWysiwyg.options.messages.nonSelection);
				}
			}
			return this;
		});
	};
})(jQuery);
