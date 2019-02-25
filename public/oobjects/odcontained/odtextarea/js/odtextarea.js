function odtextarea(obj) {
    this.id = obj.attr('id');
    this.contenu = obj.find("textarea").val();
    this.objet  = obj.data('objet');
    this.data = obj.data();
}

odtextarea.prototype = {
    getData: function (evt) {
        var content = "";
        if (this.data['wysiwyg'] == true) {
            content = tinyMCE.activeEditor.getContent();
        } else {
            content = this.contenu;
        }
        var chps = "id=" + this.id + "&value='" + content + "'";
        chps = chps + "&object='" + this.objet + "'";
        return chps;
    },
    setData: function (data) {
        this.contenu = data;
        $("#"+this.id+"Textarea").innerHTML(data);
    }
};