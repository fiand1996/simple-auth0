$(function () {
    SimpleAuth.General();
    SimpleAuth.AjaxForms();
    SimpleAuth.sendTestEmail();
    SimpleAuth.TableRowRemove();
    SimpleAuth.TableRowFilter();
    SimpleAuth.DatePicker();
    SimpleAuth.Profile();
});

var SimpleAuth = {};

SimpleAuth.General = function () {

    if (typeof $.fn.datepicker == "function") {
        $.fn.datepicker.language['id-ID'] = {
            days: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
            daysShort: ['Min', 'Sen', 'Sel', 'Ra', 'Kam', 'Jum', 'Sab'],
            daysMin: ['Min', 'Sen', 'Sel', 'Ra', 'Kam', 'Jum', 'Sab'],
            months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Des'],
            today: 'Today',
            clear: 'Clear',
            dateFormat: 'mm/dd/yyyy',
            timeFormat: 'hh:ii aa',
            firstDay: 1
        };
    }

    if ($('.select2').length > 0) {
        $('.select2').select2();
    }

    $('input[type="checkbox"].icheck-flat-blue, input[type="radio"].icheck-flat-blue').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue'
    });

    $("body").on("input focus", ":input", function () {
        $(this).removeClass("is-invalid");
    });

    $('ul.sidebar-menu a').filter(function () {
        return this.href == window.location;
    }).parent().addClass('active');

    $('ul.treeview-menu a').filter(function () {
        return this.href == window.location;
    }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if (window.location.hash === "#_=_") {
        if (history.replaceState) {
            var cleanHref = window.location.href.split("#")[0];
            history.replaceState(null, null, cleanHref);
        } else {
            window.location.hash = "";
        }
    }

    $(window).on('load', function () {
        setTimeout(function () {
            $("body").removeClass("onprogress");
        }, 500);
    })

    // document.onreadystatechange = function () {
    //     var state = document.readyState
    //     if (state == 'complete') {
    //         $("body").removeClass("onprogress");
    //     }
    // }
}

SimpleAuth.AjaxForms = function () {
    var $form = $("#form-ajax");
    var $action = $form.find(":input[name='action']").val();
    var captcha;

    if ($('#recaptcha').length == 1) {
        onloadCallback = function () {
            captcha = grecaptcha.render(
                document.getElementById("recaptcha"), {
                    sitekey: $('#recaptcha').data("site-key"),
                    theme: $('#recaptcha').data("theme")
                }
            );
        }
    }

    $form.on("submit", function () {
        var submitable = true;

        $form.find(":input.required").not(":disabled").each(function () {
            if (!$(this).val()) {
                $(this).addClass("is-invalid");
                submitable = false;
            }
        });

        if ($form.find(":input[name='email']").length == 1 && !isValidEmail($form.find(":input[name='email']").val())) {
            $form.find(":input[name='email']").addClass("is-invalid");
            submitable = false;
        }

        if (submitable) {

            $("body").addClass("onprogress");
            $("#message").html("");

            $.ajax({
                url: $form.attr("action"),
                type: $form.attr("method"),
                dataType: 'jsonp',
                data: $form.serialize(),
                error: function () {
                    SimpleAuth.Alert("Ups! Terjadi kesalahan. Silahkan ulangi beberapa saat lagi!", "error");
                },

                success: function (resp) {
                    if (typeof resp.redirect === "string") {

                        setTimeout(function () {
                            window.location.href = resp.redirect;
                        }, 500);

                    } else if (typeof resp.message === "string") {

                        var result = resp.result || 0;
                        var reset = resp.reset || 0;
                        switch (result) {
                            case 1:
                                SimpleAuth.Alert(resp.message, "success");
                                if (reset) {
                                    $form[0].reset();
                                }
                                break;

                            case 2:
                                SimpleAuth.Alert(resp.message, "info");
                                break;

                            default:
                                SimpleAuth.Alert(resp.message, "error");
                                break;
                        }
                    } else {
                        SimpleAuth.Alert("Ups! Terjadi kesalahan. Silahkan ulangi beberapa saat lagi!", "error");
                    }

                    if ($('#recaptcha').length == 1) {
                        grecaptcha.reset(captcha);
                    }
                }
            });
        } else {
            SimpleAuth.Alert('Isi semua bidang yang wajib', "error");
        }

        return false;
    })
}

