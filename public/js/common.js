if(typeof(_TB_) == 'undefined') var _TB_ = '';
var alertObj = '';
var listForm = document.dataForm;
var servicePing = 0;
var processing = false;

String.prototype.replaceAll = function(org, dest){
    return this.split(org).join(dest);
}

String.prototype.textCut = function(len){
    var str = this;
    var s = 0;
    for (var i=0; i<str.length; i++) {
        s += (str.charCodeAt(i) > 128) ? 1 : 1;
        if (s > len) return str.substring(0,i);
    }
    return str;
}

function menuReset(w){
    if(w > 1200){
        $('body').addClass('menuOpen');
        $('.leftMenu>.mobileMenu>span').html('keyboard_arrow_left');
    }else{
        $('body').removeClass('menuOpen');
        $('.leftMenu>.mobileMenu>span').html('keyboard_arrow_right');
    }
}

function numberWithCommas(x){
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function doNotReload(){
    if( (event.ctrlKey == true && (event.keyCode == 78 || event.keyCode == 82)) || (event.keyCode == 116) ) {
        winAlert('ì´ íŽ˜ì´ì§€ëŠ” [ìƒˆë¡œê³ ì¹¨] ê¸°ëŠ¥ì´ [ê¸ˆì§€]ëœ íŽ˜ì´ì§€ìž…ë‹ˆë‹¤.<br />ë‹¤ë¥¸ ì–´ë– í•œ ë°©ë²•ìœ¼ë¡œë„ [ìƒˆë¡œê³ ì¹¨]ì„<br />ì‹œë„í•˜ì§€ ì•Šê¸°ë¥¼ ê¶Œìž¥í•©ë‹ˆë‹¤.');
        event.keyCode = 0;
        event.cancelBubble = true;
        event.returnValue = false;
    }
}

// ì²¨ë¶€ ì´ë¯¸ì§€ ë¯¸ë¦¬ë³´ê¸°
var setPreview = function(opt){
	var inputFile = opt.inputFile.get(0);
	var img = opt.img.get(0);
	var prt = opt.inputFile.parent().parent().parent().parent();
	var filename = inputFile.files[0].name.split('.');
	var ext = filename[filename.length-1];
	//console.log();
	// FileReader
	if(window.FileReader){
		// image íŒŒì¼ë§Œ
		if(!inputFile.files[0].type.match(/image\//)){
			//prt.addClass('noimg');
			return;
		}
        if(!prt.hasClass('on')) prt.addClass('on');
		// preview
		try{
			var reader = new FileReader();
			reader.onload = function(e){
                opt.inputFile.siblings('img').removeClass('off');
                console.log(img);
                $(opt.img).attr('src', e.target.result);
    			//img.src = e.target.result;
    			// img.style.width  = opt.w + 'px';
    			// img.style.height = opt.h + 'px';
    			//img.style.display = '';
			}
			reader.readAsDataURL(inputFile.files[0]);
		}catch(e){
			// exception...
		}
		// img.filters (MSIE)
	}else if(img.filters){
		inputFile.select();
		inputFile.blur();
		var imgSrc = document.selection.createRange().text;

		img.style.width  = opt.w + 'px';
		img.style.height = opt.h + 'px';
		img.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(enable='true',sizingMethod='scale',src=\""+imgSrc+"\")";
		img.style.display = '';
		// no support
	}else{
		// Safari5, ...
	}
}

$(document).ready(function(){
    menuReset($(window).width());
    $(window).bind('resize', function(){
        menuReset($(this).width());
    });

    $('.leftMenu>.mobileMenu').bind('click', function(){
        if(!$('body').hasClass('menuOpen')){
            $(this).find('span').html('keyboard_arrow_left');
            $('body').addClass('menuOpen');
        }else{
            $(this).find('span').html('keyboard_arrow_right');
            $('body').removeClass('menuOpen');
        }
    });

    $('.leftMenu>ul>li.dropDown>a').bind('click', function(e){
        e.preventDefault();
        if($(this).parent().hasClass('on')){
            $(this).parent().removeClass('on');
        }else{
            $('.leftMenu>ul>li.dropDown').removeClass('on');
            $(this).parent().addClass('on');
        }
    });

    if(_TB_) ajaxGetList();
    $(document).on('mouseover', '.table01 tbody tr:not(.dark, .expire)', function(){
        $(this).addClass('on');
    });
    $(document).on('mouseout', '.table01 tbody tr:not(.dark, .expire)', function(){
        $(this).removeClass('on');
    });
    $('#selState, #selState2, #selState3').bind('change', function(){
        listForm.page.value = "";
        ajaxGetList();
    });
    $('.listReload').bind('change', function(){
        listForm.page.value = "";
        ajaxGetList();
    });
    $('#selSido').bind('change', function(){
        $.post(_URL+'/partner/selGugun', {sido: $(this).val()}, function(data){
            $('#selGugun').html(data);
            listForm.page.value = "";
            ajaxGetList();
        });
    });
    $('.searchWrap .custom_chk').bind('click', function(e){
        e.preventDefault();
        if($(this).find('input').prop('checked') == true){
            $(this).find('input').prop('checked', false);
            $(this).removeClass('on');
        }else{
            $(this).find('input').prop('checked', true);
            $(this).addClass('on');
        }
        listForm.page.value = "";
        ajaxGetList();
    });

    /*$('#ymd').bind('change', function(){
        ajaxGetList();
    });*/
    $('.table01 .sort').bind('click', function(e){
        e.preventDefault();
        $('.table01 .sort').not($(this)).removeClass('up');
        $('.table01 .sort').not($(this)).removeClass('down');

        listForm.sort.value = $(this).attr('href');
        if(!$(this).hasClass('up') && !$(this).hasClass('down')){
            $(this).addClass('up');
            listForm.sod.value = 'ASC';
        }else if($(this).hasClass('up')){
            $(this).removeClass('up');
            $(this).addClass('down');
            listForm.sod.value = 'DESC';
        }else{
            $(this).removeClass('down');
            listForm.sod.value = '';
            listForm.sort.value = '';
        }
        ajaxGetList();
    });
    $('#btnSearch').bind('click', function(e){
        e.preventDefault();
        if((listForm.selField.value && listForm.stx.value) || (listForm.sdate.value && listForm.edate.value)){
            listForm.page.value = "";
            ajaxGetList();
            return false;
        }
    });
    /*$(document).on('click', '.pageWrap a.pg_page', function(e){
        e.preventDefault();
        listForm.page.value = $(this).attr('href');
        ajaxGetList();
        return false;
    });*/
    $('.dateInput').datepicker({
        dateFormat: 'yy-mm-dd',
        dayNamesMin: ['ì¼','ì›”','í™”','ìˆ˜','ëª©','ê¸ˆ','í† '],
        monthNames: ['1ì›”','2ì›”','3ì›”','4ì›”','5ì›”','6ì›”','7ì›”','8ì›”','9ì›”','10ì›”','11ì›”','12ì›”']
    });
    $(document).on('click', 'span.dateButton', function(){
        $(this).prev().focus();
    });
    $('.dateWrap>button').bind('click', function(){
        var start = $(this).parent().find('input').eq(0);
        var end = $(this).parent().find('input').eq(1);
        var sdate, edate;
        var now = new Date();
        var yy = now.getFullYear();
        var mm = now.getMonth()+1;
        if(mm < 10) mm = "0" + mm;
        var dd = now.getDate();
        if(dd < 10) dd = "0" + dd;

        if($(this).attr('id') != 'today'){
            var now2 = new Date();
            switch($(this).attr('id')){
                case 'yesterday': now2.setTime(now2.getTime() - (1*24*60*60*1000)); break;
                case '1week': now2.setTime(now2.getTime() - (7*24*60*60*1000)); break;
                case '2week': now2.setTime(now2.getTime() - (14*24*60*60*1000)); break;
                case '1month': now2.setMonth(now2.getMonth()-1); break;
                case '3month': now2.setMonth(now2.getMonth()-3); break;
                case '6month': now2.setMonth(now2.getMonth()-6); break;
                case '1year': now2.setYear(now2.getFullYear()-1); break;
            }
            var yy2 = now2.getFullYear();
            var mm2 = now2.getMonth()+1;
            if(mm2 < 10) mm2 = "0" + mm2;
            var dd2 = now2.getDate();
            if(dd2 < 10) dd2 = "0" + dd2;
        }
        switch($(this).attr('id')){
            case 'today': sdate = edate = String(yy)+'-'+String(mm)+'-'+String(dd); break;
            case 'yesterday': sdate = edate = String(yy2)+'-'+String(mm2)+'-'+String(dd2); break;
            case '1week':
            case '2week':
            case '1month':
            case '3month':
            case '6month':
            case '1year':
                sdate = String(yy2)+'-'+String(mm2)+'-'+String(dd2);
                edate = String(yy)+'-'+String(mm)+'-'+String(dd);
            break;
        }
        start.val(sdate);
        end.val(edate);
    });
    $('.detailLayer>.close>button').bind('click', function(){
        var pop = $(this).parent().parent();
        $("#overlayer").removeClass('on');
        pop.find('>.detail').scrollTop(0);
        pop.removeClass('on');
        pop.hide(500, function(){
            pop.find('>.detail').html('');
        });
        if(document.nodeForm != undefined){
            document.nodeForm.reset();
        }
    });
    $('#overlayer').bind('click', function(){
        $('.detailLayer>.close>button').click();
    });

    $('#chkall').bind('click', function(){
        if($(this).hasClass('on')){
            $(this).removeClass('on');
            $(".listCheckbox").prop('checked', false);
        }else{
            $(this).addClass('on');
            $(".listCheckbox").prop('checked', true);
        }
    });

    $('.searchWrap button.excelDown').bind('click', function(){
        listForm.target = 'hiddenframe';
        listForm.action = _URL+'/excelList';
        listForm.submit();
    });

    $('.boardTab.assignList>ul>li>a').bind('click', function(e){
        e.preventDefault();
        $('.boardTab.assignList>ul>li>a').removeClass('on');
        $(this).addClass('on');
        listForm.division.value = $(this).attr('href');
        ajaxGetList();
    });

    $(document).on('change', '.img_upload', function(){
        var prt = $(this).offsetParent().offsetParent().offsetParent().offsetParent();
        if(prt.hasClass('detailLayer')){
            var opt = {
    			inputFile: $(this),
    			img: $('.detailLayer '+$(this).attr('img_target')),
    			w: $('.detailLayer '+$(this).attr('img_target')).width(),
    			h: $('.detailLayer '+$(this).attr('img_target')).height()
    		};
        }else{
            var opt = {
    			inputFile: $(this),
    			img: $($(this).attr('img_target')),
    			w: $($(this).attr('img_target')).width(),
    			h: $($(this).attr('img_target')).height()
    		};
        }
		setPreview(opt);
	});

    $(document).on('keyup', 'input.money', function(e){
        var x;
        x = $(this).val().replace(/[^0-9]/g,'');
        x = x.replace(/,/g,'');
        $(this).val(x.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    });

    $(document).on('keyup', 'input.onlynum', function(e){
        if($(this).attr('type') == 'text'){
            var x;
            x = $(this).val().replace(/[^0-9]/g,'');
            $(this).val(x);
        }
    });

    $(document).on('click', '.winAlert>.bottom>button', function(e){
        var pop = $(this).parent().parent();
        $("#overlayer02").removeClass('on');
        pop.fadeOut('fast', function(){
            pop.find('.body, .bottom').empty();
            if(alertObj) alertObj.focus().select();
        });
    });

    $(document).on('click', '.winAlram>.bottom>button', function(e){
        var pop = $(this).parent().parent();
        pop.removeClass('on shake');
        pop.find('.body').empty();
    });

    $(document).on('click', '.btnLayer>button.btnMore', function(e){
        $(".btnLayer>div").removeClass('on');
        if($(this).siblings('div').hasClass('on')){
            $(this).siblings('div').removeClass('on');
        }else{
            $(this).siblings('div').addClass('on');
        }
    });


    $(document).mouseup(function(e){
        var container = $(".btnLayer");
        //console.log(e.target);
        if(!container.is(e.target) && container.has(e.target).length === 0){
            $(".btnLayer>div").removeClass('on');
        }
    });
});

$(window).load(function(){
    var _gap = ($('.tableWrap').hasClass('gallery')) ? 90 : 140;
    var _hh_ = $('.containerWrap>.inner').height() - $('.searchWrap').outerHeight(true) - _gap;
    //console.log(_hh_);
    //$('.tableWrap').outerHeight(_hh_);
    if($('.scrollWrap_y').length > 0){
        makeScrollOption('y', 59);
    }
    if($('.scrollWrap_x').length > 0){
        makeScrollOption('x', 100);
    }
    if($('.scrollWrap_yx').length > 0){
        makeScrollOption('yx', 100);
    }
});

function makeScrollOption(a, b){
    $('.scrollWrap_'+a).mCustomScrollbar({
        axis: a,
        theme: 'dark',
        scrollInertia: 300,
        scrollButtons: {
            enable: true,
            scrollType: "stepped",
            //scrollAmount: b
        }
    });
}

var addField = "";
function ajaxGetList(){
    var formData = new FormData($('#dataForm')[0]);
    //formData.append("table", _TB_);
    $.ajax({
        type: "post",
        url: _URL+"/dataList",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(data){
            console.log(data);
            //$('#totalSum').text(data.totalSum);
            $('#totalCount').text(numberWithCommas(data.total));
            $('#dataList tbody').html(data.content);
            $('.pageWrap').html(data.pageing);
            if(data.tb == 'serviceMatching'){
                $('#dataList .serviceDate').datepicker({
                    dateFormat: 'yy-mm-dd',
                    dayNamesMin: ['ì¼','ì›”','í™”','ìˆ˜','ëª©','ê¸ˆ','í† '],
                    monthNames: ['1ì›”','2ì›”','3ì›”','4ì›”','5ì›”','6ì›”','7ì›”','8ì›”','9ì›”','10ì›”','11ì›”','12ì›”'],
                    onSelect: function(date, inst){
                        serviceDateUpdate(date, inst.input.attr('sno'));
                    }
                });
            }
            if($('#dataList tbody>tr').size() >= 12) $('#dataList').addClass('end');
            else $('#dataList').removeClass('end');

            if(!processing){
                $('.scrollWrap_y').mCustomScrollbar("scrollTo", '0', {
                    scrollInertia: 1
                });
            }else{
                processing = false;
            }
            return false;
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
    return false;
}

function popDetail(tb, num){
    var pop = $('.detailLayer');
    $.ajax({
        type: "post",
        url: _URL+"/"+tb+"/detail",
        data: { no: num },
        dataType: "html",
        async: false,
        success: function(data){
            $(".detailLayer>.detail").html(data);
            $("#overlayer").addClass('on');
            pop.show(1, function(){
                pop.addClass('on');
            });
            return false;
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

function billCancel(tid){
    winAlert('[ê²°ì œ ì·¨ì†Œ] ì²˜ë¦¬ í•˜ì‹œê² ìŠµë‹ˆê¹Œ?', '', 'ì˜ˆ', 'ì•„ë‹ˆì˜¤');
    var link = (_TB_ == 'paymentList') ? 'billCancel02' : 'billCancel';
    $('.winAlert>.bottom>button:eq(1)').bind('click', function(){
        processing = true;
        $.ajax({
            type: "post",
            url: _URL+"/danal/"+link,
            data: { tid: tid },
            dataType: "json",
            async: false,
            success: function(data){
                console.log(data);
                switch(data.status){
                    case 100: winAlert('ê²°ì œê°€ [ì·¨ì†Œ]ë˜ì—ˆìŠµë‹ˆë‹¤.'); ajaxGetList(); break;
                    case 1000: winAlert(data.returnmsg); break;
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    });
}

function winAlert(str, a, b, c, d){
    var pop = $('.winAlert');
    var btn1 = (b) ? b : 'í™•ì¸';
    pop.removeClass('confirm');
    pop.find('.bottom>button').remove();
    str = str.replaceAll("[","<strong>");
    str = str.replaceAll("]","</strong>");
    pop.find('.body').html(str);
    pop.find('.bottom').prepend("<button type='button'>"+btn1+"</button>");
    if(c){
        pop.addClass('confirm');
        pop.find('.bottom').prepend("<button type='button'>"+c+"</button>");
    }
    if(d) pop.find('.bottom').last().addClass(d);
    if(a) alertObj = a;
    else alertObj = '';
    $("#overlayer02").stop().addClass('on');
    pop.stop().fadeIn();
}

function errorImg(t){
    console.log("new");
    t.parent().prepend('<div class="noimg"></div>');
    t.remove();
}