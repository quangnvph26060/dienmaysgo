(window.flatsomeJsonp = window.flatsomeJsonp || []).push([
  [2],
  {
    57: function (t, e, i) {
      !(function () {
        "use strict";
        function t(t, e) {
          if (!(t instanceof e))
            throw new TypeError("Cannot call a class as a function");
        }
        var e = (function () {
            function t(t, e) {
              for (var i = 0; i < e.length; i++) {
                var n = e[i];
                (n.enumerable = n.enumerable || !1),
                  (n.configurable = !0),
                  "value" in n && (n.writable = !0),
                  Object.defineProperty(t, n.key, n);
              }
            }
            return function (e, i, n) {
              return i && t(e.prototype, i), n && t(e, n), e;
            };
          })(),
          i = (function () {
            var i = ".stickySidebar",
              n = {
                topSpacing: 0,
                bottomSpacing: 0,
                containerSelector: !1,
                innerWrapperSelector: ".inner-wrapper-sticky",
                stickyClass: "is-affixed",
                resizeSensor: !0,
                minWidth: !1,
              };
            return (function () {
              function s(e) {
                var i = this,
                  o =
                    arguments.length > 1 && void 0 !== arguments[1]
                      ? arguments[1]
                      : {};
                if (
                  (t(this, s),
                  (this.options = s.extend(n, o)),
                  (this.sidebar =
                    "string" == typeof e ? document.querySelector(e) : e),
                  void 0 === this.sidebar)
                )
                  throw new Error("There is no specific sidebar element.");
                (this.sidebarInner = !1),
                  (this.container = this.sidebar.parentElement),
                  (this.affixedType = "STATIC"),
                  (this.direction = "down"),
                  (this.support = { transform: !1, transform3d: !1 }),
                  (this._initialized = !1),
                  (this._reStyle = !1),
                  (this._breakpoint = !1),
                  (this._resizeListeners = []),
                  (this.dimensions = {
                    translateY: 0,
                    topSpacing: 0,
                    lastTopSpacing: 0,
                    bottomSpacing: 0,
                    lastBottomSpacing: 0,
                    sidebarHeight: 0,
                    sidebarWidth: 0,
                    containerTop: 0,
                    containerHeight: 0,
                    viewportHeight: 0,
                    viewportTop: 0,
                    lastViewportTop: 0,
                  }),
                  ["handleEvent"].forEach(function (t) {
                    i[t] = i[t].bind(i);
                  }),
                  this.initialize();
              }
              return (
                e(
                  s,
                  [
                    {
                      key: "initialize",
                      value: function () {
                        var t = this;
                        if (
                          (this._setSupportFeatures(),
                          this.options.innerWrapperSelector &&
                            ((this.sidebarInner = this.sidebar.querySelector(
                              this.options.innerWrapperSelector
                            )),
                            null === this.sidebarInner &&
                              (this.sidebarInner = !1)),
                          !this.sidebarInner)
                        ) {
                          var e = document.createElement("div");
                          for (
                            e.setAttribute("class", "inner-wrapper-sticky"),
                              this.sidebar.appendChild(e);
                            this.sidebar.firstChild != e;

                          )
                            e.appendChild(this.sidebar.firstChild);
                          this.sidebarInner = this.sidebar.querySelector(
                            ".inner-wrapper-sticky"
                          );
                        }
                        if (this.options.containerSelector) {
                          var i = document.querySelectorAll(
                            this.options.containerSelector
                          );
                          if (
                            ((i = Array.prototype.slice.call(i)).forEach(
                              function (e, i) {
                                e.contains(t.sidebar) && (t.container = e);
                              }
                            ),
                            !i.length)
                          )
                            throw new Error(
                              "The container does not contains on the sidebar."
                            );
                        }
                        "function" != typeof this.options.topSpacing &&
                          (this.options.topSpacing =
                            parseInt(this.options.topSpacing) || 0),
                          "function" != typeof this.options.bottomSpacing &&
                            (this.options.bottomSpacing =
                              parseInt(this.options.bottomSpacing) || 0),
                          this._widthBreakpoint(),
                          this.calcDimensions(),
                          this.stickyPosition(),
                          this.bindEvents(),
                          (this._initialized = !0);
                      },
                    },
                    {
                      key: "bindEvents",
                      value: function () {
                        window.addEventListener("resize", this, {
                          passive: !0,
                          capture: !1,
                        }),
                          window.addEventListener("scroll", this, {
                            passive: !0,
                            capture: !1,
                          }),
                          this.sidebar.addEventListener("update" + i, this),
                          this.options.resizeSensor &&
                            "undefined" != typeof ResizeSensor &&
                            (new ResizeSensor(
                              this.sidebarInner,
                              this.handleEvent
                            ),
                            new ResizeSensor(this.container, this.handleEvent));
                      },
                    },
                    {
                      key: "handleEvent",
                      value: function (t) {
                        this.updateSticky(t);
                      },
                    },
                    {
                      key: "calcDimensions",
                      value: function () {
                        if (!this._breakpoint) {
                          var t = this.dimensions;
                          (t.containerTop = s.offsetRelative(
                            this.container
                          ).top),
                            (t.containerHeight = this.container.clientHeight),
                            (t.containerBottom =
                              t.containerTop + t.containerHeight),
                            (t.sidebarHeight = this.sidebarInner.offsetHeight),
                            (t.sidebarWidth = this.sidebar.offsetWidth),
                            (t.viewportHeight = window.innerHeight),
                            this._calcDimensionsWithScroll();
                        }
                      },
                    },
                    {
                      key: "_calcDimensionsWithScroll",
                      value: function () {
                        var t = this.dimensions;
                        (t.sidebarLeft = s.offsetRelative(this.sidebar).left),
                          (t.viewportTop =
                            document.documentElement.scrollTop ||
                            document.body.scrollTop),
                          (t.viewportBottom = t.viewportTop + t.viewportHeight),
                          (t.viewportLeft =
                            document.documentElement.scrollLeft ||
                            document.body.scrollLeft),
                          (t.topSpacing = this.options.topSpacing),
                          (t.bottomSpacing = this.options.bottomSpacing),
                          "function" == typeof t.topSpacing &&
                            (t.topSpacing =
                              parseInt(t.topSpacing(this.sidebar)) || 0),
                          "function" == typeof t.bottomSpacing &&
                            (t.bottomSpacing =
                              parseInt(t.bottomSpacing(this.sidebar)) || 0),
                          "VIEWPORT-TOP" === this.affixedType
                            ? t.topSpacing < t.lastTopSpacing &&
                              ((t.translateY +=
                                t.lastTopSpacing - t.topSpacing),
                              (this._reStyle = !0))
                            : "VIEWPORT-BOTTOM" === this.affixedType &&
                              t.bottomSpacing < t.lastBottomSpacing &&
                              ((t.translateY +=
                                t.lastBottomSpacing - t.bottomSpacing),
                              (this._reStyle = !0)),
                          (t.lastTopSpacing = t.topSpacing),
                          (t.lastBottomSpacing = t.bottomSpacing);
                      },
                    },
                    {
                      key: "isSidebarFitsViewport",
                      value: function () {
                        return (
                          this.dimensions.sidebarHeight <
                          this.dimensions.viewportHeight
                        );
                      },
                    },
                    {
                      key: "observeScrollDir",
                      value: function () {
                        var t = this.dimensions;
                        if (t.lastViewportTop !== t.viewportTop) {
                          var e =
                            "down" === this.direction ? Math.min : Math.max;
                          t.viewportTop ===
                            e(t.viewportTop, t.lastViewportTop) &&
                            (this.direction =
                              "down" === this.direction ? "up" : "down");
                        }
                      },
                    },
                    {
                      key: "getAffixType",
                      value: function () {
                        var t = this.dimensions,
                          e = !1;
                        this._calcDimensionsWithScroll();
                        var i = t.sidebarHeight + t.containerTop,
                          n = t.viewportTop + t.topSpacing,
                          s = t.viewportBottom - t.bottomSpacing;
                        return (
                          "up" === this.direction
                            ? n <= t.containerTop
                              ? ((t.translateY = 0), (e = "STATIC"))
                              : n <= t.translateY + t.containerTop
                              ? ((t.translateY = n - t.containerTop),
                                (e = "VIEWPORT-TOP"))
                              : !this.isSidebarFitsViewport() &&
                                t.containerTop <= n &&
                                (e = "VIEWPORT-UNBOTTOM")
                            : this.isSidebarFitsViewport()
                            ? t.sidebarHeight + n >= t.containerBottom
                              ? ((t.translateY = t.containerBottom - i),
                                (e = "CONTAINER-BOTTOM"))
                              : n >= t.containerTop &&
                                ((t.translateY = n - t.containerTop),
                                (e = "VIEWPORT-TOP"))
                            : t.containerBottom <= s
                            ? ((t.translateY = t.containerBottom - i),
                              (e = "CONTAINER-BOTTOM"))
                            : i + t.translateY <= s
                            ? ((t.translateY = s - i), (e = "VIEWPORT-BOTTOM"))
                            : t.containerTop + t.translateY <= n &&
                              (e = "VIEWPORT-UNBOTTOM"),
                          (t.translateY = Math.max(0, t.translateY)),
                          (t.translateY = Math.min(
                            t.containerHeight,
                            t.translateY
                          )),
                          (t.lastViewportTop = t.viewportTop),
                          e
                        );
                      },
                    },
                    {
                      key: "_getStyle",
                      value: function (t) {
                        if (void 0 !== t) {
                          var e = { inner: {}, outer: {} },
                            i = this.dimensions;
                          switch (t) {
                            case "VIEWPORT-TOP":
                              e.inner = {
                                position: "fixed",
                                top: i.topSpacing,
                                left: i.sidebarLeft - i.viewportLeft,
                                width: i.sidebarWidth,
                              };
                              break;
                            case "VIEWPORT-BOTTOM":
                              e.inner = {
                                position: "fixed",
                                top: "auto",
                                left: i.sidebarLeft,
                                bottom: i.bottomSpacing,
                                width: i.sidebarWidth,
                              };
                              break;
                            case "CONTAINER-BOTTOM":
                            case "VIEWPORT-UNBOTTOM":
                              var n = this._getTranslate(
                                0,
                                i.translateY + "px"
                              );
                              e.inner = n
                                ? { transform: n }
                                : {
                                    position: "absolute",
                                    top: i.translateY,
                                    width: i.sidebarWidth,
                                  };
                          }
                          switch (t) {
                            case "VIEWPORT-TOP":
                            case "VIEWPORT-BOTTOM":
                            case "VIEWPORT-UNBOTTOM":
                            case "CONTAINER-BOTTOM":
                              e.outer = {
                                height: i.sidebarHeight,
                                position: "relative",
                              };
                          }
                          return (
                            (e.outer = s.extend(
                              { height: "", position: "" },
                              e.outer
                            )),
                            (e.inner = s.extend(
                              {
                                position: "relative",
                                top: "",
                                left: "",
                                bottom: "",
                                width: "",
                                transform: this._getTranslate(),
                              },
                              e.inner
                            )),
                            e
                          );
                        }
                      },
                    },
                    {
                      key: "stickyPosition",
                      value: function (t) {
                        if (!this._breakpoint) {
                          t = this._reStyle || t || !1;
                          var e = this.getAffixType(),
                            n = this._getStyle(e);
                          if ((this.affixedType != e || t) && e) {
                            var o =
                              "affix." +
                              e.toLowerCase().replace("viewport-", "") +
                              i;
                            for (var r in (s.eventTrigger(this.sidebar, o),
                            "STATIC" === e
                              ? s.removeClass(
                                  this.sidebar,
                                  this.options.stickyClass
                                )
                              : s.addClass(
                                  this.sidebar,
                                  this.options.stickyClass
                                ),
                            n.outer))
                              this.sidebar.style[r] = n.outer[r];
                            for (var a in n.inner) {
                              var c = "number" == typeof n.inner[a] ? "px" : "";
                              this.sidebarInner.style[a] = n.inner[a] + c;
                            }
                            var p =
                              "affixed." +
                              e.toLowerCase().replace("viewport-", "") +
                              i;
                            s.eventTrigger(this.sidebar, p);
                          } else
                            this._initialized &&
                              (this.sidebarInner.style.left = n.inner.left);
                          this.affixedType = e;
                        }
                      },
                    },
                    {
                      key: "_widthBreakpoint",
                      value: function () {
                        window.innerWidth <= this.options.minWidth
                          ? ((this._breakpoint = !0),
                            (this.affixedType = "STATIC"),
                            this.sidebar.removeAttribute("style"),
                            s.removeClass(
                              this.sidebar,
                              this.options.stickyClass
                            ),
                            this.sidebarInner.removeAttribute("style"))
                          : (this._breakpoint = !1);
                      },
                    },
                    {
                      key: "updateSticky",
                      value: function () {
                        var t = this,
                          e =
                            arguments.length > 0 && void 0 !== arguments[0]
                              ? arguments[0]
                              : {};
                        this._running ||
                          ((this._running = !0),
                          (function (e) {
                            requestAnimationFrame(function () {
                              switch (e) {
                                case "scroll":
                                  t._calcDimensionsWithScroll(),
                                    t.observeScrollDir(),
                                    t.stickyPosition();
                                  break;
                                case "resize":
                                default:
                                  t._widthBreakpoint(),
                                    t.calcDimensions(),
                                    t.stickyPosition(!0);
                              }
                              t._running = !1;
                            });
                          })(e.type));
                      },
                    },
                    {
                      key: "_setSupportFeatures",
                      value: function () {
                        var t = this.support;
                        (t.transform = s.supportTransform()),
                          (t.transform3d = s.supportTransform(!0));
                      },
                    },
                    {
                      key: "_getTranslate",
                      value: function () {
                        var t =
                            arguments.length > 0 && void 0 !== arguments[0]
                              ? arguments[0]
                              : 0,
                          e =
                            arguments.length > 1 && void 0 !== arguments[1]
                              ? arguments[1]
                              : 0,
                          i =
                            arguments.length > 2 && void 0 !== arguments[2]
                              ? arguments[2]
                              : 0;
                        return this.support.transform3d
                          ? "translate3d(" + t + ", " + e + ", " + i + ")"
                          : !!this.support.translate &&
                              "translate(" + t + ", " + e + ")";
                      },
                    },
                    {
                      key: "destroy",
                      value: function () {
                        window.removeEventListener("resize", this, {
                          caption: !1,
                        }),
                          window.removeEventListener("scroll", this, {
                            caption: !1,
                          }),
                          this.sidebar.classList.remove(
                            this.options.stickyClass
                          ),
                          (this.sidebar.style.minHeight = ""),
                          this.sidebar.removeEventListener("update" + i, this);
                        var t = { inner: {}, outer: {} };
                        for (var e in ((t.inner = {
                          position: "",
                          top: "",
                          left: "",
                          bottom: "",
                          width: "",
                          transform: "",
                        }),
                        (t.outer = { height: "", position: "" }),
                        t.outer))
                          this.sidebar.style[e] = t.outer[e];
                        for (var n in t.inner)
                          this.sidebarInner.style[n] = t.inner[n];
                        this.options.resizeSensor &&
                          "undefined" != typeof ResizeSensor &&
                          (ResizeSensor.detach(
                            this.sidebarInner,
                            this.handleEvent
                          ),
                          ResizeSensor.detach(
                            this.container,
                            this.handleEvent
                          ));
                      },
                    },
                  ],
                  [
                    {
                      key: "supportTransform",
                      value: function (t) {
                        var e = !1,
                          i = t ? "perspective" : "transform",
                          n = i.charAt(0).toUpperCase() + i.slice(1),
                          s = document.createElement("support").style;
                        return (
                          (
                            i +
                            " " +
                            ["Webkit", "Moz", "O", "ms"].join(n + " ") +
                            n
                          )
                            .split(" ")
                            .forEach(function (t, i) {
                              if (void 0 !== s[t]) return (e = t), !1;
                            }),
                          e
                        );
                      },
                    },
                    {
                      key: "eventTrigger",
                      value: function (t, e, i) {
                        try {
                          var n = new CustomEvent(e, { detail: i });
                        } catch (t) {
                          (n =
                            document.createEvent(
                              "CustomEvent"
                            )).initCustomEvent(e, !0, !0, i);
                        }
                        t.dispatchEvent(n);
                      },
                    },
                    {
                      key: "extend",
                      value: function (t, e) {
                        var i = {};
                        for (var n in t)
                          void 0 !== e[n] ? (i[n] = e[n]) : (i[n] = t[n]);
                        return i;
                      },
                    },
                    {
                      key: "offsetRelative",
                      value: function (t) {
                        var e = { left: 0, top: 0 };
                        do {
                          var i = t.offsetTop,
                            n = t.offsetLeft;
                          isNaN(i) || (e.top += i),
                            isNaN(n) || (e.left += n),
                            (t =
                              "BODY" === t.tagName
                                ? t.parentElement
                                : t.offsetParent);
                        } while (t);
                        return e;
                      },
                    },
                    {
                      key: "addClass",
                      value: function (t, e) {
                        s.hasClass(t, e) ||
                          (t.classList
                            ? t.classList.add(e)
                            : (t.className += " " + e));
                      },
                    },
                    {
                      key: "removeClass",
                      value: function (t, e) {
                        s.hasClass(t, e) &&
                          (t.classList
                            ? t.classList.remove(e)
                            : (t.className = t.className.replace(
                                new RegExp(
                                  "(^|\\b)" +
                                    e.split(" ").join("|") +
                                    "(\\b|$)",
                                  "gi"
                                ),
                                " "
                              )));
                      },
                    },
                    {
                      key: "hasClass",
                      value: function (t, e) {
                        return t.classList
                          ? t.classList.contains(e)
                          : new RegExp("(^| )" + e + "( |$)", "gi").test(
                              t.className
                            );
                      },
                    },
                  ]
                ),
                s
              );
            })();
          })();
        (window.StickySidebar = i),
          (function () {
            if ("undefined" != typeof window) {
              var t = window.$ || window.jQuery || window.Zepto;
              if (t) {
                (t.fn.stickySidebar = function (e) {
                  return this.each(function () {
                    var n = t(this),
                      s = t(this).data("stickySidebar");
                    if (
                      (s ||
                        ((s = new i(this, "object" == typeof e && e)),
                        n.data("stickySidebar", s)),
                      "string" == typeof e)
                    ) {
                      if (
                        void 0 === s[e] &&
                        -1 === ["destroy", "updateSticky"].indexOf(e)
                      )
                        throw new Error('No method named "' + e + '"');
                      s[e]();
                    }
                  });
                }),
                  (t.fn.stickySidebar.Constructor = i);
                var e = t.fn.stickySidebar;
                t.fn.stickySidebar.noConflict = function () {
                  return (t.fn.stickySidebar = e), this;
                };
              }
            }
          })();
      })();
    },
  },
]);
