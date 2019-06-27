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
		let val	= {};
		switch (true) {
			case (evt === 'upload' || evt === 'delete'):
				val 	= null;
				break;
			default:
				let files = $("#"+this.id+"Input").fileinput('getPreview');
								$.each(files.config, function (i, selected) {
					val[i]	= selected.key;
				});
		}
		return {id: this.id, value : val, event : evt, object : this.objet};
	},
	setData: function (data) {
		// no need according to initialization function of file-input
	},
};