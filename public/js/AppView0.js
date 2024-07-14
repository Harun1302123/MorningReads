"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["AppView0"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./app/Modules/Documents/resources/js/components/AppDocuments.vue?vue&type=script&lang=js":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./app/Modules/Documents/resources/js/components/AppDocuments.vue?vue&type=script&lang=js ***!
  \****************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    encoded_process_type_id: '',
    encoded_ref_id: '',
    viewMode: '',
    openMode: '',
    doc_type_key: ''
  },
  data: function data() {
    return {
      documentContent: ''
    };
  },
  created: function created() {
    this.getAppDocuments();
  },
  methods: {
    getAppDocuments: function getAppDocuments() {
      var app = this;
      app.isDisabled = true;
      axios.get('/documents/get-app-docs', {
        params: {
          encoded_process_type_id: app.encoded_process_type_id,
          encoded_app_id: app.encoded_ref_id,
          view_mode: app.viewMode,
          openMode: app.openMode,
          doc_type_key: app.doc_type_key
        }
      }).then(function (response) {
        app.documentContent = response.data.html;
      })["catch"](function (error) {
        // handle error
        console.log(error);
      }).then(function () {});
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./app/Modules/Documents/resources/js/components/AppDocuments.vue?vue&type=template&id=1295e76f":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./app/Modules/Documents/resources/js/components/AppDocuments.vue?vue&type=template&id=1295e76f ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = ["innerHTML"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
    innerHTML: $data.documentContent
  }, null, 8 /* PROPS */, _hoisted_1);
}

/***/ }),

/***/ "./app/Modules/Documents/resources/js/components/AppDocuments.vue":
/*!************************************************************************!*\
  !*** ./app/Modules/Documents/resources/js/components/AppDocuments.vue ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _AppDocuments_vue_vue_type_template_id_1295e76f__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AppDocuments.vue?vue&type=template&id=1295e76f */ "./app/Modules/Documents/resources/js/components/AppDocuments.vue?vue&type=template&id=1295e76f");
/* harmony import */ var _AppDocuments_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AppDocuments.vue?vue&type=script&lang=js */ "./app/Modules/Documents/resources/js/components/AppDocuments.vue?vue&type=script&lang=js");
/* harmony import */ var C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_AppDocuments_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_AppDocuments_vue_vue_type_template_id_1295e76f__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"app/Modules/Documents/resources/js/components/AppDocuments.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./app/Modules/Documents/resources/js/components/AppDocuments.vue?vue&type=script&lang=js":
/*!************************************************************************************************!*\
  !*** ./app/Modules/Documents/resources/js/components/AppDocuments.vue?vue&type=script&lang=js ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AppDocuments_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AppDocuments_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./AppDocuments.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./app/Modules/Documents/resources/js/components/AppDocuments.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./app/Modules/Documents/resources/js/components/AppDocuments.vue?vue&type=template&id=1295e76f":
/*!******************************************************************************************************!*\
  !*** ./app/Modules/Documents/resources/js/components/AppDocuments.vue?vue&type=template&id=1295e76f ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AppDocuments_vue_vue_type_template_id_1295e76f__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AppDocuments_vue_vue_type_template_id_1295e76f__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./AppDocuments.vue?vue&type=template&id=1295e76f */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./app/Modules/Documents/resources/js/components/AppDocuments.vue?vue&type=template&id=1295e76f");


/***/ })

}]);