function odtextarea(obj) {
    this.id = obj.attr('id');
    this.contenu = obj.find("textarea").val();
    this.objet  = obj.data('objet');
    this.data = obj.data();
}

odtextarea.prototype = {
    getData: function (evt) {
        var content = "";
        if (this.data['wysiwyg']) {
            content = tinyMCE.activeEditor.getContent();
        } else {
            content = this.contenu;
        }
        return {id: this.id, value: content, object: this.objet, event : evt};
    },
    setData: function (data) {
        this.contenu = data;
        $("#"+this.id+"Textarea").innerHTML(data);
    }
};