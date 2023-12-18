if (typeof(_TB_) == 'undefined') var _TB_ = '';
let alertObj = '';
let servicePing = 0;
let processing = false;
const listForm = document.dataForm;

String.prototype.replaceAll = function(org, dest) {
    return this.split(org).join(dest);
}

String.prototype.textCut = function(len) {
    const str = this;
    let s = 0;
    for (let i=0; i<str.length; i++) {
        s += (str.charCodeAt(i) > 128) ? 1 : 1;
        if (s > len) return str.substring(0,i);
    }
    return str;
}

function menuReset(w) {
    if (w > 1200) {
        $('body').addClass('menuOpen');
        $('.leftMenu>.mobileMenu>span').html('keyboard_arrow_left');
    } else {
        $('body').removeClass('menuOpen');
        $('.leftMenu>.mobileMenu>span').html('keyboard_arrow_right');
    }
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$(document).ready(function() {
    menuReset($(window).width());
    $(window).bind('resize', function() {
        menuReset($(this).width());
    });

    $('.leftMenu>.mobileMenu').bind('click', function() {
        if (!$('body').hasClass('menuOpen')) {
            $(this).find('span').html('keyboard_arrow_left');
            $('body').addClass('menuOpen');
        } else {
            $(this).find('span').html('keyboard_arrow_right');
            $('body').removeClass('menuOpen');
        }
    });

    $('.leftMenu>ul>li.dropDown>a').bind('click', function(e) {
        e.preventDefault();
        if ($(this).parent().hasClass('on')) {
            $(this).parent().removeClass('on');
        } else {
            $('.leftMenu>ul>li.dropDown').removeClass('on');
            $(this).parent().addClass('on');
        }
    });

    if(_TB_) ajaxGetList();
    $(document).on('mouseover', '.table01 tbody tr:not(.dark, .expire)', function() {
        $(this).addClass('on');
    });
    $(document).on('mouseout', '.table01 tbody tr:not(.dark, .expire)', function() {
        $(this).removeClass('on');
    });
    $('#selState, #selState2, #selState3').bind('change', function() {
        listForm.page.value = "";
        ajaxGetList();
    });
    $('.listReload').bind('change', function() {
        listForm.page.value = "";
        ajaxGetList();
    });
    $('#selSido').bind('change', function() {
        $.post(_URL+'/partner/selGugun', {sido: $(this).val()}, function(data) {
            $('#selGugun').html(data);
            listForm.page.value = "";
            ajaxGetList();
        });
    });
    $('.searchWrap .custom_chk').bind('click', function(e) {
        e.preventDefault();
        if ($(this).find('input').prop('checked') == true) {
            $(this).find('input').prop('checked', false);
            $(this).removeClass('on');
        } else {
            $(this).find('input').prop('checked', true);
            $(this).addClass('on');
        }
        listForm.page.value = "";
        ajaxGetList();
    });

    /*$('#ymd').bind('change', function(){
        ajaxGetList();
    });*/
    $('.table01 .sort').bind('click', function(e) {
        e.preventDefault();
        $('.table01 .sort').not($(this)).removeClass('up');
        $('.table01 .sort').not($(this)).removeClass('down');

        listForm.sort.value = $(this).attr('href');
        if (!$(this).hasClass('up') && !$(this).hasClass('down')) {
            $(this).addClass('up');
            listForm.sod.value = 'ASC';
        } else if($(this).hasClass('up')) {
            $(this).removeClass('up');
            $(this).addClass('down');
            listForm.sod.value = 'DESC';
        } else {
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
        dateFormat: 'yy-mm-dd'
    });
    $(document).on('click', 'span.dateButton', function() {
        $(this).prev().focus();
    });
    $('.dateWrap>button').bind('click', function() {
        const start = $(this).parent().find('input').eq(0);
        const end = $(this).parent().find('input').eq(1);
        const now = new Date();
        let sdate, edate;
        let yy = now.getFullYear();
        let mm = now.getMonth()+1;
        if (mm < 10) mm = "0" + mm;
        let dd = now.getDate();
        if (dd < 10) dd = "0" + dd;

        if ($(this).attr('id') != 'today') {
            const now2 = new Date();
            switch ($(this).attr('id')) {
                case 'yesterday': now2.setTime(now2.getTime() - (1*24*60*60*1000)); break;
                case '1week': now2.setTime(now2.getTime() - (7*24*60*60*1000)); break;
                case '2week': now2.setTime(now2.getTime() - (14*24*60*60*1000)); break;
                case '1month': now2.setMonth(now2.getMonth()-1); break;
                case '3month': now2.setMonth(now2.getMonth()-3); break;
                case '6month': now2.setMonth(now2.getMonth()-6); break;
                case '1year': now2.setYear(now2.getFullYear()-1); break;
            }
            let yy2 = now2.getFullYear();
            let mm2 = now2.getMonth()+1;
            if (mm2 < 10) mm2 = "0" + mm2;
            let dd2 = now2.getDate();
            if (dd2 < 10) dd2 = "0" + dd2;
        }
        switch ($(this).attr('id')) {
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
    $('.detailLayer>.close>button').bind('click', function() {
        const pop = $(this).parent().parent();
        $("#overlayer").removeClass('on');
        pop.find('>.detail').scrollTop(0);
        pop.removeClass('on');
        pop.hide(500, function(){
            pop.find('>.detail').html('');
        });
        if (document.nodeForm != undefined) {
            document.nodeForm.reset();
        }
    });
    $('#overlayer').bind('click', function() {
        $('.detailLayer>.close>button').click();
    });

    $('#chkall').bind('click', function() {
        if ($(this).hasClass('on')) {
            $(this).removeClass('on');
            $(".listCheckbox").prop('checked', false);
        } else {
            $(this).addClass('on');
            $(".listCheckbox").prop('checked', true);
        }
    });

    $('.searchWrap button.excelDown').bind('click', function() {
        listForm.target = 'hiddenframe';
        listForm.action = _URL+'/excelList';
        listForm.submit();
    });

    $('.boardTab.assignList>ul>li>a').bind('click', function(e) {
        e.preventDefault();
        $('.boardTab.assignList>ul>li>a').removeClass('on');
        $(this).addClass('on');
        listForm.division.value = $(this).attr('href');
        ajaxGetList();
    });

    $(document).on('keyup', 'input.money', function(e) {
        let x;
        x = $(this).val().replace(/[^0-9]/g,'');
        x = x.replace(/,/g,'');
        $(this).val(x.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    });

    $(document).on('keyup', 'input.onlynum', function(e) {
        if ($(this).attr('type') == 'text') {
            let x;
            x = $(this).val().replace(/[^0-9]/g,'');
            $(this).val(x);
        }
    });

    $(document).on('click', '.winAlert>.bottom>button', function(e) {
        const pop = $(this).parent().parent();
        $("#overlayer02").removeClass('on');
        pop.fadeOut('fast', function(){
            pop.find('.body, .bottom').empty();
            if (alertObj) alertObj.focus().select();
        });
    });

    $(document).on('click', '.winAlram>.bottom>button', function(e) {
        const pop = $(this).parent().parent();
        pop.removeClass('on shake');
        pop.find('.body').empty();
    });

    $(document).on('click', '.btnLayer>button.btnMore', function(e) {
        $(".btnLayer>div").removeClass('on');
        if ($(this).siblings('div').hasClass('on')) {
            $(this).siblings('div').removeClass('on');
        } else {
            $(this).siblings('div').addClass('on');
        }
    });


    $(document).mouseup(function(e) {
        const container = $(".btnLayer");
        //console.log(e.target);
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $(".btnLayer>div").removeClass('on');
        }
    });
});

$(window).load(function() {
    const _gap = ($('.tableWrap').hasClass('gallery')) ? 90 : 140;
    const _hh_ = $('.containerWrap>.inner').height() - $('.searchWrap').outerHeight(true) - _gap;
    //console.log(_hh_);
    //$('.tableWrap').outerHeight(_hh_);
    if ($('.scrollWrap_y').length > 0) {
        makeScrollOption('y', 59);
    }
    if ($('.scrollWrap_x').length > 0) {
        makeScrollOption('x', 100);
    }
    if ($('.scrollWrap_yx').length > 0) {
        makeScrollOption('yx', 100);
    }
});

function makeScrollOption(a, b) {
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

let addField = "";
function ajaxGetList() {
    const formData = new FormData($('#dataForm')[0]);
    //formData.append("table", _TB_);
    $.ajax({
        type: "post",
        url: _URL+"/dataList",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(data) {
            console.log(data);
            //$('#totalSum').text(data.totalSum);
            $('#totalCount').text(numberWithCommas(data.total));
            $('#dataList tbody').html(data.content);
            $('.pageWrap').html(data.pageing);
            if (data.tb == 'serviceMatching') {
                $('#dataList .serviceDate').datepicker({
                    dateFormat: 'yy-mm-dd',
                    onSelect: function(date, inst) {
                        serviceDateUpdate(date, inst.input.attr('sno'));
                    }
                });
            }
            if ($('#dataList tbody>tr').size() >= 12) $('#dataList').addClass('end');
            else $('#dataList').removeClass('end');

            if (!processing) {
                $('.scrollWrap_y').mCustomScrollbar("scrollTo", '0', {
                    scrollInertia: 1
                });
            } else {
                processing = false;
            }
            return false;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
    return false;
}

function popDetail(tb, num) {
    const pop = $('.detailLayer');
    $.ajax({
        type: "post",
        url: _URL+"/"+tb+"/detail",
        data: { no: num },
        dataType: "html",
        async: false,
        success: function(data) {
            $(".detailLayer>.detail").html(data);
            $("#overlayer").addClass('on');
            pop.show(1, function() {
                pop.addClass('on');
            });
            return false;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

function winAlert(str, a, b, c, d) {
    const pop = $('.winAlert');
    const btn1 = (b) ? b : 'Confirm';
    pop.removeClass('confirm');
    pop.find('.bottom>button').remove();
    str = str.replaceAll("[","<strong>");
    str = str.replaceAll("]","</strong>");
    pop.find('.body').html(str);
    pop.find('.bottom').prepend("<button type='button'>"+btn1+"</button>");

    if (c) {
        pop.addClass('confirm');
        pop.find('.bottom').prepend("<button type='button'>"+c+"</button>");
    }

    if (d) pop.find('.bottom').last().addClass(d);

    if (a) alertObj = a;
    else alertObj = '';

    $("#overlayer02").stop().addClass('on');
    pop.stop().fadeIn();
}

function errorImg(t) {
    console.log("new");
    t.parent().prepend('<div class="noimg"></div>');
    t.remove();
}