SimpleAuth.DatePicker = function () {
    $(".js-datepicker").each(function () {
        $(this).removeClass("js-datepicker");

        if ($(this).data("min-date")) {
            $(this).data("min-date", new Date($(this).data("min-date")))
        }

        if ($(this).data("start-date")) {
            $(this).data("start-date", new Date($(this).data("start-date")))
        }

        $(this).datepicker({
            language: "id-ID",
            dateFormat: "yyyy-mm-dd",
            timeFormat: "hh:ii",
            autoClose: true,
            timepicker: true,
            toggleSelected: false
        });
    })
}

SimpleAuth.TableRowRemove = function () {
    $("body").on("click", "button.remove-list-item", function () {
        var item = $(this).parents("tr"),
            tr = $(this).closest('tr').nextAll(),
            index = $(this).closest('tr').find('td strong').html(),
            id = $(this).data("id"),
            url = $(this).data("url"),
            name = $(this).data("name") ? $(this).data("name") : 'data';

        SimpleAuth.Confirm({
            title: "Yakin ingin menghapus " + name + "?",
            confirm: function () {
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'jsonp',
                    data: {
                        action: "remove",
                        id: id
                    },

                });

                item.fadeOut(500, function () {
                    item.remove();
                    tr.each(function () {
                        $(this).find('td strong').html(index);
                        index++;
                    });
                });
            }
        })
    });

    $('.row-checkall').on('ifChanged', function (event) {
        if (this.checked) {
            $('.row-checkbox').iCheck('check');
        } else {
            $('.row-checkbox').iCheck('uncheck');
        }
    });

    $('.row-checkall,.row-checkbox').on('ifChanged', function () {
        var dataList = [];
        $('.row-checkbox:checked').each(function () {
            dataList.push($(this).data("id"));
        });

        if (dataList.length > 0) {
            $(".rows-delete").html("Hapus masal (" + dataList.length + ")");
            $(".rows-delete").prop("disabled", false);
        } else {
            $(".rows-delete ").html("Hapus masal");
            $(".rows-delete").prop("disabled", true);
            $('.row-checkall').iCheck('uncheck');
        }
    });

    $("body").on("click", "button.rows-delete", function () {

        var dataList = [];
        $('.row-checkbox:checked').each(function () {
            dataList.push($(this).data("id"));
        });

        console.log(dataList.join());

        SimpleAuth.Confirm({
            title: "Yakin ingin menghapus " + dataList.length + " data?",
            confirm: function () {
                $.ajax({
                    url: $(this).data("url"),
                    type: 'POST',
                    dataType: 'jsonp',
                    data: {
                        action: "remove",
                        id: dataList.join()
                    },
                    complete: function () {
                        location.reload();
                    },
                });
            }
        })
    });
}

SimpleAuth.TableRowFilter = function () {

    $("form.filter-box").on("submit", function (ev) {
        var $form = $(this);
        if (($form.attr('method') || '').toLowerCase() != 'get') {
            return true;
        }
        ev.preventDefault();
        var bits_with_values = jQuery.grep(
            $form.serializeArray(),
            function (bit) {
                return !!bit.value;
            }
        );
        var new_qs = jQuery.param(bits_with_values);

        if (bits_with_values.length > 0) {
            location.href = location.pathname + '?' + new_qs;
        } else {
            location.href = location.pathname;
        }

        return false;
    });

    $("form.filter-box").find("select").on("change", function () {
        $("form.filter-box").trigger('submit');
    });
}

