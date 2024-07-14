"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["Currency"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/currency/CurrencyCreate.vue?vue&type=script&lang=js":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/currency/CurrencyCreate.vue?vue&type=script&lang=js ***!
  \**************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _custom_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../custom.js */ "./resources/js/custom.js");

var customClass = new _custom_js__WEBPACK_IMPORTED_MODULE_0__.API();
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      allerros: [],
      success: false,
      currency: {
        code: '',
        name: '',
        usd_value: '',
        bdt_value: ''
      }
    };
  },
  mounted: function mounted() {
    // customClass.onlyNumber();
    // customClass.isEmail();
  },
  methods: {
    saveForm: function saveForm() {
      var app = this;
      axios.post('/settings/store-currency', this.currency).then(function (resp) {
        if (resp.data.status === true) {
          app.$toast.success('Your Currency crate successfully.');
          app.$router.push({
            path: '/currency-list'
          });
        }
      })["catch"](function (error) {
        app.allerros = error.response.data.errors;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/currency/CurrencyEdit.vue?vue&type=script&lang=js":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/currency/CurrencyEdit.vue?vue&type=script&lang=js ***!
  \************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _custom_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../custom.js */ "./resources/js/custom.js");

var customClass = new _custom_js__WEBPACK_IMPORTED_MODULE_0__.API();
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      allerros: [],
      success: false,
      currency: {
        code: '',
        name: '',
        usd_value: '',
        bdt_value: ''
      }
    };
  },
  mounted: function mounted() {
    // customClass.onlyNumber();
    // customClass.isEmail();
  },
  created: function created() {
    var app = this;
    var id = app.$route.params.id;
    console.log(id);
    app.$encrypted_id = id;
    axios.get('/settings/edit-currency/' + id).then(function (resp) {
      app.currency = resp.data;
    })["catch"](function () {
      alert("Could not load your Currency");
    });
  },
  methods: {
    saveForm: function saveForm() {
      var app = this;
      var newCompany = app.currency;
      axios.patch('/settings/update-currency/' + app.$encrypted_id, newCompany).then(function (resp) {
        if (resp.data.status === true) {
          app.$toast.success('Your data update successfully.');
          app.$router.push('/currency-list');
        }
      })["catch"](function (error) {
        app.allerros = error.response.data.errors;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/currency/CurrencyList.vue?vue&type=script&lang=js":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/currency/CurrencyList.vue?vue&type=script&lang=js ***!
  \************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      laravelData: {},
      search: '',
      limits: 10,
      page: 1
    };
  },
  mounted: function mounted() {
    console.log('Component mounted.');
  },
  created: function created() {
    this.getResults();
  },
  methods: {
    getResults: function getResults(page) {
      if (typeof page === 'undefined') {
        page = 1;
      }
      var max_limit = '&limit=' + this.limits;
      var is_search = '';
      if (this.search) {
        is_search = '&search=' + this.search;
      }
      var app = this;
      axios__WEBPACK_IMPORTED_MODULE_0___default().get('/settings/currency-list?page=' + page + is_search + max_limit).then(function (response) {
        app.laravelData = response.data;
      });
    },
    keymonitor: function keymonitor(e) {
      this.getResults(1);
    },
    limit: function limit(e) {
      this.getResults(1);
    },
    ConfirmDelete: function ConfirmDelete(Id, Currency) {
      var _this = this;
      var app = this;
      var sure_del = confirm("Are you sure you want to delete this item?");
      if (sure_del) {
        axios__WEBPACK_IMPORTED_MODULE_0___default().get('/settings/delete/' + Currency + '/' + Id).then(function (resp) {
          // alert(resp);
          if (resp.data.status === true) {
            app.$toast.success('Data has been deleted successfully.');
            app.$router.push('/currency-list');
          }
        })["catch"](function (error) {
          _this.allerros = error.response.data.errors;
        });
      } else {
        return false;
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/currency/CurrencyCreate.vue?vue&type=template&id=f75755ac":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/currency/CurrencyCreate.vue?vue&type=template&id=f75755ac ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "card card-magenta border border-magenta"
};
var _hoisted_2 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "card-header"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h5", {
  "class": "card-title pt-2 pb-2"
}, "Currency form")], -1 /* HOISTED */);
var _hoisted_3 = {
  "class": "card-body"
};
var _hoisted_4 = {
  "class": "col-md-9"
};
var _hoisted_5 = {
  "class": "row form-group"
};
var _hoisted_6 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2 required-star"
}, "Code:", -1 /* HOISTED */);
var _hoisted_7 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_8 = {
  "class": "row form-group"
};
var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2 required-star"
}, "Name:", -1 /* HOISTED */);
var _hoisted_10 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_11 = {
  "class": "row form-group"
};
var _hoisted_12 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2"
}, "USD($) value:", -1 /* HOISTED */);
var _hoisted_13 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_14 = {
  "class": "row form-group"
};
var _hoisted_15 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2"
}, "BDT Value:", -1 /* HOISTED */);
var _hoisted_16 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_17 = {
  "class": "col-md-10"
};
var _hoisted_18 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
  type: "submit",
  "class": "btn btn-primary float-right"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-chevron-circle-right"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Save ")], -1 /* HOISTED */);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_router_link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("router-link");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [_hoisted_2, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    onSubmit: _cache[4] || (_cache[4] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.saveForm();
    }, ["prevent"]))
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [_hoisted_6, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerros.code ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return _ctx.currency.code = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.currency.code]]), _ctx.allerros.code ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.code[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_8, [_hoisted_9, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerros.name ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return _ctx.currency.name = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.currency.name]]), _ctx.allerros.name ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_10, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.name[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_11, [_hoisted_12, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerros.usd_value ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return _ctx.currency.usd_value = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.currency.usd_value]]), _ctx.allerros.usd_value ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_13, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.usd_value[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_14, [_hoisted_15, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerros.bdt_value ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      return _ctx.currency.bdt_value = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.currency.bdt_value]]), _ctx.allerros.bdt_value ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.bdt_value[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_17, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    to: "/currency-list",
    "class": "btn btn-default"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Back")];
    }),
    _: 1 /* STABLE */
  }), _hoisted_18])], 32 /* HYDRATE_EVENTS */)])])])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/currency/CurrencyEdit.vue?vue&type=template&id=56184e90":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/currency/CurrencyEdit.vue?vue&type=template&id=56184e90 ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "card card-magenta border border-magenta"
};
var _hoisted_2 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "card-header"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h5", {
  "class": "card-title pt-2 pb-2"
}, "Currency form")], -1 /* HOISTED */);
var _hoisted_3 = {
  "class": "card-body"
};
var _hoisted_4 = {
  "class": "col-md-9"
};
var _hoisted_5 = {
  "class": "row form-group"
};
var _hoisted_6 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2 required-star"
}, "Code:", -1 /* HOISTED */);
var _hoisted_7 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_8 = {
  "class": "row form-group"
};
var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2 required-star"
}, "Name:", -1 /* HOISTED */);
var _hoisted_10 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_11 = {
  "class": "row form-group"
};
var _hoisted_12 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2"
}, "USD($) value:", -1 /* HOISTED */);
var _hoisted_13 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_14 = {
  "class": "row form-group"
};
var _hoisted_15 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2"
}, "BDT Value:", -1 /* HOISTED */);
var _hoisted_16 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_17 = {
  "class": "row form-group"
};
var _hoisted_18 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": "is_active",
  "class": "col-md-2 required-star"
}, "Active Status: ", -1 /* HOISTED */);
var _hoisted_19 = {
  "class": "col-md-6"
};
var _hoisted_20 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_21 = {
  "class": "col-md-10"
};
var _hoisted_22 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
  type: "submit",
  "class": "btn btn-primary float-right"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-chevron-circle-right"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Save ")], -1 /* HOISTED */);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_router_link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("router-link");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [_hoisted_2, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    onSubmit: _cache[6] || (_cache[6] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.saveForm();
    }, ["prevent"]))
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [_hoisted_6, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerros.code ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return _ctx.currency.code = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.currency.code]]), _ctx.allerros.code ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.code[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_8, [_hoisted_9, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerros.name ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return _ctx.currency.name = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.currency.name]]), _ctx.allerros.name ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_10, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.name[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_11, [_hoisted_12, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerros.usd_value ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return _ctx.currency.usd_value = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.currency.usd_value]]), _ctx.allerros.usd_value ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_13, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.usd_value[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_14, [_hoisted_15, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerros.bdt_value ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      return _ctx.currency.bdt_value = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.currency.bdt_value]]), _ctx.allerros.bdt_value ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.bdt_value[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_17, [_hoisted_18, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_19, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
      return _ctx.currency.is_active = $event;
    }),
    name: "is_active",
    type: "radio",
    value: "1",
    id: "is_active"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelRadio, _ctx.currency.is_active]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Active  ")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
      return _ctx.currency.is_active = $event;
    }),
    name: "is_active",
    type: "radio",
    value: "0",
    id: "is_active"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelRadio, _ctx.currency.is_active]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Inactive")]), _ctx.allerros.is_active ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_20, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.is_active[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_21, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    to: "/currency-list",
    "class": "btn btn-default float-left"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Back")];
    }),
    _: 1 /* STABLE */
  }), _hoisted_22])], 32 /* HYDRATE_EVENTS */)])])])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/currency/CurrencyList.vue?vue&type=template&id=74a89d68":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/currency/CurrencyList.vue?vue&type=template&id=74a89d68 ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "card card-magenta border border-magenta"
};
var _hoisted_2 = {
  "class": "card-header"
};
var _hoisted_3 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "float-left"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h5", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("strong", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-list"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("strong", null, "List of Currency")])])], -1 /* HOISTED */);
var _hoisted_4 = {
  "class": "float-right"
};
var _hoisted_5 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "clearfix"
}, null, -1 /* HOISTED */);
var _hoisted_6 = {
  "class": "card-body"
};
var _hoisted_7 = {
  "class": "col-md-1 float-left"
};
var _hoisted_8 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "10"
}, "10", -1 /* HOISTED */);
var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "25"
}, "25", -1 /* HOISTED */);
var _hoisted_10 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "50"
}, "50", -1 /* HOISTED */);
var _hoisted_11 = [_hoisted_8, _hoisted_9, _hoisted_10];
var _hoisted_12 = {
  "class": "col-md-offset-8 col-md-3 float-right"
};
var _hoisted_13 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* HOISTED */);
var _hoisted_14 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* HOISTED */);
var _hoisted_15 = {
  "class": "col-md-12"
};
var _hoisted_16 = {
  "class": "table dt-responsive"
};
var _hoisted_17 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("thead", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "SL"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Code"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Name"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "USD($) value"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "BDT Value"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Active status"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  "class": "text-center"
}, "Action")])], -1 /* HOISTED */);
var _hoisted_18 = {
  "class": "text-center"
};
var _hoisted_19 = {
  key: 0,
  "class": "text-success"
};
var _hoisted_20 = {
  key: 1,
  "class": "text-danger"
};
var _hoisted_21 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-edit"
}, null, -1 /* HOISTED */);
var _hoisted_22 = ["onClick"];
var _hoisted_23 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-times"
}, null, -1 /* HOISTED */);
var _hoisted_24 = [_hoisted_23];
var _hoisted_25 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "col-md-5"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br")], -1 /* HOISTED */);
var _hoisted_26 = {
  "class": "col-md-7"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _$data$laravelData$to, _$data$limits;
  var _component_router_link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("router-link");
  var _component_pagination = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("pagination");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("    <div class=\"col-lg-12\">"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("<div class=\"form-group\">"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("<router-link :to=\"{name: 'BankCreate'}\" class=\"btn btn-success\">Create new Bank</router-link>"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("</div>"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [_hoisted_3, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    to: {
      name: 'CurrencyCreate'
    },
    "class": "btn btn-success"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Create Currency")];
    }),
    _: 1 /* STABLE */
  })]), _hoisted_5]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "class": "form-control col-md-12",
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return $data.limits = $event;
    }),
    onChange: _cache[1] || (_cache[1] = function ($event) {
      return $options.limit($event);
    })
  }, _hoisted_11, 544 /* HYDRATE_EVENTS, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.limits]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_12, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "class": "form-control",
    type: "text",
    placeholder: "Search...",
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return $data.search = $event;
    }),
    onKeyup: _cache[3] || (_cache[3] = function () {
      return $options.keymonitor && $options.keymonitor.apply($options, arguments);
    })
  }, null, 544 /* HYDRATE_EVENTS, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.search]])]), _hoisted_13, _hoisted_14, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_15, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_16, [_hoisted_17, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tbody", null, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.laravelData.data, function (currency) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", {
      key: currency.id
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(currency.si), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(currency.code), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(currency.name), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(currency.usd_value), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(currency.bdt_value), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_18, [currency.is_active == 1 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_19, "Active")) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_20, "Inactive"))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
      to: {
        name: 'CurrencyEdit',
        params: {
          id: currency.id
        }
      },
      "class": "btn btn-xs btn-primary"
    }, {
      "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
        return [_hoisted_21, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Edit ")];
      }),
      _: 2 /* DYNAMIC */
    }, 1032 /* PROPS, DYNAMIC_SLOTS */, ["to"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("   "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
      "class": "btn btn-xs btn-danger",
      onClick: function onClick($event) {
        return $options.ConfirmDelete(currency.id, 'Currency');
      }
    }, _hoisted_24, 8 /* PROPS */, _hoisted_22)])]);
  }), 128 /* KEYED_FRAGMENT */))])])]), _hoisted_25, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_26, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_pagination, {
    modelValue: $data.page,
    "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
      return $data.page = $event;
    }),
    records: (_$data$laravelData$to = $data.laravelData.total) !== null && _$data$laravelData$to !== void 0 ? _$data$laravelData$to : 0,
    "per-page": (_$data$limits = $data.limits) !== null && _$data$limits !== void 0 ? _$data$limits : 0,
    onPaginate: $options.getResults
  }, null, 8 /* PROPS */, ["modelValue", "records", "per-page", "onPaginate"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("                    <pagination :limit=\"2\" class=\"pull-right\" :data=\"laravelData\" @pagination-change-page=\"getResults\"></pagination>")])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("    </div>")], 2112 /* STABLE_FRAGMENT, DEV_ROOT_FRAGMENT */);
}

