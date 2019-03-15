
function creaateThumbnailSrc(imgSrc, width, height, keepRatio = true) {
	var iw	= imgSrc.width;
	var ih	= imgSrc.height;

	if (width !== 0 || height !== 0) {
	    if (width === 0) { width = iw; }
	    if (height === 0) { height = ih; }
        if (keepRatio) {
            if (iw > ih) {
                if (iw > width) {
                    ih *= width / iw;
                    iw = width;
                }
            } else {
                if (ih > height) {
                    iw *= height / ih;
                    ih = height;
                }
            }
        }
    }

	var canvas = document.createElement('canvas');
	canvas.width = iw;
	canvas.height = ih;
	imgSrc.width = iw;
    imgSrc.height = ih;
	var ctx = canvas.getContext('2d');
	ctx.drawImage(imgSrc, 0, 0, iw, ih);
	return canvas.toDataURL(imgSrc.type);
};

function makeBtnsCtrl(imgId, fileName, thumbCtrls) {
    var btnView  = "<a href='file/view/[NAME]' target='_blank' class='btn btn-info btn-xs [ORDER]' style='margin-left: 2px;margin-right: 2px'><i class='fa fa-eye'></i></a>";
    var btnDload = "<a href='file/download/[NAME]' target='_blank' class='btn btn-primary btn-xs [ORDER]' style='margin-left: 2px;margin-right: 2px'><i class='fa fa-download'></i></a>";
    var btnRmove = "<button class='btn btn-warning btn-xs [ORDER]' style='margin-left: 2px;margin-right: 2px' date-file='[FILE]' ><i class='fa fa-trash-o'></i></button>";
    var btnCtrls = '';
    var btnFirst = 0;

    if (thumbCtrls.view !== false) {
        btnCtrls = btnCtrls + btnView;
        btnCtrls = btnCtrls.replace('[ORDER]', 'thumb first');
        btnCtrls = btnCtrls.replace('[NAME]', imgId);
        btnFirst++;
    }

    if (thumbCtrls.dload !== false) {
        btnCtrls = btnCtrls + btnDload;
        if (btnFirst === 0) {
            btnCtrls = btnCtrls.replace('[ORDER]', 'thumb first');
        } else {
            btnCtrls = btnCtrls.replace('[ORDER]', 'thumb other'+btnFirst);
        }
        btnCtrls = btnCtrls.replace('[NAME]', imgId);
        btnFirst++;
    }

    if (thumbCtrls.rmove !== false) {
        btnCtrls = btnCtrls + btnRmove;
        if (btnFirst == 0) {
            btnCtrls = btnCtrls.replace('[ORDER]', 'thumb first');
        } else {
            btnCtrls = btnCtrls.replace('[ORDER]', 'thumb other'+btnFirst);
        }
        btnCtrls = btnCtrls.replace('[FILE]', fileName);
    }
    return btnCtrls;
}

function callAjax(chps, image) {
    $.ajax({
        type: 'POST',
        url: $("#gotcallback").text(),
        data: chps,
        success: function (data) {
            data = JSON.parse(data);
            $.each(data, function (i, ret) {
                let id   = "";
                let mode = "";
                let code = "";
                $.each(ret, function (j, part) {
                    console.log('j='+j);
                    console.log('part='+part);
                    switch (j) {
                        case 'id':
                            id = part;
                            break;
                        case 'mode':
                            mode = part;
                            break;
                        case 'code':
                            code = part;
                            break;
                    }
                });
                switch (mode) {
                    case 'addFile':
                        $('#'+id+' .messageDND').css('display', 'none');
                        $('#'+id+' .previewDND').css('display', 'block');
                        var thumbWidth = $('#'+id+' .previewDND').data('thumb-width');
                        var thumbHeight = $('#'+id+' .previewDND').data('thumb-height');
                        var thumbRatio = $('#'+id+' .previewDND').data('thumb-ratio');
                        var thumbView = $('#'+id+' .previewDND').data('thumb-view');
                        var thumbDload = $('#'+id+' .previewDND').data('thumb-dload');
                        var thumbRmove = $('#'+id+' .previewDND').data('thumb-rmove');
                        var thumbCtrls = {'view': thumbView, 'dload': thumbDload, 'rmove': thumbRmove};
                        var thumbOccur = document.createElement('div');
                        var thumbImg = new Image();
                        thumbImg.src = creaateThumbnailSrc(image, thumbWidth, thumbHeight, thumbRatio);
                        var name = code.name;
                        name = name.replace(/\./g, '-');
                        thumbImg.id = id+'_'+name;
                        $(thumbImg).appendTo(thumbOccur);
                        thumbOccur.id = name+'-Vignette';
                        $(thumbOccur).append(makeBtnsCtrl(name, code.name, thumbCtrls));
                        $(thumbOccur).addClass('vignette');
                        $(thumbOccur).data('fichier', code.name);
                        $(thumbOccur).appendTo('#'+id+' .previewDND');
                        break;
                    case 'rmFile':
                        $('#'+code.name).remove();
                        if (code.count == 0) {
                            $('#'+id+' .messageDND').css('display', 'block');
                            $('#'+id+' .previewDND').css('display', 'none');
                        }
                        break;
                    default:
                        break;
                };
            });
        },
        error: function (xhr, textStatus, errorThrown) {
            if (xhr.status === 0) {
                alert('Not connected. Verify Network.');
            } else if (xhr.status === 404) {
                alert('Requested page not found. [404]');
            } else if (xhr.status === 500) {
                alert('Server Error [500].');
            } else if (errorThrown === 'parsererror') {
                alert('Requested JSON parse failed.');
            } else if (errorThrown === 'timeout') {
                alert('Time out error.');
            } else if (errorThrown === 'abort') {
                alert('Ajax request aborted.');
            } else {
                alert('Remote sever unavailable. Please try later, ' + xhr.status + "//" + errorThrown + "//" + textStatus);
            }
        }
    });
}