SimpleAuth.sendTestEmail = function () {
    $("body").on("click", ".btn-send-email", function () {
        var $this = $(this);
        var $email = $("#e-mail").val();

        if (isValidEmail($email)) {

            $("body").addClass("onprogress");

            $.ajax({
                url: $this.data("action"),
                type: "post",
                dataType: 'jsonp',
                data: {
                    action: "test-email",
                    email: $email
                },
                complete: function () {
                    $("body").removeClass("onprogress");
                },
                success: function (resp) {
                    if (resp.result == 1) {
                        $("#e-mail").val("");
                        SimpleAuth.Alert(resp.message, "success");
                    } else {
                        SimpleAuth.Alert(resp.message, "error");
                    }
                }
            });
        } else {
            SimpleAuth.Alert("Alamat email tujuan tidak valid!", "error");
        }
    })
}

SimpleAuth.Profile = function () {
    var cropper;
    var image = document.getElementById('img-upload');

    $(".js-resend-verification-email").on("click", function () {
        var $this = $(this);
        var $alert = $this.parents(".alert");

        if ($alert.hasClass("onprogress")) {
            return;
        }

        $alert.addClass('onprogress');
        $.ajax({
            url: $this.data("url"),
            type: 'POST',
            dataType: 'jsonp',
            data: {
                action: 'resend-email'
            },

            error: function () {
                $this.remove();
                $alert.find(".js-resend-result").html("Oops! An error occured. Please try again later!");
                $alert.removeClass("onprogress");
            },

            success: function (resp) {
                $this.remove();
                $alert.find(".js-resend-result").html(resp.message);
                $alert.removeClass("onprogress");
            }
        });
    });

    $('#input').on('change', function (e) {
        var files = e.target.files;
        var reader;
        var file;
        var url;

        var done = function (url) {
            $(this).value = '';
            image.src = url;
            $('#cropModal').modal({
                backdrop: 'static',
                keyboard: false
            });
        };

        if (files && files.length > 0) {
            file = files[0];
            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function (e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    $('#crop_button').on('click', function () {
        var imgurl = cropper.getCroppedCanvas().toDataURL();
        var img = document.createElement("img");
        img.src = imgurl;
        $("body").addClass("onprogress");
        cropper.getCroppedCanvas().toBlob(function (blob) {
            var formData = new FormData();
            formData.append('croppedImage', blob, 'event.png');
            formData.append('action', 'upload');
            $.ajax({
                url: window.location,
                method: "POST",
                data: formData,
                dataType: 'jsonp',
                processData: false,
                contentType: false,
                complete: function () {
                    $('#cropModal').modal('hide');
                    $("body").removeClass("onprogress");
                },
                success: function (resp) {
                    if (resp.result == 1) {
                        SimpleAuth.Alert(resp.message, "success");
                        $('.img-circle').attr('src', resp.img_url);
                    } else {
                        SimpleAuth.Alert(resp.message, "error");
                    }
                },
                error: function () {
                    SimpleAuth.Alert("Ups! Terjadi kesalahan. Silahkan ulangi beberapa saat lagi!", "error");
                }
            });
        });
    });

    $('#cropModal').on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
            viewMode: 2,
            aspectRatio: 1 / 1,
            crop: function (e) {
                console.log(e.detail.x);
                console.log(e.detail.y);
            }
        });
    }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
    });
}

SimpleAuth.Confirm = function (data = {}) {
    data = $.extend({}, {
        title: "Apakah kamu yakin?",
        content: "Tidak mungkin untuk mendapatkan kembali data yang dihapus!",
        confirmText: "Ya, Hapus",
        cancelText: "Batal",
        confirm: function () {},
        cancel: function () {},
    }, data);

    $.confirm({
        title: data.title,
        content: data.content,
        theme: 'material',
        animation: 'scale',
        closeAnimation: 'scale',
        animationSpeed: 400,
        animationBounce: 1,
        type: 'red',
        boxWidth: '30%',
        useBootstrap: false,
        buttons: {
            confirm: {
                text: data.confirmText,
                btnClass: "btn btn-danger",
                keys: ['enter'],
                action: typeof data.confirm === 'function' ? data.confirm : function () {}
            },
            cancel: {
                text: data.cancelText,
                btnClass: "btn btn-primary",
                keys: ['esc'],
                action: typeof data.cancel === 'function' ? data.cancel : function () {}
            },
        }
    });
}