/***/ }),

/***/ "./resources/js/custom.js":
/*!********************************!*\
  !*** ./resources/js/custom.js ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "API": () => (/* binding */ API)
/* harmony export */ });
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }

var API = /*#__PURE__*/function () {
  function API() {
    _classCallCheck(this, API);
  }
  _createClass(API, [{
    key: "onlyNumber",
    value: function onlyNumber() {
      jquery__WEBPACK_IMPORTED_MODULE_0___default()('.onlyNumber').on('keydown', function (e) {
        //period decimal
        if (e.which >= 48 && e.which <= 57
        //numpad decimal
        || e.which >= 96 && e.which <= 105
        // Allow: backspace, delete, tab, escape, enter and .
        || jquery__WEBPACK_IMPORTED_MODULE_0___default().inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1
        // Allow: Ctrl+A
        || e.keyCode == 65 && e.ctrlKey === true
        // Allow: Ctrl+C
        || e.keyCode == 67 && e.ctrlKey === true
        // Allow: Ctrl+V
        || e.keyCode == 86 && e.ctrlKey === true
        // Allow: Ctrl+X
        || e.keyCode == 88 && e.ctrlKey === true
        // Allow: home, end, left, right
        || e.keyCode >= 35 && e.keyCode <= 39) {
          var thisVal = jquery__WEBPACK_IMPORTED_MODULE_0___default()(this).val();
          if (thisVal.indexOf(".") != -1 && e.key == '.') {
            return false;
          }
          jquery__WEBPACK_IMPORTED_MODULE_0___default()(this).removeClass('error');
          return true;
        } else {
          jquery__WEBPACK_IMPORTED_MODULE_0___default()(this).addClass('error');
          return false;
        }
      }).on('paste', function (e) {
        var $this = jquery__WEBPACK_IMPORTED_MODULE_0___default()(this);
        setTimeout(function () {
          $this.val($this.val().replace(/[^0-9]/g, ''));
        }, 4);
      }).on('keyup', function (e) {
        var $this = jquery__WEBPACK_IMPORTED_MODULE_0___default()(this);
        setTimeout(function () {
          $this.val($this.val().replace(/[^0-9]/g, ''));
        }, 4);
      });
    }
  }, {
    key: "isEmail",
    value: function isEmail() {
      jquery__WEBPACK_IMPORTED_MODULE_0___default()('.email').on('keydown', function (e) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (regex.test(jquery__WEBPACK_IMPORTED_MODULE_0___default()(this).val()) == false) {
          jquery__WEBPACK_IMPORTED_MODULE_0___default()(this).addClass('error');
          // return false
        } else {
          jquery__WEBPACK_IMPORTED_MODULE_0___default()(this).removeClass('error');
          return true;
        }
      });
    }
  }, {
    key: "stripedContent",
    value: function stripedContent(html) {
      var tmp = document.createElement("DIV");
      tmp.innerHTML = html;
      return tmp.textContent || tmp.innerText || "";
    }
  }]);
  return API;
}();


