!(function (t) {
  function e(e) {
    for (var i, r, a = e[0], s = e[1], n = 0, l = []; n < a.length; n++)
      (r = a[n]),
        Object.prototype.hasOwnProperty.call(o, r) && o[r] && l.push(o[r][0]),
        (o[r] = 0);
    for (i in s) Object.prototype.hasOwnProperty.call(s, i) && (t[i] = s[i]);
    for (c && c(e); l.length; ) l.shift()();
  }
  var i = {},
    o = { 6: 0 };
  function r(e) {
    if (i[e]) return i[e].exports;
    var o = (i[e] = { i: e, l: !1, exports: {} });
    return t[e].call(o.exports, o, o.exports, r), (o.l = !0), o.exports;
  }
  (r.e = function (t) {
    var e = [],
      i = o[t];
    if (0 !== i)
      if (i) e.push(i[2]);
      else {
        var a = new Promise(function (e, r) {
          i = o[t] = [e, r];
        });
        e.push((i[2] = a));
        var s,
          n = document.createElement("script");
        (n.charset = "utf-8"),
          (n.timeout = 120),
          r.nc && n.setAttribute("nonce", r.nc),
          (n.src = (function (t) {
            return (
              (function (t) {
                return (
                  r.p + "chunk." + ({ 4: "vendors-popups" }[t] || t) + ".js"
                );
              })(t) +
              (window.flatsomeVars
                ? "?ver=" + window.flatsomeVars.theme.version
                : "")
            );
          })(t));
        var c = new Error();
        s = function (e) {
          (n.onerror = n.onload = null), clearTimeout(l);
          var i = o[t];
          if (0 !== i) {
            if (i) {
              var r = e && ("load" === e.type ? "missing" : e.type),
                a = e && e.target && e.target.src;
              (c.message =
                "Loading chunk " + t + " failed.\n(" + r + ": " + a + ")"),
                (c.name = "ChunkLoadError"),
                (c.type = r),
                (c.request = a),
                i[1](c);
            }
            o[t] = void 0;
          }
        };
        var l = setTimeout(function () {
          s({ type: "timeout", target: n });
        }, 12e4);
        (n.onerror = n.onload = s), document.head.appendChild(n);
      }
    return Promise.all(e);
  }),
    (r.m = t),
    (r.c = i),
    (r.d = function (t, e, i) {
      r.o(t, e) || Object.defineProperty(t, e, { enumerable: !0, get: i });
    }),
    (r.r = function (t) {
      "undefined" != typeof Symbol &&
        Symbol.toStringTag &&
        Object.defineProperty(t, Symbol.toStringTag, { value: "Module" }),
        Object.defineProperty(t, "__esModule", { value: !0 });
    }),
    (r.t = function (t, e) {
      if ((1 & e && (t = r(t)), 8 & e)) return t;
      if (4 & e && "object" == typeof t && t && t.__esModule) return t;
      var i = Object.create(null);
      if (
        (r.r(i),
        Object.defineProperty(i, "default", { enumerable: !0, value: t }),
        2 & e && "string" != typeof t)
      )
        for (var o in t)
          r.d(
            i,
            o,
            function (e) {
              return t[e];
            }.bind(null, o)
          );
      return i;
    }),
    (r.n = function (t) {
      var e =
        t && t.__esModule
          ? function () {
              return t.default;
            }
          : function () {
              return t;
            };
      return r.d(e, "a", e), e;
    }),
    (r.o = function (t, e) {
      return Object.prototype.hasOwnProperty.call(t, e);
    }),
    (r.p = ""),
    (r.oe = function (t) {
      throw (console.error(t), t);
    });
  var a = (window.flatsomeJsonp = window.flatsomeJsonp || []),
    s = a.push.bind(a);
  (a.push = e), (a = a.slice());
  for (var n = 0; n < a.length; n++) e(a[n]);
  var c = s;
  r((r.s = 47));
})({
  1: function (t, e, i) {
    "use strict";
    var o;
    i.d(e, "a", function () {
      return a;
    });
    const r = window.matchMedia("(prefers-reduced-motion: reduce)");
    let a = !1;
    function s() {
      a = "undefined" == typeof UxBuilder && r.matches;
    }
    s(),
      null === (o = r.addEventListener) ||
        void 0 === o ||
        o.call(r, "change", s);
  },
  2: function (t, e, i) {
    "use strict";
    function o() {
      return jQuery.fn.magnificPopup
        ? Promise.resolve()
        : i.e(4).then(i.t.bind(null, 8, 7));
    }
    i.d(e, "a", function () {
      return o;
    }),
      (jQuery.loadMagnificPopup = o),
      (jQuery.fn.lazyMagnificPopup = function (t) {
        const e = jQuery(this),
          i = t.delegate ? e.find(t.delegate) : e;
        return (
          i.one("click", (r) => {
            r.preventDefault(),
              o().then(() => {
                e.data("magnificPopup") || e.magnificPopup(t),
                  e.magnificPopup("open", i.index(r.currentTarget) || 0);
              });
          }),
          e
        );
      });
  },
  47: function (t, e, i) {
    i(6), (t.exports = i(52));
  },
  48: function (t, e, i) {
    var o, r;
    !(function (a, s) {
      "use strict";
      (o = [i(5)]),
        void 0 ===
          (r = function (t) {
            !(function (t) {
              var e,
                i,
                o,
                r,
                a,
                s,
                n = {
                  loadingNotice: "Loading image",
                  errorNotice: "The image could not be loaded",
                  errorDuration: 2500,
                  linkAttribute: "href",
                  preventClicks: !0,
                  beforeShow: t.noop,
                  beforeHide: t.noop,
                  onShow: t.noop,
                  onHide: t.noop,
                  onMove: t.noop,
                };
              function c(e, i) {
                (this.$target = t(e)),
                  (this.opts = t.extend({}, n, i, this.$target.data())),
                  void 0 === this.isOpen && this._init();
              }
              (c.prototype._init = function () {
                (this.$link = this.$target.find("a")),
                  (this.$image = this.$target.find("img")),
                  (this.$flyout = t('<div class="easyzoom-flyout" />')),
                  (this.$notice = t('<div class="easyzoom-notice" />')),
                  this.$target.on({
                    "mousemove.easyzoom touchmove.easyzoom": t.proxy(
                      this._onMove,
                      this
                    ),
                    "mouseleave.easyzoom touchend.easyzoom": t.proxy(
                      this._onLeave,
                      this
                    ),
                    "mouseenter.easyzoom touchstart.easyzoom": t.proxy(
                      this._onEnter,
                      this
                    ),
                  }),
                  this.opts.preventClicks &&
                    this.$target.on("click.easyzoom", function (t) {
                      t.preventDefault();
                    });
              }),
                (c.prototype.show = function (t, a) {
                  var s = this;
                  if (!1 !== this.opts.beforeShow.call(this)) {
                    if (!this.isReady)
                      return this._loadImage(
                        this.$link.attr(this.opts.linkAttribute),
                        function () {
                          (!s.isMouseOver && a) || s.show(t);
                        }
                      );
                    this.$target.append(this.$flyout);
                    var n = this.$target.outerWidth(),
                      c = this.$target.outerHeight(),
                      l = this.$flyout.width(),
                      u = this.$flyout.height(),
                      d = this.$zoom.width(),
                      h = this.$zoom.height();
                    (e = Math.ceil(d - l)),
                      (i = Math.ceil(h - u)),
                      e < 0 && (e = 0),
                      i < 0 && (i = 0),
                      (o = e / n),
                      (r = i / c),
                      (this.isOpen = !0),
                      this.opts.onShow.call(this),
                      t && this._move(t);
                  }
                }),
                (c.prototype._onEnter = function (t) {
                  var e = t.originalEvent.touches;
                  (this.isMouseOver = !0),
                    (e && 1 != e.length) ||
                      (t.preventDefault(), this.show(t, !0));
                }),
                (c.prototype._onMove = function (t) {
                  this.isOpen && (t.preventDefault(), this._move(t));
                }),
                (c.prototype._onLeave = function () {
                  (this.isMouseOver = !1), this.isOpen && this.hide();
                }),
                (c.prototype._onLoad = function (t) {
                  t.currentTarget.width &&
                    ((this.isReady = !0),
                    this.$notice.detach(),
                    this.$flyout.html(this.$zoom),
                    this.$target.removeClass("is-loading").addClass("is-ready"),
                    t.data.call && t.data());
                }),
                (c.prototype._onError = function () {
                  var t = this;
                  this.$notice.text(this.opts.errorNotice),
                    this.$target.removeClass("is-loading").addClass("is-error"),
                    (this.detachNotice = setTimeout(function () {
                      t.$notice.detach(), (t.detachNotice = null);
                    }, this.opts.errorDuration));
                }),
                (c.prototype._loadImage = function (e, i) {
                  var o = new Image();
                  this.$target
                    .addClass("is-loading")
                    .append(this.$notice.text(this.opts.loadingNotice)),
                    (this.$zoom = t(o)
                      .on("error", t.proxy(this._onError, this))
                      .on("load", i, t.proxy(this._onLoad, this))),
                    (o.style.position = "absolute"),
                    (o.src = e);
                }),
                (c.prototype._move = function (t) {
                  if (0 === t.type.indexOf("touch")) {
                    var n = t.touches || t.originalEvent.touches;
                    (a = n[0].pageX), (s = n[0].pageY);
                  } else (a = t.pageX || a), (s = t.pageY || s);
                  var c = this.$target.offset(),
                    l = a - c.left,
                    u = s - c.top,
                    d = Math.ceil(l * o),
                    h = Math.ceil(u * r);
                  if (d < 0 || h < 0 || e < d || i < h) this.hide();
                  else {
                    var m = -1 * h,
                      f = -1 * d;
                    this.$zoom.css({ top: m, left: f }),
                      this.opts.onMove.call(this, m, f);
                  }
                }),
                (c.prototype.hide = function () {
                  this.isOpen &&
                    !1 !== this.opts.beforeHide.call(this) &&
                    (this.$flyout.detach(),
                    (this.isOpen = !1),
                    this.opts.onHide.call(this));
                }),
                (c.prototype.swap = function (e, i, o) {
                  this.hide(),
                    (this.isReady = !1),
                    this.detachNotice && clearTimeout(this.detachNotice),
                    this.$notice.parent().length && this.$notice.detach(),
                    this.$target.removeClass("is-loading is-ready is-error"),
                    this.$image.attr({
                      src: e,
                      srcset: t.isArray(o) ? o.join() : o,
                    }),
                    this.$link.attr(this.opts.linkAttribute, i);
                }),
                (c.prototype.teardown = function () {
                  this.hide(),
                    this.$target
                      .off(".easyzoom")
                      .removeClass("is-loading is-ready is-error"),
                    this.detachNotice && clearTimeout(this.detachNotice),
                    delete this.$link,
                    delete this.$zoom,
                    delete this.$image,
                    delete this.$notice,
                    delete this.$flyout,
                    delete this.isOpen,
                    delete this.isReady;
                }),
                (t.fn.easyZoom = function (e) {
                  return this.each(function () {
                    var i = t.data(this, "easyZoom");
                    i
                      ? void 0 === i.isOpen && i._init()
                      : t.data(this, "easyZoom", new c(this, e));
                  });
                });
            })(t);
          }.apply(e, o)) || (t.exports = r);
    })();
  },
  49: function (t, e) {
    Flatsome.plugin("addQty", function (t, e) {
      jQuery(t).on("click", ".plus, .minus", function () {
        let t = jQuery(this),
          e = t.closest(".quantity").find(".qty"),
          i = parseFloat(e.val()),
          o = parseFloat(e.attr("max")),
          r = parseFloat(e.attr("min")),
          a = e.attr("step");
        (i && "" !== i && "NaN" !== i) || (i = 0),
          ("" !== o && "NaN" !== o) || (o = ""),
          ("" !== r && "NaN" !== r) || (r = 0),
          ("any" !== a &&
            "" !== a &&
            void 0 !== a &&
            "NaN" !== parseFloat(a)) ||
            (a = 1),
          t.is(".plus")
            ? o && (o === i || i > o)
              ? e.val(o)
              : e.val((i + parseFloat(a)).toFixed(a.uxGetDecimals()))
            : r && (r === i || i < r)
            ? e.val(r)
            : i > 0 && e.val((i - parseFloat(a)).toFixed(a.uxGetDecimals())),
          e.trigger("input"),
          e.trigger("change");
      }),
        String.prototype.uxGetDecimals ||
          (String.prototype.uxGetDecimals = function () {
            const t = ("" + this).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
            return t
              ? Math.max(0, (t[1] ? t[1].length : 0) - (t[2] ? +t[2] : 0))
              : 0;
          });
    });
  },
  5: function (t, e) {
    t.exports = window.jQuery;
  },
  50: function (t, e) {
    Flatsome.behavior("add-qty", {
      attach(t) {
        jQuery(".quantity", t).addQty();
      },
    });
  },
  51: function (t, e) {
    Flatsome.behavior("equalize-box", {
      attach(t) {
        let e = {
          ScreenSize: { LARGE: 1, MEDIUM: 2, SMALL: 3 },
          equalizeItems: function (t) {
            const e = this;
            (e.maxHeight = 0),
              (e.rowEnd = e.disablePerRow ? e.boxCount : e.colPerRow),
              (e.$items = []),
              (e.rating = { present: !1, height: 0, dummy: null }),
              (e.swatches = { present: !1, height: 0, dummy: null }),
              jQuery(t, e.currentElement).each(function (t) {
                const i = jQuery(this);
                e.$items.push(i),
                  i.height(""),
                  i.children(".js-star-rating").remove();
                const o = i.children(".star-rating");
                var r;
                o.length &&
                  ((e.rating.present = !0),
                  (e.rating.height = o.height()),
                  (e.rating.dummy =
                    null !== (r = e.rating.dummy) && void 0 !== r
                      ? r
                      : '<div class="js-star-rating ' +
                        o.attr("class") +
                        '" style="opacity: 0; visibility: hidden"></div>')),
                  i.children(".js-ux-swatches").remove();
                const a = i.children(".ux-swatches.ux-swatches-in-loop");
                var s;
                a.length &&
                  ((e.swatches.present = !0),
                  (e.swatches.height = a.height()),
                  (e.swatches.dummy =
                    null !== (s = e.swatches.dummy) && void 0 !== s
                      ? s
                      : '<div class="js-ux-swatches ' +
                        a.attr("class") +
                        '" style="opacity: 0; visibility: hidden"><div class="' +
                        a.find(".ux-swatch").attr("class") +
                        '"></div></div>')),
                  i.height() > e.maxHeight && (e.maxHeight = i.height()),
                  (t !== e.rowEnd - 1 && t !== e.boxCount - 1) ||
                    (e.$items.forEach(function (t) {
                      t.height(e.maxHeight),
                        e.maybeAddDummyRating(t),
                        e.maybeAddDummySwatches(t);
                    }),
                    (e.rowEnd += e.colPerRow),
                    (e.maxHeight = 0),
                    (e.$items = []),
                    (e.rating.present = !1),
                    (e.swatches.present = !1));
              });
          },
          getColsPerRow: function () {
            const t = jQuery(this.currentElement).attr("class"),
              e = /large-columns-(\d+)/g,
              i = /medium-columns-(\d+)/g,
              o = /small-columns-(\d+)/g;
            let r;
            switch (this.getScreenSize()) {
              case this.ScreenSize.LARGE:
                return (r = e.exec(t)), r ? parseInt(r[1]) : 3;
              case this.ScreenSize.MEDIUM:
                return (r = i.exec(t)), r ? parseInt(r[1]) : 3;
              case this.ScreenSize.SMALL:
                return (r = o.exec(t)), r ? parseInt(r[1]) : 2;
            }
          },
          maybeAddDummyRating: function (t) {
            let e = t;
            this.rating.present &&
              e.hasClass("price-wrapper") &&
              (e.children(".star-rating").length ||
                (e.prepend(this.rating.dummy),
                e.children(".js-star-rating").height(this.rating.height)));
          },
          maybeAddDummySwatches: function (t) {
            const e = t;
            this.swatches.present &&
              (e.children(".ux-swatches.ux-swatches-in-loop").length ||
                (e.prepend(this.swatches.dummy),
                e.children(".js-ux-swatches").height(this.swatches.height)));
          },
          getScreenSize: function () {
            return window.matchMedia("(min-width: 850px)").matches
              ? this.ScreenSize.LARGE
              : window.matchMedia("(min-width: 550px) and (max-width: 849px)")
                  .matches
              ? this.ScreenSize.MEDIUM
              : window.matchMedia("(max-width: 549px)").matches
              ? this.ScreenSize.SMALL
              : void 0;
          },
          init: function () {
            const e = this,
              i = [
                ".product-title",
                ".price-wrapper",
                ".box-excerpt",
                ".add-to-cart-button",
              ];
            jQuery(".equalize-box", t).each((t, o) => {
              (e.currentElement = o),
                (e.colPerRow = e.getColsPerRow()),
                1 !== e.colPerRow &&
                  ((e.disablePerRow =
                    jQuery(o).hasClass("row-slider") ||
                    jQuery(o).hasClass("row-grid")),
                  (e.boxCount = jQuery(".box-text", e.currentElement).length),
                  i.forEach((t) => {
                    e.equalizeItems(".box-text " + t);
                  }),
                  e.equalizeItems(".box-text"));
            });
          },
        };
        e.init(),
          jQuery(window).on("resize", () => {
            e.init();
          }),
          jQuery(document).on("flatsome-equalize-box", () => {
            e.init();
          });
      },
    });
  },
  52: function (t, e, i) {
    "use strict";
    i.r(e), i(48), i(49), i(50), i(51);
    var o = i(1),
      r = i(2);
    Flatsome.behavior("quick-view", {
      attach: function (t) {
        "uxBuilder" !== jQuery("html").attr("ng-app") &&
          jQuery(".quick-view", t).each(function (t, e) {
            jQuery(e).hasClass("quick-view-added") ||
              (jQuery(e).on("click", function (t) {
                if ("" != jQuery(this).attr("data-prod")) {
                  jQuery(this).parent().parent().addClass("processing");
                  var i = {
                    action: "flatsome_quickview",
                    product: jQuery(this).attr("data-prod"),
                  };
                  jQuery.post(flatsomeVars.ajaxurl, i, function (t) {
                    Object(r.a)().then(() => {
                      jQuery(".processing").removeClass("processing"),
                        jQuery.magnificPopup.open({
                          removalDelay: 300,
                          autoFocusLast: !1,
                          closeMarkup: flatsomeVars.lightbox.close_markup,
                          closeBtnInside:
                            flatsomeVars.lightbox.close_btn_inside,
                          items: {
                            src:
                              '<div class="product-lightbox lightbox-content">' +
                              t +
                              "</div>",
                            type: "inline",
                          },
                          callbacks: {
                            afterClose: () => {
                              jQuery(e)
                                .closest(".box")
                                .find(".box-text a:first")
                                .trigger("focus");
                            },
                          },
                        }),
                        setTimeout(function () {
                          const t = jQuery(".product-lightbox");
                          t.imagesLoaded(function () {
                            const t = {
                              cellAlign: "left",
                              wrapAround: !0,
                              autoPlay: !1,
                              prevNextButtons: !0,
                              adaptiveHeight: !0,
                              imagesLoaded: !0,
                              dragThreshold: 15,
                              rightToLeft: flatsomeVars.rtl,
                            };
                            o.a &&
                              ((t.friction = 1), (t.selectedAttraction = 1)),
                              jQuery(".product-lightbox .slider").lazyFlickity(
                                t
                              );
                          }),
                            Flatsome.attach("tooltips", t);
                        }, 300);
                      let i = jQuery(".product-lightbox form.variations_form");
                      jQuery(".product-lightbox form").hasClass(
                        "variations_form"
                      ) && i.wc_variation_form();
                      let r = jQuery(
                          ".product-lightbox .product-gallery-slider"
                        ),
                        a = jQuery(
                          ".product-lightbox .product-gallery-slider .slide.first img"
                        ),
                        s = jQuery(
                          ".product-lightbox .product-gallery-slider .slide.first a"
                        ),
                        n = a.attr("data-src")
                          ? a.attr("data-src")
                          : a.attr("src");
                      const c = jQuery.Deferred();
                      r.one("flatsome-flickity-ready", () => c.resolve());
                      let l = function () {
                          r.data("flickity") && r.flickity("select", 0);
                        },
                        u = function () {
                          r.data("flickity") &&
                            r.imagesLoaded(function () {
                              r.flickity("resize");
                            });
                        };
                      jQuery.when(c).done(() => {
                        i.on("hide_variation", function (t, e) {
                          a.attr("src", n).attr("srcset", ""), u();
                        }),
                          i.on("click", ".reset_variations", function () {
                            a.attr("src", n).attr("srcset", ""), l(), u();
                          });
                      }),
                        i.on("show_variation", function (t, e) {
                          jQuery.when(c).done(() => {
                            e.image.src
                              ? (a.attr("src", e.image.src).attr("srcset", ""),
                                s.attr("href", e.image_link),
                                l(),
                                u())
                              : e.image_src &&
                                (a.attr("src", e.image_src).attr("srcset", ""),
                                s.attr("href", e.image_link),
                                l(),
                                u());
                          });
                        }),
                        jQuery(".product-lightbox .quantity").addQty();
                    });
                  }),
                    t.preventDefault();
                }
              }),
              jQuery(e).addClass("quick-view-added"));
          });
      },
    });
    var a = !1;
    const s = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(
      navigator.userAgent
    );
    function n(t) {
      if (jQuery(".cart-item .nav-dropdown").length)
        jQuery(".cart-item").addClass("current-dropdown cart-active"),
          jQuery(".shop-container").on("click", function () {
            jQuery(".cart-item").removeClass("current-dropdown cart-active");
          }),
          jQuery(".cart-item").hover(function () {
            jQuery(".cart-active").removeClass("cart-active");
          }),
          setTimeout(function () {
            jQuery(".cart-active").removeClass("current-dropdown");
          }, t);
      else {
        let t = 0;
        jQuery.fn.magnificPopup &&
          ((t = jQuery.magnificPopup.open ? 0 : 300),
          t && jQuery.magnificPopup.close()),
          setTimeout(function () {
            jQuery(".cart-item .off-canvas-toggle").trigger("click");
          }, t);
      }
    }
    jQuery(document).on("flatsome-product-gallery-tools-init", () => {
      s ||
        (a = jQuery(".has-image-zoom .slide").easyZoom({
          loadingNotice: "",
          preventClicks: !1,
        })),
        jQuery(".zoom-button")
          .off("click.flatsome")
          .on("click.flatsome", function (t) {
            jQuery(".product-gallery-slider")
              .find(".is-selected a")
              .trigger("click"),
              t.preventDefault();
          }),
        jQuery(".has-lightbox .product-gallery-slider").each(function () {
          jQuery(this).lazyMagnificPopup({
            delegate: "a",
            type: "image",
            tLoading: '<div class="loading-spin centered dark"></div>',
            closeMarkup: flatsomeVars.lightbox.close_markup,
            closeBtnInside: flatsomeVars.lightbox.close_btn_inside,
            gallery: {
              enabled: !0,
              navigateByImgClick: !0,
              preload: [0, 1],
              arrowMarkup:
                '<button class="mfp-arrow mfp-arrow-%dir%" title="%title%"><i class="icon-angle-%dir%"></i></button>',
            },
            image: {
              tError:
                '<a href="%url%">The image #%curr%</a> could not be loaded.',
              verticalFit: !1,
            },
          });
        });
    }),
      jQuery("table.my_account_orders").wrap(
        '<div class="touch-scroll-table"/>'
      ),
      jQuery(function (t) {
        if (!document.body.classList.contains("single-product")) return;
        const e = window.location.hash,
          i = window.location.href;
        function o() {
          !(function () {
            const e = t(".reviews_tab"),
              i = e.length ? e : t("#reviews").closest(".accordion-item");
            i.length && i.find("a:not(.active):first").trigger("click");
          })(),
            setTimeout(() => {
              t.scrollTo("#reviews", { duration: 300, offset: -200 });
            }, 500);
        }
        (e.toLowerCase().indexOf("comment-") >= 0 ||
          "#comments" === e ||
          "#reviews" === e ||
          "#tab-reviews" === e ||
          i.indexOf("comment-page-") > 0 ||
          i.indexOf("cpage=") > 0) &&
          o(),
          t("a.woocommerce-review-link").on("click", function (t) {
            t.preventDefault(), history.pushState(null, null, "#reviews"), o();
          });
      }),
      jQuery(".single_add_to_cart_button").on("click", function () {
        let t = jQuery(this),
          e = t.closest("form.cart");
        e
          ? e.on("submit", function () {
              t.addClass("loading");
            })
          : t.hasClass("disabled") || t.addClass("loading"),
          jQuery(window).on("pageshow", () => {
            t.removeClass("loading");
          });
      }),
      jQuery(function (t) {
        const e = t(".product-thumbnails .first img").attr("data-src")
            ? t(".product-thumbnails .first img").attr("data-src")
            : t(".product-thumbnails .first img").attr("src"),
          i = t("form.variations_form"),
          o = t(".product-gallery-slider"),
          r = t(".product-thumbnails");
        let n = null;
        const c = t.Deferred(),
          l = t.Deferred();
        o.one("flatsome-flickity-ready", () => c.resolve()),
          r.one("flatsome-flickity-ready", () => l.resolve()),
          (r.length && !r.is(":hidden")) || l.resolve();
        const u = function () {
            a &&
              a.length &&
              ((n = a.filter(".has-image-zoom .slide.first").data("easyZoom")),
              n.swap(
                t(".has-image-zoom .slide.first img").attr("src"),
                t(".has-image-zoom .slide.first img").attr("data-large_image")
              ));
          },
          d = function () {
            o.data("flickity") && o.flickity("select", 0);
          },
          h = function () {
            o.data("flickity") &&
              o.imagesLoaded(function () {
                o.flickity("resize");
              });
          };
        t.when(c).then(() => {
          t(document).trigger("flatsome-product-gallery-tools-init");
        });
        const m = t.when(c, l).then(() => {
          s && h(),
            i.on("hide_variation", function (i, o) {
              t(".product-thumbnails .first img, .sticky-add-to-cart-img").attr(
                "src",
                e
              ),
                h();
            }),
            i.on("click", ".reset_variations", function () {
              t(".product-thumbnails .first img, .sticky-add-to-cart-img").attr(
                "src",
                e
              ),
                d(),
                u(),
                h();
            });
        });
        i.on("show_variation", function (i, o) {
          t.when(m).done(() => {
            o.hasOwnProperty("image") && o.image.thumb_src
              ? (t(
                  ".product-gallery-slider-old .slide.first img, .sticky-add-to-cart-img, .product-thumbnails .first img, .product-gallery-slider .slide.first .zoomImg"
                )
                  .attr("src", o.image.thumb_src)
                  .attr("srcset", ""),
                d(),
                u(),
                h())
              : (t(".product-thumbnails .first img").attr("src", e), h());
          });
        });
      }),
      flatsomeVars.is_mini_cart_reveal &&
        (jQuery("body").on("added_to_cart", function () {
          n("5000");
          const t = jQuery("#header"),
            e = t.hasClass("has-sticky"),
            i = jQuery(".header-wrapper", t);
          e &&
            jQuery(".cart-item.has-dropdown").length &&
            t.hasClass("sticky-hide-on-scroll--active") &&
            (i.addClass("stuck"),
            t.removeClass("sticky-hide-on-scroll--active"));
        }),
        jQuery(document).ready(function () {
          jQuery("span.added-to-cart").length && n("5000");
        })),
      jQuery(document.body).on("updated_cart_totals", function () {
        jQuery(document).trigger("yith_wcwl_reload_fragments");
        let t = jQuery(".cart-wrapper");
        Flatsome.attach("lazy-load-images", t),
          Flatsome.attach("quick-view", t),
          Flatsome.attach("wishlist", t),
          Flatsome.attach("cart-refresh", t),
          Flatsome.attach("equalize-box", t);
      }),
      jQuery(document).ajaxComplete(function () {
        Flatsome.attach(jQuery(".quantity").parent()),
          Flatsome.attach(
            "lightboxes-link",
            jQuery(
              ".woocommerce-checkout .woocommerce-terms-and-conditions-wrapper"
            )
          );
      }),
      jQuery(document).on("yith_infs_adding_elem", function (t) {
        Flatsome.attach(jQuery(".shop-container"));
      }),
      jQuery(".disable-lightbox a").on("click", function (t) {
        t.preventDefault();
      }),
      jQuery(document).ready(function () {
        if (!jQuery(".custom-product-page").length) return;
        const t = jQuery("#respond p.stars");
        if (t.length > 1) {
          let e = t[0].outerHTML;
          t.remove(), jQuery('select[id="rating"]').hide().before(e);
        }
      }),
      jQuery(".sticky-add-to-cart-wrapper").waypoint(function (t) {
        var e = jQuery(this.element),
          i = jQuery(this.element).find(".sticky-add-to-cart");
        jQuery(".wc-variation-selection-needed").on("click", function () {
          jQuery.scrollTo(".sticky-add-to-cart-wrapper", {
            duration: 0,
            offset: -200,
          });
        }),
          "down" === t &&
            (e.css({ height: e.outerHeight() }),
            i.addClass("sticky-add-to-cart--active"),
            jQuery("body").addClass("has-sticky-product-cart")),
          "up" === t &&
            (i.removeClass("sticky-add-to-cart--active"),
            e.css({ height: "auto" }),
            jQuery("body").removeClass("has-sticky-product-cart"));
      }),
      setTimeout(function () {
        jQuery(document.body).on("country_to_state_changed", function () {
          "undefined" != typeof floatlabels && floatlabels.rebuild();
        });
      }, 500);
  },
  6: function (t, e, i) {
    i.p = window.flatsomeVars ? window.flatsomeVars.assets_url : "/";
  },
});
