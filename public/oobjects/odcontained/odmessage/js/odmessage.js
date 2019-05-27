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
        return {id : this.id, value: this.buttons[type], event: 'click', object : this.objet, type: type};
    },
};