function odmessage(obj) {
    this.id         = obj.attr('id');
    let btns        = $('.lobibox-footer').find('button');

    let buttons     = [];
    $.each(btns, function () {
        buttons[$(this).data('type')] =  $(this).val();
    });
    this.buttons    = buttons;
}

odmessage.prototype = {
    getData: function (type) {
        // let chps = "id=" + this.id + "&type='" + type + "'";
        // chps = chps + "&value='" + this.buttons[type] + "'";
        //
        // return chps;
        return {id : this.id, value: this.buttons[type], event: evt, object : this.objet, type: type};
    },
    setData: function (type) {
        // ??? utile ???
    },
};