/***/ }),

/***/ "./node_modules/vue-loader/dist/exportHelper.js":
/*!******************************************************!*\
  !*** ./node_modules/vue-loader/dist/exportHelper.js ***!
  \******************************************************/
/***/ ((__unused_webpack_module, exports) => {


Object.defineProperty(exports, "__esModule", ({ value: true }));
// runtime helper for setting properties on components
// in a tree-shakable way
exports["default"] = (sfc, props) => {
    const target = sfc.__vccOpts || sfc;
    for (const [key, val] of props) {
        target[key] = val;
    }
    return target;
};


/***/ }),

/***/ "./resources/js/components/settings/currency/CurrencyCreate.vue":
/*!**********************************************************************!*\
  !*** ./resources/js/components/settings/currency/CurrencyCreate.vue ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _CurrencyCreate_vue_vue_type_template_id_f75755ac__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CurrencyCreate.vue?vue&type=template&id=f75755ac */ "./resources/js/components/settings/currency/CurrencyCreate.vue?vue&type=template&id=f75755ac");
/* harmony import */ var _CurrencyCreate_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CurrencyCreate.vue?vue&type=script&lang=js */ "./resources/js/components/settings/currency/CurrencyCreate.vue?vue&type=script&lang=js");
/* harmony import */ var C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_CurrencyCreate_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_CurrencyCreate_vue_vue_type_template_id_f75755ac__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/settings/currency/CurrencyCreate.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/settings/currency/CurrencyEdit.vue":
/*!********************************************************************!*\
  !*** ./resources/js/components/settings/currency/CurrencyEdit.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _CurrencyEdit_vue_vue_type_template_id_56184e90__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CurrencyEdit.vue?vue&type=template&id=56184e90 */ "./resources/js/components/settings/currency/CurrencyEdit.vue?vue&type=template&id=56184e90");
