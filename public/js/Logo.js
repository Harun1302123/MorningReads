"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["Logo"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/logo_title/LogoEdit.vue?vue&type=script&lang=js":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/logo_title/LogoEdit.vue?vue&type=script&lang=js ***!
  \**********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _custom_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../custom.js */ "./resources/js/custom.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }

var customClass = new _custom_js__WEBPACK_IMPORTED_MODULE_0__.API();
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return _defineProperty({
      laravelData: [],
      allerros: []
    }, "laravelData", {
      title: '',
      imagefile: '',
      manage_by: '',
      help_link: ''
    });
  },
  mounted: function mounted() {
    console.log('Component mounted.');
  },
  created: function created() {
    this.getResults();
  },
  methods: {
    getResults: function getResults() {
      var _this = this;
      axios.get('/settings/logo-edit').then(function (respdonse) {
        _this.laravelData = respdonse.data;
      });
    },
    onFileChange: function onFileChange(event) {
      this.laravelData.imagefile = event.target.files[0];
      console.log(this.laravelData.imagefile);
    },
    saveForm: function saveForm() {
      var app = this;
      var newCompany = app.laravelData;
      var form = new FormData();
      form.append('company_logo', this.laravelData.imagefile);
      form.append('title', this.laravelData.title);
      form.append('manage_by', this.laravelData.manage_by);
      form.append('help_link', this.laravelData.help_link);
      axios.defaults.headers.post['Content-Type'] = 'multipart/form-data';
      axios.post('/settings/update-logo', form).then(function (resp) {
        if (resp.data.status === true) {
          location.reload();
          app.$toast.success('Your data update successfully.');
          app.$router.push({
            path: '/edit-logo'
          });
        }
      })["catch"](function (error) {
        app.allerros = error.response.data.errors;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/logo_title/LogoEdit.vue?vue&type=template&id=1e86153f":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/logo_title/LogoEdit.vue?vue&type=template&id=1e86153f ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************/
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
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h5", null, " Title & Logo ")], -1 /* HOISTED */);
var _hoisted_3 = {
  "class": "card-body"
};
var _hoisted_4 = {
  "class": "col-md-10"
};
var _hoisted_5 = {
  "class": "row form-group"
};
var _hoisted_6 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2 required-star"
}, "Image:", -1 /* HOISTED */);
var _hoisted_7 = ["href"];
var _hoisted_8 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "text-danger",
  style: {
    "font-size": "9px",
    "font-weight": "bold"
  }
}, "[File Format: *.jpg/ .jpeg | File size within 200 KB]", -1 /* HOISTED */);
var _hoisted_10 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* HOISTED */);
var _hoisted_11 = {
  "class": "row form-group"
};
var _hoisted_12 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2 required-star"
}, "Title:", -1 /* HOISTED */);
var _hoisted_13 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_14 = {
  "class": "row form-group"
};
var _hoisted_15 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2 required-star"
}, "Manage by:", -1 /* HOISTED */);
var _hoisted_16 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_17 = {
  "class": "row form-group"
};
var _hoisted_18 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2 required-star"
}, "Help Link:", -1 /* HOISTED */);
var _hoisted_19 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_20 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "col-md-10"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
  type: "submit",
  "class": "btn btn-primary float-right"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-chevron-circle-right"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Save ")])], -1 /* HOISTED */);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [_hoisted_2, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    onSubmit: _cache[4] || (_cache[4] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.saveForm();
    }, ["prevent"]))
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [_hoisted_6, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerros.files ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "file",
    id: "files",
    ref: "files",
    onChange: _cache[0] || (_cache[0] = function () {
      return $options.onFileChange && $options.onFileChange.apply($options, arguments);
    })
  }, null, 544 /* HYDRATE_EVENTS, NEED_PATCH */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
    href: '/' + _ctx.laravelData.logo
  }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.laravelData.logo), 9 /* TEXT, PROPS */, _hoisted_7), _ctx.allerros.files ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_8, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.files[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _hoisted_9, _hoisted_10], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_11, [_hoisted_12, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerros.title ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return _ctx.laravelData.title = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.laravelData.title]]), _ctx.allerros.title ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_13, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.title[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_14, [_hoisted_15, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerros.manage_by ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return _ctx.laravelData.manage_by = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.laravelData.manage_by]]), _ctx.allerros.manage_by ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.manage_by[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_17, [_hoisted_18, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerros.help_link ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      return _ctx.laravelData.help_link = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.laravelData.help_link]]), _ctx.allerros.help_link ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_19, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.help_link[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), _hoisted_20], 32 /* HYDRATE_EVENTS */)])])])]);
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

/***/ "./resources/js/components/settings/logo_title/LogoEdit.vue":
/*!******************************************************************!*\
  !*** ./resources/js/components/settings/logo_title/LogoEdit.vue ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _LogoEdit_vue_vue_type_template_id_1e86153f__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./LogoEdit.vue?vue&type=template&id=1e86153f */ "./resources/js/components/settings/logo_title/LogoEdit.vue?vue&type=template&id=1e86153f");
/* harmony import */ var _LogoEdit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./LogoEdit.vue?vue&type=script&lang=js */ "./resources/js/components/settings/logo_title/LogoEdit.vue?vue&type=script&lang=js");
/* harmony import */ var C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_LogoEdit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_LogoEdit_vue_vue_type_template_id_1e86153f__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/settings/logo_title/LogoEdit.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/settings/logo_title/LogoEdit.vue?vue&type=script&lang=js":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/settings/logo_title/LogoEdit.vue?vue&type=script&lang=js ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_LogoEdit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_LogoEdit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./LogoEdit.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/logo_title/LogoEdit.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/settings/logo_title/LogoEdit.vue?vue&type=template&id=1e86153f":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/settings/logo_title/LogoEdit.vue?vue&type=template&id=1e86153f ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_LogoEdit_vue_vue_type_template_id_1e86153f__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_LogoEdit_vue_vue_type_template_id_1e86153f__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./LogoEdit.vue?vue&type=template&id=1e86153f */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/logo_title/LogoEdit.vue?vue&type=template&id=1e86153f");


/***/ })

}]);