SimpleAuth.Alert = function (text, type = 'success') {
    var $message = $("#message");
    var $parent = $("html, body");
    var top = $message.offset().top - 85;

    $parent.animate({
        scrollTop: top + "px"
    });

    $message.html('<div class="alert alert-' + type + '" role="alert">' + text + '</div>');
    $message.fadeTo(2500, 500).slideUp(500, function () {
        $message.alert('close');
    });
    $("body").removeClass("onprogress");
}

SimpleAuth.onprogress = function (status = 1) {
    if (status) {
        $("body").addClass("onprogress");
    } else {
        $("body").removeClass("onprogress");
    }
}

SimpleAuth.OauthInit = function (url, key) {
    SimpleAuth.FacebookOauth(url, key);
    SimpleAuth.GoogleOauth(url, key);
    SimpleAuth.TwitterOauth(url, key);
    SimpleAuth.GithubOauth(url, key);
}

SimpleAuth.Oauth = function (url, data) {
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'jsonp',
        data: data,
        error: function () {
            SimpleAuth.Alert("Ups! Terjadi kesalahan. Silahkan ulangi beberapa saat lagi!", "error")
            SimpleAuth.onprogress(0);
        },
        success: function (resp) {
            if (resp.result == 1) {
                window.location.href = resp.redirect;
            } else {
                SimpleAuth.Alert(resp.message, "error");
                SimpleAuth.onprogress(0);
            }
        }
    })
}

SimpleAuth.GoogleOauth = function (url, key) {
    $("body").on("click", "a.oauth-google", function () {
        OAuth.initialize(key);
        OAuth.popup('google').done(function (result) {
            result.me().then(data => {
                result.get('/plus/v1/people/me').then(me => {
                    var user = {
                        token: result.access_token,
                        userid: me.id,
                        email: data.email,
                        firstname: me.name.givenName,
                        lastname: me.name.familyName,
                        dialog: 'google'
                    };
                    SimpleAuth.Oauth(url, user);
                }).fail(function (err) {
                    SimpleAuth.Alert(err, "error");
                });
            });
            SimpleAuth.onprogress();
        }).fail(function (err) {
            SimpleAuth.Alert(err, "error");
        });
    });
}

SimpleAuth.FacebookOauth = function (url, key) {
    $("body").on("click", "a.oauth-facebook", function () {
        OAuth.initialize(key);
        OAuth.popup('facebook').done(function (result) {
            result.me().then(data => {
                var user = {
                    token: result.access_token,
                    userid: data.id,
                    email: data.email,
                    firstname: data.firstname,
                    lastname: data.lastname,
                    dialog: 'facebook'
                };
                SimpleAuth.Oauth(url, user);
            });
            SimpleAuth.onprogress();
        }).fail(function (err) {
            SimpleAuth.Alert(err, "error");
        });
    });
}

SimpleAuth.TwitterOauth = function (url, key) {
    $("body").on("click", "a.oauth-twitter", function () {
        OAuth.initialize(key);
        OAuth.popup('twitter').done(function (result) {
            result.me().then(data => {
                var user = {
                    token: result.oauth_token,
                    userid: data.id,
                    email: data.email,
                    firstname: data.name.split(' ').slice(0, -1).join(' '),
                    lastname: data.name.split(' ').slice(-1).join(' '),
                    dialog: 'twitter'
                };
                SimpleAuth.Oauth(url, user);
            });
            SimpleAuth.onprogress();
        }).fail(function (err) {
            SimpleAuth.Alert(err, "error");
        });
    });
}

SimpleAuth.GithubOauth = function (url, key) {
    $("body").on("click", "a.oauth-github", function () {
        OAuth.initialize(key);
        OAuth.popup('github').done(function (result) {
            result.me().then(data => {
                var user = {
                    token: result.access_token,
                    userid: data.id,
                    email: data.email,
                    firstname: data.name.split(' ').slice(0, -1).join(' '),
                    lastname: data.name.split(' ').slice(-1).join(' '),
                    dialog: 'github'
                };
                SimpleAuth.Oauth(url, user);
            });
            SimpleAuth.onprogress();
        }).fail(function (err) {
            SimpleAuth.Alert(err, "error");
        });
    });
}

function isValidEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}