(window.flatsomeJsonp = window.flatsomeJsonp || []).push([
  [3],
  {
    55: function (t, o) {
      !(function (t, o, e) {
        function i(o, e) {
          this.bodyOverflowX,
            (this.callbacks = { hide: [], show: [] }),
            (this.checkInterval = null),
            this.Content,
            (this.$el = t(o)),
            this.$elProxy,
            this.elProxyPosition,
            (this.enabled = !0),
            (this.options = t.extend({}, l, e)),
            (this.mouseIsOverProxy = !1),
            (this.namespace = "tooltipster-" + Math.round(1e5 * Math.random())),
            (this.Status = "hidden"),
            (this.timerHide = null),
            (this.timerShow = null),
            this.$tooltip,
            (this.options.iconTheme = this.options.iconTheme.replace(".", "")),
            (this.options.theme = this.options.theme.replace(".", "")),
            this._init();
        }
        function n(o, e) {
          var i = !0;
          return (
            t.each(o, function (t, n) {
              if (void 0 === e[t] || o[t] !== e[t]) return (i = !1), !1;
            }),
            i
          );
        }
        function s() {
          return !p && a;
        }
        function r() {
          var t = (e.body || e.documentElement).style,
            o = "transition";
          if ("string" == typeof t[o]) return !0;
          (v = ["Moz", "Webkit", "Khtml", "O", "ms"]),
            (o = o.charAt(0).toUpperCase() + o.substr(1));
          for (var i = 0; i < v.length; i++)
            if ("string" == typeof t[v[i] + o]) return !0;
          return !1;
        }
        var l = {
          animation: "fade",
          arrow: !0,
          arrowColor: "",
          autoClose: !0,
          content: null,
          contentAsHTML: !1,
          contentCloning: !0,
          debug: !0,
          delay: 200,
          minWidth: 0,
          maxWidth: null,
          functionInit: function (t, o) {},
          functionBefore: function (t, o) {
            o();
          },
          functionReady: function (t, o) {},
          functionAfter: function (t) {},
          hideOnClick: !1,
          icon: "(?)",
          iconCloning: !0,
          iconDesktop: !1,
          iconTouch: !1,
          iconTheme: "tooltipster-icon",
          interactive: !1,
          interactiveTolerance: 350,
          multiple: !1,
          offsetX: 0,
          offsetY: 0,
          onlyOne: !1,
          position: "top",
          positionTracker: !1,
          positionTrackerCallback: function (t) {
            "hover" == this.option("trigger") &&
              this.option("autoClose") &&
              this.hide();
          },
          restoration: "current",
          speed: 350,
          timer: 0,
          theme: "tooltipster-default",
          touchDevices: !0,
          trigger: "hover",
          updateAnimation: !0,
        };
        (i.prototype = {
          _init: function () {
            var o = this;
            if (e.querySelector) {
              var i = null;
              void 0 === o.$el.data("tooltipster-initialTitle") &&
                (void 0 === (i = o.$el.attr("title")) && (i = null),
                o.$el.data("tooltipster-initialTitle", i)),
                null !== o.options.content
                  ? o._content_set(o.options.content)
                  : o._content_set(i);
              var n = o.options.functionInit.call(o.$el, o.$el, o.Content);
              void 0 !== n && o._content_set(n),
                o.$el.removeAttr("title").addClass("tooltipstered"),
                (!a && o.options.iconDesktop) || (a && o.options.iconTouch)
                  ? ("string" == typeof o.options.icon
                      ? ((o.$elProxy = t(
                          '<span class="' + o.options.iconTheme + '"></span>'
                        )),
                        o.$elProxy.text(o.options.icon))
                      : o.options.iconCloning
                      ? (o.$elProxy = o.options.icon.clone(!0))
                      : (o.$elProxy = o.options.icon),
                    o.$elProxy.insertAfter(o.$el))
                  : (o.$elProxy = o.$el),
                "hover" == o.options.trigger
                  ? (o.$elProxy
                      .on("mouseenter." + o.namespace, function () {
                        (s() && !o.options.touchDevices) ||
                          ((o.mouseIsOverProxy = !0), o._show());
                      })
                      .on("mouseleave." + o.namespace, function () {
                        (s() && !o.options.touchDevices) ||
                          (o.mouseIsOverProxy = !1);
                      }),
                    a &&
                      o.options.touchDevices &&
                      o.$elProxy.on("touchstart." + o.namespace, function () {
                        o._showNow();
                      }))
                  : "click" == o.options.trigger &&
                    o.$elProxy.on("click." + o.namespace, function () {
                      (s() && !o.options.touchDevices) || o._show();
                    });
            }
          },
          _show: function () {
            var t = this;
            "shown" != t.Status &&
              "appearing" != t.Status &&
              (t.options.delay
                ? (t.timerShow = setTimeout(function () {
                    ("click" == t.options.trigger ||
                      ("hover" == t.options.trigger && t.mouseIsOverProxy)) &&
                      t._showNow();
                  }, t.options.delay))
                : t._showNow());
          },
          _showNow: function (e) {
            var i = this;
            i.options.functionBefore.call(i.$el, i.$el, function () {
              if (i.enabled && null !== i.Content) {
                e && i.callbacks.show.push(e),
                  (i.callbacks.hide = []),
                  clearTimeout(i.timerShow),
                  (i.timerShow = null),
                  clearTimeout(i.timerHide),
                  (i.timerHide = null),
                  i.options.onlyOne &&
                    t(".tooltipstered")
                      .not(i.$el)
                      .each(function (o, e) {
                        var i = t(e),
                          n = i.data("tooltipster-ns");
                        t.each(n, function (t, o) {
                          var e = i.data(o),
                            n = e.status(),
                            s = e.option("autoClose");
                          "hidden" !== n &&
                            "disappearing" !== n &&
                            s &&
                            e.hide();
                        });
                      });
                var n = function () {
                  (i.Status = "shown"),
                    t.each(i.callbacks.show, function (t, o) {
                      o.call(i.$el);
                    }),
                    (i.callbacks.show = []);
                };
                if ("hidden" !== i.Status) {
                  var s = 0;
                  "disappearing" === i.Status
                    ? ((i.Status = "appearing"),
                      r()
                        ? (i.$tooltip
                            .clearQueue()
                            .removeClass("tooltipster-dying")
                            .addClass(
                              "tooltipster-" + i.options.animation + "-show"
                            ),
                          i.options.speed > 0 &&
                            i.$tooltip.delay(i.options.speed),
                          i.$tooltip.queue(n))
                        : i.$tooltip.stop().fadeIn(n))
                    : "shown" === i.Status && n();
                } else {
                  (i.Status = "appearing"),
                    (s = i.options.speed),
                    (i.bodyOverflowX = t("body").css("overflow-x")),
                    t("body").css("overflow-x", "hidden");
                  var l = "tooltipster-" + i.options.animation,
                    p =
                      "-webkit-transition-duration: " +
                      i.options.speed +
                      "ms; -webkit-animation-duration: " +
                      i.options.speed +
                      "ms; -moz-transition-duration: " +
                      i.options.speed +
                      "ms; -moz-animation-duration: " +
                      i.options.speed +
                      "ms; -o-transition-duration: " +
                      i.options.speed +
                      "ms; -o-animation-duration: " +
                      i.options.speed +
                      "ms; -ms-transition-duration: " +
                      i.options.speed +
                      "ms; -ms-animation-duration: " +
                      i.options.speed +
                      "ms; transition-duration: " +
                      i.options.speed +
                      "ms; animation-duration: " +
                      i.options.speed +
                      "ms;",
                    f = i.options.minWidth
                      ? "min-width:" + Math.round(i.options.minWidth) + "px;"
                      : "",
                    d = i.options.maxWidth
                      ? "max-width:" + Math.round(i.options.maxWidth) + "px;"
                      : "",
                    c = i.options.interactive ? "pointer-events: auto;" : "";
                  if (
                    ((i.$tooltip = t(
                      '<div class="tooltipster-base ' +
                        i.options.theme +
                        '" style="' +
                        f +
                        " " +
                        d +
                        " " +
                        c +
                        " " +
                        p +
                        '"><div class="tooltipster-content"></div></div>'
                    )),
                    r() && i.$tooltip.addClass(l),
                    i._content_insert(),
                    i.$tooltip.appendTo("body"),
                    i.reposition(),
                    i.options.functionReady.call(i.$el, i.$el, i.$tooltip),
                    r()
                      ? (i.$tooltip.addClass(l + "-show"),
                        i.options.speed > 0 &&
                          i.$tooltip.delay(i.options.speed),
                        i.$tooltip.queue(n))
                      : i.$tooltip
                          .css("display", "none")
                          .fadeIn(i.options.speed, n),
                    i._interval_set(),
                    t(o).on(
                      "scroll." + i.namespace + " resize." + i.namespace,
                      function () {
                        i.reposition();
                      }
                    ),
                    i.options.autoClose)
                  )
                    if (
                      (t("body").off("." + i.namespace),
                      "hover" == i.options.trigger)
                    ) {
                      if (
                        (a &&
                          setTimeout(function () {
                            t("body").on(
                              "touchstart." + i.namespace,
                              function () {
                                i.hide();
                              }
                            );
                          }, 0),
                        i.options.interactive)
                      ) {
                        a &&
                          i.$tooltip.on(
                            "touchstart." + i.namespace,
                            function (t) {
                              t.stopPropagation();
                            }
                          );
                        var h = null;
                        i.$elProxy
                          .add(i.$tooltip)
                          .on(
                            "mouseleave." + i.namespace + "-autoClose",
                            function () {
                              clearTimeout(h),
                                (h = setTimeout(function () {
                                  i.hide();
                                }, i.options.interactiveTolerance));
                            }
                          )
                          .on(
                            "mouseenter." + i.namespace + "-autoClose",
                            function () {
                              clearTimeout(h);
                            }
                          );
                      } else
                        i.$elProxy.on(
                          "mouseleave." + i.namespace + "-autoClose",
                          function () {
                            i.hide();
                          }
                        );
                      i.options.hideOnClick &&
                        i.$elProxy.on(
                          "click." + i.namespace + "-autoClose",
                          function () {
                            i.hide();
                          }
                        );
                    } else
                      "click" == i.options.trigger &&
                        (setTimeout(function () {
                          t("body").on(
                            "click." +
                              i.namespace +
                              " touchstart." +
                              i.namespace,
                            function () {
                              i.hide();
                            }
                          );
                        }, 0),
                        i.options.interactive &&
                          i.$tooltip.on(
                            "click." +
                              i.namespace +
                              " touchstart." +
                              i.namespace,
                            function (t) {
                              t.stopPropagation();
                            }
                          ));
                }
                i.options.timer > 0 &&
                  (i.timerHide = setTimeout(function () {
                    (i.timerHide = null), i.hide();
                  }, i.options.timer + s));
              }
            });
          },
          _interval_set: function () {
            var o = this;
            o.checkInterval = setInterval(function () {
              if (
                0 === t("body").find(o.$el).length ||
                0 === t("body").find(o.$elProxy).length ||
                "hidden" == o.Status ||
                0 === t("body").find(o.$tooltip).length
              )
                ("shown" != o.Status && "appearing" != o.Status) || o.hide(),
                  o._interval_cancel();
              else if (o.options.positionTracker) {
                var e = o._repositionInfo(o.$elProxy),
                  i = !1;
                n(e.dimension, o.elProxyPosition.dimension) &&
                  ("fixed" === o.$elProxy.css("position")
                    ? n(e.position, o.elProxyPosition.position) && (i = !0)
                    : n(e.offset, o.elProxyPosition.offset) && (i = !0)),
                  i ||
                    (o.reposition(),
                    o.options.positionTrackerCallback.call(o, o.$el));
              }
            }, 200);
          },
          _interval_cancel: function () {
            clearInterval(this.checkInterval), (this.checkInterval = null);
          },
          _content_set: function (t) {
            "object" == typeof t &&
              null !== t &&
              this.options.contentCloning &&
              (t = t.clone(!0)),
              (this.Content = t);
          },
          _content_insert: function () {
            var t = this,
              o = this.$tooltip.find(".tooltipster-content");
            "string" != typeof t.Content || t.options.contentAsHTML
              ? o.empty().append(t.Content)
              : o.text(t.Content);
          },
          _update: function (t) {
            var o = this;
            o._content_set(t),
              null !== o.Content
                ? "hidden" !== o.Status &&
                  (o._content_insert(),
                  o.reposition(),
                  o.options.updateAnimation &&
                    (r()
                      ? (o.$tooltip
                          .css({
                            width: "",
                            "-webkit-transition":
                              "all " +
                              o.options.speed +
                              "ms, width 0ms, height 0ms, left 0ms, top 0ms",
                            "-moz-transition":
                              "all " +
                              o.options.speed +
                              "ms, width 0ms, height 0ms, left 0ms, top 0ms",
                            "-o-transition":
                              "all " +
                              o.options.speed +
                              "ms, width 0ms, height 0ms, left 0ms, top 0ms",
                            "-ms-transition":
                              "all " +
                              o.options.speed +
                              "ms, width 0ms, height 0ms, left 0ms, top 0ms",
                            transition:
                              "all " +
                              o.options.speed +
                              "ms, width 0ms, height 0ms, left 0ms, top 0ms",
                          })
                          .addClass("tooltipster-content-changing"),
                        setTimeout(function () {
                          "hidden" != o.Status &&
                            (o.$tooltip.removeClass(
                              "tooltipster-content-changing"
                            ),
                            setTimeout(function () {
                              "hidden" !== o.Status &&
                                o.$tooltip.css({
                                  "-webkit-transition": o.options.speed + "ms",
                                  "-moz-transition": o.options.speed + "ms",
                                  "-o-transition": o.options.speed + "ms",
                                  "-ms-transition": o.options.speed + "ms",
                                  transition: o.options.speed + "ms",
                                });
                            }, o.options.speed));
                        }, o.options.speed))
                      : o.$tooltip.fadeTo(o.options.speed, 0.5, function () {
                          "hidden" != o.Status &&
                            o.$tooltip.fadeTo(o.options.speed, 1);
                        })))
                : o.hide();
          },
          _repositionInfo: function (t) {
            return {
              dimension: { height: t.outerHeight(!1), width: t.outerWidth(!1) },
              offset: t.offset(),
              position: {
                left: parseInt(t.css("left")),
                top: parseInt(t.css("top")),
              },
            };
          },
          hide: function (e) {
            var i = this;
            e && i.callbacks.hide.push(e),
              (i.callbacks.show = []),
              clearTimeout(i.timerShow),
              (i.timerShow = null),
              clearTimeout(i.timerHide),
              (i.timerHide = null);
            var n = function () {
              t.each(i.callbacks.hide, function (t, o) {
                o.call(i.$el);
              }),
                (i.callbacks.hide = []);
            };
            if ("shown" == i.Status || "appearing" == i.Status) {
              i.Status = "disappearing";
              var s = function () {
                (i.Status = "hidden"),
                  "object" == typeof i.Content &&
                    null !== i.Content &&
                    i.Content.detach(),
                  i.$tooltip.remove(),
                  (i.$tooltip = null),
                  t(o).off("." + i.namespace),
                  t("body")
                    .off("." + i.namespace)
                    .css("overflow-x", i.bodyOverflowX),
                  t("body").off("." + i.namespace),
                  i.$elProxy.off("." + i.namespace + "-autoClose"),
                  i.options.functionAfter.call(i.$el, i.$el),
                  n();
              };
              r()
                ? (i.$tooltip
                    .clearQueue()
                    .removeClass("tooltipster-" + i.options.animation + "-show")
                    .addClass("tooltipster-dying"),
                  i.options.speed > 0 && i.$tooltip.delay(i.options.speed),
                  i.$tooltip.queue(s))
                : i.$tooltip.stop().fadeOut(i.options.speed, s);
            } else "hidden" == i.Status && n();
            return i;
          },
          show: function (t) {
            return this._showNow(t), this;
          },
          update: function (t) {
            return this.content(t);
          },
          content: function (t) {
            return void 0 === t ? this.Content : (this._update(t), this);
          },
          reposition: function () {
            var e = this;
            if (0 !== t("body").find(e.$tooltip).length) {
              e.$tooltip.css("width", ""),
                (e.elProxyPosition = e._repositionInfo(e.$elProxy));
              var i = null,
                n = t(o).width(),
                s = e.elProxyPosition,
                r = e.$tooltip.outerWidth(!1),
                l = (e.$tooltip.innerWidth(), e.$tooltip.outerHeight(!1));
              if (e.$elProxy.is("area")) {
                var a = e.$elProxy.attr("shape"),
                  p = e.$elProxy.parent().attr("name"),
                  f = t('img[usemap="#' + p + '"]'),
                  d = f.offset().left,
                  c = f.offset().top,
                  h =
                    void 0 !== e.$elProxy.attr("coords")
                      ? e.$elProxy.attr("coords").split(",")
                      : void 0;
                if ("circle" == a) {
                  var u = parseInt(h[0]),
                    m = parseInt(h[1]),
                    v = parseInt(h[2]);
                  (s.dimension.height = 2 * v),
                    (s.dimension.width = 2 * v),
                    (s.offset.top = c + m - v),
                    (s.offset.left = d + u - v);
                } else if ("rect" == a) {
                  (u = parseInt(h[0])), (m = parseInt(h[1]));
                  var $ = parseInt(h[2]),
                    g = parseInt(h[3]);
                  (s.dimension.height = g - m),
                    (s.dimension.width = $ - u),
                    (s.offset.top = c + m),
                    (s.offset.left = d + u);
                } else if ("poly" == a) {
                  for (
                    var w = 0, y = 0, b = 0, x = 0, C = "even", P = 0;
                    P < h.length;
                    P++
                  ) {
                    var T = parseInt(h[P]);
                    "even" == C
                      ? (T > b && ((b = T), 0 === P && (w = b)),
                        T < w && (w = T),
                        (C = "odd"))
                      : (T > x && ((x = T), 1 == P && (y = x)),
                        T < y && (y = T),
                        (C = "even"));
                  }
                  (s.dimension.height = x - y),
                    (s.dimension.width = b - w),
                    (s.offset.top = c + y),
                    (s.offset.left = d + w);
                } else
                  (s.dimension.height = f.outerHeight(!1)),
                    (s.dimension.width = f.outerWidth(!1)),
                    (s.offset.top = c),
                    (s.offset.left = d);
              }
              var _ = 0,
                k = 0,
                I = 0,
                S = parseInt(e.options.offsetY),
                O = parseInt(e.options.offsetX),
                H = e.options.position;
              function M() {
                var e = t(o).scrollLeft();
                _ - e < 0 && ((i = _ - e), (_ = e)),
                  _ + r - e > n && ((i = _ - (n + e - r)), (_ = n + e - r));
              }
              function D(e, i) {
                s.offset.top - t(o).scrollTop() - l - S - 12 < 0 &&
                  i.indexOf("top") > -1 &&
                  (H = e),
                  s.offset.top + s.dimension.height + l + 12 + S >
                    t(o).scrollTop() + t(o).height() &&
                    i.indexOf("bottom") > -1 &&
                    ((H = e), (I = s.offset.top - l - S - 12));
              }
              if ("top" == H) {
                var W = s.offset.left + r - (s.offset.left + s.dimension.width);
                (_ = s.offset.left + O - W / 2),
                  (I = s.offset.top - l - S - 12),
                  M(),
                  D("bottom", "top");
              }
              if (
                ("top-left" == H &&
                  ((_ = s.offset.left + O),
                  (I = s.offset.top - l - S - 12),
                  M(),
                  D("bottom-left", "top-left")),
                "top-right" == H &&
                  ((_ = s.offset.left + s.dimension.width + O - r),
                  (I = s.offset.top - l - S - 12),
                  M(),
                  D("bottom-right", "top-right")),
                "bottom" == H &&
                  ((W =
                    s.offset.left + r - (s.offset.left + s.dimension.width)),
                  (_ = s.offset.left - W / 2 + O),
                  (I = s.offset.top + s.dimension.height + S + 12),
                  M(),
                  D("top", "bottom")),
                "bottom-left" == H &&
                  ((_ = s.offset.left + O),
                  (I = s.offset.top + s.dimension.height + S + 12),
                  M(),
                  D("top-left", "bottom-left")),
                "bottom-right" == H &&
                  ((_ = s.offset.left + s.dimension.width + O - r),
                  (I = s.offset.top + s.dimension.height + S + 12),
                  M(),
                  D("top-right", "bottom-right")),
                "left" == H)
              ) {
                (_ = s.offset.left - O - r - 12),
                  (k = s.offset.left + O + s.dimension.width + 12);
                var A = s.offset.top + l - (s.offset.top + s.dimension.height);
                if (((I = s.offset.top - A / 2 - S), _ < 0 && k + r > n)) {
                  var z = 2 * parseFloat(e.$tooltip.css("border-width")),
                    F = r + _ - z;
                  e.$tooltip.css("width", F + "px"),
                    (l = e.$tooltip.outerHeight(!1)),
                    (_ = s.offset.left - O - F - 12 - z),
                    (A =
                      s.offset.top + l - (s.offset.top + s.dimension.height)),
                    (I = s.offset.top - A / 2 - S);
                } else
                  _ < 0 &&
                    ((_ = s.offset.left + O + s.dimension.width + 12),
                    (i = "left"));
              }
              if (
                ("right" == H &&
                  ((_ = s.offset.left + O + s.dimension.width + 12),
                  (k = s.offset.left - O - r - 12),
                  (A = s.offset.top + l - (s.offset.top + s.dimension.height)),
                  (I = s.offset.top - A / 2 - S),
                  _ + r > n && k < 0
                    ? ((z = 2 * parseFloat(e.$tooltip.css("border-width"))),
                      (F = n - _ - z),
                      e.$tooltip.css("width", F + "px"),
                      (l = e.$tooltip.outerHeight(!1)),
                      (A =
                        s.offset.top + l - (s.offset.top + s.dimension.height)),
                      (I = s.offset.top - A / 2 - S))
                    : _ + r > n &&
                      ((_ = s.offset.left - O - r - 12), (i = "right"))),
                e.options.arrow)
              ) {
                var N = "tooltipster-arrow-" + H;
                if (e.options.arrowColor.length < 1)
                  var X = e.$tooltip.css("background-color");
                else X = e.options.arrowColor;
                if (
                  (i
                    ? "left" == i
                      ? ((N = "tooltipster-arrow-right"), (i = ""))
                      : "right" == i
                      ? ((N = "tooltipster-arrow-left"), (i = ""))
                      : (i = "left:" + Math.round(i) + "px;")
                    : (i = ""),
                  "top" == H || "top-left" == H || "top-right" == H)
                )
                  var q = parseFloat(e.$tooltip.css("border-bottom-width")),
                    j = e.$tooltip.css("border-bottom-color");
                else
                  "bottom" == H || "bottom-left" == H || "bottom-right" == H
                    ? ((q = parseFloat(e.$tooltip.css("border-top-width"))),
                      (j = e.$tooltip.css("border-top-color")))
                    : "left" == H
                    ? ((q = parseFloat(e.$tooltip.css("border-right-width"))),
                      (j = e.$tooltip.css("border-right-color")))
                    : "right" == H
                    ? ((q = parseFloat(e.$tooltip.css("border-left-width"))),
                      (j = e.$tooltip.css("border-left-color")))
                    : ((q = parseFloat(e.$tooltip.css("border-bottom-width"))),
                      (j = e.$tooltip.css("border-bottom-color")));
                q > 1 && q++;
                var E = "";
                if (0 !== q) {
                  var L = "",
                    Q = "border-color: " + j + ";";
                  -1 !== N.indexOf("bottom")
                    ? (L = "margin-top: -" + Math.round(q) + "px;")
                    : -1 !== N.indexOf("top")
                    ? (L = "margin-bottom: -" + Math.round(q) + "px;")
                    : -1 !== N.indexOf("left")
                    ? (L = "margin-right: -" + Math.round(q) + "px;")
                    : -1 !== N.indexOf("right") &&
                      (L = "margin-left: -" + Math.round(q) + "px;"),
                    (E =
                      '<span class="tooltipster-arrow-border" style="' +
                      L +
                      " " +
                      Q +
                      ';"></span>');
                }
                e.$tooltip.find(".tooltipster-arrow").remove();
                var U =
                  '<div class="' +
                  N +
                  ' tooltipster-arrow" style="' +
                  i +
                  '">' +
                  E +
                  '<span style="border-color:' +
                  X +
                  ';"></span></div>';
                e.$tooltip.append(U);
              }
              e.$tooltip.css({
                top: Math.round(I) + "px",
                left: Math.round(_) + "px",
              });
            }
            return e;
          },
          enable: function () {
            return (this.enabled = !0), this;
          },
          disable: function () {
            return this.hide(), (this.enabled = !1), this;
          },
          destroy: function () {
            var o = this;
            o.hide(),
              o.$el[0] !== o.$elProxy[0] && o.$elProxy.remove(),
              o.$el.removeData(o.namespace).off("." + o.namespace);
            var e = o.$el.data("tooltipster-ns");
            if (1 === e.length) {
              var i = null;
              "previous" === o.options.restoration
                ? (i = o.$el.data("tooltipster-initialTitle"))
                : "current" === o.options.restoration &&
                  (i =
                    "string" == typeof o.Content
                      ? o.Content
                      : t("<div></div>").append(o.Content).html()),
                i && o.$el.attr("title", i),
                o.$el
                  .removeClass("tooltipstered")
                  .removeData("tooltipster-ns")
                  .removeData("tooltipster-initialTitle");
            } else
              (e = t.grep(e, function (t, e) {
                return t !== o.namespace;
              })),
                o.$el.data("tooltipster-ns", e);
            return o;
          },
          elementIcon: function () {
            return this.$el[0] !== this.$elProxy[0] ? this.$elProxy[0] : void 0;
          },
          elementTooltip: function () {
            return this.$tooltip ? this.$tooltip[0] : void 0;
          },
          option: function (t, o) {
            return void 0 === o
              ? this.options[t]
              : ((this.options[t] = o), this);
          },
          status: function () {
            return this.Status;
          },
        }),
          (t.fn.tooltipster = function () {
            var o = arguments;
            if (0 === this.length) {
              if ("string" == typeof o[0]) {
                var e = !0;
                switch (o[0]) {
                  case "setDefaults":
                    t.extend(l, o[1]);
                    break;
                  default:
                    e = !1;
                }
                return !!e || this;
              }
              return this;
            }
            if ("string" == typeof o[0]) {
              var n = "#*$~&";
              return (
                this.each(function () {
                  var e = t(this).data("tooltipster-ns"),
                    i = e ? t(this).data(e[0]) : null;
                  if (!i)
                    throw new Error(
                      "You called Tooltipster's \"" +
                        o[0] +
                        '" method on an uninitialized element'
                    );
                  if ("function" != typeof i[o[0]])
                    throw new Error(
                      'Unknown method .tooltipster("' + o[0] + '")'
                    );
                  var s = i[o[0]](o[1], o[2]);
                  if (s !== i) return (n = s), !1;
                }),
                "#*$~&" !== n ? n : this
              );
            }
            var s = [],
              r = o[0] && void 0 !== o[0].multiple,
              a = (r && o[0].multiple) || (!r && l.multiple),
              p = o[0] && void 0 !== o[0].debug,
              f = (p && o[0].debug) || (!p && l.debug);
            return (
              this.each(function () {
                var e = !1,
                  n = t(this).data("tooltipster-ns"),
                  r = null;
                n
                  ? a
                    ? (e = !0)
                    : f &&
                      console.log(
                        'Tooltipster: one or more tooltips are already attached to this element: ignoring. Use the "multiple" option to attach more tooltips.'
                      )
                  : (e = !0),
                  e &&
                    ((r = new i(this, o[0])),
                    n || (n = []),
                    n.push(r.namespace),
                    t(this).data("tooltipster-ns", n),
                    t(this).data(r.namespace, r)),
                  s.push(r);
              }),
              a ? s : this
            );
          });
        var a = !!("ontouchstart" in o),
          p = !1;
        t("body").one("mousemove", function () {
          p = !0;
        });
      })(jQuery, window, document);
    },
  },
]);
