drag_n_drop_default_config = {
	previewFileIcon : '<img src="graphicobjecttemplating/icons/unknown.svg"/>'
}

function oddragndrop(obj) {
	this.id     = obj.attr('id');
	this.form   = obj.data('form');
	this.objet  = obj.data('objet');
	this.data   = obj.data();
}

oddragndrop.prototype = {
	getData: function (evt) {
		var val	= '';
		switch (evt) {
			case 'upload':
			case 'delete':
				val 	= null;
			default:
				var eltSelected = $("#"+this.id+" .file-preview .file-preview-thumbnails .file-preview-frame"+
				" file-thumbnail-footer .file-footer-caption .file-caption-info");
				$.each(eltSelected, function (i, selected) {
					val[i]	= selected.text();
				})
		}
		return {id: this.id, value : val, event : evt, object : this.objet};
	},
	setData: function (data) {
		// no need according to initialization function of file-input
	},
};