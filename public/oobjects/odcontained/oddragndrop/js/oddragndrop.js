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
		return {id: this.id, value : null, event : evt, object : this.objet};
	},
	setData: function (data) {

	},
};