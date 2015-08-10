var webapp = function() {
    configinfo = null;
    notification = null;
}
webapp.prototype = {
    init: function() {
    },

    contact: function() {
        if(!$('#contact-form').valid()) {
            return false;
        }

        $('#contact').mask('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>&nbsp;送信しています。少々お待ちください...');
        this.wait(2000).done(function() {
            var values = $('#contact-form').serializeArray();
            var services = '';
            for(var i=0;i<values.length;i++) {
                if(values[i].name=='services') {
                    services += ((services!='')?'|':'')+values[i].value;
                }
            }
            $.ajax({
                type: 'POST',
                async: false,
                dataType: 'json',
                url: webappobj.configinfo.baseurl+'contact/send.json',
                data: {
                    officeora_token: fuel_csrf_token(),
                    name: $('#name').val(),
                    email: $('#email').val(),
                    subject: $('#subject').val(),
                    message: $('#message').val(),
                    services: services,
                },
                success: function(data) {
                    if(data.result) {
                        $('.loadmask-msg').html("<div>送信しました<br>できるだけ早く返信いたしますので、少々お待ちください。<br>有難うございました。<br><br><a class='btn btn-default' href='javascript:webappobj.doneContact()'>閉じる</a></div>");
                    } else {
                        $('.loadmask-msg').html("<div>送信に失敗しました...<br>後で再送してください。申し訳ございません。<br><br><a class='btn btn-default' href='javascript:webappobj.doneContact()'>閉じる</a></div>");
                    }
                }
            });
        });
    },

    doneContact: function() {
        $('#contact-form')[0].reset();
        $('#contact').unmask();
    },

    wait: function(msec) {
        var d = new $.Deferred;
        setTimeout(function() {
            d.resolve(msec);
        },msec);
        return d.promise();
    }
}
