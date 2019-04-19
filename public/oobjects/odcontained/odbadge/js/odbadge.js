function odbadge(obj) {
    this.id = obj.attr('id');
    this.contenu = obj.attr('content');
    this.data = obj.data();
}

odbadge.prototype = {
    getData: function (evt) {
        // var chps = "id=" + this.id + "&value='" + this.contenu + "'";
        // return chps;
        return {id : this.id, value: this.contenu, event: evt, object : this.objet};
    },
    setData: function (data) {
        this.contenu = data;
        $("#"+this.id).innerHTML(data);
    }
};