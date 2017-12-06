/*
 * MyOrdbok
 */
(function(e, t) {
    e.fn.MyOrdbok = function(n) {
        // var zolai='zolai',zozum='zozum',cur='cur',act='act',btn='btn';
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
            // data:{
            // 	fn:'form[name="*"]',in:'input[name="*"]',mn:'meta[name="*"]',c:'.*',i:'#*',t:'<*>'
            // },
            name: {
                form: 'form[name="*"]',
                input: 'input[name="*"]',
                button: 'button[name="*"]',
                meta: 'meta[name="*"]',
                tag: "<*>",
                class: ".",
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
            // ra:function(e,r){
            // 	return e.join(r||'');
            // },
            Form: function(e) {
                return this.name.form.replace("*", e);
            },
            Input: function(e) {
                return this.name.input.replace("*", e);
            },
            // Button:function(e){
            // 	return this.name.button.replace('*',e);
            // },
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
            // ID:function(e){return $(this.id(e));},
            // CN:function(e){return $(this.class(e));},
            // Rf:function(q,n){return q.substr(n||1);},
            // Rl:function(q,n){return q.substring(n||1);},
            // cf:function(q,s){return q.toLowerCase().split(s||' ');},
            // NOTE: Attr
            // attr:{
            // 	Role:function(e){
            // 		return fn.check(e.attr('data-role')).split(' ');
            // 	},
            // 	Id:function(e){
            // 		return fn.check(e.attr('id')).split('-');
            // 	},
            // 	Class:function(e){
            // 		return fn.check(e.attr('class')).split(' ');
            // 	},
            // 	Href:function(e){
            // 		return e.attr('href');
            // 	},
            // 	Title:function(e){
            // 		return e.attr('title');
            // 	}
            // },
            store: {
                s: function(e, t, n) {
                    //$.cookie(e[0], e[1],{expires:7, path:'/'});
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
                e.each(n, function(n, s) {
                    var r = function(t, n, a) {
                        if (t) {
                            if (t.t) {
                                //|| item.d.for || item.d.class && item.d.html|| item.d.value|| item.d.for
                                //item.d && item.d.html || item.d && item.d.name || !item.l && item.d.text
                                if (!t.l) n.append(e(i.tag(t.t), t.d)); else if (t.d) var s = t.d; else var s = null;
                            }
                            if (t.l && t.l.length) {
                                var l = e(i.tag(t.t), s);
                                for (index in t.l) r(t.l[index], l);
                                n[a || "append"](l);
                            }
                        }
                    };
                    r(s, t, a);
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
        // fn.ah
        // fn.data.link(['urlmain','urlproject','urlfull','api']);
        // fn.data.meta(['uid','unm']);
        /*
		$.ajax({url:fn.url([e.url,comment]),dataType:"json",data:obj.serialize()}).done(function(j) {
			//...
		}).fail(function(jqXHR,textStatus) {
			//...
		}).always(function(j) {
			//...
		});
		*/
        // fn.data.link(['api']);
        i.data.link([ "api" ]);
        console.log(i.api);
        // fn.data.meta(['uid','unm']);
        var a = "ontouchstart" in t.documentElement ? "touchend" : "click";
        // var click = ('ontouchstart' in doc.documentElement)? "touchstart" : "click";
        var s = {
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
                    //this.field.select();
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
                    var a = n.field.val();
                    if (a == "" || t != a) return;
                    e.getJSON(i.Url([ i.api, "suggestion" ]), {
                        q: a
                    }, function(t) {
                        n.listTotal = t.length;
                        if (n.listTotal > 0) {
                            n.result.empty();
                            e.each(t, function(t, i) {
                                e("<p>", {
                                    title: i,
                                    html: i.replace(new RegExp(a, "i"), "<b>$&</b>")
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
                        // Enter
                        return false;
                    } else {
                        i.listCurrent = -1;
                        return false;
                    }
                },
                add: function(t) {
                    var n = this;
                    var i = e(t);
                    //this.field.val(x.childNodes[0].nodeValue);
                    // this.field.val(zj.At($(x)));
                    n.field.val(i.attr("title"));
                    i.addClass(n.className).siblings().removeClass();
                    // x.className = e.className;
                    n.listCurrent = i.index();
                    i.click(function() {
                        n.form.submit();
                    });
                }
            },
            toggle: {
                menu: function() {
                    // NOTE: font info toggle
                    e("ul.menu li[data-toggle]").on(a, function() {
                        var t = e(this);
                        //core.x=element;
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
                },
                panel: function() {
                    var n = e("body>div"), i = s.x;
                    var r = function() {
                        i.removeClass("active").next().removeAttr("style").hide();
                        n.removeAttr("style");
                    };
                    if (i.hasClass("active")) {
                        r();
                    } else {
                        i.next().show().animate({
                            width: "250px",
                            height: "100%"
                        });
                        if (i.next().hasClass("page")) {
                            n.animate({
                                left: "+=250px"
                            });
                        } else {
                            n.animate({
                                right: "+=250px"
                            });
                        }
                        n.css({
                            width: "100%",
                            position: "fixed"
                        });
                        i.addClass("active");
                    }
                    var l = function(n) {
                        if (!e(n.target).closest(i.next()).length) {
                            r();
                            e(t).off(a, l);
                        }
                    };
                    e(t).on(a, l);
                }
            },
            word: {
                help: function() {
                    this.form(s.x.data("word")).appendTo(s.x);
                },
                suggest: function() {
                    // this.form().appendTo(core.x.parent().parent());
                    s.x.parent().replaceWith(this.form(s.x.data("word")));
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
                        class: "submit"
                    }).append(e("<input>", {
                        type: "submit",
                        name: "submit",
                        value: "Post"
                    }), e("<input>", {
                        type: "reset",
                        value: "Reset"
                    }))).on("submit", this.submit);
                },
                // word, mean,exam, wo, wm, we,
                submit: function(t) {
                    t.preventDefault();
                    var n = e(this);
                    var a = n.children("p");
                    a.html("...a moment please").removeClass();
                    // var msgContainer = form.parent();
                    // msgContainer.html('Thank you').addClass('done');
                    // msgContainer.html('fail').addClass('fail');
                    // form.children('div').hide();
                    var s = e.post(i.Url([ i.api, "post" ]), i.serializeObject(e(this)), function() {}).done(function(e) {
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
                    q: s.x.parent().text(),
                    l: s.c[1]
                } ]);
                s.x.addClass("playing");
                e.load();
                e.play();
                e.addEventListener("ended", function() {
                    //  myAudio.currentTime = 0;
                    //  console.log("ended");
                    s.x.removeClass("playing");
                });
            },
            click: function() {
                e(t).on(a, i.Class("zA"), function(t) {
                    var n = e(this);
                    s.x = n;
                    // core.r=zj.Ad(x);
                    s.c = n.attr("class").split(" ");
                    // core.i=zj.Ai(x);
                    r(s.c);
                    t.preventDefault();
                    t.stopPropagation();
                });
            },
            auto: function() {
                // console.log(fn.Class('zO'));
                e(i.Class("zO")).each(function() {
                    var t = e(this);
                    s.x = t;
                    s.c = t.attr("class").split(" ");
                    r(s.c);
                });
            },
            img: {
                set: function() {}
            }
        };
        function r(t) {
            if (s[t[0]] && e.isFunction(s[t[0]])) s[t[0]](); else if (s[t[0]] && e.isFunction(s[t[0]][t[1]])) s[t[0]][t[1]](); else if (s[t[0]] && e.isFunction(s[t[0]][0])) s[t[0]][0]();
        }
        e.each(n, function(e, t) {
            r(t.split(" "));
        });
    };
})(jQuery, document);