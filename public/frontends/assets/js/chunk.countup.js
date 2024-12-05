(window.flatsomeJsonp = window.flatsomeJsonp || []).push([
  [0],
  {
    56: function (t, i, n) {
      "use strict";
      n.r(i),
        n.d(i, "CountUp", function () {
          return a;
        });
      var s = function () {
          return (s =
            Object.assign ||
            function (t) {
              for (var i, n = 1, s = arguments.length; n < s; n++)
                for (var a in (i = arguments[n]))
                  Object.prototype.hasOwnProperty.call(i, a) && (t[a] = i[a]);
              return t;
            }).apply(this, arguments);
        },
        a = (function () {
          function t(t, i, n) {
            var a = this;
            (this.endVal = i),
              (this.options = n),
              (this.version = "2.3.2"),
              (this.defaults = {
                startVal: 0,
                decimalPlaces: 0,
                duration: 2,
                useEasing: !0,
                useGrouping: !0,
                smartEasingThreshold: 999,
                smartEasingAmount: 333,
                separator: ",",
                decimal: ".",
                prefix: "",
                suffix: "",
                enableScrollSpy: !1,
                scrollSpyDelay: 200,
                scrollSpyOnce: !1,
              }),
              (this.finalEndVal = null),
              (this.useEasing = !0),
              (this.countDown = !1),
              (this.error = ""),
              (this.startVal = 0),
              (this.paused = !0),
              (this.once = !1),
              (this.count = function (t) {
                a.startTime || (a.startTime = t);
                var i = t - a.startTime;
                (a.remaining = a.duration - i),
                  a.useEasing
                    ? a.countDown
                      ? (a.frameVal =
                          a.startVal -
                          a.easingFn(i, 0, a.startVal - a.endVal, a.duration))
                      : (a.frameVal = a.easingFn(
                          i,
                          a.startVal,
                          a.endVal - a.startVal,
                          a.duration
                        ))
                    : (a.frameVal =
                        a.startVal +
                        (a.endVal - a.startVal) * (i / a.duration));
                var n = a.countDown
                  ? a.frameVal < a.endVal
                  : a.frameVal > a.endVal;
                (a.frameVal = n ? a.endVal : a.frameVal),
                  (a.frameVal = Number(
                    a.frameVal.toFixed(a.options.decimalPlaces)
                  )),
                  a.printValue(a.frameVal),
                  i < a.duration
                    ? (a.rAF = requestAnimationFrame(a.count))
                    : null !== a.finalEndVal
                    ? a.update(a.finalEndVal)
                    : a.callback && a.callback();
              }),
              (this.formatNumber = function (t) {
                var i,
                  n,
                  s,
                  e,
                  r = t < 0 ? "-" : "";
                i = Math.abs(t).toFixed(a.options.decimalPlaces);
                var o = (i += "").split(".");
                if (
                  ((n = o[0]),
                  (s = o.length > 1 ? a.options.decimal + o[1] : ""),
                  a.options.useGrouping)
                ) {
                  e = "";
                  for (var l = 0, h = n.length; l < h; ++l)
                    0 !== l && l % 3 == 0 && (e = a.options.separator + e),
                      (e = n[h - l - 1] + e);
                  n = e;
                }
                return (
                  a.options.numerals &&
                    a.options.numerals.length &&
                    ((n = n.replace(/[0-9]/g, function (t) {
                      return a.options.numerals[+t];
                    })),
                    (s = s.replace(/[0-9]/g, function (t) {
                      return a.options.numerals[+t];
                    }))),
                  r + a.options.prefix + n + s + a.options.suffix
                );
              }),
              (this.easeOutExpo = function (t, i, n, s) {
                return (n * (1 - Math.pow(2, (-10 * t) / s)) * 1024) / 1023 + i;
              }),
              (this.options = s(s({}, this.defaults), n)),
              (this.formattingFn = this.options.formattingFn
                ? this.options.formattingFn
                : this.formatNumber),
              (this.easingFn = this.options.easingFn
                ? this.options.easingFn
                : this.easeOutExpo),
              (this.startVal = this.validateValue(this.options.startVal)),
              (this.frameVal = this.startVal),
              (this.endVal = this.validateValue(i)),
              (this.options.decimalPlaces = Math.max(
                this.options.decimalPlaces
              )),
              this.resetDuration(),
              (this.options.separator = String(this.options.separator)),
              (this.useEasing = this.options.useEasing),
              "" === this.options.separator && (this.options.useGrouping = !1),
              (this.el = "string" == typeof t ? document.getElementById(t) : t),
              this.el
                ? this.printValue(this.startVal)
                : (this.error = "[CountUp] target is null or undefined"),
              "undefined" != typeof window &&
                this.options.enableScrollSpy &&
                (this.error
                  ? console.error(this.error, t)
                  : ((window.onScrollFns = window.onScrollFns || []),
                    window.onScrollFns.push(function () {
                      return a.handleScroll(a);
                    }),
                    (window.onscroll = function () {
                      window.onScrollFns.forEach(function (t) {
                        return t();
                      });
                    }),
                    this.handleScroll(this)));
          }
          return (
            (t.prototype.handleScroll = function (t) {
              if (t && window && !t.once) {
                var i = window.innerHeight + window.scrollY,
                  n = t.el.getBoundingClientRect(),
                  s = n.top + n.height + window.pageYOffset;
                s < i && s > window.scrollY && t.paused
                  ? ((t.paused = !1),
                    setTimeout(function () {
                      return t.start();
                    }, t.options.scrollSpyDelay),
                    t.options.scrollSpyOnce && (t.once = !0))
                  : window.scrollY > s && !t.paused && t.reset();
              }
            }),
            (t.prototype.determineDirectionAndSmartEasing = function () {
              var t = this.finalEndVal ? this.finalEndVal : this.endVal;
              this.countDown = this.startVal > t;
              var i = t - this.startVal;
              if (
                Math.abs(i) > this.options.smartEasingThreshold &&
                this.options.useEasing
              ) {
                this.finalEndVal = t;
                var n = this.countDown ? 1 : -1;
                (this.endVal = t + n * this.options.smartEasingAmount),
                  (this.duration = this.duration / 2);
              } else (this.endVal = t), (this.finalEndVal = null);
              null !== this.finalEndVal
                ? (this.useEasing = !1)
                : (this.useEasing = this.options.useEasing);
            }),
            (t.prototype.start = function (t) {
              this.error ||
                ((this.callback = t),
                this.duration > 0
                  ? (this.determineDirectionAndSmartEasing(),
                    (this.paused = !1),
                    (this.rAF = requestAnimationFrame(this.count)))
                  : this.printValue(this.endVal));
            }),
            (t.prototype.pauseResume = function () {
              this.paused
                ? ((this.startTime = null),
                  (this.duration = this.remaining),
                  (this.startVal = this.frameVal),
                  this.determineDirectionAndSmartEasing(),
                  (this.rAF = requestAnimationFrame(this.count)))
                : cancelAnimationFrame(this.rAF),
                (this.paused = !this.paused);
            }),
            (t.prototype.reset = function () {
              cancelAnimationFrame(this.rAF),
                (this.paused = !0),
                this.resetDuration(),
                (this.startVal = this.validateValue(this.options.startVal)),
                (this.frameVal = this.startVal),
                this.printValue(this.startVal);
            }),
            (t.prototype.update = function (t) {
              cancelAnimationFrame(this.rAF),
                (this.startTime = null),
                (this.endVal = this.validateValue(t)),
                this.endVal !== this.frameVal &&
                  ((this.startVal = this.frameVal),
                  null == this.finalEndVal && this.resetDuration(),
                  (this.finalEndVal = null),
                  this.determineDirectionAndSmartEasing(),
                  (this.rAF = requestAnimationFrame(this.count)));
            }),
            (t.prototype.printValue = function (t) {
              var i = this.formattingFn(t);
              "INPUT" === this.el.tagName
                ? (this.el.value = i)
                : "text" === this.el.tagName || "tspan" === this.el.tagName
                ? (this.el.textContent = i)
                : (this.el.innerHTML = i);
            }),
            (t.prototype.ensureNumber = function (t) {
              return "number" == typeof t && !isNaN(t);
            }),
            (t.prototype.validateValue = function (t) {
              var i = Number(t);
              return this.ensureNumber(i)
                ? i
                : ((this.error =
                    "[CountUp] invalid start or end value: ".concat(t)),
                  null);
            }),
            (t.prototype.resetDuration = function () {
              (this.startTime = null),
                (this.duration = 1e3 * Number(this.options.duration)),
                (this.remaining = this.duration);
            }),
            t
          );
        })();
    },
  },
]);
