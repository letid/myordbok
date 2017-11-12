/*
 * MyOrdbok
 */
(function(e, t) {
    e.fn.MyOrdbok = function(n) {
        var i = {
            tag: {
                f: "<form>",
                p: "<p>",
                i: "<input>",
                l: "<label>",
                t: "<textarea>",
                d: "<div>",
                u: "<ul>",
                o: "<ol>",
                li: "<li>",
                a: "<a>",
                s: "<span>",
                e: "<em>",
                strong: "<strong>",
                bold: "<b>",
                img: "<img>",
                h4: "<h4>"
            },
            name: {
                form: 'form[name="*"]',
                input: 'input[name="*"]',
                button: 'button[name="*"]',
                meta: 'meta[name="*"]',
                tag: "<*>",
                "class": ".",
                id: "#"
            },
            check: function(e) {
                return typeof e != "undefined" ? e : "";
            },
            data: {
                link: function(t) {
                    e.each(t, function(t, n) {
                        i[n] = e('link[rel="*"]'.replace("*", n)).attr("href");
                    });
                },
                meta: function(t) {
                    e.each(t, function(t, n) {
                        i[n] = e(i.name.meta.replace("*", n)).attr("content");
                    });
                }
            },
            Form: function(e) {
                return this.name.form.replace("*", e);
            },
            Input: function(e) {
                return this.name.input.replace("*", e);
            },
            Tag: function(e) {
                return this.name.tag.replace("*", e);
            },
            Class: function(e) {
                return this.name.class + e;
            },
            Id: function(e) {
                return this.name.id + e;
            },
            Char: function(t) {
                return e.map(t, function(t) {
                    return e.isNumeric(t) ? String.fromCharCode(t) : t;
                }).join("");
            },
            Url: function(t) {
                return e.map(t, function(t) {
                    if (e.isPlainObject(t)) {
                        return "?" + e.param(t);
                    } else if (t) {
                        return t.slice(-1) == "/" ? t.slice(0, -1) : t;
                    }
                }).join("/").replace("/?", "?");
            },
            Trim: function(e) {
                var t = /[^a-zA-Z0-9 ]/g;
                if (e.match(t)) {
                    e = e.replace(t, "");
                }
                return e.replace(/ /g, "");
            },
            store: {
                s: function(e, t, n) {
                    var i;
                    if (n) {
                        var a = new Date();
                        a.setTime(a.getTime() + n * 24 * 60 * 60 * 1e3);
                        i = "; expires=" + a.toGMTString();
                    }
                    document.cookie = escape(e) + "=" + escape(t) + i + "; path=/";
                },
                g: function(e) {
                    var t = escape(e) + "=";
                    var n = document.cookie.split(";");
                    for (var i = 0; i < n.length; i++) {
                        var a = n[i];
                        while (a.charAt(0) === " ") a = a.substring(1, a.length);
                        if (a.indexOf(t) === 0) return unescape(a.substring(t.length, a.length));
                    }
                    return null;
                },
                r: function(e) {
                    this.s(e, "", -1);
                }
            },
            html: function(t, n, a) {
                e.each(n, function(n, r) {
                    var s = function(t, n, a) {
                        if (t) {
                            if (t.t) {
                                if (!t.l) n.append(e(i.tag(t.t), t.d)); else if (t.d) var r = t.d; else var r = null;
                            }
                            if (t.l && t.l.length) {
                                var l = e(i.tag(t.t), r);
                                for (index in t.l) s(t.l[index], l);
                                n[a || "append"](l);
                            }
                        }
                    };
                    s(r, t, a);
                });
                return t;
            },
            serializeObject: function(t) {
                var n = {};
                e.each(t.serializeArray(), function(e, t) {
                    n[t.name] = t.value;
                });
                return n;
            },
            serializeJSON: function(t) {
                var n = {};
                e.each(t.serializeArray(), function() {
                    if (n[this.name] !== undefined) {
                        if (!n[this.name].push) {
                            n[this.name] = [ n[this.name] ];
                        }
                        n[this.name].push(this.value || "");
                    } else {
                        n[this.name] = this.value || "";
                    }
                });
                return n;
            }
        };
        i.data.link([ "api" ]);
        var a = {
            suggest: {
                form: "search",
                field: "q",
                button: "submit",
                classIn: "in",
                className: "selected",
                listCurrent: -1,
                listTotal: 0,
                delay: 0,
                result: "#suggest",
                ready: function() {
                    var t = this;
                    t.form = e(i.Form(t.form));
                    if (!t.form.length) return;
                    t.field = t.form.find(i.Input(t.field)).attr("autocomplete", "off").focus().select();
                    t.result = e(t.result);
                    t.field.focusin(function() {
                        t.form.addClass(t.classIn);
                    }).focusout(function() {
                        setTimeout(function() {
                            t.clear();
                        }, 200);
                    }).keyup(function(n) {
                        var i = n || window.event;
                        var a = e(this).val();
                        t.form.addClass(t.classIn);
                        if (t.arrows(i.keyCode, i.ctrlKey || i.metaKey) != true) setTimeout(function() {
                            t.listener(a);
                        }, t.delay);
                    });
                },
                clear: function() {
                    this.result.empty();
                    this.form.removeClass(this.classIn);
                },
                listener: function(t) {
                    var n = this;
                    var i = n.field.val();
                    if (i == "" || t != i) return;
                    e.getJSON("/api/suggestion", {
                        q: i
                    }, function(t) {
                        n.listTotal = t.length;
                        if (n.listTotal > 0) {
                            n.result.empty();
                            e.each(t, function(t, a) {
                                e("<p>", {
                                    title: a,
                                    html: a.replace(new RegExp(i, "i"), "<b>$&</b>")
                                }).appendTo(n.result).mousemove(function() {
                                    n.add(this);
                                });
                            });
                        } else {
                            n.clear();
                        }
                    });
                },
                arrows: function(t, n) {
                    var i = this;
                    if (e.inArray(t, [ 40, 38, 13 ]) >= 0) {
                        if (t == 38) {
                            if (i.listCurrent <= 0) {
                                i.listCurrent = i.listTotal - 1;
                            } else {
                                i.listCurrent--;
                            }
                        } else {
                            if (i.listCurrent >= i.listTotal - 1) {
                                i.listCurrent = 0;
                            } else {
                                i.listCurrent++;
                            }
                        }
                        i.result.children().each(function(e) {
                            if (e == i.listCurrent) i.add(this);
                        });
                        return true;
                    } else if (e.inArray(t, [ 13, 37, 39, 16, 17, 116 ]) >= 0) {
                        return true;
                    } else if (n && e.inArray(t, [ 67 ]) >= 0) {
                        return true;
                    } else if (t == 27) {} else if (t == 13) {
                        return false;
                    } else {
                        i.listCurrent = -1;
                        return false;
                    }
                },
                add: function(t) {
                    var n = this;
                    var i = e(t);
                    n.field.val(i.attr("title"));
                    i.addClass(n.className).siblings().removeClass();
                    n.listCurrent = i.index();
                    i.click(function() {
                        n.form.submit();
                    });
                }
            },
            toggle: {
                menu: function() {
                    e("ul.menu li[data-toggle]").on("click", function() {
                        var t = e(this);
                        var n = t.data("toggle");
                        var a = t.parent().next();
                        t.addClass("active").siblings().removeClass("active");
                        if (a.is(":hidden")) a.fadeIn("fast");
                        a.children(i.Class(n)).fadeToggle("fast", function() {
                            if (e(this).is(":hidden")) {
                                a.fadeOut("fast");
                                t.removeClass("active");
                            }
                        }).siblings().fadeOut("fast");
                    });
                }
            },
            word: {
                help: function() {
                    this.form(a.x.data("word")).appendTo(a.x);
                },
                suggest: function() {
                    a.x.parent().replaceWith(this.form(a.x.data("word")));
                },
                form: function(t) {
                    return e("<form>", {
                        method: "POST"
                    }).append(e("<div>").append(e("<input>", {
                        type: "text",
                        name: "word",
                        value: t
                    })), e("<div>").append(e("<span>").html("Meaning"), e("<textarea>", {
                        name: "mean"
                    })), e("<div>").append(e("<span>").html("Example"), e("<textarea>", {
                        name: "exam"
                    })), e("<p>").html(""), e("<div>", {
                        "class": "submit"
                    }).append(e("<input>", {
                        type: "submit",
                        name: "submit",
                        value: "Post"
                    }), e("<input>", {
                        type: "reset",
                        value: "Reset"
                    }))).on("submit", this.submit);
                },
                submit: function(t) {
                    t.preventDefault();
                    var n = e(this);
                    var a = n.children("p");
                    a.html("...a moment please").removeClass();
                    var r = e.post(i.Url([ i.api, "post" ]), i.serializeObject(e(this)), function() {}).done(function(e) {
                        a.html(e.msg).addClass(e.status);
                        if (e.status == "done") {
                            n.children("div").hide();
                        }
                    }).fail(function(e, t, n) {
                        a.html(n).addClass("fail");
                    }).always(function() {});
                }
            },
            speech: function() {
                var e = t.createElement("audio");
                e.src = i.Url([ i.api, "speech", {
                    q: a.x.parent().text(),
                    l: a.c[1]
                } ]);
                a.x.addClass("playing");
                e.load();
                e.play();
                e.addEventListener("ended", function() {
                    a.x.removeClass("playing");
                });
            },
            click: function() {
                e(t).on("click", i.Class("zA"), function(t) {
                    var n = e(this);
                    a.x = n;
                    a.c = n.attr("class").split(" ");
                    r(a.c);
                    t.preventDefault();
                    t.stopPropagation();
                });
            },
            auto: function() {
                e(i.Class("zO")).each(function() {
                    var t = e(this);
                    a.x = t;
                    a.c = t.attr("class").split(" ");
                    r(a.c);
                });
            },
            img: {
                set: function() {}
            }
        };
        function r(t) {
            if (a[t[0]] && e.isFunction(a[t[0]])) a[t[0]](); else if (a[t[0]] && e.isFunction(a[t[0]][t[1]])) a[t[0]][t[1]](); else if (a[t[0]] && e.isFunction(a[t[0]][0])) a[t[0]][0]();
        }
        e.each(n, function(e, t) {
            r(t.split(" "));
        });
    };
})(jQuery, document);