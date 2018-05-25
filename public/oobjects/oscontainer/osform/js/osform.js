function osform(obj) {
    this.id = obj.attr('id');
}

osform.prototype = {
    getData: function (evt) {
        var formData = "";
        var eltSelection = $("*[data-form='" + this.id + "']");

        $.each(eltSelection, function (i, selection) {
            var object     = selection.getAttribute('data-objet');
            if (object != null && object.substring(object.length - 6, object.length) !== 'button') {
                var evalString = "new "+object+'($("#'+selection.getAttribute('id')+'"));';
                var instance = eval(evalString);
                var datas = instance.getData('click');

                if (datas.length > 0) {
                    datas = datas.replaceAll("&", "§");
                    datas = datas.replaceAll("\'", "*");
                    formData = formData + "|" + datas;
                }
            }
        });
        if (formData.length > 0) {
            formData = formData.substr(1);
        }
        return formData;
    },
    setData: function (data) {
        var arrayData = datas.split("|");
        arrayData.each(function () {
            var id    = "";
            var value = "";
            var type  = "";

            dataObj = $(this).split("§");
            dataObj.each(function () {
                var pos = $(this).indexOf("=");
                var attr = $(this).substr(0, pos);

                switch (attr) {
                    case "id":
                        id = $(this).substr(pos +1);
                        break;
                    case "value":
                        value = $(this).substr(pos +1);
                        break;
                    case "type":
                        type = $(this).substr(pos +1);
                        break;
                }
            });

            var obj = $('#'+id);
            var evalString = "new "+obj.attr('data-objet')+'($("#'+obj.attr('id')+'#));';
            var instance = eval(evalString);
            var datas = instance.setData(value);
        })
    },
};