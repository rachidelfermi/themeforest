/*
 * Fullwidth Audio Player - jQuery plugin 1.6.2 
 * Copyright 2013, Rafael Dery
 *
 * Only for the sale at the envato marketplaces
 */
! function(a) {
    a.fullwidthAudioPlayer = {
        version: "1.6.1",
        author: "Rafael Dery"
    }, jQuery.fn.fullwidthAudioPlayer = function(b) {
        function c(b) {
            if ((K.keepClosedOnceClosed || K.storePlaylist) && "undefined" == typeof amplify) return alert("Please include the amplify.min.js file in your document!"), !1;
            if (y = a(b), y.hide(), U = "fap-popup" == b.id, x()) {
                if (K.hideOnMobile) return !1;
                K.autoPlay = K.playlist = !1, K.wrapperPosition = "top"
            }
            if ("undefined" != typeof amplify && 1 === amplify.store("fap-keep-closed") && K.keepClosedOnceClosed && (K.opened = !1), J = Boolean(window.fapPopupWin), K.autoPopup || (J = !0), I = !K.autoPlay, h(), M = K.playlist ? K.height + K.playlistHeight + K.offset : K.height, "popup" == K.wrapperPosition && !U) return K.layout = "fullwidth", T = !0, K.playlist || (M = K.height), K.autoPopup && !window.fapPopupWin && d(y.html(), K.autoPlay), !1;
            window.SC && SC.initialize({
                client_id: "d2be7a47322c293cdaffc039a26e05d1"
            });
            var c = '<div id="fap-wrapper" class="fap-wrapper-bottom"><div id="fap-main" style="color:' + K.mainColor + ';"><div id="fap-wrapper-switcher" class="fap-' + K.wrapperPosition + '"></div><p id="fap-init-text">Creating Playlist...</p></div></div>';
            a("body").append(c), z = a("body").children("#fap-wrapper"), A = z.children("#fap-main"), "fullwidth" == K.layout ? z.addClass("fap-fullwidth").css({}) : "boxed" == K.layout && (z.addClass("fap-boxed"), A.css({
                background: K.wrapperColor,
                borderColor: K.strokeColor
            })), U && z.addClass("fap-popup-skin"), x() && z.css({
                position: "absolute"
            }), U ? A.css({
                marginLeft: 10,
                marginRight: 10
            }) : "center" == K.mainPosition ? A.css({
                marginLeft: "auto",
                marginRight: "auto"
            }) : "right" == K.mainPosition ? A.css({
                "float": "right",
                marginRight: 10
            }) : A.css({
                marginLeft: 10
            }), "top" == K.wrapperPosition ? A.children("#fap-wrapper-switcher").css({
                bottom: -17,
                borderTop: "none"
            }) : A.children("#fap-wrapper-switcher").css({
                top: -27
            }), K.opened ? a.fullwidthAudioPlayer.setPlayerPosition("open", !1) : a.fullwidthAudioPlayer.setPlayerPosition("close", !1), A.children("#fap-wrapper-switcher").click(function() {
                K.opened ? (a.fullwidthAudioPlayer.setPlayerPosition("close", !0), K.keepClosedOnceClosed && amplify.store("fap-keep-closed", 1)) : a.fullwidthAudioPlayer.setPlayerPosition("open", !0)
            }), soundManager.onready(e)
        }

        function d(b, c, d) {
            if (d = "undefined" != typeof d ? d : !0, selectIndex = "undefined" != typeof selectIndex ? selectIndex : 0, !window.fapPopupWin || window.fapPopupWin.closed) {
                var e = 980,
                    f = (window.screen.width - e) / 2,
                    g = (window.screen.height - M) / 2,
                    h = /Chrome/i.test(navigator.userAgent);
                window.fapPopupWin = window.open(K.popupUrl, "", "menubar=no,toolbar=no,location=yes,status=no,width=" + e + ",height=" + (h ? M + 30 : M) + ",left=" + f + ",top=" + g), null == window.fapPopupWin && alert("Pop-Up Music Player can not be opened. Your browser is blocking Pop-Ups. Please allow Pop-Ups for this site to use the Music Player."), a(window.fapPopupWin).load(function() {
                    a(window.fapPopupWin).animate({
                        innerHeight: M
                    }, 500), d && a('.fap-single-track[data-autoenqueue="yes"]').each(function(c, d) {
                        var e = a(d);
                        b += i(e)
                    }), K.autoPlay = c, window.fapPopupWin.initPlayer(K, b), J = !0
                })
            } else {
                var j = a(b);
                a.fullwidthAudioPlayer.addTrack(j.attr("href"), j.attr("title"), j.data("meta") ? a("body").find(j.data("meta")).html() : "", j.attr("rel"), j.attr("target"), c)
            }
        }

        function e() {
            if (K.playlist) {
                var b = '<ul id="fap-playlist"></ul>';
                L = a(b).css("height", K.playlistHeight)
            }
            K.xmlPath ? a.ajax({
                type: "GET",
                url: K.xmlPath,
                dataType: "xml",
                cache: !1,
                success: function(b) {
                    var c = a(b).find("playlists"),
                        d = d = K.xmlPlaylist ? K.xmlPlaylist : c.children("playlist:first").attr("id");
                    f(c.children('playlist[id="' + d + '"]').children("track")), a(".fap-xml-playlist").each(function(b, d) {
                        var e = a(d);
                        e.append("<h3>" + d.title + '</h3><ul class="fap-my-playlist"></ul>'), c.children('playlist[id="' + d.id + '"]').children("track").each(function(b, c) {
                            var f = a(c),
                                g = f.attr("target") ? 'target="' + f.attr("target") + '"' : "",
                                h = f.attr("rel") ? 'rel="' + f.attr("rel") + '"' : "",
                                i = f.find("meta") ? 'data-meta="#' + d.id + "-" + b + '"' : "";
                            e.children("ul").append('<li><a href="' + f.attr("href") + '" title="' + f.attr("title") + '" ' + g + " " + h + " " + i + ">" + f.attr("title") + "</a></li>"), e.append('<span id="' + d.id + "-" + b + '">' + f.find("meta").text() + "</span>")
                        })
                    })
                },
                error: function() {
                    alert("XML file could not be loaded. Please check the XML path!")
                }
            }) : f(y.children("a"))
        }

        function f(b) {
            if (K.storePlaylist) var c = Boolean(amplify.store("fap-playlist"));
            b = c ? JSON.parse(amplify.store("fap-playlist")) : b, y.bind("fap-tracks-stored", function() {
                if (++N, N < b.length)
                    if (K.storePlaylist && c) {
                        var d = b[N];
                        a.fullwidthAudioPlayer.addTrack(d.stream_url, d.title, d.meta, d.artwork_url, d.permalink_url, K.autoPlay)
                    } else {
                        var d = b.eq(N);
                        a.fullwidthAudioPlayer.addTrack(d.attr("href"), d.attr("title"), K.xmlPath ? d.children("meta").text() : y.find(d.data("meta")).html(), d.attr("rel"), d.attr("target"), K.autoPlay)
                    } else y.unbind("fap-tracks-stored"), K.randomize && u(), g()
            }).trigger("fap-tracks-stored")
        }

        function g() {
            function b() {
                if (++N, N < f.size()) {
                    var c = f.eq(N);
                    a.fullwidthAudioPlayer.addTrack(c.attr("href"), c.attr("title"), a("body").find(c.data("meta")).html(), c.attr("rel"), c.attr("target"), !1)
                } else y.unbind("fap-tracks-stored", b)
            }
            A.children("p").remove(), A.append('<div id="fap-meta-wrapper" class="fap-clearfix"><div id="fap-cover-wrapper"><img src="" id="fap-current-cover"/><div id="fap-cover-replacement"></div></div><div id="fap-track-info"><p id="fap-current-title"></p><p id="fap-current-meta"></p></div></div>'), E = A.children("#fap-meta-wrapper").css("height", K.height - 10), q(document.getElementById("fap-cover-replacement"), K.coverSize[0], K.coverSize[1]), K.socials && E.children("#fap-track-info").append(''), B = A.append('<div id="fap-player-wrapper" class="fap-clearfix"><div id="fap-player-controls"></div><div id="fap-playlist-controls"></div></div>').children("#fap-player-wrapper"), C = B.children("#fap-player-controls"), D = B.children("#fap-playlist-controls");
            var c = C.append('<div id="fap-main-controls"></div>').children("#fap-main-controls");
            if (c.append('<a href="#" id="fap-previous" class="fa fa-backward"></a>').children("#fap-previous").click(function() {
                    return a.fullwidthAudioPlayer.previous(), !1
                }), c.append('<a href="#" id="fap-play-pause" class="fa fa-play" style="color: ' + K.mainColor + ';"></a>').children("#fap-play-pause").click(function() {
                    return a.fullwidthAudioPlayer.toggle(), !1
                }), c.append('<a href="#" id="fap-next" class="fa fa-forward" style="color: ' + K.mainColor + ';"></a>').children("#fap-next").click(function() {
                    return a.fullwidthAudioPlayer.next(), !1
                }), K.volume && (C.append('<div id="fap-volume-bar"><div id="fap-volume-sign" class="volume-on"></div><div id="fap-volume-scrubber"><div id="fap-volume-indicator"></div></div></div>'), C.find("#fap-volume-scrubber").click(function(b) {
                    var c = (b.pageX - a(this).offset().left) / O;
                    a.fullwidthAudioPlayer.volume(c)
                }), C.find("#fap-volume-sign").dblclick(function() {
                    a(this).hasClass("volume-on") ? a.fullwidthAudioPlayer.volume(0) : a.fullwidthAudioPlayer.volume(100)
                })), F = C.append('<div id="fap-time-bar"><div id="fap-loading-bar"></div><div id="fap-progress-bar"></div><span id="fap-current-time">00:00:00</span><span id="fap-total-time">00:00:00</span></div>').children("#fap-time-bar"), C.find("#fap-loading-bar, #fap-progress-bar").click(function(b) {
                    var c = (b.pageX - a(this).parent().offset().left) / F.width();
                    G.setPosition(c * G.duration), r(c)
                }), K.shuffle && D.append('<a href="#" id="fap-playlist-shuffle" title="Shuffle"></a>').children("#fap-playlist-shuffle").click(function(a) {
                    u(), a.preventDefault()
                }), K.playlist) {
                if ("bottom" == K.wrapperPosition ? (A.append('<div class="clear"></div>').append(L), L.css({
                        marginTop: K.offset
                    })) : (A.prepend('<div class="clear"></div>').prepend(L), L.css({
                        marginBottom: K.offset
                    })), L.niceScroll({
                        cursorborderradius: 0,
                        cursorcolor: K.mainColor,
                        cursorborder: "none",
                        autohidemode: !1
                    }), L.getNiceScroll().hide(), a(".nicescroll-rails").hover(function() {
                        L.getNiceScroll().resize().show()
                    }, function() {
                        L.getNiceScroll().resize().hide()
                    }), L.hover(function() {
                        L.getNiceScroll().resize().show()
                    }, function() {
                        L.getNiceScroll().resize().hide()
                    }), K.sortable) {
                    var e;
                    L.sortable().bind("sortstart", function(a, b) {
                        b.item.addClass("fap-prevent-click"), e = L.children("li").index(b.item)
                    }), L.sortable().bind("sortupdate", function(a, b) {
                        var c = L.children("li").index(b.item),
                            d = V[e],
                            f = V[P].title;
                        V.splice(e, 1), V.splice(c, 0, d), w(f), K.storePlaylist && amplify.store("fap-playlist", JSON.stringify(V))
                    })
                }
                U ? a.fullwidthAudioPlayer.setPlayerPosition("openPlaylist", !1) : D.append('<a href="#" id="fap-playlist-toggle" title="Playlist"></a>').children("#fap-playlist-toggle").click(function(b) {
                    R ? a.fullwidthAudioPlayer.setPlayerPosition("closePlaylist", !0) : a.fullwidthAudioPlayer.setPlayerPosition("openPlaylist", !0), b.preventDefault()
                })
            }
            K.keyboard && a(document).keyup(function(b) {
                switch (b.which) {
                    case 32:
                        a.fullwidthAudioPlayer.toggle();
                        break;
                    case 39:
                        a.fullwidthAudioPlayer.next();
                        break;
                    case 37:
                        a.fullwidthAudioPlayer.previous();
                        break;
                    case 38:
                        a.fullwidthAudioPlayer.volume(Q / 100 + .05);
                        break;
                    case 40:
                        a.fullwidthAudioPlayer.volume(Q / 100 - .05)
                }
            }), E.children("p").css("marginLeft", K.coverSize[0] + 10), y.trigger("onFapReady"), J = !0;
            var f = a('.fap-single-track[data-autoenqueue="yes"]');
            N = -1, y.bind("fap-tracks-stored", b), b(), y.bind("fap-tracks-stored", function(b, c) {
                S && a.fullwidthAudioPlayer.selectTrack(c, S)
            }), a.fullwidthAudioPlayer.selectTrack(K.selectedIndex, /Android|webOS|iPhone|iPod|iPad|BlackBerry/i.test(navigator.userAgent) ? !1 : K.autoPlay), K.autoPlay ? y.trigger("onFapPlay") : y.trigger("onFapPause")
        }

        function h() {
            function b() {
                function b() {
                    if (++N, N < g.size()) {
                        var c = g.eq(N);
                        a.fullwidthAudioPlayer.addTrack(c.attr("href"), c.attr("title"), a("body").find(c.data("meta")).html(), c.attr("rel"), c.attr("target"), 0 == N && e)
                    } else y.unbind("fap-tracks-stored", b)
                }
                if (!J) return !1;
                var c = a(this),
                    e = !0;
                if (c.data("enqueue") && (e = "yes" == c.data("enqueue") ? !1 : !0), T)
                    if (c.hasClass("fap-add-playlist")) {
                        var f = c.data("playlist"),
                            g = jQuery('[data-playlist="' + f + '"]').find(".fap-single-track"),
                            h = i(a(g.get(0)));
                        if (0 == g.size()) return !1;
                        d(h, e), g.splice(0, 1), window.fapReady = void 0 != window.fapPopupWin.addTrack;
                        var j = setInterval(function() {
                            window.fapReady && (clearInterval(j), g.each(function(a, b) {
                                d(b, e)
                            }))
                        }, 50)
                    } else {
                        var h = i(c);
                        d(h, e)
                    } else if (c.hasClass("fap-add-playlist")) {
                    var f = c.data("playlist"),
                        g = jQuery('[data-playlist="' + f + '"]').find(".fap-single-track");
                    if (0 == g.size()) return !1;
                    N = -1, y.bind("fap-tracks-stored", b), b()
                } else a.fullwidthAudioPlayer.addTrack(c.attr("href"), c.attr("title"), a("body").find(c.data("meta")).html(), c.attr("rel"), c.attr("target"), e);
                return !1
            }
            y.jquery >= "1.7" ? (a("body").on("click", ".fap-my-playlist li a, .fap-single-track", b), a("body").on("click", ".fap-add-playlist", b)) : (a("body").delegate(".fap-my-playlist li a, .fap-single-track", "click", b), a("body").delegate(".fap-add-playlist", "click", b))
        }

        function i(b) {
            var c = '<a href="' + b.attr("href") + '" title="' + (b.attr("title") ? b.attr("title") : "") + '" target="' + (b.attr("target") ? b.attr("target") : "") + '" rel="' + (b.attr("rel") ? b.attr("rel") : "") + '" data-meta="' + (b.data("meta") ? b.data("meta") : "") + '"></a>';
            if (b.data("meta")) {
                var d = a("body").find(b.data("meta")).html() ? a("body").find(b.data("meta")).html() : "";
                c += '<span id="' + b.data("meta").substring(1) + '">' + d + "</span>"
            }
            return c
        }

        function j(b) {
            if (RegExp("http(s?)://soundcloud").test(b)) SC.get("/resolve", {
                url: b
            }, function(b, c) {
                var d = -1,
                    e = -1;
                if (null == c)
                    if (a.isArray(b))
                        for (var f = 0; f < b.length; ++f) e = k(b[f]), d = d > e ? e : d, 0 == f && (d = e);
                    else if ("playlist" == b.kind)
                    for (var f = 0; f < b.tracks.length; ++f) e = k(b.tracks[f]), d = d > e ? e : d, 0 == f && (d = e);
                else "user" == b.kind ? SC.get("/users/" + b.id + "/tracks", function(a) {
                    for (var b = 0; b < a.length; ++b) e = k(a[b]), d = d > e ? e : d, 0 == b && (d = e);
                    y.trigger("onFapTracksAdded", [V]), y.trigger("fap-tracks-stored", [d])
                }) : "group" == b.kind ? SC.get("/groups/" + b.id + "/tracks", function(a) {
                    for (var b = 0; b < a.length; ++b) e = k(a[b]), d = d > e ? e : d, 0 == b && (d = e);
                    y.trigger("onFapTracksAdded", [V]), y.trigger("fap-tracks-stored", [d])
                }) : "track" == b.kind && (d = k(b));
                else d++;
                d >= 0 && (y.trigger("onFapTracksAdded", [V]), y.trigger("fap-tracks-stored", [d]))
            });
            else if (RegExp("http(s?)://official.fm").test(b)) {
                var c = b.substr(b.lastIndexOf("/tracks") + 8);
                a.getJSON("http://api.official.fm/tracks/" + c + "?fields=streaming,cover&api_version=2", function(a) {
                    var b = a.track,
                        c = k({
                            stream_url: b.streaming.http,
                            title: b.artist + " - " + b.title,
                            meta: b.project.name,
                            artwork_url: b.cover.urls.small,
                            permalink_url: b.page
                        });
                    y.trigger("onFapTracksAdded", [V]), y.trigger("fap-tracks-stored", [c])
                })
            }
        }

        function k(a) {
            for (var b = V.length, c = 0; c < V.length; ++c)
                if (a.stream_url == V[c].stream_url) return b = c;
            return V.push(a), p(a.artwork_url, a.title), K.storePlaylist && amplify.store("fap-playlist", JSON.stringify(V)), b
        }

        function l() {
            C.find("#fap-loading-bar").width(340 * Math.round(this.bytesLoaded / this.bytesTotal) + "px")
        }

        function m() {
            s(this.position, this.duration)
        }

        function n() {
            K.playNextWhenFinished ? a.fullwidthAudioPlayer.next() : (a.fullwidthAudioPlayer.pause(), G.setPosition(0), r(0))
        }

        function o(a) {
            a || window.console && window.console.log && console.log("Track could not be loaded! Please check the URL: " + this.url)
        }

        function p(b, c) {
            function d() {
                var b = a(this).parent();
                if (b.hasClass("fap-prevent-click")) b.removeClass("fap-prevent-click");
                else {
                    var c = L.children("li").index(b);
                    a.fullwidthAudioPlayer.selectTrack(c, !0)
                }
            }

            function e() {
                var b = a(this),
                    c = b.parent().parent().children("li").index(b.parent());
                V.splice(c, 1), b.parent().remove(), c == P ? (P--, c = c == V.length ? 0 : c, a.fullwidthAudioPlayer.selectTrack(c, I ? !1 : !0)) : P > c && P--, L.getNiceScroll().resize(), K.storePlaylist && amplify.store("fap-playlist", JSON.stringify(V))
            }
            if (!K.playlist) return !1;
            var f = b ? '<img src="' + b + '"/>' : '<div class="fap-cover-replace-small"></div>';
            L.append('<li class="fap-clearfix">' + f + "<span>" + c + '</span><div class="fap-remove-track">&times;</div></li>');
            var g = L.children("li").last().css({
                marginBottom: 7,
                height: 25
            }); - 1 == navigator.appVersion.indexOf("MSIE 7.") && (b || q(g.children(".fap-cover-replace-small").get(0), 20, 20)), y.jquery >= "1.7" ? (g.on("click", "span", d), g.on("click", ".fap-remove-track", e)) : (g.delegate("span", "click", d), g.delegate(".fap-remove-track", "click", e)), L.getNiceScroll().resize()
        }

        function q(b, c, d) {
            a(b).append('<span style="line-height: ' + d + "px; color: " + K.metaColor + ';">&hellip;</span>')
        }

        function r(a) {
            C.find("#fap-progress-bar").width(a * F.width())
        }

        function s(a, b) {
            var c = t(a / 1e3);
            H != c && (C.find("#fap-current-time").text(c), C.find("#fap-total-time").text(t(b / 1e3)), r(a / b)), H = c
        }

        function t(a) {
            a = Math.abs(a);
            var b = new Array;
            b[0] = Math.floor(a / 3600 % 24), b[1] = Math.floor(a / 60 % 60), b[2] = Math.floor(a % 60);
            for (var c = !0, d = -1, e = 0; e < b.length; e++) b[e] < 10 && (b[e] = "0" + b[e]), "00" == b[e] && e < b.length - 2 && !c ? d = e : c = !0;
            return b.splice(0, d + 1), b.join(":")
        }

        function u() {
            if (L && L.empty(), -1 != P) {
                var a = V[P].title;
                V.shuffle(), w(a);
                for (var b = 0; b < V.length; ++b) p(V[b].artwork_url, V[b].title);
                A.find("#fap-playlist").children("li").eq(P).css("backgroundColor", K.fillColor), A.find("#fap-playlist").scrollTop(0)
            } else {
                V.shuffle();
                for (var b = 0; b < V.length; ++b) p(V[b].artwork_url, V[b].title)
            }
            K.storePlaylist && amplify.store("fap-playlist", JSON.stringify(V))
        }

        function v() {
            for (var a, b, c = 0; c < this.length; c++) b = Math.floor(Math.random() * this.length), a = this[c], this[c] = this[b], this[b] = a
        }

        function w(a) {
            for (var b = 0; b < V.length; ++b) V[b].title == a && (P = b)
        }

        function x() {
            return /Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)
        }
        var y, z, A, B, C, D, E, F, G, H, I, J, K = a.extend({}, a.fn.fullwidthAudioPlayer.defaults, b),
            L = null,
            M = 0,
            N = -1,
            O = 90,
            P = -1,
            Q = 100,
            R = !1,
            S = !1,
            T = !1,
            U = !1,
            V = [];
        return a.fullwidthAudioPlayer.play = function() {
            -1 == P && a.fullwidthAudioPlayer.next(), V.length > 0 && (G.playState ? G.resume() : G.play(), C.find("#fap-play-pause").removeClass("fa-play").addClass("fa-pause"), I = !1, y.trigger("onFapPlay"))
        }, a.fullwidthAudioPlayer.pause = function() {
            V.length > 0 && (G.pause(), C.find("#fap-play-pause").removeClass("fa-pause").addClass("fa-play"), I = !0, y.trigger("onFapPause"))
        }, a.fullwidthAudioPlayer.toggle = function() {
            I ? a.fullwidthAudioPlayer.play() : a.fullwidthAudioPlayer.pause()
        }, a.fullwidthAudioPlayer.previous = function() {
            V.length > 0 && a.fullwidthAudioPlayer.selectTrack(P - 1, !0)
        }, a.fullwidthAudioPlayer.next = function() {
            V.length > 0 && a.fullwidthAudioPlayer.selectTrack(P + 1, !0)
        }, a.fullwidthAudioPlayer.volume = function(a) {
            V.length > 0 && (0 > a && (a = 0), a > 1 && (a = 1), Q = 100 * a, G && G.setVolume(Q), C.find("#fap-volume-indicator").width(a * O), 0 == a ? C.find("#fap-volume-sign").removeClass("volume-on").addClass("volume-off") : C.find("#fap-volume-sign").removeClass("volume-off").addClass("volume-on"))
        }, a.fullwidthAudioPlayer.addTrack = function(a, b, c, d, e, f) {
            if (null == a || "" == a) return alert('The track with the title "' + b + '" does not contain a track resource!'), !1;
            if (void 0 === b && (b = ""), void 0 === c && (c = ""), void 0 === d && (d = ""), void 0 === e && (e = ""), void 0 === f && (f = !1), T && window.fapPopupWin && !window.fapPopupWin.closed) return window.fapPopupWin.addTrack(a, b, c, d, e, f), window.fapPopupWin.focus(), !1;
            var g = new RegExp("^(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=|[A-Za-z0-9+/]{4})$");
            if (g.test(a) && (a = Base64.decode(a)), S = f, RegExp("http(s?)://soundcloud").test(a) || RegExp("http(s?)://official.fm").test(a)) j(a);
            else {
                var h = k({
                    stream_url: a,
                    title: b,
                    meta: c,
                    artwork_url: d,
                    permalink_url: e
                });
                y.trigger("onFapTracksAdded", [V]), y.trigger("fap-tracks-stored", [h])
            }
        }, a.fullwidthAudioPlayer.selectTrack = function(b, c) {
            if (V.length <= 0) return a.fullwidthAudioPlayer.clear(), !1;
            if (b == P) return a.fullwidthAudioPlayer.toggle(), !1;
            0 > b ? P = V.length - 1 : b >= V.length ? (P = 0, c = K.loopPlaylist) : P = b, I = !c;
            var d = RegExp("http(s?)://soundcloud").test(V[P].permalink_url);
            if (C.find("#fap-progress-bar").width(0), C.find("#fap-total-time, #fap-current-time").text("00:00:00"), E.find("#fap-current-cover").attr("src", V[P].artwork_url), E.find("#fap-current-title").html(V[P].title), E.find("#fap-current-meta").html(d ? V[P].genre : V[P].meta), V[P].artwork_url ? (E.find("#fap-current-cover").show(), E.find("#fap-cover-replacement").hide()) : (E.find("#fap-current-cover").hide(), E.find("#fap-cover-replacement").show()), V[P].permalink_url) {
                E.find("#fap-social-links").children("a").show();
                var e = "http://www.facebook.com/sharer.php?u=" + encodeURIComponent(V[P].permalink_url),
                    f = "http://twitter.com/share?url=" + encodeURIComponent(V[P].permalink_url) + "&text=" + encodeURIComponent(V[P].title);
                E.find("#fap-social-links a:eq(0)").attr("href", e), E.find("#fap-social-links a:eq(1)").attr("href", f), E.find("#fap-social-links a:eq(2)").attr("href", V[P].permalink_url + "/download"), E.find("#fap-social-links a:eq(3)").attr("href", V[P].permalink_url)
            } else E.find("#fap-social-links").children("a").hide();
            L && (L.children("li").css("", "none"), L.children("li").eq(P).css("", K.activeTrackColor), L.scrollTop(L.children("li").eq(0).outerHeight(!0) * P)), c ? C.find("#fap-play-pause").removeClass("fa-play").addClass("fa-pause") : C.find("#fap-play-pause").removeClass("fa-pause").addClass("fa-play"), G && G.destruct();
            var g = {
                id: "fap_sound",
                autoPlay: c,
                autoLoad: K.autoLoad,
                volume: Q,
                whileloading: l,
                whileplaying: m,
                onfinish: n,
                onload: o
            };
            d ? (E.find("#fap-social-links").children("a:eq(3)").show(), V[P].downloadable ? E.find("#fap-social-links").children("a:eq(2)").show() : E.find("#fap-social-links").children("a:eq(2)").hide(), a.extend(g, {
                id: "fap_sound",
                url: V[P].stream_url + "?client_id=" + SC.options.client_id
            })) : (E.find("#fap-social-links").children("a:eq(2), a:eq(3)").hide(), a.extend(g, {
                id: "fap_sound",
                url: V[P].stream_url
            })), G = soundManager.createSound(g), !K.opened && c && K.openPlayerOnTrackPlay && !U && a.fullwidthAudioPlayer.setPlayerPosition("open", !0), y.trigger("onFapTrackSelect", [V[P], c])
        }, a.fullwidthAudioPlayer.setPlayerPosition = function(b, c) {
            return z.is(":animated") ? !1 : ("open" == b ? (A.children("#fap-wrapper-switcher").html(K.closeLabel), "top" == K.wrapperPosition ? (K.animatePageOnPlayerTop && a("body").animate({
                marginTop: K.height
            }, c ? 300 : 0), z.animate({
                top: -(M - K.height)
            }, c ? 300 : 0)) : z.animate({
                bottom: -(M - K.height)
            }, c ? 300 : 0), K.opened = !0) : "close" == b ? (A.children("#fap-wrapper-switcher").html(K.openLabel), "top" == K.wrapperPosition ? (K.animatePageOnPlayerTop && a("body").animate({
                marginTop: 0
            }, c ? 300 : 0), z.animate({
                top: -M - 1
            }, c ? 300 : 0)) : z.animate({
                bottom: -M - 1
            }, c ? 300 : 0), K.opened = R = !1) : "openPlaylist" == b ? ("top" == K.wrapperPosition ? (K.animatePageOnPlayerTop && a("body").animate({
                marginTop: M
            }, c ? 300 : 0), z.animate({
                top: 0
            }, 300, function() {
                L.getNiceScroll().resize().show()
            })) : z.animate({
                bottom: 0
            }, 300, function() {
                L.getNiceScroll().resize().show()
            }), R = !0) : "closePlaylist" == b && (L.getNiceScroll().hide(), "top" == K.wrapperPosition ? (K.animatePageOnPlayerTop && a("body").animate({
                marginTop: K.height
            }, c ? 300 : 0), z.animate({
                top: -(M - K.height)
            }, 300)) : z.animate({
                bottom: -(M - K.height)
            }, 300), R = !1), void 0)
        }, a.fullwidthAudioPlayer.clear = function() {
            E.find("#fap-current-cover").hide(), E.find("#fap-cover-replacement").show(), E.find("#fap-current-title, #fap-current-meta").html(""), E.find("#fap-social-links").children("a").attr("href", "").hide(), C.find("#fap-progress-bar, #fap-loading-bar").width(0), C.find("#fap-current-time, #fap-total-time").text("00:00:00"), C.find("#fap-play-pause").removeClass("fa-pause").addClass("fa-play"), I = !0, P = -1, L && L.empty(), V = [], G && G.destruct(), K.playlist && L.getNiceScroll().resize(), y.trigger("onFapClear")
        }, a.fullwidthAudioPlayer.popUp = function(a) {
            a = "undefined" != typeof a ? a : !0, T && (!window.fapPopupWin || window.fapPopupWin.closed ? d("", !1, a) : window.fapPopupWin.focus())
        }, Array.prototype.shuffle = v, this.each(function() {
            c(this)
        })
    }, a.fn.fullwidthAudioPlayer.defaults = {
        wrapperPosition: "bottom",
        mainPosition: "center",
        wrapperColor: "#f0f0f0",
        mainColor: "#000",
        fillColor: "#e3e3e3",
        metaColor: "#666666",
        strokeColor: "#e0e0e0",
        activeTrackColor: "#E8E8E8",
        twitterText: "Share on Twitter",
        facebookText: "Share on Facebook",
        downloadText: "Download",
        layout: "fullwidth",
        popupUrl: "popup.html",
        height: 70,
        playlistHeight: 158,
        coverSize: [54, 54],
        offset: 12,
        opened: !0,
        volume: !0,
        playlist: !0,
        autoLoad: !0,
        autoPlay: !1,
        playNextWhenFinished: !0,
        keyboard: !0,
        socials: !0,
        autoPopup: !1,
        randomize: !1,
        shuffle: !0,
        sortable: !1,
        base64: !0,
        xmlPath: "",
        xmlPlaylist: "",
        hideOnMobile: !1,
        loopPlaylist: !0,
        storePlaylist: !1,
        keepClosedOnceClosed: !1,
        animatePageOnPlayerTop: !1,
        openLabel: "+",
        closeLabel: "&times;",
        openPlayerOnTrackPlay: !1,
        popup: !0,
        selectedIndex: 0
    }
}(jQuery),
function(b) {
    var c, d = !1,
        e = !1,
        f = 5e3,
        g = 2e3,
        h = 0,
        i = document.getElementsByTagName("script"),
        i = i[i.length - 1].src.split("?")[0];
    c = 0 < i.split("/").length ? i.split("/").slice(0, -1).join("/") + "/" : "", Array.prototype.forEach || (Array.prototype.forEach = function(a, b) {
        for (var c = 0, d = this.length; d > c; ++c) a.call(b, this[c], c, this)
    });
    var j = window.requestAnimationFrame || !1,
        k = window.cancelAnimationFrame || !1;
    ["ms", "moz", "webkit", "o"].forEach(function(a) {
        j || (j = window[a + "RequestAnimationFrame"]), k || (k = window[a + "CancelAnimationFrame"] || window[a + "CancelRequestAnimationFrame"])
    });
    var l = window.MutationObserver || window.WebKitMutationObserver || !1,
        m = {
            zindex: "auto",
            cursoropacitymin: 0,
            cursoropacitymax: 1,
            cursorcolor: "#424242",
            cursorwidth: "5px",
            cursorborder: "1px solid #fff",
            cursorborderradius: "5px",
            scrollspeed: 60,
            mousescrollstep: 24,
            touchbehavior: !1,
            hwacceleration: !0,
            usetransition: !0,
            boxzoom: !1,
            dblclickzoom: !0,
            gesturezoom: !0,
            grabcursorenabled: !0,
            autohidemode: !0,
            background: "",
            iframeautoresize: !0,
            cursorminheight: 32,
            preservenativescrolling: !0,
            railoffset: !1,
            bouncescroll: !0,
            spacebarenabled: !0,
            railpadding: {
                top: 0,
                right: 0,
                left: 0,
                bottom: 0
            },
            disableoutline: !0,
            horizrailenabled: !0,
            railalign: "right",
            railvalign: "bottom",
            enabletranslate3d: !0,
            enablemousewheel: !0,
            enablekeyboard: !0,
            smoothscroll: !0,
            sensitiverail: !0,
            enablemouselockapi: !0,
            cursorfixedheight: !1,
            directionlockdeadzone: 6,
            hidecursordelay: 400,
            nativeparentscrolling: !0,
            enablescrollonselection: !0,
            overflowx: !0,
            overflowy: !0,
            cursordragspeed: .3,
            rtlmode: !1,
            cursordragontouch: !1
        },
        n = !1,
        o = function(a, i) {
            function o() {
                var a = t.win;
                if ("zIndex" in a) return a.zIndex();
                for (; 0 < a.length && 9 != a[0].nodeType;) {
                    var b = a.css("zIndex");
                    if (!isNaN(b) && 0 != b) return parseInt(b);
                    a = a.parent()
                }
                return !1
            }

            function q(a, b, c) {
                return b = a.css(b), a = parseFloat(b), isNaN(a) ? (a = C[b] || 0, c = 3 == a ? c ? t.win.outerHeight() - t.win.innerHeight() : t.win.outerWidth() - t.win.innerWidth() : 1, t.isie8 && a && (a += 1), c ? a : 0) : a
            }

            function r(a, b, c, d) {
                t._bind(a, b, function(d) {
                    d = d ? d : window.event;
                    var e = {
                        original: d,
                        target: d.target || d.srcElement,
                        type: "wheel",
                        deltaMode: "MozMousePixelScroll" == d.type ? 0 : 1,
                        deltaX: 0,
                        deltaZ: 0,
                        preventDefault: function() {
                            return d.preventDefault ? d.preventDefault() : d.returnValue = !1, !1
                        },
                        stopImmediatePropagation: function() {
                            d.stopImmediatePropagation ? d.stopImmediatePropagation() : d.cancelBubble = !0
                        }
                    };
                    return "mousewheel" == b ? (e.deltaY = -.025 * d.wheelDelta, d.wheelDeltaX && (e.deltaX = -.025 * d.wheelDeltaX)) : e.deltaY = d.detail, c.call(a, e)
                }, d)
            }

            function s(a, b, c) {
                var d, e;
                if (0 == a.deltaMode ? (d = -Math.floor(a.deltaX * (t.opt.mousescrollstep / 54)), e = -Math.floor(a.deltaY * (t.opt.mousescrollstep / 54))) : 1 == a.deltaMode && (d = -Math.floor(a.deltaX * t.opt.mousescrollstep), e = -Math.floor(a.deltaY * t.opt.mousescrollstep)), b && 0 == d && e && (d = e, e = 0), d && (t.scrollmom && t.scrollmom.stop(), t.lastdeltax += d, t.debounced("mousewheelx", function() {
                        var a = t.lastdeltax;
                        t.lastdeltax = 0, t.rail.drag || t.doScrollLeftBy(a)
                    }, 120)), e) {
                    if (t.opt.nativeparentscrolling && c && !t.ispage && !t.zoomactive)
                        if (0 > e) {
                            if (t.getScrollTop() >= t.page.maxh) return !0
                        } else if (0 >= t.getScrollTop()) return !0;
                    t.scrollmom && t.scrollmom.stop(), t.lastdeltay += e, t.debounced("mousewheely", function() {
                        var a = t.lastdeltay;
                        t.lastdeltay = 0, t.rail.drag || t.doScrollBy(a)
                    }, 120)
                }
                return a.stopImmediatePropagation(), a.preventDefault()
            }
            var t = this;
            if (this.version = "3.4.0", this.name = "nicescroll", this.me = i, this.opt = {
                    doc: b("body"),
                    win: !1
                }, b.extend(this.opt, m), this.opt.snapbackspeed = 80, a)
                for (var u in t.opt) "undefined" != typeof a[u] && (t.opt[u] = a[u]);
            this.iddoc = (this.doc = t.opt.doc) && this.doc[0] ? this.doc[0].id || "" : "", this.ispage = /BODY|HTML/.test(t.opt.win ? t.opt.win[0].nodeName : this.doc[0].nodeName), this.haswrapper = !1 !== t.opt.win, this.win = t.opt.win || (this.ispage ? b(window) : this.doc), this.docscroll = this.ispage && !this.haswrapper ? b(window) : this.win, this.body = b("body"), this.iframe = this.isfixed = this.viewport = !1, this.isiframe = "IFRAME" == this.doc[0].nodeName && "IFRAME" == this.win[0].nodeName, this.istextarea = "TEXTAREA" == this.win[0].nodeName, this.forcescreen = !1, this.canshowonmouseevent = "scroll" != t.opt.autohidemode, this.page = this.view = this.onzoomout = this.onzoomin = this.onscrollcancel = this.onscrollend = this.onscrollstart = this.onclick = this.ongesturezoom = this.onkeypress = this.onmousewheel = this.onmousemove = this.onmouseup = this.onmousedown = !1, this.scroll = {
                x: 0,
                y: 0
            }, this.scrollratio = {
                x: 0,
                y: 0
            }, this.cursorheight = 20, this.scrollvaluemax = 0, this.observerremover = this.observer = this.scrollmom = this.scrollrunning = this.checkrtlmode = !1;
            do this.id = "ascrail" + g++; while (document.getElementById(this.id));
            if (this.hasmousefocus = this.hasfocus = this.zoomactive = this.zoom = this.selectiondrag = this.cursorfreezed = this.cursor = this.rail = !1, this.visibility = !0, this.hidden = this.locked = !1, this.cursoractive = !0, this.overflowx = t.opt.overflowx, this.overflowy = t.opt.overflowy, this.nativescrollingarea = !1, this.checkarea = 0, this.events = [], this.saved = {}, this.delaylist = {}, this.synclist = {}, this.lastdeltay = this.lastdeltax = 0, n) u = n;
            else {
                u = document.createElement("DIV");
                var v = {
                    haspointerlock: "pointerLockElement" in document || "mozPointerLockElement" in document || "webkitPointerLockElement" in document
                };
                v.isopera = "opera" in window, v.isopera12 = v.isopera && "getUserMedia" in navigator, v.isie = "all" in document && "attachEvent" in u && !v.isopera, v.isieold = v.isie && !("msInterpolationMode" in u.style), v.isie7 = !(!v.isie || v.isieold || "documentMode" in document && 7 != document.documentMode), v.isie8 = v.isie && "documentMode" in document && 8 == document.documentMode, v.isie9 = v.isie && "performance" in window && 9 <= document.documentMode, v.isie10 = v.isie && "performance" in window && 10 <= document.documentMode, v.isie9mobile = /iemobile.9/i.test(navigator.userAgent), v.isie9mobile && (v.isie9 = !1), v.isie7mobile = !v.isie9mobile && v.isie7 && /iemobile/i.test(navigator.userAgent), v.ismozilla = "MozAppearance" in u.style, v.iswebkit = "WebkitAppearance" in u.style, v.ischrome = "chrome" in window, v.ischrome22 = v.ischrome && v.haspointerlock, v.ischrome26 = v.ischrome && "transition" in u.style, v.cantouch = "ontouchstart" in document.documentElement || "ontouchstart" in window, v.hasmstouch = window.navigator.msPointerEnabled || !1, v.ismac = /^mac$/i.test(navigator.platform), v.isios = v.cantouch && /iphone|ipad|ipod/i.test(navigator.platform), v.isios4 = v.isios && !("seal" in Object), v.isandroid = /android/i.test(navigator.userAgent), v.trstyle = !1, v.hastransform = !1, v.hastranslate3d = !1, v.transitionstyle = !1, v.hastransition = !1, v.transitionend = !1;
                for (var w = ["transform", "msTransform", "webkitTransform", "MozTransform", "OTransform"], x = 0; x < w.length; x++)
                    if ("undefined" != typeof u.style[w[x]]) {
                        v.trstyle = w[x];
                        break
                    }
                v.hastransform = 0 != v.trstyle, v.hastransform && (u.style[v.trstyle] = "translate3d(1px,2px,3px)", v.hastranslate3d = /translate3d/.test(u.style[v.trstyle])), v.transitionstyle = !1, v.prefixstyle = "", v.transitionend = !1;
                for (var w = "transition webkitTransition MozTransition OTransition OTransition msTransition KhtmlTransition".split(" "), y = " -webkit- -moz- -o- -o -ms- -khtml-".split(" "), z = "transitionend webkitTransitionEnd transitionend otransitionend oTransitionEnd msTransitionEnd KhtmlTransitionEnd".split(" "), x = 0; x < w.length; x++)
                    if (w[x] in u.style) {
                        v.transitionstyle = w[x], v.prefixstyle = y[x], v.transitionend = z[x];
                        break
                    }
                v.ischrome26 && (v.prefixstyle = y[1]), v.hastransition = v.transitionstyle;
                a: {
                    for (w = ["-moz-grab", "-webkit-grab", "grab"], (v.ischrome && !v.ischrome22 || v.isie) && (w = []), x = 0; x < w.length; x++)
                        if (y = w[x], u.style.cursor = y, u.style.cursor == y) {
                            w = y;
                            break a
                        }
                    w = "url(http://www.google.com/intl/en_ALL/mapfiles/openhand.cur),n-resize"
                }
                v.cursorgrabvalue = w, v.hasmousecapture = "setCapture" in u, v.hasMutationObserver = !1 !== l, u = null, u = n = v
            }
            this.detected = u;
            var A = b.extend({}, this.detected);
            if (this.ishwscroll = (this.canhwscroll = A.hastransform && t.opt.hwacceleration) && t.haswrapper, this.istouchcapable = !1, A.cantouch && A.ischrome && !A.isios && !A.isandroid && (this.istouchcapable = !0, A.cantouch = !1), A.cantouch && A.ismozilla && !A.isios && (this.istouchcapable = !0, A.cantouch = !1), t.opt.enablemouselockapi || (A.hasmousecapture = !1, A.haspointerlock = !1), this.delayed = function(a, b, c, d) {
                    var e = t.delaylist[a],
                        f = (new Date).getTime();
                    return !d && e && e.tt ? !1 : (e && e.tt && clearTimeout(e.tt), e && e.last + c > f && !e.tt ? t.delaylist[a] = {
                        last: f + c,
                        tt: setTimeout(function() {
                            t.delaylist[a].tt = 0, b.call()
                        }, c)
                    } : e && e.tt || (t.delaylist[a] = {
                        last: f,
                        tt: 0
                    }, setTimeout(function() {
                        b.call()
                    }, 0)), void 0)
                }, this.debounced = function(a, b, c) {
                    var d = t.delaylist[a];
                    (new Date).getTime(), t.delaylist[a] = b, d || setTimeout(function() {
                        var b = t.delaylist[a];
                        t.delaylist[a] = !1, b.call()
                    }, c)
                }, this.synched = function(a, b) {
                    return t.synclist[a] = b, t.onsync || (j(function() {
                        t.onsync = !1;
                        for (a in t.synclist) {
                            var b = t.synclist[a];
                            b && b.call(t), t.synclist[a] = !1
                        }
                    }), t.onsync = !0), a
                }, this.unsynched = function(a) {
                    t.synclist[a] && (t.synclist[a] = !1)
                }, this.css = function(a, b) {
                    for (var c in b) t.saved.css.push([a, c, a.css(c)]), a.css(c, b[c])
                }, this.scrollTop = function(a) {
                    return "undefined" == typeof a ? t.getScrollTop() : t.setScrollTop(a)
                }, this.scrollLeft = function(a) {
                    return "undefined" == typeof a ? t.getScrollLeft() : t.setScrollLeft(a)
                }, BezierClass = function(a, b, c, d, e, f, g) {
                    this.st = a, this.ed = b, this.spd = c, this.p1 = d || 0, this.p2 = e || 1, this.p3 = f || 0, this.p4 = g || 1, this.ts = (new Date).getTime(), this.df = this.ed - this.st
                }, BezierClass.prototype = {
                    B2: function(a) {
                        return 3 * a * a * (1 - a)
                    },
                    B3: function(a) {
                        return 3 * a * (1 - a) * (1 - a)
                    },
                    B4: function(a) {
                        return (1 - a) * (1 - a) * (1 - a)
                    },
                    getNow: function() {
                        var a = 1 - ((new Date).getTime() - this.ts) / this.spd,
                            b = this.B2(a) + this.B3(a) + this.B4(a);
                        return 0 > a ? this.ed : this.st + Math.round(this.df * b)
                    },
                    update: function(a, b) {
                        return this.st = this.getNow(), this.ed = a, this.spd = b, this.ts = (new Date).getTime(), this.df = this.ed - this.st, this
                    }
                }, this.ishwscroll) {
                this.doc.translate = {
                    x: 0,
                    y: 0,
                    tx: "0px",
                    ty: "0px"
                }, A.hastranslate3d && A.isios && this.doc.css("-webkit-backface-visibility", "hidden");
                var B = function() {
                    var a = t.doc.css(A.trstyle);
                    return a && "matrix" == a.substr(0, 6) ? a.replace(/^.*\((.*)\)$/g, "$1").replace(/px/g, "").split(/, +/) : !1
                };
                this.getScrollTop = function(a) {
                    if (!a) {
                        if (a = B()) return 16 == a.length ? -a[13] : -a[5];
                        if (t.timerscroll && t.timerscroll.bz) return t.timerscroll.bz.getNow()
                    }
                    return t.doc.translate.y
                }, this.getScrollLeft = function(a) {
                    if (!a) {
                        if (a = B()) return 16 == a.length ? -a[12] : -a[4];
                        if (t.timerscroll && t.timerscroll.bh) return t.timerscroll.bh.getNow()
                    }
                    return t.doc.translate.x
                }, this.notifyScrollEvent = document.createEvent ? function(a) {
                    var b = document.createEvent("UIEvents");
                    b.initUIEvent("scroll", !1, !0, window, 1), a.dispatchEvent(b)
                } : document.fireEvent ? function(a) {
                    var b = document.createEventObject();
                    a.fireEvent("onscroll"), b.cancelBubble = !0
                } : function() {}, A.hastranslate3d && t.opt.enabletranslate3d ? (this.setScrollTop = function(a, b) {
                    t.doc.translate.y = a, t.doc.translate.ty = -1 * a + "px", t.doc.css(A.trstyle, "translate3d(" + t.doc.translate.tx + "," + t.doc.translate.ty + ",0px)"), b || t.notifyScrollEvent(t.win[0])
                }, this.setScrollLeft = function(a, b) {
                    t.doc.translate.x = a, t.doc.translate.tx = -1 * a + "px", t.doc.css(A.trstyle, "translate3d(" + t.doc.translate.tx + "," + t.doc.translate.ty + ",0px)"), b || t.notifyScrollEvent(t.win[0])
                }) : (this.setScrollTop = function(a, b) {
                    t.doc.translate.y = a, t.doc.translate.ty = -1 * a + "px", t.doc.css(A.trstyle, "translate(" + t.doc.translate.tx + "," + t.doc.translate.ty + ")"), b || t.notifyScrollEvent(t.win[0])
                }, this.setScrollLeft = function(a, b) {
                    t.doc.translate.x = a, t.doc.translate.tx = -1 * a + "px", t.doc.css(A.trstyle, "translate(" + t.doc.translate.tx + "," + t.doc.translate.ty + ")"), b || t.notifyScrollEvent(t.win[0])
                })
            } else this.getScrollTop = function() {
                return t.docscroll.scrollTop()
            }, this.setScrollTop = function(a) {
                return t.docscroll.scrollTop(a)
            }, this.getScrollLeft = function() {
                return t.docscroll.scrollLeft()
            }, this.setScrollLeft = function(a) {
                return t.docscroll.scrollLeft(a)
            };
            this.getTarget = function(a) {
                return a ? a.target ? a.target : a.srcElement ? a.srcElement : !1 : !1
            }, this.hasParent = function(a, b) {
                if (!a) return !1;
                for (var c = a.target || a.srcElement || a || !1; c && c.id != b;) c = c.parentNode || !1;
                return !1 !== c
            };
            var C = {
                thin: 1,
                medium: 3,
                thick: 5
            };
            this.getOffset = function() {
                if (t.isfixed) return {
                    top: parseFloat(t.win.css("top")),
                    left: parseFloat(t.win.css("left"))
                };
                if (!t.viewport) return t.win.offset();
                var a = t.win.offset(),
                    b = t.viewport.offset();
                return {
                    top: a.top - b.top + t.viewport.scrollTop(),
                    left: a.left - b.left + t.viewport.scrollLeft()
                }
            }, this.updateScrollBar = function(a) {
                if (t.ishwscroll) t.rail.css({
                    height: t.win.innerHeight()
                }), t.railh && t.railh.css({
                    width: t.win.innerWidth()
                });
                else {
                    var b = t.getOffset(),
                        c = b.top,
                        d = b.left,
                        c = c + q(t.win, "border-top-width", !0);
                    t.win.outerWidth(), t.win.innerWidth();
                    var d = d + (t.rail.align ? t.win.outerWidth() - q(t.win, "border-right-width") - t.rail.width : q(t.win, "border-left-width")),
                        e = t.opt.railoffset;
                    e && (e.top && (c += e.top), t.rail.align && e.left && (d += e.left)), t.locked || t.rail.css({
                        top: c,
                        left: d,
                        height: a ? a.h : t.win.innerHeight()
                    }), t.zoom && t.zoom.css({
                        top: c + 1,
                        left: 1 == t.rail.align ? d - 20 : d + t.rail.width + 4
                    }), t.railh && !t.locked && (c = b.top, d = b.left, a = t.railh.align ? c + q(t.win, "border-top-width", !0) + t.win.innerHeight() - t.railh.height : c + q(t.win, "border-top-width", !0), d += q(t.win, "border-left-width"), t.railh.css({
                        top: a,
                        left: d,
                        width: t.railh.width
                    }))
                }
            }, this.doRailClick = function(a, b, c) {
                var d;
                t.locked || (t.cancelEvent(a), b ? (b = c ? t.doScrollLeft : t.doScrollTop, d = c ? (a.pageX - t.railh.offset().left - t.cursorwidth / 2) * t.scrollratio.x : (a.pageY - t.rail.offset().top - t.cursorheight / 2) * t.scrollratio.y, b(d)) : (b = c ? t.doScrollLeftBy : t.doScrollBy, d = c ? t.scroll.x : t.scroll.y, a = c ? a.pageX - t.railh.offset().left : a.pageY - t.rail.offset().top, c = c ? t.view.w : t.view.h, d >= a ? b(c) : b(-c)))
            }, t.hasanimationframe = j, t.hascancelanimationframe = k, t.hasanimationframe ? t.hascancelanimationframe || (k = function() {
                t.cancelAnimationFrame = !0
            }) : (j = function(a) {
                return setTimeout(a, 15 - Math.floor(+new Date / 1e3) % 16)
            }, k = clearInterval), this.init = function() {
                if (t.saved.css = [], A.isie7mobile) return !0;
                if (A.hasmstouch && t.css(t.ispage ? b("html") : t.win, {
                        "-ms-touch-action": "none"
                    }), t.zindex = "auto", t.zindex = t.ispage || "auto" != t.opt.zindex ? t.opt.zindex : o() || "auto", !t.ispage && "auto" != t.zindex && t.zindex > h && (h = t.zindex), t.isie && 0 == t.zindex && "auto" == t.opt.zindex && (t.zindex = "auto"), !t.ispage || !A.cantouch && !A.isieold && !A.isie9mobile) {
                    var a = t.docscroll;
                    t.ispage && (a = t.haswrapper ? t.win : t.doc), A.isie9mobile || t.css(a, {
                        "overflow-y": "hidden"
                    }), t.ispage && A.isie7 && ("BODY" == t.doc[0].nodeName ? t.css(b("html"), {
                        "overflow-y": "hidden"
                    }) : "HTML" == t.doc[0].nodeName && t.css(b("body"), {
                        "overflow-y": "hidden"
                    })), A.isios && !t.ispage && !t.haswrapper && t.css(b("body"), {
                        "-webkit-overflow-scrolling": "touch"
                    });
                    var g = b(document.createElement("div"));
                    g.css({
                        position: "relative",
                        top: 0,
                        "float": "right",
                        width: t.opt.cursorwidth,
                        height: "0px",
                        "background-color": t.opt.cursorcolor,
                        border: t.opt.cursorborder,
                        "background-clip": "padding-box",
                        "-webkit-border-radius": t.opt.cursorborderradius,
                        "-moz-border-radius": t.opt.cursorborderradius,
                        "border-radius": t.opt.cursorborderradius
                    }), g.hborder = parseFloat(g.outerHeight() - g.innerHeight()), t.cursor = g;
                    var i = b(document.createElement("div"));
                    i.attr("id", t.id), i.addClass("nicescroll-rails");
                    var j, k, m, n = ["left", "right"];
                    for (m in n) k = n[m], (j = t.opt.railpadding[k]) ? i.css("padding-" + k, j + "px") : t.opt.railpadding[k] = 0;
                    if (i.append(g), i.width = Math.max(parseFloat(t.opt.cursorwidth), g.outerWidth()) + t.opt.railpadding.left + t.opt.railpadding.right, i.css({
                            width: i.width + "px",
                            zIndex: t.zindex,
                            background: t.opt.background,
                            cursor: "default"
                        }), i.visibility = !0, i.scrollable = !0, i.align = "left" == t.opt.railalign ? 0 : 1, t.rail = i, g = t.rail.drag = !1, t.opt.boxzoom && !t.ispage && !A.isieold && (g = document.createElement("div"), t.bind(g, "click", t.doZoom), t.zoom = b(g), t.zoom.css({
                            cursor: "pointer",
                            "z-index": t.zindex,
                            backgroundImage: "url(" + c + "zoomico.png)",
                            height: 18,
                            width: 18,
                            backgroundPosition: "0px 0px"
                        }), t.opt.dblclickzoom && t.bind(t.win, "dblclick", t.doZoom), A.cantouch && t.opt.gesturezoom && (t.ongesturezoom = function(a) {
                            return 1.5 < a.scale && t.doZoomIn(a), .8 > a.scale && t.doZoomOut(a), t.cancelEvent(a)
                        }, t.bind(t.win, "gestureend", t.ongesturezoom))), t.railh = !1, t.opt.horizrailenabled) {
                        t.css(a, {
                            "overflow-x": "hidden"
                        }), g = b(document.createElement("div")), g.css({
                            position: "relative",
                            top: 0,
                            height: t.opt.cursorwidth,
                            width: "0px",
                            "background-color": t.opt.cursorcolor,
                            border: t.opt.cursorborder,
                            "background-clip": "padding-box",
                            "-webkit-border-radius": t.opt.cursorborderradius,
                            "-moz-border-radius": t.opt.cursorborderradius,
                            "border-radius": t.opt.cursorborderradius
                        }), g.wborder = parseFloat(g.outerWidth() - g.innerWidth()), t.cursorh = g;
                        var q = b(document.createElement("div"));
                        q.attr("id", t.id + "-hr"), q.addClass("nicescroll-rails"), q.height = Math.max(parseFloat(t.opt.cursorwidth), g.outerHeight()), q.css({
                            height: q.height + "px",
                            zIndex: t.zindex,
                            background: t.opt.background
                        }), q.append(g), q.visibility = !0, q.scrollable = !0, q.align = "top" == t.opt.railvalign ? 0 : 1, t.railh = q, t.railh.drag = !1
                    }
                    if (t.ispage ? (i.css({
                            position: "fixed",
                            top: "0px",
                            height: "100%"
                        }), i.align ? i.css({
                            right: "0px"
                        }) : i.css({
                            left: "0px"
                        }), t.body.append(i), t.railh && (q.css({
                            position: "fixed",
                            left: "0px",
                            width: "100%"
                        }), q.align ? q.css({
                            bottom: "0px"
                        }) : q.css({
                            top: "0px"
                        }), t.body.append(q))) : (t.ishwscroll ? ("static" == t.win.css("position") && t.css(t.win, {
                            position: "relative"
                        }), a = "HTML" == t.win[0].nodeName ? t.body : t.win, t.zoom && (t.zoom.css({
                            position: "absolute",
                            top: 1,
                            right: 0,
                            "margin-right": i.width + 4
                        }), a.append(t.zoom)), i.css({
                            position: "absolute",
                            top: 0
                        }), i.align ? i.css({
                            right: 0
                        }) : i.css({
                            left: 0
                        }), a.append(i), q && (q.css({
                            position: "absolute",
                            left: 0,
                            bottom: 0
                        }), q.align ? q.css({
                            bottom: 0
                        }) : q.css({
                            top: 0
                        }), a.append(q))) : (t.isfixed = "fixed" == t.win.css("position"), a = t.isfixed ? "fixed" : "absolute", t.isfixed || (t.viewport = t.getViewport(t.win[0])), t.viewport && (t.body = t.viewport, 0 == /relative|absolute/.test(t.viewport.css("position")) && t.css(t.viewport, {
                            position: "relative"
                        })), i.css({
                            position: a
                        }), t.zoom && t.zoom.css({
                            position: a
                        }), t.updateScrollBar(), t.body.append(i), t.zoom && t.body.append(t.zoom), t.railh && (q.css({
                            position: a
                        }), t.body.append(q))), A.isios && t.css(t.win, {
                            "-webkit-tap-highlight-color": "rgba(0,0,0,0)",
                            "-webkit-touch-callout": "none"
                        }), A.isie && t.opt.disableoutline && t.win.attr("hideFocus", "true"), A.iswebkit && t.opt.disableoutline && t.win.css({
                            outline: "none"
                        })), !1 === t.opt.autohidemode ? (t.autohidedom = !1, t.rail.css({
                            opacity: t.opt.cursoropacitymax
                        }), t.railh && t.railh.css({
                            opacity: t.opt.cursoropacitymax
                        })) : !0 === t.opt.autohidemode ? (t.autohidedom = b().add(t.rail), A.isie8 && (t.autohidedom = t.autohidedom.add(t.cursor)), t.railh && (t.autohidedom = t.autohidedom.add(t.railh)), t.railh && A.isie8 && (t.autohidedom = t.autohidedom.add(t.cursorh))) : "scroll" == t.opt.autohidemode ? (t.autohidedom = b().add(t.rail), t.railh && (t.autohidedom = t.autohidedom.add(t.railh))) : "cursor" == t.opt.autohidemode ? (t.autohidedom = b().add(t.cursor), t.railh && (t.autohidedom = t.autohidedom.add(t.cursorh))) : "hidden" == t.opt.autohidemode && (t.autohidedom = !1, t.hide(), t.locked = !1), A.isie9mobile) t.scrollmom = new p(t), t.onmangotouch = function() {
                        var a = t.getScrollTop(),
                            b = t.getScrollLeft();
                        if (a == t.scrollmom.lastscrolly && b == t.scrollmom.lastscrollx) return !0;
                        var c = a - t.mangotouch.sy,
                            d = b - t.mangotouch.sx;
                        if (0 != Math.round(Math.sqrt(Math.pow(d, 2) + Math.pow(c, 2)))) {
                            var e = 0 > c ? -1 : 1,
                                f = 0 > d ? -1 : 1,
                                g = +new Date;
                            t.mangotouch.lazy && clearTimeout(t.mangotouch.lazy), 80 < g - t.mangotouch.tm || t.mangotouch.dry != e || t.mangotouch.drx != f ? (t.scrollmom.stop(), t.scrollmom.reset(b, a), t.mangotouch.sy = a, t.mangotouch.ly = a, t.mangotouch.sx = b, t.mangotouch.lx = b, t.mangotouch.dry = e, t.mangotouch.drx = f, t.mangotouch.tm = g) : (t.scrollmom.stop(), t.scrollmom.update(t.mangotouch.sx - d, t.mangotouch.sy - c), t.mangotouch.tm = g, c = Math.max(Math.abs(t.mangotouch.ly - a), Math.abs(t.mangotouch.lx - b)), t.mangotouch.ly = a, t.mangotouch.lx = b, c > 2 && (t.mangotouch.lazy = setTimeout(function() {
                                t.mangotouch.lazy = !1, t.mangotouch.dry = 0, t.mangotouch.drx = 0, t.mangotouch.tm = 0, t.scrollmom.doMomentum(30)
                            }, 100)))
                        }
                    }, i = t.getScrollTop(), q = t.getScrollLeft(), t.mangotouch = {
                        sy: i,
                        ly: i,
                        dry: 0,
                        sx: q,
                        lx: q,
                        drx: 0,
                        lazy: !1,
                        tm: 0
                    }, t.bind(t.docscroll, "scroll", t.onmangotouch);
                    else {
                        if (A.cantouch || t.istouchcapable || t.opt.touchbehavior || A.hasmstouch) {
                            t.scrollmom = new p(t), t.ontouchstart = function(a) {
                                if (a.pointerType && 2 != a.pointerType) return !1;
                                if (!t.locked) {
                                    if (A.hasmstouch)
                                        for (var c = a.target ? a.target : !1; c;) {
                                            var d = b(c).getNiceScroll();
                                            if (0 < d.length && d[0].me == t.me) break;
                                            if (0 < d.length) return !1;
                                            if ("DIV" == c.nodeName && c.id == t.id) break;
                                            c = c.parentNode ? c.parentNode : !1
                                        }
                                    if (t.cancelScroll(), (c = t.getTarget(a)) && /INPUT/i.test(c.nodeName) && /range/i.test(c.type)) return t.stopPropagation(a);
                                    if (!("clientX" in a) && "changedTouches" in a && (a.clientX = a.changedTouches[0].clientX, a.clientY = a.changedTouches[0].clientY), t.forcescreen && (d = a, a = {
                                            original: a.original ? a.original : a
                                        }, a.clientX = d.screenX, a.clientY = d.screenY), t.rail.drag = {
                                            x: a.clientX,
                                            y: a.clientY,
                                            sx: t.scroll.x,
                                            sy: t.scroll.y,
                                            st: t.getScrollTop(),
                                            sl: t.getScrollLeft(),
                                            pt: 2,
                                            dl: !1
                                        }, t.ispage || !t.opt.directionlockdeadzone) t.rail.drag.dl = "f";
                                    else {
                                        var d = b(window).width(),
                                            e = b(window).height(),
                                            f = Math.max(document.body.scrollWidth, document.documentElement.scrollWidth),
                                            g = Math.max(document.body.scrollHeight, document.documentElement.scrollHeight),
                                            e = Math.max(0, g - e),
                                            d = Math.max(0, f - d);
                                        t.rail.drag.ck = !t.rail.scrollable && t.railh.scrollable ? e > 0 ? "v" : !1 : t.rail.scrollable && !t.railh.scrollable ? d > 0 ? "h" : !1 : !1, t.rail.drag.ck || (t.rail.drag.dl = "f")
                                    }
                                    if (t.opt.touchbehavior && t.isiframe && A.isie && (d = t.win.position(), t.rail.drag.x += d.left, t.rail.drag.y += d.top), t.hasmoving = !1, t.lastmouseup = !1, t.scrollmom.reset(a.clientX, a.clientY), !A.cantouch && !this.istouchcapable && !A.hasmstouch) {
                                        if (!c || !/INPUT|SELECT|TEXTAREA/i.test(c.nodeName)) return !t.ispage && A.hasmousecapture && c.setCapture(), t.cancelEvent(a);
                                        /SUBMIT|CANCEL|BUTTON/i.test(b(c).attr("type")) && (pc = {
                                            tg: c,
                                            click: !1
                                        }, t.preventclick = pc)
                                    }
                                }
                            }, t.ontouchend = function(a) {
                                return a.pointerType && 2 != a.pointerType ? !1 : t.rail.drag && 2 == t.rail.drag.pt && (t.scrollmom.doMomentum(), t.rail.drag = !1, t.hasmoving && (t.hasmoving = !1, t.lastmouseup = !0, t.hideCursor(), A.hasmousecapture && document.releaseCapture(), !A.cantouch)) ? t.cancelEvent(a) : void 0
                            };
                            var r = t.opt.touchbehavior && t.isiframe && !A.hasmousecapture;
                            t.ontouchmove = function(a, c) {
                                if (a.pointerType && 2 != a.pointerType) return !1;
                                if (t.rail.drag && 2 == t.rail.drag.pt) {
                                    if (A.cantouch && "undefined" == typeof a.original) return !0;
                                    if (t.hasmoving = !0, t.preventclick && !t.preventclick.click && (t.preventclick.click = t.preventclick.tg.onclick || !1, t.preventclick.tg.onclick = t.onpreventclick), a = b.extend({
                                            original: a
                                        }, a), "changedTouches" in a && (a.clientX = a.changedTouches[0].clientX, a.clientY = a.changedTouches[0].clientY), t.forcescreen) {
                                        var d = a;
                                        a = {
                                            original: a.original ? a.original : a
                                        }, a.clientX = d.screenX, a.clientY = d.screenY
                                    }
                                    if (d = ofy = 0, r && !c) {
                                        var e = t.win.position(),
                                            d = -e.left;
                                        ofy = -e.top
                                    }
                                    var f = a.clientY + ofy,
                                        e = f - t.rail.drag.y,
                                        g = a.clientX + d,
                                        h = g - t.rail.drag.x,
                                        i = t.rail.drag.st - e;
                                    if (t.ishwscroll && t.opt.bouncescroll ? 0 > i ? i = Math.round(i / 2) : i > t.page.maxh && (i = t.page.maxh + Math.round((i - t.page.maxh) / 2)) : (0 > i && (f = i = 0), i > t.page.maxh && (i = t.page.maxh, f = 0)), t.railh && t.railh.scrollable) {
                                        var j = t.rail.drag.sl - h;
                                        t.ishwscroll && t.opt.bouncescroll ? 0 > j ? j = Math.round(j / 2) : j > t.page.maxw && (j = t.page.maxw + Math.round((j - t.page.maxw) / 2)) : (0 > j && (g = j = 0), j > t.page.maxw && (j = t.page.maxw, g = 0))
                                    }
                                    if (d = !1, t.rail.drag.dl) d = !0, "v" == t.rail.drag.dl ? j = t.rail.drag.sl : "h" == t.rail.drag.dl && (i = t.rail.drag.st);
                                    else {
                                        var e = Math.abs(e),
                                            h = Math.abs(h),
                                            k = t.opt.directionlockdeadzone;
                                        if ("v" == t.rail.drag.ck) {
                                            if (e > k && .3 * e >= h) return t.rail.drag = !1, !0;
                                            h > k && (t.rail.drag.dl = "f", b("body").scrollTop(b("body").scrollTop()))
                                        } else if ("h" == t.rail.drag.ck) {
                                            if (h > k && .3 * az >= e) return t.rail.drag = !1, !0;
                                            e > k && (t.rail.drag.dl = "f", b("body").scrollLeft(b("body").scrollLeft()))
                                        }
                                    }
                                    if (t.synched("touchmove", function() {
                                            t.rail.drag && 2 == t.rail.drag.pt && (t.prepareTransition && t.prepareTransition(0), t.rail.scrollable && t.setScrollTop(i), t.scrollmom.update(g, f), t.railh && t.railh.scrollable ? (t.setScrollLeft(j), t.showCursor(i, j)) : t.showCursor(i), A.isie10 && document.selection.clear())
                                        }), A.ischrome && t.istouchcapable && (d = !1), d) return t.cancelEvent(a)
                                }
                            }
                        }
                        if (t.onmousedown = function(a, b) {
                                if (!t.rail.drag || 1 == t.rail.drag.pt) {
                                    if (t.locked) return t.cancelEvent(a);
                                    t.cancelScroll(), t.rail.drag = {
                                        x: a.clientX,
                                        y: a.clientY,
                                        sx: t.scroll.x,
                                        sy: t.scroll.y,
                                        pt: 1,
                                        hr: !!b
                                    };
                                    var c = t.getTarget(a);
                                    return !t.ispage && A.hasmousecapture && c.setCapture(), t.isiframe && !A.hasmousecapture && (t.saved.csspointerevents = t.doc.css("pointer-events"), t.css(t.doc, {
                                        "pointer-events": "none"
                                    })), t.cancelEvent(a)
                                }
                            }, t.onmouseup = function(a) {
                                return t.rail.drag && (A.hasmousecapture && document.releaseCapture(), t.isiframe && !A.hasmousecapture && t.doc.css("pointer-events", t.saved.csspointerevents), 1 == t.rail.drag.pt) ? (t.rail.drag = !1, t.cancelEvent(a)) : void 0
                            }, t.onmousemove = function(a) {
                                if (t.rail.drag && 1 == t.rail.drag.pt) {
                                    if (A.ischrome && 0 == a.which) return t.onmouseup(a);
                                    if (t.cursorfreezed = !0, t.rail.drag.hr) {
                                        t.scroll.x = t.rail.drag.sx + (a.clientX - t.rail.drag.x), 0 > t.scroll.x && (t.scroll.x = 0);
                                        var b = t.scrollvaluemaxw;
                                        t.scroll.x > b && (t.scroll.x = b)
                                    } else t.scroll.y = t.rail.drag.sy + (a.clientY - t.rail.drag.y), 0 > t.scroll.y && (t.scroll.y = 0), b = t.scrollvaluemax, t.scroll.y > b && (t.scroll.y = b);
                                    return t.synched("mousemove", function() {
                                        t.rail.drag && 1 == t.rail.drag.pt && (t.showCursor(), t.rail.drag.hr ? t.doScrollLeft(Math.round(t.scroll.x * t.scrollratio.x), t.opt.cursordragspeed) : t.doScrollTop(Math.round(t.scroll.y * t.scrollratio.y), t.opt.cursordragspeed))
                                    }), t.cancelEvent(a)
                                }
                            }, A.cantouch || t.opt.touchbehavior) t.onpreventclick = function(a) {
                            return t.preventclick ? (t.preventclick.tg.onclick = t.preventclick.click, t.preventclick = !1, t.cancelEvent(a)) : void 0
                        }, t.bind(t.win, "mousedown", t.ontouchstart), t.onclick = A.isios ? !1 : function(a) {
                            return t.lastmouseup ? (t.lastmouseup = !1, t.cancelEvent(a)) : !0
                        }, t.opt.grabcursorenabled && A.cursorgrabvalue && (t.css(t.ispage ? t.doc : t.win, {
                            cursor: A.cursorgrabvalue
                        }), t.css(t.rail, {
                            cursor: A.cursorgrabvalue
                        }));
                        else {
                            var s = function(a) {
                                if (t.selectiondrag) {
                                    if (a) {
                                        var b = t.win.outerHeight();
                                        a = a.pageY - t.selectiondrag.top, a > 0 && b > a && (a = 0), a >= b && (a -= b), t.selectiondrag.df = a
                                    }
                                    0 != t.selectiondrag.df && (t.doScrollBy(2 * -Math.floor(t.selectiondrag.df / 6)), t.debounced("doselectionscroll", function() {
                                        s()
                                    }, 50))
                                }
                            };
                            t.hasTextSelected = "getSelection" in document ? function() {
                                return 0 < document.getSelection().rangeCount
                            } : "selection" in document ? function() {
                                return "None" != document.selection.type
                            } : function() {
                                return !1
                            }, t.onselectionstart = function() {
                                t.ispage || (t.selectiondrag = t.win.offset())
                            }, t.onselectionend = function() {
                                t.selectiondrag = !1
                            }, t.onselectiondrag = function(a) {
                                t.selectiondrag && t.hasTextSelected() && t.debounced("selectionscroll", function() {
                                    s(a)
                                }, 250)
                            }
                        }
                        A.hasmstouch && (t.css(t.rail, {
                            "-ms-touch-action": "none"
                        }), t.css(t.cursor, {
                            "-ms-touch-action": "none"
                        }), t.bind(t.win, "MSPointerDown", t.ontouchstart), t.bind(document, "MSPointerUp", t.ontouchend), t.bind(document, "MSPointerMove", t.ontouchmove), t.bind(t.cursor, "MSGestureHold", function(a) {
                            a.preventDefault()
                        }), t.bind(t.cursor, "contextmenu", function(a) {
                            a.preventDefault()
                        })), this.istouchcapable && (t.bind(t.win, "touchstart", t.ontouchstart), t.bind(document, "touchend", t.ontouchend), t.bind(document, "touchcancel", t.ontouchend), t.bind(document, "touchmove", t.ontouchmove)), t.bind(t.cursor, "mousedown", t.onmousedown), t.bind(t.cursor, "mouseup", t.onmouseup), t.railh && (t.bind(t.cursorh, "mousedown", function(a) {
                            t.onmousedown(a, !0)
                        }), t.bind(t.cursorh, "mouseup", function(a) {
                            return t.rail.drag && 2 == t.rail.drag.pt ? void 0 : (t.rail.drag = !1, t.hasmoving = !1, t.hideCursor(), A.hasmousecapture && document.releaseCapture(), t.cancelEvent(a))
                        })), (t.opt.cursordragontouch || !A.cantouch && !t.opt.touchbehavior) && (t.rail.css({
                            cursor: "default"
                        }), t.railh && t.railh.css({
                            cursor: "default"
                        }), t.jqbind(t.rail, "mouseenter", function() {
                            t.canshowonmouseevent && t.showCursor(), t.rail.active = !0
                        }), t.jqbind(t.rail, "mouseleave", function() {
                            t.rail.active = !1, t.rail.drag || t.hideCursor()
                        }), t.opt.sensitiverail && (t.bind(t.rail, "click", function(a) {
                            t.doRailClick(a, !1, !1)
                        }), t.bind(t.rail, "dblclick", function(a) {
                            t.doRailClick(a, !0, !1)
                        }), t.bind(t.cursor, "click", function(a) {
                            t.cancelEvent(a)
                        }), t.bind(t.cursor, "dblclick", function(a) {
                            t.cancelEvent(a)
                        })), t.railh && (t.jqbind(t.railh, "mouseenter", function() {
                            t.canshowonmouseevent && t.showCursor(), t.rail.active = !0
                        }), t.jqbind(t.railh, "mouseleave", function() {
                            t.rail.active = !1, t.rail.drag || t.hideCursor()
                        }), t.opt.sensitiverail && (t.bind(t.railh, "click", function(a) {
                            t.doRailClick(a, !1, !0)
                        }), t.bind(t.railh, "dblclick", function(a) {
                            t.doRailClick(a, !0, !0)
                        }), t.bind(t.cursorh, "click", function(a) {
                            t.cancelEvent(a)
                        }), t.bind(t.cursorh, "dblclick", function(a) {
                            t.cancelEvent(a)
                        })))), A.cantouch || t.opt.touchbehavior ? (t.bind(A.hasmousecapture ? t.win : document, "mouseup", t.ontouchend), t.bind(document, "mousemove", t.ontouchmove), t.onclick && t.bind(document, "click", t.onclick), t.opt.cursordragontouch && (t.bind(t.cursor, "mousedown", t.onmousedown), t.bind(t.cursor, "mousemove", t.onmousemove), t.cursorh && t.bind(t.cursorh, "mousedown", t.onmousedown), t.cursorh && t.bind(t.cursorh, "mousemove", t.onmousemove))) : (t.bind(A.hasmousecapture ? t.win : document, "mouseup", t.onmouseup), t.bind(document, "mousemove", t.onmousemove), t.onclick && t.bind(document, "click", t.onclick), !t.ispage && t.opt.enablescrollonselection && (t.bind(t.win[0], "mousedown", t.onselectionstart), t.bind(document, "mouseup", t.onselectionend), t.bind(t.cursor, "mouseup", t.onselectionend), t.cursorh && t.bind(t.cursorh, "mouseup", t.onselectionend), t.bind(document, "mousemove", t.onselectiondrag)), t.zoom && (t.jqbind(t.zoom, "mouseenter", function() {
                            t.canshowonmouseevent && t.showCursor(), t.rail.active = !0
                        }), t.jqbind(t.zoom, "mouseleave", function() {
                            t.rail.active = !1, t.rail.drag || t.hideCursor()
                        }))), t.opt.enablemousewheel && (t.isiframe || t.bind(A.isie && t.ispage ? document : t.docscroll, "mousewheel", t.onmousewheel), t.bind(t.rail, "mousewheel", t.onmousewheel), t.railh && t.bind(t.railh, "mousewheel", t.onmousewheelhr)), !t.ispage && !A.cantouch && !/HTML|BODY/.test(t.win[0].nodeName) && (t.win.attr("tabindex") || t.win.attr({
                            tabindex: f++
                        }), t.jqbind(t.win, "focus", function(a) {
                            d = t.getTarget(a).id || !0, t.hasfocus = !0, t.canshowonmouseevent && t.noticeCursor()
                        }), t.jqbind(t.win, "blur", function() {
                            d = !1, t.hasfocus = !1
                        }), t.jqbind(t.win, "mouseenter", function(a) {
                            e = t.getTarget(a).id || !0, t.hasmousefocus = !0, t.canshowonmouseevent && t.noticeCursor()
                        }), t.jqbind(t.win, "mouseleave", function() {
                            e = !1, t.hasmousefocus = !1
                        }))
                    }
                    if (t.onkeypress = function(a) {
                            if (t.locked && 0 == t.page.maxh) return !0;
                            a = a ? a : window.e;
                            var b = t.getTarget(a);
                            if (b && /INPUT|TEXTAREA|SELECT|OPTION/.test(b.nodeName) && (!b.getAttribute("type") && !b.type || !/submit|button|cancel/i.tp)) return !0;
                            if (t.hasfocus || t.hasmousefocus && !d || t.ispage && !d && !e) {
                                if (b = a.keyCode, t.locked && 27 != b) return t.cancelEvent(a);
                                var c = a.ctrlKey || !1,
                                    f = a.shiftKey || !1,
                                    g = !1;
                                switch (b) {
                                    case 38:
                                    case 63233:
                                        t.doScrollBy(72), g = !0;
                                        break;
                                    case 40:
                                    case 63235:
                                        t.doScrollBy(-72), g = !0;
                                        break;
                                    case 37:
                                    case 63232:
                                        t.railh && (c ? t.doScrollLeft(0) : t.doScrollLeftBy(72), g = !0);
                                        break;
                                    case 39:
                                    case 63234:
                                        t.railh && (c ? t.doScrollLeft(t.page.maxw) : t.doScrollLeftBy(-72), g = !0);
                                        break;
                                    case 33:
                                    case 63276:
                                        t.doScrollBy(t.view.h), g = !0;
                                        break;
                                    case 34:
                                    case 63277:
                                        t.doScrollBy(-t.view.h), g = !0;
                                        break;
                                    case 36:
                                    case 63273:
                                        t.railh && c ? t.doScrollPos(0, 0) : t.doScrollTo(0), g = !0;
                                        break;
                                    case 35:
                                    case 63275:
                                        t.railh && c ? t.doScrollPos(t.page.maxw, t.page.maxh) : t.doScrollTo(t.page.maxh), g = !0;
                                        break;
                                    case 32:
                                        t.opt.spacebarenabled && (f ? t.doScrollBy(t.view.h) : t.doScrollBy(-t.view.h), g = !0);
                                        break;
                                    case 27:
                                        t.zoomactive && (t.doZoom(), g = !0)
                                }
                                if (g) return t.cancelEvent(a)
                            }
                        }, t.opt.enablekeyboard && t.bind(document, A.isopera && !A.isopera12 ? "keypress" : "keydown", t.onkeypress), t.bind(window, "resize", t.lazyResize), t.bind(window, "orientationchange", t.lazyResize), t.bind(window, "load", t.lazyResize), A.ischrome && !t.ispage && !t.haswrapper) {
                        var u = t.win.attr("style"),
                            i = parseFloat(t.win.css("width")) + 1;
                        t.win.css("width", i), t.synched("chromefix", function() {
                            t.win.attr("style", u)
                        })
                    }
                    t.onAttributeChange = function() {
                        t.lazyResize(250)
                    }, !t.ispage && !t.haswrapper && (!1 !== l ? (t.observer = new l(function(a) {
                        a.forEach(t.onAttributeChange)
                    }), t.observer.observe(t.win[0], {
                        childList: !0,
                        characterData: !1,
                        attributes: !0,
                        subtree: !1
                    }), t.observerremover = new l(function(a) {
                        a.forEach(function(a) {
                            if (0 < a.removedNodes.length)
                                for (var b in a.removedNodes)
                                    if (a.removedNodes[b] == t.win[0]) return t.remove()
                        })
                    }), t.observerremover.observe(t.win[0].parentNode, {
                        childList: !0,
                        characterData: !1,
                        attributes: !1,
                        subtree: !1
                    })) : (t.bind(t.win, A.isie && !A.isie9 ? "propertychange" : "DOMAttrModified", t.onAttributeChange), A.isie9 && t.win[0].attachEvent("onpropertychange", t.onAttributeChange), t.bind(t.win, "DOMNodeRemoved", function(a) {
                        a.target == t.win[0] && t.remove()
                    }))), !t.ispage && t.opt.boxzoom && t.bind(window, "resize", t.resizeZoom), t.istextarea && t.bind(t.win, "mouseup", t.lazyResize), t.checkrtlmode = !0, t.lazyResize(30)
                }
                if ("IFRAME" == this.doc[0].nodeName) {
                    var v = function() {
                        t.iframexd = !1;
                        try {
                            var a = "contentDocument" in this ? this.contentDocument : this.contentWindow.document
                        } catch (c) {
                            t.iframexd = !0, a = !1
                        }
                        if (t.iframexd) return "console" in window && console.log("NiceScroll error: policy restriced iframe"), !0;
                        if (t.forcescreen = !0, t.isiframe && (t.iframe = {
                                doc: b(a),
                                html: t.doc.contents().find("html")[0],
                                body: t.doc.contents().find("body")[0]
                            }, t.getContentSize = function() {
                                return {
                                    w: Math.max(t.iframe.html.scrollWidth, t.iframe.body.scrollWidth),
                                    h: Math.max(t.iframe.html.scrollHeight, t.iframe.body.scrollHeight)
                                }
                            }, t.docscroll = b(t.iframe.body)), !A.isios && t.opt.iframeautoresize && !t.isiframe) {
                            t.win.scrollTop(0), t.doc.height("");
                            var d = Math.max(a.getElementsByTagName("html")[0].scrollHeight, a.body.scrollHeight);
                            t.doc.height(d)
                        }
                        t.lazyResize(30), A.isie7 && t.css(b(t.iframe.html), {
                            "overflow-y": "hidden"
                        }), t.css(b(t.iframe.body), {
                            "overflow-y": "hidden"
                        }), "contentWindow" in this ? t.bind(this.contentWindow, "scroll", t.onscroll) : t.bind(a, "scroll", t.onscroll), t.opt.enablemousewheel && t.bind(a, "mousewheel", t.onmousewheel), t.opt.enablekeyboard && t.bind(a, A.isopera ? "keypress" : "keydown", t.onkeypress), (A.cantouch || t.opt.touchbehavior) && (t.bind(a, "mousedown", t.onmousedown), t.bind(a, "mousemove", function(a) {
                            t.onmousemove(a, !0)
                        }), t.opt.grabcursorenabled && A.cursorgrabvalue && t.css(b(a.body), {
                            cursor: A.cursorgrabvalue
                        })), t.bind(a, "mouseup", t.onmouseup), t.zoom && (t.opt.dblclickzoom && t.bind(a, "dblclick", t.doZoom), t.ongesturezoom && t.bind(a, "gestureend", t.ongesturezoom))
                    };
                    this.doc[0].readyState && "complete" == this.doc[0].readyState && setTimeout(function() {
                        v.call(t.doc[0], !1)
                    }, 500), t.bind(this.doc, "load", v)
                }
            }, this.showCursor = function(a, b) {
                t.cursortimeout && (clearTimeout(t.cursortimeout), t.cursortimeout = 0), t.rail && (t.autohidedom && (t.autohidedom.stop().css({
                    opacity: t.opt.cursoropacitymax
                }), t.cursoractive = !0), t.rail.drag && 1 == t.rail.drag.pt || ("undefined" != typeof a && !1 !== a && (t.scroll.y = Math.round(1 * a / t.scrollratio.y)), "undefined" != typeof b && (t.scroll.x = Math.round(1 * b / t.scrollratio.x))), t.cursor.css({
                    height: t.cursorheight,
                    top: t.scroll.y
                }), t.cursorh && (!t.rail.align && t.rail.visibility ? t.cursorh.css({
                    width: t.cursorwidth,
                    left: t.scroll.x + t.rail.width
                }) : t.cursorh.css({
                    width: t.cursorwidth,
                    left: t.scroll.x
                }), t.cursoractive = !0), t.zoom && t.zoom.stop().css({
                    opacity: t.opt.cursoropacitymax
                }))
            }, this.hideCursor = function(a) {
                !t.cursortimeout && t.rail && t.autohidedom && (t.cursortimeout = setTimeout(function() {
                    t.rail.active && t.showonmouseevent || (t.autohidedom.stop().animate({
                        opacity: t.opt.cursoropacitymin
                    }), t.zoom && t.zoom.stop().animate({
                        opacity: t.opt.cursoropacitymin
                    }), t.cursoractive = !1), t.cursortimeout = 0
                }, a || t.opt.hidecursordelay))
            }, this.noticeCursor = function(a, b, c) {
                t.showCursor(b, c), t.rail.active || t.hideCursor(a)
            }, this.getContentSize = t.ispage ? function() {
                return {
                    w: Math.max(document.body.scrollWidth, document.documentElement.scrollWidth),
                    h: Math.max(document.body.scrollHeight, document.documentElement.scrollHeight)
                }
            } : t.haswrapper ? function() {
                return {
                    w: t.doc.outerWidth() + parseInt(t.win.css("paddingLeft")) + parseInt(t.win.css("paddingRight")),
                    h: t.doc.outerHeight() + parseInt(t.win.css("paddingTop")) + parseInt(t.win.css("paddingBottom"))
                }
            } : function() {
                return {
                    w: t.docscroll[0].scrollWidth,
                    h: t.docscroll[0].scrollHeight
                }
            }, this.onResize = function(a, b) {
                if (!t.win) return !1;
                if (!t.haswrapper && !t.ispage) {
                    if ("none" == t.win.css("display")) return t.visibility && t.hideRail().hideRailHr(), !1;
                    !t.hidden && !t.visibility && t.showRail().showRailHr()
                }
                var c = t.page.maxh,
                    d = t.page.maxw,
                    e = t.view.w;
                if (t.view = {
                        w: t.ispage ? t.win.width() : parseInt(t.win[0].clientWidth),
                        h: t.ispage ? t.win.height() : parseInt(t.win[0].clientHeight)
                    }, t.page = b ? b : t.getContentSize(), t.page.maxh = Math.max(0, t.page.h - t.view.h), t.page.maxw = Math.max(0, t.page.w - t.view.w), t.page.maxh == c && t.page.maxw == d && t.view.w == e) {
                    if (t.ispage) return t;
                    if (c = t.win.offset(), t.lastposition && (d = t.lastposition, d.top == c.top && d.left == c.left)) return t;
                    t.lastposition = c
                }
                return 0 == t.page.maxh ? (t.hideRail(), t.scrollvaluemax = 0, t.scroll.y = 0, t.scrollratio.y = 0, t.cursorheight = 0, t.setScrollTop(0), t.rail.scrollable = !1) : t.rail.scrollable = !0, 0 == t.page.maxw ? (t.hideRailHr(), t.scrollvaluemaxw = 0, t.scroll.x = 0, t.scrollratio.x = 0, t.cursorwidth = 0, t.setScrollLeft(0), t.railh.scrollable = !1) : t.railh.scrollable = !0, t.locked = 0 == t.page.maxh && 0 == t.page.maxw, t.locked ? (t.ispage || t.updateScrollBar(t.view), !1) : (t.hidden || t.visibility ? !t.hidden && !t.railh.visibility && t.showRailHr() : t.showRail().showRailHr(), t.istextarea && t.win.css("resize") && "none" != t.win.css("resize") && (t.view.h -= 20), t.cursorheight = Math.min(t.view.h, Math.round(t.view.h * (t.view.h / t.page.h))), t.cursorheight = t.opt.cursorfixedheight ? t.opt.cursorfixedheight : Math.max(t.opt.cursorminheight, t.cursorheight), t.cursorwidth = Math.min(t.view.w, Math.round(t.view.w * (t.view.w / t.page.w))), t.cursorwidth = t.opt.cursorfixedheight ? t.opt.cursorfixedheight : Math.max(t.opt.cursorminheight, t.cursorwidth), t.scrollvaluemax = t.view.h - t.cursorheight - t.cursor.hborder, t.railh && (t.railh.width = 0 < t.page.maxh ? t.view.w - t.rail.width : t.view.w, t.scrollvaluemaxw = t.railh.width - t.cursorwidth - t.cursorh.wborder), t.checkrtlmode && t.railh && (t.checkrtlmode = !1, t.opt.rtlmode && 0 == t.scroll.x && t.setScrollLeft(t.page.maxw)), t.ispage || t.updateScrollBar(t.view), t.scrollratio = {
                    x: t.page.maxw / t.scrollvaluemaxw,
                    y: t.page.maxh / t.scrollvaluemax
                }, t.getScrollTop() > t.page.maxh ? t.doScrollTop(t.page.maxh) : (t.scroll.y = Math.round(t.getScrollTop() * (1 / t.scrollratio.y)), t.scroll.x = Math.round(t.getScrollLeft() * (1 / t.scrollratio.x)), t.cursoractive && t.noticeCursor()), t.scroll.y && 0 == t.getScrollTop() && t.doScrollTo(Math.floor(t.scroll.y * t.scrollratio.y)), t)
            }, this.resize = t.onResize, this.lazyResize = function(a) {
                return a = isNaN(a) ? 30 : a, t.delayed("resize", t.resize, a), t
            }, this._bind = function(a, b, c, d) {
                t.events.push({
                    e: a,
                    n: b,
                    f: c,
                    b: d,
                    q: !1
                }), a.addEventListener ? a.addEventListener(b, c, d || !1) : a.attachEvent ? a.attachEvent("on" + b, c) : a["on" + b] = c
            }, this.jqbind = function(a, c, d) {
                t.events.push({
                    e: a,
                    n: c,
                    f: d,
                    q: !0
                }), b(a).bind(c, d)
            }, this.bind = function(a, b, c, d) {
                var e = "jquery" in a ? a[0] : a;
                "mousewheel" == b ? "onwheel" in t.win ? t._bind(e, "wheel", c, d || !1) : (a = "undefined" != typeof document.onmousewheel ? "mousewheel" : "DOMMouseScroll", r(e, a, c, d || !1), "DOMMouseScroll" == a && r(e, "MozMousePixelScroll", c, d || !1)) : e.addEventListener ? (A.cantouch && /mouseup|mousedown|mousemove/.test(b) && t._bind(e, "mousedown" == b ? "touchstart" : "mouseup" == b ? "touchend" : "touchmove", function(a) {
                    if (a.touches) {
                        if (2 > a.touches.length) {
                            var b = a.touches.length ? a.touches[0] : a;
                            b.original = a, c.call(this, b)
                        }
                    } else a.changedTouches && (b = a.changedTouches[0], b.original = a, c.call(this, b))
                }, d || !1), t._bind(e, b, c, d || !1), A.cantouch && "mouseup" == b && t._bind(e, "touchcancel", c, d || !1)) : t._bind(e, b, function(a) {
                    return (a = a || window.event || !1) && a.srcElement && (a.target = a.srcElement), "pageY" in a || (a.pageX = a.clientX + document.documentElement.scrollLeft, a.pageY = a.clientY + document.documentElement.scrollTop), !1 === c.call(e, a) || !1 === d ? t.cancelEvent(a) : !0
                })
            }, this._unbind = function(a, b, c, d) {
                a.removeEventListener ? a.removeEventListener(b, c, d) : a.detachEvent ? a.detachEvent("on" + b, c) : a["on" + b] = !1
            }, this.unbindAll = function() {
                for (var a = 0; a < t.events.length; a++) {
                    var b = t.events[a];
                    b.q ? b.e.unbind(b.n, b.f) : t._unbind(b.e, b.n, b.f, b.b)
                }
            }, this.cancelEvent = function(a) {
                return (a = a.original ? a.original : a ? a : window.event || !1) ? (a.preventDefault && a.preventDefault(), a.stopPropagation && a.stopPropagation(), a.preventManipulation && a.preventManipulation(), a.cancelBubble = !0, a.cancel = !0, a.returnValue = !1) : !1
            }, this.stopPropagation = function(a) {
                return (a = a.original ? a.original : a ? a : window.event || !1) ? a.stopPropagation ? a.stopPropagation() : (a.cancelBubble && (a.cancelBubble = !0), !1) : !1
            }, this.showRail = function() {
                return 0 == t.page.maxh || !t.ispage && "none" == t.win.css("display") || (t.visibility = !0, t.rail.visibility = !0, t.rail.css("display", "block")), t
            }, this.showRailHr = function() {
                return t.railh ? (0 == t.page.maxw || !t.ispage && "none" == t.win.css("display") || (t.railh.visibility = !0, t.railh.css("display", "block")), t) : t
            }, this.hideRail = function() {
                return t.visibility = !1, t.rail.visibility = !1, t.rail.css("display", "none"), t
            }, this.hideRailHr = function() {
                return t.railh ? (t.railh.visibility = !1, t.railh.css("display", "none"), t) : t
            }, this.show = function() {
                return t.hidden = !1, t.locked = !1, t.showRail().showRailHr()
            }, this.hide = function() {
                return t.hidden = !0, t.locked = !0, t.hideRail().hideRailHr()
            }, this.toggle = function() {
                return t.hidden ? t.show() : t.hide()
            }, this.remove = function() {
                t.stop(), t.cursortimeout && clearTimeout(t.cursortimeout), t.doZoomOut(), t.unbindAll(), !1 !== t.observer && t.observer.disconnect(), !1 !== t.observerremover && t.observerremover.disconnect(), t.events = [], t.cursor && t.cursor.remove(), t.cursorh && t.cursorh.remove(), t.rail && t.rail.remove(), t.railh && t.railh.remove(), t.zoom && t.zoom.remove();
                for (var a = 0; a < t.saved.css.length; a++) {
                    var c = t.saved.css[a];
                    c[0].css(c[1], "undefined" == typeof c[2] ? "" : c[2])
                }
                t.saved = !1, t.me.data("__nicescroll", ""), b.nicescroll.remove(t);
                for (var d in t) t[d] = null, delete t[d];
                t = null
            }, this.scrollstart = function(a) {
                return this.onscrollstart = a, t
            }, this.scrollend = function(a) {
                return this.onscrollend = a, t
            }, this.scrollcancel = function(a) {
                return this.onscrollcancel = a, t
            }, this.zoomin = function(a) {
                return this.onzoomin = a, t
            }, this.zoomout = function(a) {
                return this.onzoomout = a, t
            }, this.isScrollable = function(a) {
                if (a = a.target ? a.target : a, "OPTION" == a.nodeName) return !0;
                for (; a && 1 == a.nodeType && !/BODY|HTML/.test(a.nodeName);) {
                    var c = b(a),
                        c = c.css("overflowY") || c.css("overflowX") || c.css("overflow") || "";
                    if (/scroll|auto/.test(c)) return a.clientHeight != a.scrollHeight;
                    a = a.parentNode ? a.parentNode : !1
                }
                return !1
            }, this.getViewport = function(a) {
                for (a = a && a.parentNode ? a.parentNode : !1; a && 1 == a.nodeType && !/BODY|HTML/.test(a.nodeName);) {
                    var c = b(a),
                        d = c.css("overflowY") || c.css("overflowX") || c.css("overflow") || "";
                    if (/scroll|auto/.test(d) && a.clientHeight != a.scrollHeight || 0 < c.getNiceScroll().length) return c;
                    a = a.parentNode ? a.parentNode : !1
                }
                return !1
            }, this.onmousewheel = function(a) {
                if (t.locked) return !0;
                if (t.rail.drag) return t.cancelEvent(a);
                if (!t.rail.scrollable) return t.railh && t.railh.scrollable ? t.onmousewheelhr(a) : !0;
                var b = +new Date,
                    c = !1;
                return t.opt.preservenativescrolling && t.checkarea + 600 < b && (t.nativescrollingarea = t.isScrollable(a), c = !0), t.checkarea = b, t.nativescrollingarea ? !0 : ((a = s(a, !1, c)) && (t.checkarea = 0), a)
            }, this.onmousewheelhr = function(a) {
                if (t.locked || !t.railh.scrollable) return !0;
                if (t.rail.drag) return t.cancelEvent(a);
                var b = +new Date,
                    c = !1;
                return t.opt.preservenativescrolling && t.checkarea + 600 < b && (t.nativescrollingarea = t.isScrollable(a), c = !0), t.checkarea = b, t.nativescrollingarea ? !0 : t.locked ? t.cancelEvent(a) : s(a, !0, c)
            }, this.stop = function() {
                return t.cancelScroll(), t.scrollmon && t.scrollmon.stop(), t.cursorfreezed = !1, t.scroll.y = Math.round(t.getScrollTop() * (1 / t.scrollratio.y)), t.noticeCursor(), t
            }, this.getTransitionSpeed = function(a) {
                var b = Math.round(10 * t.opt.scrollspeed);
                return a = Math.min(b, Math.round(a / 20 * t.opt.scrollspeed)), a > 20 ? a : 0
            }, t.opt.smoothscroll ? t.ishwscroll && A.hastransition && t.opt.usetransition ? (this.prepareTransition = function(a, b) {
                var c = b ? a > 20 ? a : 0 : t.getTransitionSpeed(a),
                    d = c ? A.prefixstyle + "transform " + c + "ms ease-out" : "";
                return t.lasttransitionstyle && t.lasttransitionstyle == d || (t.lasttransitionstyle = d, t.doc.css(A.transitionstyle, d)), c
            }, this.doScrollLeft = function(a, b) {
                var c = t.scrollrunning ? t.newscrolly : t.getScrollTop();
                t.doScrollPos(a, c, b)
            }, this.doScrollTop = function(a, b) {
                var c = t.scrollrunning ? t.newscrollx : t.getScrollLeft();
                t.doScrollPos(c, a, b)
            }, this.doScrollPos = function(a, b, c) {
                var d = t.getScrollTop(),
                    e = t.getScrollLeft();
                return (0 > (t.newscrolly - d) * (b - d) || 0 > (t.newscrollx - e) * (a - e)) && t.cancelScroll(), 0 == t.opt.bouncescroll && (0 > b ? b = 0 : b > t.page.maxh && (b = t.page.maxh), 0 > a ? a = 0 : a > t.page.maxw && (a = t.page.maxw)), t.scrollrunning && a == t.newscrollx && b == t.newscrolly ? !1 : (t.newscrolly = b, t.newscrollx = a, t.newscrollspeed = c || !1, t.timer ? !1 : (t.timer = setTimeout(function() {
                    var c, d, e = t.getScrollTop(),
                        f = t.getScrollLeft();
                    c = a - f, d = b - e, c = Math.round(Math.sqrt(Math.pow(c, 2) + Math.pow(d, 2))), c = t.newscrollspeed && 1 < t.newscrollspeed ? t.newscrollspeed : t.getTransitionSpeed(c), t.newscrollspeed && 1 >= t.newscrollspeed && (c *= t.newscrollspeed), t.prepareTransition(c, !0), t.timerscroll && t.timerscroll.tm && clearInterval(t.timerscroll.tm), c > 0 && (!t.scrollrunning && t.onscrollstart && t.onscrollstart.call(t, {
                        type: "scrollstart",
                        current: {
                            x: f,
                            y: e
                        },
                        request: {
                            x: a,
                            y: b
                        },
                        end: {
                            x: t.newscrollx,
                            y: t.newscrolly
                        },
                        speed: c
                    }), A.transitionend ? t.scrollendtrapped || (t.scrollendtrapped = !0, t.bind(t.doc, A.transitionend, t.onScrollEnd, !1)) : (t.scrollendtrapped && clearTimeout(t.scrollendtrapped), t.scrollendtrapped = setTimeout(t.onScrollEnd, c)), t.timerscroll = {
                        bz: new BezierClass(e, t.newscrolly, c, 0, 0, .58, 1),
                        bh: new BezierClass(f, t.newscrollx, c, 0, 0, .58, 1)
                    }, t.cursorfreezed || (t.timerscroll.tm = setInterval(function() {
                        t.showCursor(t.getScrollTop(), t.getScrollLeft())
                    }, 60))), t.synched("doScroll-set", function() {
                        t.timer = 0, t.scrollendtrapped && (t.scrollrunning = !0), t.setScrollTop(t.newscrolly), t.setScrollLeft(t.newscrollx), t.scrollendtrapped || t.onScrollEnd()
                    })
                }, 50), void 0))
            }, this.cancelScroll = function() {
                if (!t.scrollendtrapped) return !0;
                var a = t.getScrollTop(),
                    b = t.getScrollLeft();
                return t.scrollrunning = !1, A.transitionend || clearTimeout(A.transitionend), t.scrollendtrapped = !1, t._unbind(t.doc, A.transitionend, t.onScrollEnd), t.prepareTransition(0), t.setScrollTop(a), t.railh && t.setScrollLeft(b), t.timerscroll && t.timerscroll.tm && clearInterval(t.timerscroll.tm), t.timerscroll = !1, t.cursorfreezed = !1, t.showCursor(a, b), t
            }, this.onScrollEnd = function() {
                t.scrollendtrapped && t._unbind(t.doc, A.transitionend, t.onScrollEnd), t.scrollendtrapped = !1, t.prepareTransition(0), t.timerscroll && t.timerscroll.tm && clearInterval(t.timerscroll.tm), t.timerscroll = !1;
                var a = t.getScrollTop(),
                    b = t.getScrollLeft();
                return t.setScrollTop(a), t.railh && t.setScrollLeft(b), t.noticeCursor(!1, a, b), t.cursorfreezed = !1, 0 > a ? a = 0 : a > t.page.maxh && (a = t.page.maxh), 0 > b ? b = 0 : b > t.page.maxw && (b = t.page.maxw), a != t.newscrolly || b != t.newscrollx ? t.doScrollPos(b, a, t.opt.snapbackspeed) : (t.onscrollend && t.scrollrunning && t.onscrollend.call(t, {
                    type: "scrollend",
                    current: {
                        x: b,
                        y: a
                    },
                    end: {
                        x: t.newscrollx,
                        y: t.newscrolly
                    }
                }), t.scrollrunning = !1, void 0)
            }) : (this.doScrollLeft = function(a, b) {
                var c = t.scrollrunning ? t.newscrolly : t.getScrollTop();
                t.doScrollPos(a, c, b)
            }, this.doScrollTop = function(a, b) {
                var c = t.scrollrunning ? t.newscrollx : t.getScrollLeft();
                t.doScrollPos(c, a, b)
            }, this.doScrollPos = function(a, b, c) {
                function d() {
                    if (t.cancelAnimationFrame) return !0;
                    if (t.scrollrunning = !0, l = 1 - l) return t.timer = j(d) || 1;
                    var a = 0,
                        b = sy = t.getScrollTop();
                    if (t.dst.ay) {
                        var b = t.bzscroll ? t.dst.py + t.bzscroll.getNow() * t.dst.ay : t.newscrolly,
                            c = b - sy;
                        (0 > c && b < t.newscrolly || c > 0 && b > t.newscrolly) && (b = t.newscrolly), t.setScrollTop(b), b == t.newscrolly && (a = 1)
                    } else a = 1;
                    var e = sx = t.getScrollLeft();
                    t.dst.ax ? (e = t.bzscroll ? t.dst.px + t.bzscroll.getNow() * t.dst.ax : t.newscrollx, c = e - sx, (0 > c && e < t.newscrollx || c > 0 && e > t.newscrollx) && (e = t.newscrollx), t.setScrollLeft(e), e == t.newscrollx && (a += 1)) : a += 1, 2 == a ? (t.timer = 0, t.cursorfreezed = !1, t.bzscroll = !1, t.scrollrunning = !1, 0 > b ? b = 0 : b > t.page.maxh && (b = t.page.maxh), 0 > e ? e = 0 : e > t.page.maxw && (e = t.page.maxw), e != t.newscrollx || b != t.newscrolly ? t.doScrollPos(e, b) : t.onscrollend && t.onscrollend.call(t, {
                        type: "scrollend",
                        current: {
                            x: sx,
                            y: sy
                        },
                        end: {
                            x: t.newscrollx,
                            y: t.newscrolly
                        }
                    })) : t.timer = j(d) || 1
                }
                if (b = "undefined" == typeof b || !1 === b ? t.getScrollTop(!0) : b, t.timer && t.newscrolly == b && t.newscrollx == a) return !0;
                t.timer && k(t.timer), t.timer = 0;
                var e = t.getScrollTop(),
                    f = t.getScrollLeft();
                (0 > (t.newscrolly - e) * (b - e) || 0 > (t.newscrollx - f) * (a - f)) && t.cancelScroll(), t.newscrolly = b, t.newscrollx = a, t.bouncescroll && t.rail.visibility || (0 > t.newscrolly ? t.newscrolly = 0 : t.newscrolly > t.page.maxh && (t.newscrolly = t.page.maxh)), t.bouncescroll && t.railh.visibility || (0 > t.newscrollx ? t.newscrollx = 0 : t.newscrollx > t.page.maxw && (t.newscrollx = t.page.maxw)), t.dst = {}, t.dst.x = a - f, t.dst.y = b - e, t.dst.px = f, t.dst.py = e;
                var g = Math.round(Math.sqrt(Math.pow(t.dst.x, 2) + Math.pow(t.dst.y, 2)));
                t.dst.ax = t.dst.x / g, t.dst.ay = t.dst.y / g;
                var h = 0,
                    i = g;
                if (0 == t.dst.x ? (h = e, i = b, t.dst.ay = 1, t.dst.py = 0) : 0 == t.dst.y && (h = f, i = a, t.dst.ax = 1, t.dst.px = 0), g = t.getTransitionSpeed(g), c && 1 >= c && (g *= c), t.bzscroll = g > 0 ? t.bzscroll ? t.bzscroll.update(i, g) : new BezierClass(h, i, g, 0, 1, 0, 1) : !1, !t.timer) {
                    (e == t.page.maxh && b >= t.page.maxh || f == t.page.maxw && a >= t.page.maxw) && t.checkContentSize();
                    var l = 1;
                    t.cancelAnimationFrame = !1, t.timer = 1, t.onscrollstart && !t.scrollrunning && t.onscrollstart.call(t, {
                        type: "scrollstart",
                        current: {
                            x: f,
                            y: e
                        },
                        request: {
                            x: a,
                            y: b
                        },
                        end: {
                            x: t.newscrollx,
                            y: t.newscrolly
                        },
                        speed: g
                    }), d(), (e == t.page.maxh && b >= e || f == t.page.maxw && a >= f) && t.checkContentSize(), t.noticeCursor()
                }
            }, this.cancelScroll = function() {
                return t.timer && k(t.timer), t.timer = 0, t.bzscroll = !1, t.scrollrunning = !1, t
            }) : (this.doScrollLeft = function(a, b) {
                var c = t.getScrollTop();
                t.doScrollPos(a, c, b)
            }, this.doScrollTop = function(a, b) {
                var c = t.getScrollLeft();
                t.doScrollPos(c, a, b)
            }, this.doScrollPos = function(a, b) {
                var c = a > t.page.maxw ? t.page.maxw : a;
                0 > c && (c = 0);
                var d = b > t.page.maxh ? t.page.maxh : b;
                0 > d && (d = 0), t.synched("scroll", function() {
                    t.setScrollTop(d), t.setScrollLeft(c)
                })
            }, this.cancelScroll = function() {}), this.doScrollBy = function(a, b) {
                var c = 0,
                    c = b ? Math.floor((t.scroll.y - a) * t.scrollratio.y) : (t.timer ? t.newscrolly : t.getScrollTop(!0)) - a;
                if (t.bouncescroll) {
                    var d = Math.round(t.view.h / 2); - d > c ? c = -d : c > t.page.maxh + d && (c = t.page.maxh + d)
                }
                return t.cursorfreezed = !1, py = t.getScrollTop(!0), 0 > c && 0 >= py ? t.noticeCursor() : c > t.page.maxh && py >= t.page.maxh ? (t.checkContentSize(), t.noticeCursor()) : (t.doScrollTop(c), void 0)
            }, this.doScrollLeftBy = function(a, b) {
                var c = 0,
                    c = b ? Math.floor((t.scroll.x - a) * t.scrollratio.x) : (t.timer ? t.newscrollx : t.getScrollLeft(!0)) - a;
                if (t.bouncescroll) {
                    var d = Math.round(t.view.w / 2); - d > c ? c = -d : c > t.page.maxw + d && (c = t.page.maxw + d)
                }
                return t.cursorfreezed = !1, px = t.getScrollLeft(!0), 0 > c && 0 >= px || c > t.page.maxw && px >= t.page.maxw ? t.noticeCursor() : (t.doScrollLeft(c), void 0)
            }, this.doScrollTo = function(a, b) {
                b && Math.round(a * t.scrollratio.y), t.cursorfreezed = !1, t.doScrollTop(a)
            }, this.checkContentSize = function() {
                var a = t.getContentSize();
                (a.h != t.page.h || a.w != t.page.w) && t.resize(!1, a)
            }, t.onscroll = function() {
                t.rail.drag || t.cursorfreezed || t.synched("scroll", function() {
                    t.scroll.y = Math.round(t.getScrollTop() * (1 / t.scrollratio.y)), t.railh && (t.scroll.x = Math.round(t.getScrollLeft() * (1 / t.scrollratio.x))), t.noticeCursor()
                })
            }, t.bind(t.docscroll, "scroll", t.onscroll), this.doZoomIn = function(a) {
                if (!t.zoomactive) {
                    t.zoomactive = !0, t.zoomrestore = {
                        style: {}
                    };
                    var c, d = "position top left zIndex backgroundColor marginTop marginBottom marginLeft marginRight".split(" "),
                        e = t.win[0].style;
                    for (c in d) {
                        var f = d[c];
                        t.zoomrestore.style[f] = "undefined" != typeof e[f] ? e[f] : ""
                    }
                    return t.zoomrestore.style.width = t.win.css("width"), t.zoomrestore.style.height = t.win.css("height"), t.zoomrestore.padding = {
                        w: t.win.outerWidth() - t.win.width(),
                        h: t.win.outerHeight() - t.win.height()
                    }, A.isios4 && (t.zoomrestore.scrollTop = b(window).scrollTop(), b(window).scrollTop(0)), t.win.css({
                        position: A.isios4 ? "absolute" : "fixed",
                        top: 0,
                        left: 0,
                        "z-index": h + 100,
                        margin: "0px"
                    }), d = t.win.css("backgroundColor"), ("" == d || /transparent|rgba\(0, 0, 0, 0\)|rgba\(0,0,0,0\)/.test(d)) && t.win.css("backgroundColor", "#fff"), t.rail.css({
                        "z-index": h + 101
                    }), t.zoom.css({
                        "z-index": h + 102
                    }), t.zoom.css("backgroundPosition", "0px -18px"), t.resizeZoom(), t.onzoomin && t.onzoomin.call(t), t.cancelEvent(a)
                }
            }, this.doZoomOut = function(a) {
                return t.zoomactive ? (t.zoomactive = !1, t.win.css("margin", ""), t.win.css(t.zoomrestore.style), A.isios4 && b(window).scrollTop(t.zoomrestore.scrollTop), t.rail.css({
                    "z-index": t.zindex
                }), t.zoom.css({
                    "z-index": t.zindex
                }), t.zoomrestore = !1, t.zoom.css("backgroundPosition", "0px 0px"), t.onResize(), t.onzoomout && t.onzoomout.call(t), t.cancelEvent(a)) : void 0
            }, this.doZoom = function(a) {
                return t.zoomactive ? t.doZoomOut(a) : t.doZoomIn(a)
            }, this.resizeZoom = function() {
                if (t.zoomactive) {
                    var a = t.getScrollTop();
                    t.win.css({
                        width: b(window).width() - t.zoomrestore.padding.w + "px",
                        height: b(window).height() - t.zoomrestore.padding.h + "px"
                    }), t.onResize(), t.setScrollTop(Math.min(t.page.maxh, a))
                }
            }, this.init(), b.nicescroll.push(this)
        },
        p = function(a) {
            var b = this;
            this.nc = a, this.steptime = this.lasttime = this.speedy = this.speedx = this.lasty = this.lastx = 0, this.snapy = this.snapx = !1, this.demuly = this.demulx = 0, this.lastscrolly = this.lastscrollx = -1, this.timer = this.chky = this.chkx = 0, this.time = function() {
                return +new Date
            }, this.reset = function(a, c) {
                b.stop();
                var d = b.time();
                b.steptime = 0, b.lasttime = d, b.speedx = 0, b.speedy = 0, b.lastx = a, b.lasty = c, b.lastscrollx = -1, b.lastscrolly = -1
            }, this.update = function(a, c) {
                var d = b.time();
                b.steptime = d - b.lasttime, b.lasttime = d;
                var d = c - b.lasty,
                    e = a - b.lastx,
                    f = b.nc.getScrollTop(),
                    g = b.nc.getScrollLeft(),
                    f = f + d,
                    g = g + e;
                b.snapx = 0 > g || g > b.nc.page.maxw, b.snapy = 0 > f || f > b.nc.page.maxh, b.speedx = e, b.speedy = d, b.lastx = a, b.lasty = c
            }, this.stop = function() {
                b.nc.unsynched("domomentum2d"), b.timer && clearTimeout(b.timer), b.timer = 0, b.lastscrollx = -1, b.lastscrolly = -1
            }, this.doSnapy = function(a, c) {
                var d = !1;
                0 > c ? (c = 0, d = !0) : c > b.nc.page.maxh && (c = b.nc.page.maxh, d = !0), 0 > a ? (a = 0, d = !0) : a > b.nc.page.maxw && (a = b.nc.page.maxw, d = !0), d && b.nc.doScrollPos(a, c, b.nc.opt.snapbackspeed)
            }, this.doMomentum = function(a) {
                var c = b.time(),
                    d = a ? c + a : b.lasttime;
                a = b.nc.getScrollLeft();
                var e = b.nc.getScrollTop(),
                    f = b.nc.page.maxh,
                    g = b.nc.page.maxw;
                if (b.speedx = g > 0 ? Math.min(60, b.speedx) : 0, b.speedy = f > 0 ? Math.min(60, b.speedy) : 0, d = d && 50 >= c - d, (0 > e || e > f || 0 > a || a > g) && (d = !1), a = b.speedx && d ? b.speedx : !1, b.speedy && d && b.speedy || a) {
                    var h = Math.max(16, b.steptime);
                    h > 50 && (a = h / 50, b.speedx *= a, b.speedy *= a, h = 50), b.demulxy = 0, b.lastscrollx = b.nc.getScrollLeft(), b.chkx = b.lastscrollx, b.lastscrolly = b.nc.getScrollTop(), b.chky = b.lastscrolly;
                    var i = b.lastscrollx,
                        j = b.lastscrolly,
                        k = function() {
                            var a = 600 < b.time() - c ? .04 : .02;
                            b.speedx && (i = Math.floor(b.lastscrollx - b.speedx * (1 - b.demulxy)), b.lastscrollx = i, 0 > i || i > g) && (a = .1), b.speedy && (j = Math.floor(b.lastscrolly - b.speedy * (1 - b.demulxy)), b.lastscrolly = j, 0 > j || j > f) && (a = .1), b.demulxy = Math.min(1, b.demulxy + a), b.nc.synched("domomentum2d", function() {
                                b.speedx && (b.nc.getScrollLeft() != b.chkx && b.stop(), b.chkx = i, b.nc.setScrollLeft(i)), b.speedy && (b.nc.getScrollTop() != b.chky && b.stop(), b.chky = j, b.nc.setScrollTop(j)), b.timer || (b.nc.hideCursor(), b.doSnapy(i, j))
                            }), 1 > b.demulxy ? b.timer = setTimeout(k, h) : (b.stop(), b.nc.hideCursor(), b.doSnapy(i, j))
                        };
                    k()
                } else b.doSnapy(b.nc.getScrollLeft(), b.nc.getScrollTop())
            }
        },
        q = b.fn.scrollTop;
    b.cssHooks.pageYOffset = {
        get: function(a) {
            var c = b.data(a, "__nicescroll") || !1;
            return c && c.ishwscroll ? c.getScrollTop() : q.call(a)
        },
        set: function(a, c) {
            var d = b.data(a, "__nicescroll") || !1;
            return d && d.ishwscroll ? d.setScrollTop(parseInt(c)) : q.call(a, c), this
        }
    }, b.fn.scrollTop = function(a) {
        if ("undefined" == typeof a) {
            var c = this[0] ? b.data(this[0], "__nicescroll") || !1 : !1;
            return c && c.ishwscroll ? c.getScrollTop() : q.call(this)
        }
        return this.each(function() {
            var c = b.data(this, "__nicescroll") || !1;
            c && c.ishwscroll ? c.setScrollTop(parseInt(a)) : q.call(b(this), a)
        })
    };
    var r = b.fn.scrollLeft;
    b.cssHooks.pageXOffset = {
        get: function(a) {
            var c = b.data(a, "__nicescroll") || !1;
            return c && c.ishwscroll ? c.getScrollLeft() : r.call(a)
        },
        set: function(a, c) {
            var d = b.data(a, "__nicescroll") || !1;
            return d && d.ishwscroll ? d.setScrollLeft(parseInt(c)) : r.call(a, c), this
        }
    }, b.fn.scrollLeft = function(a) {
        if ("undefined" == typeof a) {
            var c = this[0] ? b.data(this[0], "__nicescroll") || !1 : !1;
            return c && c.ishwscroll ? c.getScrollLeft() : r.call(this)
        }
        return this.each(function() {
            var c = b.data(this, "__nicescroll") || !1;
            c && c.ishwscroll ? c.setScrollLeft(parseInt(a)) : r.call(b(this), a)
        })
    };
    for (var s = function(c) {
            var d = this;
            if (this.length = 0, this.name = "nicescrollarray", this.each = function(a) {
                    for (var b = 0, c = 0; c < d.length; c++) a.call(d[c], b++);
                    return d
                }, this.push = function(a) {
                    d[d.length] = a, d.length++
                }, this.remove = function(a) {
                    d.each(function(b) {
                        this.id === a.id && (delete d[b], d.length--)
                    })
                }, this.eq = function(a) {
                    return d[a]
                }, c)
                for (a = 0; a < c.length; a++) {
                    var e = b.data(c[a], "__nicescroll") || !1;
                    e && (this[this.length] = e, this.length++)
                }
            return this
        }, i = s.prototype, t = "show hide toggle onResize resize remove stop doScrollPos".split(" "), u = function(a, b) {
            a[b] = function() {
                var a = arguments;
                return this.each(function() {
                    this[b].apply(this, a)
                })
            }
        }, v = 0; v < t.length; v++) u(i, t[v]);
    b.fn.getNiceScroll = function(a) {
        return "undefined" == typeof a ? new s(this) : b.data(this[a], "__nicescroll") || !1
    }, b.extend(b.expr[":"], {
        nicescroll: function(a) {
            return b.data(a, "__nicescroll") ? !0 : !1
        }
    }), b.fn.niceScroll = function(a, c) {
        "undefined" == typeof c && "object" == typeof a && !("jquery" in a) && (c = a, a = !1);
        var d = new s;
        "undefined" == typeof c && (c = {}), a && (c.doc = b(a), c.win = b(this));
        var e = !("doc" in c);
        return !e && !("win" in c) && (c.win = b(this)), this.each(function() {
            var a = b(this).data("__nicescroll") || !1;
            a || (c.doc = e ? b(this) : c.doc, a = new o(c, b(this)), b(this).data("__nicescroll", a)), d.push(a)
        }), 1 == d.length ? d[0] : d
    }, window.NiceScroll = {
        getjQuery: function() {
            return b
        }
    }, b.nicescroll || (b.nicescroll = new s, b.nicescroll.options = m)
}(jQuery);
var Base64 = {
    _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
    encode: function(a) {
        var b, c, d, e, f, g, h, i = "",
            j = 0;
        for (a = Base64._utf8_encode(a); j < a.length;) b = a.charCodeAt(j++), c = a.charCodeAt(j++), d = a.charCodeAt(j++), e = b >> 2, f = (3 & b) << 4 | c >> 4, g = (15 & c) << 2 | d >> 6, h = 63 & d, isNaN(c) ? g = h = 64 : isNaN(d) && (h = 64), i = i + this._keyStr.charAt(e) + this._keyStr.charAt(f) + this._keyStr.charAt(g) + this._keyStr.charAt(h);
        return i
    },
    decode: function(a) {
        var b, c, d, e, f, g, h, i = "",
            j = 0;
        for (a = a.replace(/[^A-Za-z0-9\+\/\=]/g, ""); j < a.length;) e = this._keyStr.indexOf(a.charAt(j++)), f = this._keyStr.indexOf(a.charAt(j++)), g = this._keyStr.indexOf(a.charAt(j++)), h = this._keyStr.indexOf(a.charAt(j++)), b = e << 2 | f >> 4, c = (15 & f) << 4 | g >> 2, d = (3 & g) << 6 | h, i += String.fromCharCode(b), 64 != g && (i += String.fromCharCode(c)), 64 != h && (i += String.fromCharCode(d));
        return i = Base64._utf8_decode(i)
    },
    _utf8_encode: function(a) {
        a = a.replace(/\r\n/g, "\n");
        for (var b = "", c = 0; c < a.length; c++) {
            var d = a.charCodeAt(c);
            128 > d ? b += String.fromCharCode(d) : d > 127 && 2048 > d ? (b += String.fromCharCode(192 | d >> 6), b += String.fromCharCode(128 | 63 & d)) : (b += String.fromCharCode(224 | d >> 12), b += String.fromCharCode(128 | 63 & d >> 6), b += String.fromCharCode(128 | 63 & d))
        }
        return b
    },
    _utf8_decode: function(a) {
        for (var b = "", c = 0, d = c1 = c2 = 0; c < a.length;) d = a.charCodeAt(c), 128 > d ? (b += String.fromCharCode(d), c++) : d > 191 && 224 > d ? (c2 = a.charCodeAt(c + 1), b += String.fromCharCode((31 & d) << 6 | 63 & c2), c += 2) : (c2 = a.charCodeAt(c + 1), c3 = a.charCodeAt(c + 2), b += String.fromCharCode((15 & d) << 12 | (63 & c2) << 6 | 63 & c3), c += 3);
        return b
    }
};