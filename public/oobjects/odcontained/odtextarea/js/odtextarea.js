function odtextarea(obj) {
    this.id = obj.attr('id');
    this.contenu = obj.find("textarea").val();
    this.data = obj.data();
}

odtextarea.prototype = {
    getData: function (evt) {
        var chps = "id=" + this.id + "&value='" + this.contenu + "'";
        chps = chps + "&object='"+this.data('objet')+"'";
        return chps;
    },
    setData: function (data) {
        this.contenu = data;
        $("#"+this.id+"Textarea").innerHTML(data);
    }
};