function oeddragndrop(obj) {
    this.id         = obj.attr('id');
    this.form       = obj.data('form') ? obj.data('form') : '';
    this.objet      = obj.data('objet');
    var dragNDrop   = obj.find('.dragNDrop');
    this.extAllows  = (dragNDrop.data('acceptedFiles') != undefined) ? dragNDrop.data('acceptedFiles') : '';
    this.sizeMin    = (dragNDrop.data('minFileSize') != undefined) ? dragNDrop.data('minFileSize') * 1024 * 1024 : 0;
    this.sizeMax    = (dragNDrop.data('maxFileSize') != undefined) ? dragNDrop.data('maxFileSize') * 1024 * 1024 : 0;
    var preview     = dragNDrop.find('.previewDND');
    this.thumbView  = preview.data('thumb-view');
    this.thumbDload = preview.data('thumb-dload');
    this.thumbRmove = preview.data('thumb-rmove');
    this.datas  = obj.data();
}

oeddragndrop.prototype = {
    validate: function(files) {
        var f = files[0];
        var extension = f.name.substr( (f.name.lastIndexOf('.') +1) );
        if (this.extAllows.length > 0 && this.extAllows.indexOf(extension) >= 0) {
            if (this.sizeMin != 0 || this.sizeMax != 0) {
                if (this.sizeMin != 0 && f.size < this.sizeMin) { return false; }
                if (this.sizeMax != 0 && f.size > this.sizeMax) { return false; }
            }
        }
        return true;
    },
    upload: function (files, event) {
        if (this.validate(files) && event == 'dropIn') {
			var fichier = files[0];
            var reader  = new FileReader();
			var valeur  = this.value != undefined ? this.value : '';
			var datas   = "id=" + this.id + "&value='" + valeur + "'" + "&event='dropIn'";
			datas       = datas + "&object='" + this.objet + "'&";

            // When the image is loaded,
            // run handleReaderLoad function
            // reader.onload = this.handleReaderLoad;
            reader.onload = (function(fic, chps) {
				return function(evt) {
					var pic     = {};
                    var tabDts  = [];
                    var image   = new Image();

                    var name    = fic.name;
					pic.file    = evt.target.result.split(',')[1];
                    image.src   = evt.target.result;

                    var str     = $.param(pic);
					chps        = chps + 'name=' + name + '&' + str;

					callAjax(chps, image);
                };
			})(fichier, datas);

            // Read in the image file as a data URL.
            reader.readAsDataURL(fichier);
        }
    },
    remove: function (file, event) {
        if (event == 'dropOut') {
            var vignette  = file.parent();
            var fileName  = $(vignette).data('fichier');
            var valeur    = this.value != undefined ? this.value : '';
            var datas     = "id=" + this.id + "&value='" + valeur + "'" + "&event='dropOut'" + "&object='" + this.objet;
            datas         = datas + "'&name='" + vignette.get(0).id + "'&file='" + fileName + "'";

            callAjax(datas, null);
        }
    },
};