/* harmony import */ var _CurrencyEdit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CurrencyEdit.vue?vue&type=script&lang=js */ "./resources/js/components/settings/currency/CurrencyEdit.vue?vue&type=script&lang=js");
/* harmony import */ var C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_CurrencyEdit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_CurrencyEdit_vue_vue_type_template_id_56184e90__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/settings/currency/CurrencyEdit.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/settings/currency/CurrencyList.vue":
/*!********************************************************************!*\
  !*** ./resources/js/components/settings/currency/CurrencyList.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _CurrencyList_vue_vue_type_template_id_74a89d68__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CurrencyList.vue?vue&type=template&id=74a89d68 */ "./resources/js/components/settings/currency/CurrencyList.vue?vue&type=template&id=74a89d68");
/* harmony import */ var _CurrencyList_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CurrencyList.vue?vue&type=script&lang=js */ "./resources/js/components/settings/currency/CurrencyList.vue?vue&type=script&lang=js");
/* harmony import */ var C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_CurrencyList_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_CurrencyList_vue_vue_type_template_id_74a89d68__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/settings/currency/CurrencyList.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/settings/currency/CurrencyCreate.vue?vue&type=script&lang=js":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/settings/currency/CurrencyCreate.vue?vue&type=script&lang=js ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_CurrencyCreate_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_CurrencyCreate_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./CurrencyCreate.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/currency/CurrencyCreate.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/settings/currency/CurrencyEdit.vue?vue&type=script&lang=js":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/settings/currency/CurrencyEdit.vue?vue&type=script&lang=js ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_CurrencyEdit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_CurrencyEdit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./CurrencyEdit.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/currency/CurrencyEdit.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/settings/currency/CurrencyList.vue?vue&type=script&lang=js":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/settings/currency/CurrencyList.vue?vue&type=script&lang=js ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_CurrencyList_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_CurrencyList_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./CurrencyList.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/currency/CurrencyList.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/settings/currency/CurrencyCreate.vue?vue&type=template&id=f75755ac":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/settings/currency/CurrencyCreate.vue?vue&type=template&id=f75755ac ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_CurrencyCreate_vue_vue_type_template_id_f75755ac__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_CurrencyCreate_vue_vue_type_template_id_f75755ac__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./CurrencyCreate.vue?vue&type=template&id=f75755ac */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/currency/CurrencyCreate.vue?vue&type=template&id=f75755ac");


/***/ }),

/***/ "./resources/js/components/settings/currency/CurrencyEdit.vue?vue&type=template&id=56184e90":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/settings/currency/CurrencyEdit.vue?vue&type=template&id=56184e90 ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_CurrencyEdit_vue_vue_type_template_id_56184e90__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_CurrencyEdit_vue_vue_type_template_id_56184e90__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./CurrencyEdit.vue?vue&type=template&id=56184e90 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/currency/CurrencyEdit.vue?vue&type=template&id=56184e90");


/***/ }),

/***/ "./resources/js/components/settings/currency/CurrencyList.vue?vue&type=template&id=74a89d68":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/settings/currency/CurrencyList.vue?vue&type=template&id=74a89d68 ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_CurrencyList_vue_vue_type_template_id_74a89d68__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_CurrencyList_vue_vue_type_template_id_74a89d68__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./CurrencyList.vue?vue&type=template&id=74a89d68 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/currency/CurrencyList.vue?vue&type=template&id=74a89d68");


/***/ })

}]);