function odtextarea(obj) {
    this.id = obj.attr('id');
    this.contenu = obj.find(this.id+"Textarea").innerHTML();
    this.data = obj.data();
}

odtextarea.prototype = {
    getData: function (evt) {
        let chps = "id=" + this.id + "&value='" + this.contenu + "'";
        return chps;
    },
    setData: function (data) {
        this.contenu = data;
        $("#"+this.id+"Textarea").innerHTML(data);
    }
};