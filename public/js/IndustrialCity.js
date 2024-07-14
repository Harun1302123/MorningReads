"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["IndustrialCity"],{

/***/ "./node_modules/@tinymce/tinymce-vue/lib/es2015/main/ts/ScriptLoader.js":
/*!******************************************************************************!*\
  !*** ./node_modules/@tinymce/tinymce-vue/lib/es2015/main/ts/ScriptLoader.js ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ScriptLoader": () => (/* binding */ ScriptLoader)
/* harmony export */ });
/* harmony import */ var _Utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Utils */ "./node_modules/@tinymce/tinymce-vue/lib/es2015/main/ts/Utils.js");
/**
 * Copyright (c) 2018-present, Ephox, Inc.
 *
 * This source code is licensed under the Apache 2 license found in the
 * LICENSE file in the root directory of this source tree.
 *
 */

var createState = function () { return ({
    listeners: [],
    scriptId: (0,_Utils__WEBPACK_IMPORTED_MODULE_0__.uuid)('tiny-script'),
    scriptLoaded: false
}); };
var CreateScriptLoader = function () {
    var state = createState();
    var injectScriptTag = function (scriptId, doc, url, callback) {
        var scriptTag = doc.createElement('script');
        scriptTag.referrerPolicy = 'origin';
        scriptTag.type = 'application/javascript';
        scriptTag.id = scriptId;
        scriptTag.src = url;
        var handler = function () {
            scriptTag.removeEventListener('load', handler);
            callback();
        };
        scriptTag.addEventListener('load', handler);
        if (doc.head) {
            doc.head.appendChild(scriptTag);
        }
    };
    var load = function (doc, url, callback) {
        if (state.scriptLoaded) {
            callback();
        }
        else {
            state.listeners.push(callback);
            if (!doc.getElementById(state.scriptId)) {
                injectScriptTag(state.scriptId, doc, url, function () {
                    state.listeners.forEach(function (fn) { return fn(); });
                    state.scriptLoaded = true;
                });
            }
        }
    };
    // Only to be used by tests.
    var reinitialize = function () {
        state = createState();
    };
    return {
        load: load,
        reinitialize: reinitialize
    };
};
var ScriptLoader = CreateScriptLoader();



/***/ }),

/***/ "./node_modules/@tinymce/tinymce-vue/lib/es2015/main/ts/TinyMCE.js":
/*!*************************************************************************!*\
  !*** ./node_modules/@tinymce/tinymce-vue/lib/es2015/main/ts/TinyMCE.js ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "getTinymce": () => (/* binding */ getTinymce)
/* harmony export */ });
/**
 * Copyright (c) 2018-present, Ephox, Inc.
 *
 * This source code is licensed under the Apache 2 license found in the
 * LICENSE file in the root directory of this source tree.
 *
 */
var getGlobal = function () { return (typeof window !== 'undefined' ? window : __webpack_require__.g); };
var getTinymce = function () {
    var global = getGlobal();
    return global && global.tinymce ? global.tinymce : null;
};



/***/ }),

/***/ "./node_modules/@tinymce/tinymce-vue/lib/es2015/main/ts/Utils.js":
/*!***********************************************************************!*\
  !*** ./node_modules/@tinymce/tinymce-vue/lib/es2015/main/ts/Utils.js ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "bindHandlers": () => (/* binding */ bindHandlers),
/* harmony export */   "bindModelHandlers": () => (/* binding */ bindModelHandlers),
/* harmony export */   "initEditor": () => (/* binding */ initEditor),
/* harmony export */   "isNullOrUndefined": () => (/* binding */ isNullOrUndefined),
/* harmony export */   "isTextarea": () => (/* binding */ isTextarea),
/* harmony export */   "isValidKey": () => (/* binding */ isValidKey),
/* harmony export */   "mergePlugins": () => (/* binding */ mergePlugins),
/* harmony export */   "uuid": () => (/* binding */ uuid)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");
/**
 * Copyright (c) 2018-present, Ephox, Inc.
 *
 * This source code is licensed under the Apache 2 license found in the
 * LICENSE file in the root directory of this source tree.
 *
 */

var validEvents = [
    'onActivate',
    'onAddUndo',
    'onBeforeAddUndo',
    'onBeforeExecCommand',
    'onBeforeGetContent',
    'onBeforeRenderUI',
    'onBeforeSetContent',
    'onBeforePaste',
    'onBlur',
    'onChange',
    'onClearUndos',
    'onClick',
    'onContextMenu',
    'onCopy',
    'onCut',
    'onDblclick',
    'onDeactivate',
    'onDirty',
    'onDrag',
    'onDragDrop',
    'onDragEnd',
    'onDragGesture',
    'onDragOver',
    'onDrop',
    'onExecCommand',
    'onFocus',
    'onFocusIn',
    'onFocusOut',
    'onGetContent',
    'onHide',
    'onInit',
    'onKeyDown',
    'onKeyPress',
    'onKeyUp',
    'onLoadContent',
    'onMouseDown',
    'onMouseEnter',
    'onMouseLeave',
    'onMouseMove',
    'onMouseOut',
    'onMouseOver',
    'onMouseUp',
    'onNodeChange',
    'onObjectResizeStart',
    'onObjectResized',
    'onObjectSelected',
    'onPaste',
    'onPostProcess',
    'onPostRender',
    'onPreProcess',
    'onProgressState',
    'onRedo',
    'onRemove',
    'onReset',
    'onSaveContent',
    'onSelectionChange',
    'onSetAttrib',
    'onSetContent',
    'onShow',
    'onSubmit',
    'onUndo',
    'onVisualAid'
];
var isValidKey = function (key) {
    return validEvents.map(function (event) { return event.toLowerCase(); }).indexOf(key.toLowerCase()) !== -1;
};
var bindHandlers = function (initEvent, listeners, editor) {
    Object.keys(listeners)
        .filter(isValidKey)
        .forEach(function (key) {
        var handler = listeners[key];
        if (typeof handler === 'function') {
            if (key === 'onInit') {
                handler(initEvent, editor);
            }
            else {
                editor.on(key.substring(2), function (e) { return handler(e, editor); });
            }
        }
    });
};
var bindModelHandlers = function (props, ctx, editor, modelValue) {
    var modelEvents = props.modelEvents ? props.modelEvents : null;
    var normalizedEvents = Array.isArray(modelEvents) ? modelEvents.join(' ') : modelEvents;
    (0,vue__WEBPACK_IMPORTED_MODULE_0__.watch)(modelValue, function (val, prevVal) {
        if (editor && typeof val === 'string' && val !== prevVal && val !== editor.getContent({ format: props.outputFormat })) {
            editor.setContent(val);
        }
    });
    editor.on(normalizedEvents ? normalizedEvents : 'change input undo redo', function () {
        ctx.emit('update:modelValue', editor.getContent({ format: props.outputFormat }));
    });
};
var initEditor = function (initEvent, props, ctx, editor, modelValue, content) {
    editor.setContent(content());
    if (ctx.attrs['onUpdate:modelValue']) {
        bindModelHandlers(props, ctx, editor, modelValue);
    }
    bindHandlers(initEvent, ctx.attrs, editor);
};
var unique = 0;
var uuid = function (prefix) {
    var time = Date.now();
    var random = Math.floor(Math.random() * 1000000000);
    unique++;
    return prefix + '_' + random + unique + String(time);
};
var isTextarea = function (element) {
    return element !== null && element.tagName.toLowerCase() === 'textarea';
};
var normalizePluginArray = function (plugins) {
    if (typeof plugins === 'undefined' || plugins === '') {
        return [];
    }
    return Array.isArray(plugins) ? plugins : plugins.split(' ');
};
var mergePlugins = function (initPlugins, inputPlugins) {
    return normalizePluginArray(initPlugins).concat(normalizePluginArray(inputPlugins));
};
var isNullOrUndefined = function (value) {
    return value === null || value === undefined;
};



/***/ }),

/***/ "./node_modules/@tinymce/tinymce-vue/lib/es2015/main/ts/components/Editor.js":
/*!***********************************************************************************!*\
  !*** ./node_modules/@tinymce/tinymce-vue/lib/es2015/main/ts/components/Editor.js ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Editor": () => (/* binding */ Editor)
/* harmony export */ });
/* harmony import */ var _ScriptLoader__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../ScriptLoader */ "./node_modules/@tinymce/tinymce-vue/lib/es2015/main/ts/ScriptLoader.js");
/* harmony import */ var _TinyMCE__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../TinyMCE */ "./node_modules/@tinymce/tinymce-vue/lib/es2015/main/ts/TinyMCE.js");
/* harmony import */ var _Utils__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../Utils */ "./node_modules/@tinymce/tinymce-vue/lib/es2015/main/ts/Utils.js");
/* harmony import */ var _EditorPropTypes__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./EditorPropTypes */ "./node_modules/@tinymce/tinymce-vue/lib/es2015/main/ts/components/EditorPropTypes.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");
/**
 * Copyright (c) 2018-present, Ephox, Inc.
 *
 * This source code is licensed under the Apache 2 license found in the
 * LICENSE file in the root directory of this source tree.
 *
 */
var __assign = (undefined && undefined.__assign) || function () {
    __assign = Object.assign || function(t) {
        for (var s, i = 1, n = arguments.length; i < n; i++) {
            s = arguments[i];
            for (var p in s) if (Object.prototype.hasOwnProperty.call(s, p))
                t[p] = s[p];
        }
        return t;
    };
    return __assign.apply(this, arguments);
};





var renderInline = function (ce, id, elementRef, tagName) {
    return ce(tagName ? tagName : 'div', {
        id: id,
        ref: elementRef
    });
};
var renderIframe = function (ce, id, elementRef) {
    return ce('textarea', {
        id: id,
        visibility: 'hidden',
        ref: elementRef
    });
};
var Editor = (0,vue__WEBPACK_IMPORTED_MODULE_4__.defineComponent)({
    props: _EditorPropTypes__WEBPACK_IMPORTED_MODULE_3__.editorProps,
    setup: function (props, ctx) {
        var conf = props.init ? __assign({}, props.init) : {};
        var _a = (0,vue__WEBPACK_IMPORTED_MODULE_4__.toRefs)(props), disabled = _a.disabled, modelValue = _a.modelValue, tagName = _a.tagName;
        var element = (0,vue__WEBPACK_IMPORTED_MODULE_4__.ref)(null);
        var vueEditor = null;
        var elementId = props.id || (0,_Utils__WEBPACK_IMPORTED_MODULE_2__.uuid)('tiny-vue');
        var inlineEditor = (props.init && props.init.inline) || props.inline;
        var modelBind = !!ctx.attrs['onUpdate:modelValue'];
        var mounting = true;
        var initialValue = props.initialValue ? props.initialValue : '';
        var cache = '';
        var getContent = function (isMounting) { return modelBind ?
            function () { return ((modelValue === null || modelValue === void 0 ? void 0 : modelValue.value) ? modelValue.value : ''); } :
            function () { return isMounting ? initialValue : cache; }; };
        var initWrapper = function () {
            var content = getContent(mounting);
            var finalInit = __assign(__assign({}, conf), { readonly: props.disabled, selector: "#" + elementId, plugins: (0,_Utils__WEBPACK_IMPORTED_MODULE_2__.mergePlugins)(conf.plugins, props.plugins), toolbar: props.toolbar || (conf.toolbar), inline: inlineEditor, setup: function (editor) {
                    vueEditor = editor;
                    editor.on('init', function (e) { return (0,_Utils__WEBPACK_IMPORTED_MODULE_2__.initEditor)(e, props, ctx, editor, modelValue, content); });
                    if (typeof conf.setup === 'function') {
                        conf.setup(editor);
                    }
                } });
            if ((0,_Utils__WEBPACK_IMPORTED_MODULE_2__.isTextarea)(element.value)) {
                element.value.style.visibility = '';
            }
            (0,_TinyMCE__WEBPACK_IMPORTED_MODULE_1__.getTinymce)().init(finalInit);
            mounting = false;
        };
        (0,vue__WEBPACK_IMPORTED_MODULE_4__.watch)(disabled, function (disable) {
            var _a;
            if (vueEditor !== null) {
                if (typeof ((_a = vueEditor.mode) === null || _a === void 0 ? void 0 : _a.set) === 'function') {
                    vueEditor.mode.set(disable ? 'readonly' : 'design');
                }
                else {
                    vueEditor.setMode(disable ? 'readonly' : 'design');
                }
            }
        });
        (0,vue__WEBPACK_IMPORTED_MODULE_4__.watch)(tagName, function (_) {
            var _a;
            if (!modelBind) {
                cache = vueEditor.getContent();
            }
            (_a = (0,_TinyMCE__WEBPACK_IMPORTED_MODULE_1__.getTinymce)()) === null || _a === void 0 ? void 0 : _a.remove(vueEditor);
            (0,vue__WEBPACK_IMPORTED_MODULE_4__.nextTick)(function () { return initWrapper(); });
        });
        (0,vue__WEBPACK_IMPORTED_MODULE_4__.onMounted)(function () {
            if ((0,_TinyMCE__WEBPACK_IMPORTED_MODULE_1__.getTinymce)() !== null) {
                initWrapper();
            }
            else if (element.value && element.value.ownerDocument) {
                var channel = props.cloudChannel ? props.cloudChannel : '5';
                var apiKey = props.apiKey ? props.apiKey : 'no-api-key';
                var scriptSrc = (0,_Utils__WEBPACK_IMPORTED_MODULE_2__.isNullOrUndefined)(props.tinymceScriptSrc) ?
                    "https://cdn.tiny.cloud/1/" + apiKey + "/tinymce/" + channel + "/tinymce.min.js" :
                    props.tinymceScriptSrc;
                _ScriptLoader__WEBPACK_IMPORTED_MODULE_0__.ScriptLoader.load(element.value.ownerDocument, scriptSrc, initWrapper);
            }
        });
        (0,vue__WEBPACK_IMPORTED_MODULE_4__.onBeforeUnmount)(function () {
            if ((0,_TinyMCE__WEBPACK_IMPORTED_MODULE_1__.getTinymce)() !== null) {
                (0,_TinyMCE__WEBPACK_IMPORTED_MODULE_1__.getTinymce)().remove(vueEditor);
            }
        });
        if (!inlineEditor) {
            (0,vue__WEBPACK_IMPORTED_MODULE_4__.onActivated)(function () {
                if (!mounting) {
                    initWrapper();
                }
            });
            (0,vue__WEBPACK_IMPORTED_MODULE_4__.onDeactivated)(function () {
                var _a;
                if (!modelBind) {
                    cache = vueEditor.getContent();
                }
                (_a = (0,_TinyMCE__WEBPACK_IMPORTED_MODULE_1__.getTinymce)()) === null || _a === void 0 ? void 0 : _a.remove(vueEditor);
            });
        }
        var rerender = function (init) {
            var _a;
            cache = vueEditor.getContent();
            (_a = (0,_TinyMCE__WEBPACK_IMPORTED_MODULE_1__.getTinymce)()) === null || _a === void 0 ? void 0 : _a.remove(vueEditor);
            conf = __assign(__assign({}, conf), init);
            (0,vue__WEBPACK_IMPORTED_MODULE_4__.nextTick)(function () { return initWrapper(); });
        };
        ctx.expose({
            rerender: rerender
        });
        return function () { return inlineEditor ?
            renderInline(vue__WEBPACK_IMPORTED_MODULE_4__.h, elementId, element, props.tagName) :
            renderIframe(vue__WEBPACK_IMPORTED_MODULE_4__.h, elementId, element); };
    }
});


/***/ }),

/***/ "./node_modules/@tinymce/tinymce-vue/lib/es2015/main/ts/components/EditorPropTypes.js":
/*!********************************************************************************************!*\
  !*** ./node_modules/@tinymce/tinymce-vue/lib/es2015/main/ts/components/EditorPropTypes.js ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "editorProps": () => (/* binding */ editorProps)
/* harmony export */ });
var editorProps = {
    apiKey: String,
    cloudChannel: String,
    id: String,
    init: Object,
    initialValue: String,
    inline: Boolean,
    modelEvents: [String, Array],
    plugins: [String, Array],
    tagName: String,
    toolbar: [String, Array],
    modelValue: String,
    disabled: Boolean,
    tinymceScriptSrc: String,
    outputFormat: {
        type: String,
        validator: function (prop) { return prop === 'html' || prop === 'text'; }
    },
};


/***/ }),

/***/ "./node_modules/@tinymce/tinymce-vue/lib/es2015/main/ts/index.js":
/*!***********************************************************************!*\
  !*** ./node_modules/@tinymce/tinymce-vue/lib/es2015/main/ts/index.js ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _components_Editor__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/Editor */ "./node_modules/@tinymce/tinymce-vue/lib/es2015/main/ts/components/Editor.js");
/**
 * Copyright (c) 2018-present, Ephox, Inc.
 *
 * This source code is licensed under the Apache 2 license found in the
 * LICENSE file in the root directory of this source tree.
 *
 */

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_components_Editor__WEBPACK_IMPORTED_MODULE_0__.Editor);


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/IndustrialCityCreate.vue?vue&type=script&lang=js":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/IndustrialCityCreate.vue?vue&type=script&lang=js ***!
  \***************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _tinymce_tinymce_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @tinymce/tinymce-vue */ "./node_modules/@tinymce/tinymce-vue/lib/es2015/main/ts/index.js");

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      show: true,
      allerros: [],
      success: false,
      industrialCity: {
        office_short_code: '',
        h_office_id: '',
        name_en: '',
        name: '',
        district_en: '',
        district: '',
        upazila_en: '',
        upazila: '',
        details_en: '',
        details: '',
        image: '',
        latitude: '',
        longitude: '',
        order: '',
        status: '',
        type: '0',
        establish_year: '',
        land_amount: '',
        per_acre_price: '',
        used_plot: '',
        ind_plot_no: '',
        total_plot_allocated: '',
        ind_unit_total: '',
        ind_unit_under_prod: '',
        ind_unit_under_cons: '',
        ind_unit_off: '',
        ind_unit_allocate_wait: ''
      },
      districtsData: [],
      homeOffice: [],
      selected: null
    };
  },
  components: {
    'editor': _tinymce_tinymce_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  mounted: function mounted() {
    $("#district").change(function () {
      $(this).after('<span class="loading_data">Loading...</span>');
      var self = $(this);
      var districtId = $('#district').val();
      if (districtId !== '') {
        $("#loaderImg").html("<img style='margin-top: -15px;' src='<?php echo url('/public/assets/images/ajax-loader.gif'); ?>' alt='loading' />");
        $.ajax({
          type: "GET",
          url: "/settings/get-upazila-by-district-id",
          data: {
            districtId: districtId
          },
          success: function success(response) {
            var option = '<option value="">Select One</option>';
            var optionTwo = '<option value="">নির্বাচন করুন</option>';
            if (response.responseCode == 1) {
              $.each(response.data, function (id, value) {
                option += '<option value="' + value.area_id + '">' + value.area_nm + '</option>';
                optionTwo += '<option value="' + value.area_id + '">' + value.area_nm_ban + '</option>';
              });
            }
            $("#upazila").html(option);
            $("#upazilaBN").html(optionTwo);
            self.next().hide();
          }
        });
      } else {
        $("#upazila").html('<option value="">Select District First</option>');
        $("#upazilaBN").html('<option value="">প্রথমে জেলা নির্বাচন করুন</option>');
        $(self).next().hide();
      }
    });
  },
  created: function created() {
    this.getdistrict();
    var app = this;
    axios.get('/settings/home-page/get-homeOffice').then(function (resp) {
      app.homeOffice = resp.data.homeOfficeData;
    })["catch"](function () {
      alert("Could not load your News");
    });
  },
  methods: {
    onFileChange: function onFileChange(event) {
      this.industrialCity.image = event.target.files[0];
    },
    saveForm: function saveForm() {
      var app = this;
      var form = new FormData();
      form.append('image', this.industrialCity.image);
      form.append('name', this.industrialCity.name);
      form.append('office_short_code', this.industrialCity.office_short_code);
      form.append('h_office_id', this.industrialCity.h_office_id);
      form.append('name_en', this.industrialCity.name_en);
      form.append('district', this.industrialCity.district);
      form.append('district_en', this.industrialCity.district_en);
      form.append('upazila_en', this.industrialCity.upazila_en);
      form.append('upazila', this.industrialCity.upazila);
      form.append('details', this.industrialCity.details);
      form.append('details_en', this.industrialCity.details_en);
      form.append('latitude', this.industrialCity.latitude);
      form.append('longitude', this.industrialCity.longitude);
      form.append('order', this.industrialCity.order);
      form.append('status', this.industrialCity.status);
      form.append('type', this.industrialCity.type);
      form.append('establish_year', this.industrialCity.establish_year);
      form.append('land_amount', this.industrialCity.land_amount);
      form.append('per_acre_price', this.industrialCity.per_acre_price);
      form.append('used_plot', this.industrialCity.used_plot);
      form.append('ind_plot_no', this.industrialCity.ind_plot_no);
      form.append('total_plot_allocated', this.industrialCity.total_plot_allocated);
      form.append('ind_unit_total', this.industrialCity.ind_unit_total);
      form.append('ind_unit_under_prod', this.industrialCity.ind_unit_under_prod);
      form.append('ind_unit_under_cons', this.industrialCity.ind_unit_under_cons);
      form.append('ind_unit_off', this.industrialCity.ind_unit_off);
      form.append('ind_unit_allocate_wait', this.industrialCity.ind_unit_allocate_wait);
      axios.defaults.headers.post['Content-Type'] = 'multipart/form-data';
      axios.post('/settings/home-page/store-industrial-city', form).then(function (resp) {
        if (resp.data.status === true) {
          app.$toast.success('Your news crate successfully.');
          app.$router.push({
            path: '/home-page/industrial-city'
          });
        }
      })["catch"](function (error) {
        app.allerros = error.response.data.errors;
      });
    },
    getdistrict: function getdistrict() {
      var _this = this;
      axios.get('/settings/get-district').then(function (respdonse) {
        _this.districtsData = respdonse.data;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/IndustrialCityEdit.vue?vue&type=script&lang=js":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/IndustrialCityEdit.vue?vue&type=script&lang=js ***!
  \*************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _tinymce_tinymce_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @tinymce/tinymce-vue */ "./node_modules/@tinymce/tinymce-vue/lib/es2015/main/ts/index.js");

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      show: true,
      id: null,
      allerros: [],
      industrialCity: {
        office_short_code: '',
        h_office_id: '',
        name_en: '',
        name: '',
        district_en: '',
        district: '',
        upazila_en: '',
        upazila: '',
        details_en: '',
        details: '',
        image: '',
        latitude: '',
        longitude: '',
        order: '',
        status: '',
        type: '',
        establish_year: '',
        land_amount: '',
        per_acre_price: '',
        used_plot: '',
        ind_plot_no: '',
        total_plot_allocated: '',
        ind_unit_total: '',
        ind_unit_under_prod: '',
        ind_unit_under_cons: '',
        ind_unit_off: '',
        ind_unit_allocate_wait: ''
      },
      districtsData: [],
      upazilasData: [],
      homeOffice: [],
      selected: null,
      masterPlanList: {},
      masterPlanForm: {
        mp_name_en: '',
        mp_name_bn: '',
        mp_remarks_en: '',
        mp_remarks_bn: '',
        mp_doc: ''
      },
      masterPlanFormErrors: {},
      limits: 10,
      search: ''
    };
  },
  components: {
    'editor': _tinymce_tinymce_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  mounted: function mounted() {
    $("#district").change(function () {
      $(this).after('<span class="loading_data">Loading...</span>');
      var self = $(this);
      var districtId = $('#district').val();
      if (districtId !== '') {
        $("#loaderImg").html("<img alt='...' style='margin-top: -15px;' src='<?php echo url('/public/assets/images/ajax-loader.gif'); ?>' alt='loading' />");
        $.ajax({
          type: "GET",
          url: "/settings/get-upazila-by-district-id",
          data: {
            districtId: districtId
          },
          success: function success(response) {
            var option = '<option value="">Select One</option>';
            var optionTwo = '<option value="">নির্বাচন করুন</option>';
            if (response.responseCode == 1) {
              $.each(response.data, function (id, value) {
                option += '<option value="' + value.area_id + '">' + value.area_nm + '</option>';
                optionTwo += '<option value="' + value.area_id + '">' + value.area_nm_ban + '</option>';
              });
            }
            $("#upazila").html(option);
            $("#upazilaBN").html(optionTwo);
            self.next().hide();
          }
        });
      } else {
        $("#upazila").html('<option value="">Select District First</option>');
        $("#upazilaBN").html('<option value="">প্রথমে জেলা নির্বাচন করুন</option>');
        $(self).next().hide();
      }
    });
    $(document).ready(function () {
      $("#industrialCity").validate({
        errorPlacement: function errorPlacement() {
          return false;
        }
      });
    });
  },
  created: function created() {
    this.getdistrict();
    this.getUpazila();
    var app = this;
    var id = app.$route.params.id;
    app.id = id;
    axios.get('/settings/home-page/edit-industrial-city/' + id).then(function (resp) {
      app.industrialCity = resp.data.industryData;
      app.homeOffice = resp.data.homeOfficeData;
    })["catch"](function () {
      alert("Could not load your News");
    });
    this.getMasterPlanList();
  },
  methods: {
    onFileChange: function onFileChange(event) {
      this.industrialCity.image = event.target.files[0];
    },
    setMasterPlanDocument: function setMasterPlanDocument(event) {
      this.masterPlanForm.mp_doc = event.target.files[0];
    },
    saveForm: function saveForm() {
      var _this = this;
      var app = this;
      var form = new FormData();
      form.append('image', this.industrialCity.image);
      form.append('name', this.industrialCity.name);
      form.append('office_short_code', this.industrialCity.office_short_code);
      form.append('name_en', this.industrialCity.name_en);
      form.append('district', this.industrialCity.district);
      form.append('district_en', this.industrialCity.district_en);
      form.append('upazila_en', this.industrialCity.upazila_en);
      form.append('upazila', this.industrialCity.upazila);
      form.append('details', this.industrialCity.details);
      form.append('details_en', this.industrialCity.details_en);
      form.append('latitude', this.industrialCity.latitude);
      form.append('longitude', this.industrialCity.longitude);
      form.append('order', this.industrialCity.order);
      form.append('status', this.industrialCity.status);
      form.append('type', this.industrialCity.type);
      form.append('h_office_id', this.industrialCity.h_office_id);
      form.append('id', app.id);
      form.append('establish_year', this.industrialCity.establish_year);
      form.append('land_amount', this.industrialCity.land_amount);
      form.append('per_acre_price', this.industrialCity.per_acre_price);
      form.append('used_plot', this.industrialCity.used_plot);
      form.append('ind_plot_no', this.industrialCity.ind_plot_no);
      form.append('total_plot_allocated', this.industrialCity.total_plot_allocated);
      form.append('ind_unit_total', this.industrialCity.ind_unit_total);
      form.append('ind_unit_under_prod', this.industrialCity.ind_unit_under_prod);
      form.append('ind_unit_under_cons', this.industrialCity.ind_unit_under_cons);
      form.append('ind_unit_off', this.industrialCity.ind_unit_off);
      form.append('ind_unit_allocate_wait', this.industrialCity.ind_unit_allocate_wait);
      axios.defaults.headers.post['Content-Type'] = 'multipart/form-data';
      axios.post('/settings/home-page/update-industrial-city', form).then(function (resp) {
        if (resp.data.status === true) {
          app.$toast.success('Your data update successfully.');
          app.$router.replace('/home-page/industrial-city');
        }
      })["catch"](function (error) {
        _this.allerros = error.response.data.errors;
      });
    },
    createMasterPlan: function createMasterPlan() {
      var app = this;
      var form = new FormData();
      form.append('mp_name_en', app.masterPlanForm.mp_name_en);
      form.append('mp_name_bn', app.masterPlanForm.mp_name_bn);
      form.append('mp_remarks_en', app.masterPlanForm.mp_remarks_en);
      form.append('mp_remarks_bn', app.masterPlanForm.mp_remarks_bn);
      form.append('mp_doc', app.masterPlanForm.mp_doc);
      form.append('city_id', app.id);
      axios.defaults.headers.post['Content-Type'] = 'multipart/form-data';
      axios.post('/settings/home-page/industrial-city/master-plan/create', form).then(function (resp) {
        if (resp.data.status === true) {
          app.$toast.success('New master plan created successfully.');
          $('#createMasterPlanModal').trigger('click');
          app.masterPlanForm.mp_name_en = '';
          app.masterPlanForm.mp_name_bn = '';
          app.masterPlanForm.mp_remarks_en = '';
          app.masterPlanForm.mp_remarks_bn = '';
          app.masterPlanForm.mp_doc = '';
          app.masterPlanFormErrors = {};
          app.getMasterPlanList();
        }
      })["catch"](function (error) {
        app.masterPlanFormErrors = error.response.data.errors;
      });
    },
    getdistrict: function getdistrict() {
      var _this2 = this;
      axios.get('/settings/get-district').then(function (respdonse) {
        _this2.districtsData = respdonse.data;
      });
    },
    getUpazila: function getUpazila() {
      var _this3 = this;
      axios.get('/settings/get-upazila-name').then(function (respdonse) {
        _this3.upazilasData = respdonse.data;
      });
    },
    getMasterPlanList: function getMasterPlanList(page) {
      if (typeof page === 'undefined') {
        page = 1;
      }
      var max_limit = '&limit=' + this.limits;
      var is_search = '';
      if (this.search) {
        is_search = '&search=' + this.search;
      }
      var app = this;
      axios.get('/settings/home-page/industrial-city/master-plan-list/' + this.$route.params.id + '?page=' + page + is_search + max_limit).then(function (response) {
        app.masterPlanList = response.data;
      });
    },
    keymonitor: function keymonitor(e) {
      this.getMasterPlanList(1);
    },
    limit: function limit(e) {
      this.getMasterPlanList(1);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/IndustrialCityList.vue?vue&type=script&lang=js":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/IndustrialCityList.vue?vue&type=script&lang=js ***!
  \*************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      laravelData: {},
      search: '',
      limits: 10,
      page: 1
    };
  },
  mounted: function mounted() {},
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
      axios.get('/settings/home-page/industrial-city?page=' + page + is_search + max_limit).then(function (response) {
        app.laravelData = response.data;
      });
    },
    keymonitor: function keymonitor(e) {
      this.getResults(1);
    },
    limit: function limit(e) {
      this.getResults(1);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/MasterPlanEdit.vue?vue&type=script&lang=js":
/*!*********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/MasterPlanEdit.vue?vue&type=script&lang=js ***!
  \*********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      id: null,
      masterPlanForm: {
        name: '',
        name_en: '',
        remarks: '',
        remarks_en: '',
        document: '',
        status: ''
      },
      masterPlanFormErrors: {}
    };
  },
  components: {},
  mounted: function mounted() {},
  created: function created() {
    var app = this;
    var id = app.$route.params.id;
    app.id = id;
    axios.get('/settings/home-page/industrial-city/master-plan/edit/' + id).then(function (resp) {
      app.masterPlanForm = resp.data.masterPlan;
      app.city_id = resp.data.industrial_city_id;
    })["catch"](function () {
      alert("Could not load your master plan data");
    });
  },
  methods: {
    setMasterPlanDocument: function setMasterPlanDocument(event) {
      this.masterPlanForm.document = event.target.files[0];
    },
    updateMasterPlan: function updateMasterPlan() {
      var app = this;
      var form = new FormData();
      form.append('name', app.masterPlanForm.name);
      form.append('name_en', app.masterPlanForm.name_en);
      form.append('remarks', app.masterPlanForm.remarks);
      form.append('remarks_en', app.masterPlanForm.remarks_en);
      form.append('mp_doc', app.masterPlanForm.document);
      form.append('status', app.masterPlanForm.status);
      form.append('master_plan_id', app.id);
      axios.defaults.headers.post['Content-Type'] = 'multipart/form-data';
      axios.post('/settings/home-page/industrial-city/master-plan/update', form).then(function (resp) {
        if (resp.data.status === true) {
          app.$toast.success('Update master plan created successfully.');
          app.$router.push('/home-page/industrial-city/edit/' + app.city_id);
        }
      })["catch"](function (error) {
        app.masterPlanFormErrors = error.response.data.errors;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/IndustrialCityCreate.vue?vue&type=template&id=e891ec7e":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/IndustrialCityCreate.vue?vue&type=template&id=e891ec7e ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "card"
};
var _hoisted_2 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "card-header bg-primary"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h5", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("strong", null, "New Industrial City")])], -1 /* HOISTED */);
var _hoisted_3 = {
  "class": "card-body"
};
var _hoisted_4 = {
  "class": "col-md-11"
};
var _hoisted_5 = {
  "class": "row form-group"
};
var _hoisted_6 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Type: ", -1 /* HOISTED */);
var _hoisted_7 = {
  "class": "col-md-9"
};
var _hoisted_8 = ["checked"];
var _hoisted_9 = ["checked"];
var _hoisted_10 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_11 = {
  key: 0
};
var _hoisted_12 = {
  key: 1
};
var _hoisted_13 = {
  "class": "row form-group"
};
var _hoisted_14 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Office Short Code:", -1 /* HOISTED */);
var _hoisted_15 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_16 = {
  "class": "row form-group"
};
var _hoisted_17 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Home Office Name:", -1 /* HOISTED */);
var _hoisted_18 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: ""
}, "Select One", -1 /* HOISTED */);
var _hoisted_19 = ["value"];
var _hoisted_20 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_21 = {
  "class": "row form-group"
};
var _hoisted_22 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Name (English):", -1 /* HOISTED */);
var _hoisted_23 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_24 = {
  "class": "row form-group"
};
var _hoisted_25 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Name (বাংলা):", -1 /* HOISTED */);
var _hoisted_26 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_27 = {
  "class": "row form-group"
};
var _hoisted_28 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "District (English):", -1 /* HOISTED */);
var _hoisted_29 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: ""
}, "Select One", -1 /* HOISTED */);
var _hoisted_30 = ["value"];
var _hoisted_31 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_32 = {
  "class": "row form-group"
};
var _hoisted_33 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "District (বাংলা):", -1 /* HOISTED */);
var _hoisted_34 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: ""
}, "নির্বাচন করুন ", -1 /* HOISTED */);
var _hoisted_35 = ["value"];
var _hoisted_36 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_37 = {
  "class": "row form-group"
};
var _hoisted_38 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Upazila (English):", -1 /* HOISTED */);
var _hoisted_39 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: ""
}, "Select District First", -1 /* HOISTED */);
var _hoisted_40 = [_hoisted_39];
var _hoisted_41 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_42 = {
  "class": "row form-group"
};
var _hoisted_43 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Upazila (বাংলা):", -1 /* HOISTED */);
var _hoisted_44 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: ""
}, "প্রথমে জেলা নির্বাচন করুন", -1 /* HOISTED */);
var _hoisted_45 = [_hoisted_44];
var _hoisted_46 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_47 = {
  key: 2
};
var _hoisted_48 = {
  "class": "row form-group"
};
var _hoisted_49 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Details ( English ):", -1 /* HOISTED */);
var _hoisted_50 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_51 = {
  "class": "row form-group"
};
var _hoisted_52 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Details (বাংলা ):", -1 /* HOISTED */);
var _hoisted_53 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_54 = {
  "class": "row form-group"
};
var _hoisted_55 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Image:", -1 /* HOISTED */);
var _hoisted_56 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "help-block"
}, "[File Format: *.jpg/ .jpeg/.png/ .gif/ .svg | Max size 1 MB]", -1 /* HOISTED */);
var _hoisted_57 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_58 = {
  "class": "row form-group"
};
var _hoisted_59 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Latitude:", -1 /* HOISTED */);
var _hoisted_60 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_61 = {
  "class": "row form-group"
};
var _hoisted_62 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Longitude:", -1 /* HOISTED */);
var _hoisted_63 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_64 = {
  "class": "row form-group"
};
var _hoisted_65 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Establishment Year (স্থাপনকাল):", -1 /* HOISTED */);
var _hoisted_66 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_67 = {
  "class": "row form-group"
};
var _hoisted_68 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Land Amount (জমির পরিমাণ (একরে)):", -1 /* HOISTED */);
var _hoisted_69 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_70 = {
  "class": "row form-group"
};
var _hoisted_71 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Per Acre Price (একর প্রতি জমির মূল্য (লক্ষ টাকায়)):", -1 /* HOISTED */);
var _hoisted_72 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_73 = {
  "class": "row form-group"
};
var _hoisted_74 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Plot used for Office & Others (অফিস ও অন্যান্য কাজে ব্যবহৃত প্লট):", -1 /* HOISTED */);
var _hoisted_75 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_76 = {
  "class": "row form-group"
};
var _hoisted_77 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Industrial PLot Number (শিল্প প্লট সংখ্যা):", -1 /* HOISTED */);
var _hoisted_78 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_79 = {
  "class": "row form-group"
};
var _hoisted_80 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Total Allocated PLot (মোট বরাদ্দকৃত প্লট):", -1 /* HOISTED */);
var _hoisted_81 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_82 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "col-md-12",
  style: {
    "margin-bottom": "15px"
  }
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h4", null, "Industrial unit Details (বরাদ্দকৃত প্লটে শিল্প ইউনিটের বিবরণ)")], -1 /* HOISTED */);
var _hoisted_83 = {
  "class": "row form-group"
};
var _hoisted_84 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Total (মোট):", -1 /* HOISTED */);
var _hoisted_85 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_86 = {
  "class": "row form-group"
};
var _hoisted_87 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Under Production (উৎপাদনরত):", -1 /* HOISTED */);
var _hoisted_88 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_89 = {
  "class": "row form-group"
};
var _hoisted_90 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Under Construction/ Not Started Yet (নির্মানাধীন/নির্মাণ কাজ শুরু হয়নি):", -1 /* HOISTED */);
var _hoisted_91 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_92 = {
  "class": "row form-group"
};
var _hoisted_93 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Stopped (বন্ধ):", -1 /* HOISTED */);
var _hoisted_94 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_95 = {
  "class": "row form-group"
};
var _hoisted_96 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Plot Awaiting for Allocation (বরাদ্দের অপেক্ষায় প্লট সংখ্যা (অনুন্নত)):", -1 /* HOISTED */);
var _hoisted_97 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_98 = {
  "class": "row form-group"
};
var _hoisted_99 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Order:", -1 /* HOISTED */);
var _hoisted_100 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_101 = {
  "class": "row form-group"
};
var _hoisted_102 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Status: ", -1 /* HOISTED */);
var _hoisted_103 = {
  "class": "col-md-9"
};
var _hoisted_104 = ["checked"];
var _hoisted_105 = ["checked"];
var _hoisted_106 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_107 = {
  "class": "col-md-12"
};
var _hoisted_108 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-chevron-circle-left"
}, null, -1 /* HOISTED */);
var _hoisted_109 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
  type: "submit",
  "class": "btn btn-primary float-right"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-chevron-circle-right"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Save ")], -1 /* HOISTED */);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_editor = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("editor");
  var _component_router_link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("router-link");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [_hoisted_2, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    onSubmit: _cache[31] || (_cache[31] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.saveForm();
    }, ["prevent"])),
    id: "industrialCity"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [_hoisted_6, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return _ctx.industrialCity.type = $event;
    }),
    name: "is_type",
    type: "radio",
    id: "show",
    onClick: _cache[1] || (_cache[1] = function ($event) {
      return _ctx.show = true;
    }),
    checked: _ctx.industrialCity.type,
    value: "0"
  }, null, 8 /* PROPS */, _hoisted_8), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelRadio, _ctx.industrialCity.type]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Home ")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return _ctx.industrialCity.type = $event;
    }),
    name: "is_type",
    type: "radio",
    id: "hide",
    onClick: _cache[3] || (_cache[3] = function ($event) {
      return _ctx.show = false;
    }),
    checked: _ctx.industrialCity.type,
    value: "1"
  }, null, 8 /* PROPS */, _hoisted_9), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelRadio, _ctx.industrialCity.type]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Office")]), _ctx.allerros.type ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_10, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.type[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]), _ctx.show ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_11)) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_12, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_13, [_hoisted_14, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.office_short_code ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
      return _ctx.industrialCity.office_short_code = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.office_short_code]]), _ctx.allerros.office_short_code ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_15, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.office_short_code[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_16, [_hoisted_17, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.homeOffice ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
      return _ctx.industrialCity.h_office_id = $event;
    }),
    "class": "form-control input-sm",
    id: "homeOffice"
  }, [_hoisted_18, ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(_ctx.homeOffice, function (option) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      key: option.id,
      value: option.id
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(option.name), 9 /* TEXT, PROPS */, _hoisted_19);
  }), 128 /* KEYED_FRAGMENT */))], 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, _ctx.industrialCity.h_office_id]]), _ctx.allerros.homeOffice ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_20, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.homeOffice[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)])])), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_21, [_hoisted_22, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.name_en ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[6] || (_cache[6] = function ($event) {
      return _ctx.industrialCity.name_en = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.name_en]]), _ctx.allerros.name_en ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_23, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.name_en[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_24, [_hoisted_25, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.name ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[7] || (_cache[7] = function ($event) {
      return _ctx.industrialCity.name = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.name]]), _ctx.allerros.name ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_26, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.name[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_27, [_hoisted_28, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.district_en ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "onUpdate:modelValue": _cache[8] || (_cache[8] = function ($event) {
      return _ctx.industrialCity.district_en = $event;
    }),
    "class": "form-control input-sm",
    id: "district"
  }, [_hoisted_29, ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(_ctx.districtsData, function (option) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      key: option.id,
      value: option.area_id
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(option.area_nm), 9 /* TEXT, PROPS */, _hoisted_30);
  }), 128 /* KEYED_FRAGMENT */))], 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, _ctx.industrialCity.district_en]]), _ctx.allerros.district_en ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_31, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.district_en[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_32, [_hoisted_33, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.district ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "onUpdate:modelValue": _cache[9] || (_cache[9] = function ($event) {
      return _ctx.industrialCity.district = $event;
    }),
    "class": "form-control input-sm"
  }, [_hoisted_34, ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(_ctx.districtsData, function (option) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      key: option.id,
      value: option.area_id
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(option.area_nm_ban), 9 /* TEXT, PROPS */, _hoisted_35);
  }), 128 /* KEYED_FRAGMENT */))], 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, _ctx.industrialCity.district]]), _ctx.allerros.district ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_36, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.district[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_37, [_hoisted_38, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.upazila_en ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "onUpdate:modelValue": _cache[10] || (_cache[10] = function ($event) {
      return _ctx.industrialCity.upazila_en = $event;
    }),
    "class": "form-control input-sm",
    id: "upazila"
  }, _hoisted_40, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, _ctx.industrialCity.upazila_en]]), _ctx.allerros.upazila_en ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_41, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.upazila_en[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_42, [_hoisted_43, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.upazila ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "onUpdate:modelValue": _cache[11] || (_cache[11] = function ($event) {
      return _ctx.industrialCity.upazila = $event;
    }),
    "class": "form-control input-sm",
    id: "upazilaBN"
  }, _hoisted_45, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, _ctx.industrialCity.upazila]]), _ctx.allerros.upazila ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_46, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.upazila[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), _ctx.show ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_47, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_48, [_hoisted_49, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.details_en ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_editor, {
    modelValue: _ctx.industrialCity.details_en,
    "onUpdate:modelValue": _cache[12] || (_cache[12] = function ($event) {
      return _ctx.industrialCity.details_en = $event;
    }),
    "api-key": "5tyznzq0zx85ayto1vep7l7jy3d4hsyf8mxev8jwuq5zqqwk",
    init: {
      height: 300,
      menubar: true,
      plugins: ['advlist autolink lists link image charmap print preview anchor', 'searchreplace visualblocks code fullscreen', 'insertdatetime media table paste code help wordcount'],
      toolbar: 'undo redo | formatselect | bold italic backcolor | \
                                           alignleft aligncenter alignright alignjustify | \
                                           bullist numlist outdent indent | removeformat | help'
    }
  }, null, 8 /* PROPS */, ["modelValue"]), _ctx.allerros.details_en ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_50, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.details_en[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_51, [_hoisted_52, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.details ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_editor, {
    modelValue: _ctx.industrialCity.details,
    "onUpdate:modelValue": _cache[13] || (_cache[13] = function ($event) {
      return _ctx.industrialCity.details = $event;
    }),
    "api-key": "5tyznzq0zx85ayto1vep7l7jy3d4hsyf8mxev8jwuq5zqqwk",
    init: {
      height: 300,
      menubar: true,
      plugins: ['advlist autolink lists link image charmap print preview anchor', 'searchreplace visualblocks code fullscreen', 'insertdatetime media table paste code help wordcount'],
      toolbar: 'undo redo | formatselect | bold italic backcolor | \
                                           alignleft aligncenter alignright alignjustify | \
                                           bullist numlist outdent indent | removeformat | help'
    }
  }, null, 8 /* PROPS */, ["modelValue"]), _ctx.allerros.details ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_53, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.details[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_54, [_hoisted_55, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.files ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "file",
    id: "files",
    ref: "files",
    "class": "form-control",
    onChange: _cache[14] || (_cache[14] = function () {
      return $options.onFileChange && $options.onFileChange.apply($options, arguments);
    })
  }, null, 544 /* HYDRATE_EVENTS, NEED_PATCH */), _hoisted_56, _ctx.allerros.image ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_57, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.image[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_58, [_hoisted_59, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.latitude ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[15] || (_cache[15] = function ($event) {
      return _ctx.industrialCity.latitude = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.latitude]]), _ctx.allerros.latitude ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_60, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.latitude[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_61, [_hoisted_62, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.longitude ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[16] || (_cache[16] = function ($event) {
      return _ctx.industrialCity.longitude = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.longitude]]), _ctx.allerros.longitude ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_63, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.longitude[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_64, [_hoisted_65, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.establish_year ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[17] || (_cache[17] = function ($event) {
      return _ctx.industrialCity.establish_year = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.establish_year]]), _ctx.allerros.establish_year ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_66, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.establish_year[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_67, [_hoisted_68, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.land_amount ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[18] || (_cache[18] = function ($event) {
      return _ctx.industrialCity.land_amount = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.land_amount]]), _ctx.allerros.land_amount ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_69, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.land_amount[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_70, [_hoisted_71, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.per_acre_price ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[19] || (_cache[19] = function ($event) {
      return _ctx.industrialCity.per_acre_price = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.per_acre_price]]), _ctx.allerros.per_acre_price ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_72, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.per_acre_price[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_73, [_hoisted_74, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.used_plot ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[20] || (_cache[20] = function ($event) {
      return _ctx.industrialCity.used_plot = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.used_plot]]), _ctx.allerros.used_plot ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_75, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.used_plot[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_76, [_hoisted_77, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.ind_plot_no ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[21] || (_cache[21] = function ($event) {
      return _ctx.industrialCity.ind_plot_no = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.ind_plot_no]]), _ctx.allerros.ind_plot_no ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_78, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.ind_plot_no[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_79, [_hoisted_80, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.total_plot_allocated ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[22] || (_cache[22] = function ($event) {
      return _ctx.industrialCity.total_plot_allocated = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.total_plot_allocated]]), _ctx.allerros.total_plot_allocated ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_81, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.total_plot_allocated[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), _hoisted_82, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_83, [_hoisted_84, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.ind_unit_total ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[23] || (_cache[23] = function ($event) {
      return _ctx.industrialCity.ind_unit_total = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.ind_unit_total]]), _ctx.allerros.ind_unit_total ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_85, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.ind_unit_total[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_86, [_hoisted_87, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.ind_unit_under_prod ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[24] || (_cache[24] = function ($event) {
      return _ctx.industrialCity.ind_unit_under_prod = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.ind_unit_under_prod]]), _ctx.allerros.ind_unit_under_prod ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_88, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.ind_unit_under_prod[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_89, [_hoisted_90, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.ind_unit_under_cons ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[25] || (_cache[25] = function ($event) {
      return _ctx.industrialCity.ind_unit_under_cons = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.ind_unit_under_cons]]), _ctx.allerros.ind_unit_under_cons ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_91, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.ind_unit_under_cons[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_92, [_hoisted_93, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.ind_unit_off ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[26] || (_cache[26] = function ($event) {
      return _ctx.industrialCity.ind_unit_off = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.ind_unit_off]]), _ctx.allerros.ind_unit_off ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_94, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.ind_unit_off[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_95, [_hoisted_96, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.ind_unit_allocate_wait ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[27] || (_cache[27] = function ($event) {
      return _ctx.industrialCity.ind_unit_allocate_wait = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.ind_unit_allocate_wait]]), _ctx.allerros.ind_unit_allocate_wait ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_97, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.ind_unit_allocate_wait[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_98, [_hoisted_99, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.order ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "number",
    "onUpdate:modelValue": _cache[28] || (_cache[28] = function ($event) {
      return _ctx.industrialCity.order = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.order]]), _ctx.allerros.order ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_100, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.order[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_101, [_hoisted_102, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_103, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[29] || (_cache[29] = function ($event) {
      return _ctx.industrialCity.status = $event;
    }),
    name: "is_active",
    type: "radio",
    checked: _ctx.industrialCity.status,
    value: "1"
  }, null, 8 /* PROPS */, _hoisted_104), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelRadio, _ctx.industrialCity.status]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Active ")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[30] || (_cache[30] = function ($event) {
      return _ctx.industrialCity.status = $event;
    }),
    name: "is_active",
    type: "radio",
    checked: _ctx.industrialCity.status,
    value: "0"
  }, null, 8 /* PROPS */, _hoisted_105), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelRadio, _ctx.industrialCity.status]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Inactive")]), _ctx.allerros.status ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_106, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.status[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_107, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    to: "/home-page/industrial-city",
    "class": "btn btn-default"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_108, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Back ")];
    }),
    _: 1 /* STABLE */
  }), _hoisted_109])])])], 32 /* HYDRATE_EVENTS */)])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/IndustrialCityEdit.vue?vue&type=template&id=fc4e71e2":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/IndustrialCityEdit.vue?vue&type=template&id=fc4e71e2 ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************/
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
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("strong", null, "Edit Industrial City")])], -1 /* HOISTED */);
var _hoisted_3 = {
  "class": "card-body"
};
var _hoisted_4 = {
  "class": "col-md-11"
};
var _hoisted_5 = {
  "class": "row form-group"
};
var _hoisted_6 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Type: ", -1 /* HOISTED */);
var _hoisted_7 = {
  "class": "col-md-9"
};
var _hoisted_8 = ["checked"];
var _hoisted_9 = ["checked"];
var _hoisted_10 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_11 = {
  key: 0
};
var _hoisted_12 = {
  key: 1
};
var _hoisted_13 = {
  "class": "row form-group"
};
var _hoisted_14 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Office Short Code:", -1 /* HOISTED */);
var _hoisted_15 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_16 = {
  "class": "row form-group"
};
var _hoisted_17 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Home Office Name:", -1 /* HOISTED */);
var _hoisted_18 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: ""
}, "Select One", -1 /* HOISTED */);
var _hoisted_19 = ["value"];
var _hoisted_20 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_21 = {
  "class": "row form-group"
};
var _hoisted_22 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Name (English):", -1 /* HOISTED */);
var _hoisted_23 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_24 = {
  "class": "row form-group"
};
var _hoisted_25 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Name (বাংলা):", -1 /* HOISTED */);
var _hoisted_26 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_27 = {
  "class": "row form-group"
};
var _hoisted_28 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "District (English):", -1 /* HOISTED */);
var _hoisted_29 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: ""
}, "Select One", -1 /* HOISTED */);
var _hoisted_30 = ["value"];
var _hoisted_31 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_32 = {
  "class": "row form-group"
};
var _hoisted_33 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "District (বাংলা):", -1 /* HOISTED */);
var _hoisted_34 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: ""
}, "নির্বাচন করুন ", -1 /* HOISTED */);
var _hoisted_35 = ["value"];
var _hoisted_36 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_37 = {
  "class": "row form-group"
};
var _hoisted_38 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Upazila (English):", -1 /* HOISTED */);
var _hoisted_39 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: ""
}, "Select District First", -1 /* HOISTED */);
var _hoisted_40 = ["value"];
var _hoisted_41 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_42 = {
  "class": "row form-group"
};
var _hoisted_43 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Upazila (বাংলা):", -1 /* HOISTED */);
var _hoisted_44 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: ""
}, "প্রথমে জেলা নির্বাচন করুন", -1 /* HOISTED */);
var _hoisted_45 = ["value"];
var _hoisted_46 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_47 = {
  key: 2
};
var _hoisted_48 = {
  "class": "row form-group"
};
var _hoisted_49 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Details ( English ):", -1 /* HOISTED */);
var _hoisted_50 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_51 = {
  "class": "row form-group"
};
var _hoisted_52 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Details (বাংলা ):", -1 /* HOISTED */);
var _hoisted_53 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_54 = {
  "class": "row form-group"
};
var _hoisted_55 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Image:", -1 /* HOISTED */);
var _hoisted_56 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "help-block"
}, "[File Format: *.jpg/ .jpeg/.png/ .gif/ .svg | Max size 1 MB]", -1 /* HOISTED */);
var _hoisted_57 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_58 = {
  key: 0,
  "class": "col-md-2"
};
var _hoisted_59 = ["href"];
var _hoisted_60 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-file-image-o"
}, null, -1 /* HOISTED */);
var _hoisted_61 = {
  key: 1,
  "class": "col-md-2"
};
var _hoisted_62 = {
  "class": "row form-group"
};
var _hoisted_63 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Latitude:", -1 /* HOISTED */);
var _hoisted_64 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_65 = {
  "class": "row form-group"
};
var _hoisted_66 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Longitude:", -1 /* HOISTED */);
var _hoisted_67 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_68 = {
  "class": "row form-group"
};
var _hoisted_69 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Establishment Year (স্থাপনকাল):", -1 /* HOISTED */);
var _hoisted_70 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_71 = {
  "class": "row form-group"
};
var _hoisted_72 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Land Amount (জমির পরিমাণ (একরে)):", -1 /* HOISTED */);
var _hoisted_73 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_74 = {
  "class": "row form-group"
};
var _hoisted_75 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Per Acre Price (একর প্রতি জমির মূল্য (লক্ষ টাকায়)):", -1 /* HOISTED */);
var _hoisted_76 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_77 = {
  "class": "row form-group"
};
var _hoisted_78 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Plot used for Office & Others (অফিস ও অন্যান্য কাজে ব্যবহৃত প্লট):", -1 /* HOISTED */);
var _hoisted_79 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_80 = {
  "class": "row form-group"
};
var _hoisted_81 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Industrial PLot Number (শিল্প প্লট সংখ্যা):", -1 /* HOISTED */);
var _hoisted_82 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_83 = {
  "class": "row form-group"
};
var _hoisted_84 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Total Allocated PLot (মোট বরাদ্দকৃত প্লট):", -1 /* HOISTED */);
var _hoisted_85 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_86 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "col-md-12",
  style: {
    "margin-bottom": "15px"
  }
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "col-md-12"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h4", null, "Industrial unit Details (বরাদ্দকৃত প্লটে শিল্প ইউনিটের বিবরণ)")])], -1 /* HOISTED */);
var _hoisted_87 = {
  "class": "row form-group"
};
var _hoisted_88 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Total (মোট):", -1 /* HOISTED */);
var _hoisted_89 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_90 = {
  "class": "row form-group"
};
var _hoisted_91 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Under Production (উৎপাদনরত):", -1 /* HOISTED */);
var _hoisted_92 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_93 = {
  "class": "row form-group"
};
var _hoisted_94 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Under Construction/ Not Started Yet (নির্মানাধীন/নির্মাণ কাজ শুরু হয়নি):", -1 /* HOISTED */);
var _hoisted_95 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_96 = {
  "class": "row form-group"
};
var _hoisted_97 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Stopped (বন্ধ):", -1 /* HOISTED */);
var _hoisted_98 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_99 = {
  "class": "row form-group"
};
var _hoisted_100 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Plot Awaiting for Allocation (বরাদ্দের অপেক্ষায় প্লট সংখ্যা (অনুন্নত)):", -1 /* HOISTED */);
var _hoisted_101 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_102 = {
  "class": "row form-group"
};
var _hoisted_103 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Order:", -1 /* HOISTED */);
var _hoisted_104 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_105 = {
  "class": "row form-group"
};
var _hoisted_106 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Status: ", -1 /* HOISTED */);
var _hoisted_107 = {
  "class": "col-md-9"
};
var _hoisted_108 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_109 = {
  "class": "col-md-12"
};
var _hoisted_110 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-chevron-circle-left"
}, null, -1 /* HOISTED */);
var _hoisted_111 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
  type: "submit",
  "class": "btn btn-primary float-right"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-chevron-circle-right"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Save ")], -1 /* HOISTED */);
var _hoisted_112 = {
  "class": "card card-magenta border border-magenta"
};
var _hoisted_113 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createStaticVNode)("<div class=\"card-header\"><div class=\"float-left\"><h5 class=\"card-title pt-2 pb-2\"><i class=\"fa fa-list\"></i> List of Master Plan</h5></div><div class=\"float-right\"><button type=\"button\" class=\"btn btn-sm btn-success\" data-toggle=\"modal\" data-target=\"#createMasterPlanModal\"><i class=\"fa fa-plus\"></i> Add New Master Plan </button></div><!-- /.box-tools --></div>", 1);
var _hoisted_114 = {
  "class": "card-body"
};
var _hoisted_115 = {
  "class": "col-md-1 float-left"
};
var _hoisted_116 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "10"
}, "10", -1 /* HOISTED */);
var _hoisted_117 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "25"
}, "25", -1 /* HOISTED */);
var _hoisted_118 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "50"
}, "50", -1 /* HOISTED */);
var _hoisted_119 = [_hoisted_116, _hoisted_117, _hoisted_118];
var _hoisted_120 = {
  "class": "col-md-offset-8 col-md-3 float-right"
};
var _hoisted_121 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* HOISTED */);
var _hoisted_122 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* HOISTED */);
var _hoisted_123 = {
  "class": "col-md-12"
};
var _hoisted_124 = {
  "class": "table-responsive"
};
var _hoisted_125 = {
  "class": "table vue-table table-striped table-bordered"
};
var _hoisted_126 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("thead", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "#SL"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Name"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Remarks"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Document"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Status"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Action")])], -1 /* HOISTED */);
var _hoisted_127 = ["href"];
var _hoisted_128 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-file-image-o"
}, null, -1 /* HOISTED */);
var _hoisted_129 = {
  key: 0
};
var _hoisted_130 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "text-success"
}, "Active ", -1 /* HOISTED */);
var _hoisted_131 = [_hoisted_130];
var _hoisted_132 = {
  key: 1
};
var _hoisted_133 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "text-danger"
}, "Inactive", -1 /* HOISTED */);
var _hoisted_134 = [_hoisted_133];
var _hoisted_135 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-edit"
}, null, -1 /* HOISTED */);
var _hoisted_136 = {
  "class": "modal fade",
  tabindex: "-1",
  role: "dialog",
  id: "createMasterPlanModal",
  "aria-labelledby": "createMasterPlanModal"
};
var _hoisted_137 = {
  "class": "modal-dialog modal-md",
  role: "document"
};
var _hoisted_138 = {
  "class": "modal-content"
};
var _hoisted_139 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "modal-header"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h4", {
  "class": "modal-title",
  id: "gridSystemModalLabel"
}, "Create master plan"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
  type: "button",
  "class": "close",
  "data-dismiss": "modal",
  "aria-label": "Close"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "aria-hidden": "true",
  style: {
    "font-size": "22px"
  }
}, "×")])], -1 /* HOISTED */);
var _hoisted_140 = {
  "class": "modal-body"
};
var _hoisted_141 = {
  "class": "row form-group"
};
var _hoisted_142 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Name (English):", -1 /* HOISTED */);
var _hoisted_143 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_144 = {
  "class": "row form-group"
};
var _hoisted_145 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Name (বাংলা):", -1 /* HOISTED */);
var _hoisted_146 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_147 = {
  "class": "row form-group"
};
var _hoisted_148 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Remarks (English):", -1 /* HOISTED */);
var _hoisted_149 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_150 = {
  "class": "row form-group"
};
var _hoisted_151 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Remarks (বাংলা):", -1 /* HOISTED */);
var _hoisted_152 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_153 = {
  "class": "row form-group"
};
var _hoisted_154 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Document:", -1 /* HOISTED */);
var _hoisted_155 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "help-block"
}, "[File Format: *.jpg/ .jpeg/ .png/ .gif/ .pdf | Max size 2 MB]", -1 /* HOISTED */);
var _hoisted_156 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_157 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "modal-footer"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "col-md-12"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
  type: "submit",
  "class": "btn btn-primary float-right mr-1"
}, "Create Master Plan"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("   "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
  type: "button",
  "class": "btn btn-default float-right mr-1",
  "data-dismiss": "modal"
}, "Close"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("   ")])], -1 /* HOISTED */);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_editor = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("editor");
  var _component_router_link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("router-link");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [_hoisted_2, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    onSubmit: _cache[31] || (_cache[31] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.saveForm();
    }, ["prevent"])),
    id: "industrialCity"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [_hoisted_6, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return _ctx.industrialCity.type = $event;
    }),
    name: "is_type",
    type: "radio",
    id: "show",
    onClick: _cache[1] || (_cache[1] = function ($event) {
      return _ctx.show = true;
    }),
    checked: _ctx.industrialCity.type,
    value: "0"
  }, null, 8 /* PROPS */, _hoisted_8), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelRadio, _ctx.industrialCity.type]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Home ")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return _ctx.industrialCity.type = $event;
    }),
    name: "is_type",
    type: "radio",
    id: "hide",
    onClick: _cache[3] || (_cache[3] = function ($event) {
      return _ctx.show = false;
    }),
    checked: _ctx.industrialCity.type,
    value: "1"
  }, null, 8 /* PROPS */, _hoisted_9), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelRadio, _ctx.industrialCity.type]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Office")]), _ctx.allerros.type ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_10, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.type[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]), _ctx.show && _ctx.industrialCity.type == '0' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_11)) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_12, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_13, [_hoisted_14, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.office_short_code ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
      return _ctx.industrialCity.office_short_code = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.office_short_code]]), _ctx.allerros.office_short_code ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_15, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.office_short_code[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_16, [_hoisted_17, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.homeOffice ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
      return _ctx.industrialCity.h_office_id = $event;
    }),
    "class": "form-control input-sm",
    id: "homeOffice"
  }, [_hoisted_18, ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(_ctx.homeOffice, function (option) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      key: option.id,
      value: option.id
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(option.name), 9 /* TEXT, PROPS */, _hoisted_19);
  }), 128 /* KEYED_FRAGMENT */))], 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, _ctx.industrialCity.h_office_id]]), _ctx.allerros.homeOffice ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_20, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.homeOffice[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)])])), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_21, [_hoisted_22, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.name_en ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[6] || (_cache[6] = function ($event) {
      return _ctx.industrialCity.name_en = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.name_en]]), _ctx.allerros.name_en ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_23, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.name_en[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_24, [_hoisted_25, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.name ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[7] || (_cache[7] = function ($event) {
      return _ctx.industrialCity.name = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.name]]), _ctx.allerros.name ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_26, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.name[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_27, [_hoisted_28, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.district_en ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "onUpdate:modelValue": _cache[8] || (_cache[8] = function ($event) {
      return _ctx.industrialCity.district_en = $event;
    }),
    "class": "form-control input-sm",
    id: "district"
  }, [_hoisted_29, ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(_ctx.districtsData, function (option) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      key: option.id,
      value: option.area_id
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(option.area_nm), 9 /* TEXT, PROPS */, _hoisted_30);
  }), 128 /* KEYED_FRAGMENT */))], 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, _ctx.industrialCity.district_en]]), _ctx.allerros.district_en ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_31, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.district_en[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_32, [_hoisted_33, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.district ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "onUpdate:modelValue": _cache[9] || (_cache[9] = function ($event) {
      return _ctx.industrialCity.district = $event;
    }),
    "class": "form-control input-sm"
  }, [_hoisted_34, ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(_ctx.districtsData, function (option) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      key: option.id,
      value: option.area_id
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(option.area_nm_ban), 9 /* TEXT, PROPS */, _hoisted_35);
  }), 128 /* KEYED_FRAGMENT */))], 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, _ctx.industrialCity.district]]), _ctx.allerros.district ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_36, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.district[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_37, [_hoisted_38, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.upazila_en ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "onUpdate:modelValue": _cache[10] || (_cache[10] = function ($event) {
      return _ctx.industrialCity.upazila_en = $event;
    }),
    "class": "form-control input-sm",
    id: "upazila"
  }, [_hoisted_39, ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(_ctx.upazilasData, function (option) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      key: option.id,
      value: option.area_id
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(option.area_nm), 9 /* TEXT, PROPS */, _hoisted_40);
  }), 128 /* KEYED_FRAGMENT */))], 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, _ctx.industrialCity.upazila_en]]), _ctx.allerros.upazila_en ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_41, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.upazila_en[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_42, [_hoisted_43, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.upazila ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "onUpdate:modelValue": _cache[11] || (_cache[11] = function ($event) {
      return _ctx.industrialCity.upazila = $event;
    }),
    "class": "form-control input-sm",
    id: "upazilaBN"
  }, [_hoisted_44, ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(_ctx.upazilasData, function (option) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      key: option.id,
      value: option.area_id
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(option.area_nm_ban), 9 /* TEXT, PROPS */, _hoisted_45);
  }), 128 /* KEYED_FRAGMENT */))], 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, _ctx.industrialCity.upazila]]), _ctx.allerros.upazila ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_46, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.upazila[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), _ctx.show && _ctx.industrialCity.type == '0' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_47, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_48, [_hoisted_49, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.details_en ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_editor, {
    modelValue: _ctx.industrialCity.details_en,
    "onUpdate:modelValue": _cache[12] || (_cache[12] = function ($event) {
      return _ctx.industrialCity.details_en = $event;
    }),
    "api-key": "5tyznzq0zx85ayto1vep7l7jy3d4hsyf8mxev8jwuq5zqqwk",
    init: {
      height: 300,
      menubar: true,
      plugins: ['advlist autolink lists link image charmap print preview anchor', 'searchreplace visualblocks code fullscreen', 'insertdatetime media table paste code help wordcount'],
      toolbar: 'undo redo | formatselect | bold italic backcolor | \
                                           alignleft aligncenter alignright alignjustify | \
                                           bullist numlist outdent indent | removeformat | help'
    }
  }, null, 8 /* PROPS */, ["modelValue"]), _ctx.allerros.details_en ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_50, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.details_en[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_51, [_hoisted_52, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.details ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_editor, {
    modelValue: _ctx.industrialCity.details,
    "onUpdate:modelValue": _cache[13] || (_cache[13] = function ($event) {
      return _ctx.industrialCity.details = $event;
    }),
    "api-key": "5tyznzq0zx85ayto1vep7l7jy3d4hsyf8mxev8jwuq5zqqwk",
    init: {
      height: 300,
      menubar: true,
      plugins: ['advlist autolink lists link image charmap print preview anchor', 'searchreplace visualblocks code fullscreen', 'insertdatetime media table paste code help wordcount'],
      toolbar: 'undo redo | formatselect | bold italic backcolor | \
                                           alignleft aligncenter alignright alignjustify | \
                                           bullist numlist outdent indent | removeformat | help'
    }
  }, null, 8 /* PROPS */, ["modelValue"]), _ctx.allerros.details ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_53, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.details[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_54, [_hoisted_55, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-7', _ctx.allerros.files ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "file",
    id: "files",
    ref: "files",
    "class": "form-control",
    onChange: _cache[14] || (_cache[14] = function () {
      return $options.onFileChange && $options.onFileChange.apply($options, arguments);
    })
  }, null, 544 /* HYDRATE_EVENTS, NEED_PATCH */), _hoisted_56, _ctx.allerros.image ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_57, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.image[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */), _ctx.industrialCity.image !== '' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_58, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
    "class": "btn btn-info",
    target: "_blank",
    href: '/' + _ctx.industrialCity.image
  }, [_hoisted_60, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" View Photo")], 8 /* PROPS */, _hoisted_59)])) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_61))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_62, [_hoisted_63, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.latitude ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[15] || (_cache[15] = function ($event) {
      return _ctx.industrialCity.latitude = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.latitude]]), _ctx.allerros.latitude ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_64, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.latitude[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_65, [_hoisted_66, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.longitude ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[16] || (_cache[16] = function ($event) {
      return _ctx.industrialCity.longitude = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.longitude]]), _ctx.allerros.longitude ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_67, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.longitude[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_68, [_hoisted_69, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.establish_year ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[17] || (_cache[17] = function ($event) {
      return _ctx.industrialCity.establish_year = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.establish_year]]), _ctx.allerros.establish_year ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_70, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.establish_year[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_71, [_hoisted_72, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.land_amount ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[18] || (_cache[18] = function ($event) {
      return _ctx.industrialCity.land_amount = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.land_amount]]), _ctx.allerros.land_amount ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_73, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.land_amount[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_74, [_hoisted_75, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.per_acre_price ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[19] || (_cache[19] = function ($event) {
      return _ctx.industrialCity.per_acre_price = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.per_acre_price]]), _ctx.allerros.per_acre_price ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_76, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.per_acre_price[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_77, [_hoisted_78, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.used_plot ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[20] || (_cache[20] = function ($event) {
      return _ctx.industrialCity.used_plot = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.used_plot]]), _ctx.allerros.used_plot ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_79, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.used_plot[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_80, [_hoisted_81, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.ind_plot_no ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[21] || (_cache[21] = function ($event) {
      return _ctx.industrialCity.ind_plot_no = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.ind_plot_no]]), _ctx.allerros.ind_plot_no ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_82, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.ind_plot_no[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_83, [_hoisted_84, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.total_plot_allocated ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[22] || (_cache[22] = function ($event) {
      return _ctx.industrialCity.total_plot_allocated = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.total_plot_allocated]]), _ctx.allerros.total_plot_allocated ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_85, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.total_plot_allocated[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), _hoisted_86, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_87, [_hoisted_88, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.ind_unit_total ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[23] || (_cache[23] = function ($event) {
      return _ctx.industrialCity.ind_unit_total = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.ind_unit_total]]), _ctx.allerros.ind_unit_total ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_89, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.ind_unit_total[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_90, [_hoisted_91, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.ind_unit_under_prod ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[24] || (_cache[24] = function ($event) {
      return _ctx.industrialCity.ind_unit_under_prod = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.ind_unit_under_prod]]), _ctx.allerros.ind_unit_under_prod ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_92, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.ind_unit_under_prod[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_93, [_hoisted_94, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.ind_unit_under_cons ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[25] || (_cache[25] = function ($event) {
      return _ctx.industrialCity.ind_unit_under_cons = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.ind_unit_under_cons]]), _ctx.allerros.ind_unit_under_cons ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_95, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.ind_unit_under_cons[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_96, [_hoisted_97, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.ind_unit_off ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[26] || (_cache[26] = function ($event) {
      return _ctx.industrialCity.ind_unit_off = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.ind_unit_off]]), _ctx.allerros.ind_unit_off ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_98, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.ind_unit_off[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_99, [_hoisted_100, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.ind_unit_allocate_wait ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[27] || (_cache[27] = function ($event) {
      return _ctx.industrialCity.ind_unit_allocate_wait = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.ind_unit_allocate_wait]]), _ctx.allerros.ind_unit_allocate_wait ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_101, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.ind_unit_allocate_wait[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_102, [_hoisted_103, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.allerros.order ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "number",
    "onUpdate:modelValue": _cache[28] || (_cache[28] = function ($event) {
      return _ctx.industrialCity.order = $event;
    }),
    "class": "form-control",
    size: "10x5",
    min: "0"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.industrialCity.order]]), _ctx.allerros.order ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_104, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.order[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_105, [_hoisted_106, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_107, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[29] || (_cache[29] = function ($event) {
      return _ctx.industrialCity.status = $event;
    }),
    name: "is_active",
    type: "radio",
    value: "1"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelRadio, _ctx.industrialCity.status]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Active ")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[30] || (_cache[30] = function ($event) {
      return _ctx.industrialCity.status = $event;
    }),
    name: "is_active",
    type: "radio",
    value: "0"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelRadio, _ctx.industrialCity.status]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Inactive")]), _ctx.allerros.status ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_108, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.status[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_109, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    to: "/home-page/industrial-city",
    "class": "btn btn-default"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_110, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Back ")];
    }),
    _: 1 /* STABLE */
  }), _hoisted_111])])])], 32 /* HYDRATE_EVENTS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_112, [_hoisted_113, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_114, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_115, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "class": "form-control col-md-12",
    "onUpdate:modelValue": _cache[32] || (_cache[32] = function ($event) {
      return _ctx.limits = $event;
    }),
    onChange: _cache[33] || (_cache[33] = function ($event) {
      return $options.limit($event);
    })
  }, _hoisted_119, 544 /* HYDRATE_EVENTS, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, _ctx.limits]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_120, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "class": "form-control",
    type: "text",
    placeholder: "Search...",
    "onUpdate:modelValue": _cache[34] || (_cache[34] = function ($event) {
      return _ctx.search = $event;
    }),
    onKeyup: _cache[35] || (_cache[35] = function () {
      return $options.keymonitor && $options.keymonitor.apply($options, arguments);
    })
  }, null, 544 /* HYDRATE_EVENTS, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.search]])]), _hoisted_121, _hoisted_122, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_123, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_124, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_125, [_hoisted_126, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tbody", null, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(_ctx.masterPlanList.data, function (industrial) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", {
      key: industrial.id
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(industrial.si), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(industrial.name), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(industrial.remarks), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, [industrial.document ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("a", {
      key: 0,
      "class": "btn btn-info btn-xs",
      target: "_blank",
      href: '/' + industrial.document
    }, [_hoisted_128, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Open document")], 8 /* PROPS */, _hoisted_127)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, [industrial.status == 1 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_129, _hoisted_131)) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_132, _hoisted_134))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
      to: {
        name: 'MasterPlanEdit',
        params: {
          id: industrial.id
        }
      },
      "class": "btn btn-xs btn-primary"
    }, {
      "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
        return [_hoisted_135, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Edit ")];
      }),
      _: 2 /* DYNAMIC */
    }, 1032 /* PROPS, DYNAMIC_SLOTS */, ["to"])])]);
  }), 128 /* KEYED_FRAGMENT */))])])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_136, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_137, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_138, [_hoisted_139, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    onSubmit: _cache[41] || (_cache[41] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.createMasterPlan();
    }, ["prevent"])),
    id: "masterPlanForm"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_140, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_141, [_hoisted_142, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.masterPlanFormErrors.mp_name_en ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[36] || (_cache[36] = function ($event) {
      return _ctx.masterPlanForm.mp_name_en = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.masterPlanForm.mp_name_en]]), _ctx.masterPlanFormErrors.mp_name_en ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_143, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.masterPlanFormErrors.mp_name_en[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_144, [_hoisted_145, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.masterPlanFormErrors.mp_name_bn ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[37] || (_cache[37] = function ($event) {
      return _ctx.masterPlanForm.mp_name_bn = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.masterPlanForm.mp_name_bn]]), _ctx.masterPlanFormErrors.mp_name_bn ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_146, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.masterPlanFormErrors.mp_name_bn[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_147, [_hoisted_148, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.masterPlanFormErrors.mp_remarks_en ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("textarea", {
    "onUpdate:modelValue": _cache[38] || (_cache[38] = function ($event) {
      return _ctx.masterPlanForm.mp_remarks_en = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.masterPlanForm.mp_remarks_en]]), _ctx.masterPlanFormErrors.mp_remarks_en ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_149, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.masterPlanFormErrors.mp_remarks_en[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_150, [_hoisted_151, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.masterPlanFormErrors.mp_remarks_bn ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("textarea", {
    "onUpdate:modelValue": _cache[39] || (_cache[39] = function ($event) {
      return _ctx.masterPlanForm.mp_remarks_bn = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.masterPlanForm.mp_remarks_bn]]), _ctx.masterPlanFormErrors.mp_remarks_bn ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_152, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.masterPlanFormErrors.mp_remarks_bn[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_153, [_hoisted_154, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.masterPlanFormErrors.mp_doc ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "file",
    id: "mp_doc",
    "class": "form-control",
    onChange: _cache[40] || (_cache[40] = function () {
      return $options.setMasterPlanDocument && $options.setMasterPlanDocument.apply($options, arguments);
    })
  }, null, 32 /* HYDRATE_EVENTS */), _hoisted_155, _ctx.masterPlanFormErrors.mp_doc ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_156, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.masterPlanFormErrors.mp_doc[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)])]), _hoisted_157], 32 /* HYDRATE_EVENTS */)])])])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/IndustrialCityList.vue?vue&type=template&id=72909fa3":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/IndustrialCityList.vue?vue&type=template&id=72909fa3 ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************/
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
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h5", {
  "class": "box-title"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-list"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" List of Industrial City")])], -1 /* HOISTED */);
var _hoisted_4 = {
  "class": "float-right"
};
var _hoisted_5 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-plus"
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
  "class": "table-responsive"
};
var _hoisted_17 = {
  "class": "table vue-table table-striped table-bordered"
};
var _hoisted_18 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("thead", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "SL"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Name"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "District"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Upazila"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Type"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Status"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Action")])], -1 /* HOISTED */);
var _hoisted_19 = {
  key: 0
};
var _hoisted_20 = {
  key: 1
};
var _hoisted_21 = {
  key: 0
};
var _hoisted_22 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "text-success"
}, "Active", -1 /* HOISTED */);
var _hoisted_23 = [_hoisted_22];
var _hoisted_24 = {
  key: 1
};
var _hoisted_25 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "text-danger"
}, "Inactive", -1 /* HOISTED */);
var _hoisted_26 = [_hoisted_25];
var _hoisted_27 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-edit"
}, null, -1 /* HOISTED */);
var _hoisted_28 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-folder-open"
}, null, -1 /* HOISTED */);
var _hoisted_29 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "col-md-5"
}, null, -1 /* HOISTED */);
var _hoisted_30 = {
  "class": "col-md-7"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _$data$laravelData$to, _$data$limits;
  var _component_router_link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("router-link");
  var _component_pagination = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("pagination");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [_hoisted_3, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    to: {
      name: 'IndustrialCityCreate'
    },
    "class": "btn btn-sm btn-success"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_5, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Add New City ")];
    }),
    _: 1 /* STABLE */
  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" /.box-tools ")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
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
  }, null, 544 /* HYDRATE_EVENTS, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.search]])]), _hoisted_13, _hoisted_14, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_15, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_16, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_17, [_hoisted_18, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tbody", null, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.laravelData.data, function (industrial) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", {
      key: industrial.id
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(industrial.si), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(industrial.name), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(industrial.district_name), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(industrial.upazila_name), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, [industrial.type == 1 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_19, "Office")) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_20, "Home"))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, [industrial.status == 1 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_21, _hoisted_23)) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_24, _hoisted_26))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
      to: {
        name: 'IndustrialCityEdit',
        params: {
          id: industrial.id
        }
      },
      "class": "btn btn-xs btn-primary"
    }, {
      "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
        return [_hoisted_27, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Edit ")];
      }),
      _: 2 /* DYNAMIC */
    }, 1032 /* PROPS, DYNAMIC_SLOTS */, ["to"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("   "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
      to: {
        name: 'IndustrialCityEdit',
        params: {
          id: industrial.id
        }
      },
      "class": "btn btn-xs btn-warning"
    }, {
      "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
        return [_hoisted_28, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Master-plan ")];
      }),
      _: 2 /* DYNAMIC */
    }, 1032 /* PROPS, DYNAMIC_SLOTS */, ["to"])])]);
  }), 128 /* KEYED_FRAGMENT */))])])]), _hoisted_29, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_30, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_pagination, {
    modelValue: $data.page,
    "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
      return $data.page = $event;
    }),
    records: (_$data$laravelData$to = $data.laravelData.total) !== null && _$data$laravelData$to !== void 0 ? _$data$laravelData$to : 0,
    "per-page": (_$data$limits = $data.limits) !== null && _$data$limits !== void 0 ? _$data$limits : 0,
    onPaginate: $options.getResults
  }, null, 8 /* PROPS */, ["modelValue", "records", "per-page", "onPaginate"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("                    <pagination :limit=\"2\" class=\"pull-right\" :data=\"laravelData\" @pagination-change-page=\"getResults\"></pagination>")])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("    </div>")], 2112 /* STABLE_FRAGMENT, DEV_ROOT_FRAGMENT */);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/MasterPlanEdit.vue?vue&type=template&id=e61c2c94":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/MasterPlanEdit.vue?vue&type=template&id=e61c2c94 ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************/
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
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("strong", null, "Edit Master Plan")])], -1 /* HOISTED */);
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
  "class": "col-md-3 required-star"
}, "Name (English):", -1 /* HOISTED */);
var _hoisted_7 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_8 = {
  "class": "row form-group"
};
var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Name (বাংলা):", -1 /* HOISTED */);
var _hoisted_10 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_11 = {
  "class": "row form-group"
};
var _hoisted_12 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Remarks (English):", -1 /* HOISTED */);
var _hoisted_13 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_14 = {
  "class": "row form-group"
};
var _hoisted_15 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Remarks (বাংলা):", -1 /* HOISTED */);
var _hoisted_16 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_17 = {
  "class": "row form-group"
};
var _hoisted_18 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3"
}, "Document:", -1 /* HOISTED */);
var _hoisted_19 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "help-block"
}, "[File Format: *.jpg/ .jpeg/ .png/ .gif/ .pdf | Max size 2 MB]", -1 /* HOISTED */);
var _hoisted_20 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_21 = {
  "class": "col-md-2"
};
var _hoisted_22 = ["href"];
var _hoisted_23 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-file-image-o"
}, null, -1 /* HOISTED */);
var _hoisted_24 = {
  "class": "row form-group"
};
var _hoisted_25 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-3 required-star"
}, "Status: ", -1 /* HOISTED */);
var _hoisted_26 = {
  "class": "col-md-9"
};
var _hoisted_27 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_28 = {
  "class": "col-md-12"
};
var _hoisted_29 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-chevron-circle-left"
}, null, -1 /* HOISTED */);
var _hoisted_30 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
  type: "submit",
  "class": "btn btn-primary float-right"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-chevron-circle-right"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Save ")], -1 /* HOISTED */);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_router_link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("router-link");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [_hoisted_2, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    onSubmit: _cache[7] || (_cache[7] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.updateMasterPlan();
    }, ["prevent"])),
    id: "masterPlanEditForm"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [_hoisted_6, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.masterPlanFormErrors.name_en ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return _ctx.masterPlanForm.name_en = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.masterPlanForm.name_en]]), _ctx.masterPlanFormErrors.name_en ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.masterPlanFormErrors.name_en[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_8, [_hoisted_9, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.masterPlanFormErrors.name ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return _ctx.masterPlanForm.name = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.masterPlanForm.name]]), _ctx.masterPlanFormErrors.name ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_10, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.masterPlanFormErrors.name[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_11, [_hoisted_12, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.masterPlanFormErrors.remarks_en ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("textarea", {
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return _ctx.masterPlanForm.remarks_en = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.masterPlanForm.remarks_en]]), _ctx.masterPlanFormErrors.remarks_en ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_13, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.masterPlanFormErrors.remarks_en[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_14, [_hoisted_15, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-9', _ctx.masterPlanFormErrors.remarks ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("textarea", {
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      return _ctx.masterPlanForm.remarks = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.masterPlanForm.remarks]]), _ctx.masterPlanFormErrors.remarks ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.masterPlanFormErrors.remarks[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_17, [_hoisted_18, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-7', _ctx.masterPlanFormErrors.document ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "file",
    id: "files",
    ref: "files",
    "class": "form-control",
    onChange: _cache[4] || (_cache[4] = function () {
      return $options.setMasterPlanDocument && $options.setMasterPlanDocument.apply($options, arguments);
    })
  }, null, 544 /* HYDRATE_EVENTS, NEED_PATCH */), _hoisted_19, _ctx.masterPlanFormErrors.document ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_20, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.masterPlanFormErrors.document[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_21, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
    "class": "btn btn-info",
    target: "_blank",
    href: '/' + _ctx.masterPlanForm.document
  }, [_hoisted_23, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Open document")], 8 /* PROPS */, _hoisted_22)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_24, [_hoisted_25, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_26, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
      return _ctx.masterPlanForm.status = $event;
    }),
    name: "is_active",
    type: "radio",
    value: "1"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelRadio, _ctx.masterPlanForm.status]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Active ")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[6] || (_cache[6] = function ($event) {
      return _ctx.masterPlanForm.status = $event;
    }),
    name: "is_active",
    type: "radio",
    value: "0"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelRadio, _ctx.masterPlanForm.status]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Inactive")]), _ctx.masterPlanFormErrors.status ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_27, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.masterPlanFormErrors.status[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_28, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    to: "/home-page/industrial-city",
    "class": "btn btn-default"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_29, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Back ")];
    }),
    _: 1 /* STABLE */
  }), _hoisted_30])])])], 32 /* HYDRATE_EVENTS */)])]);
}

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

/***/ "./resources/js/components/settings/industrial-city/IndustrialCityCreate.vue":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/settings/industrial-city/IndustrialCityCreate.vue ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _IndustrialCityCreate_vue_vue_type_template_id_e891ec7e__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./IndustrialCityCreate.vue?vue&type=template&id=e891ec7e */ "./resources/js/components/settings/industrial-city/IndustrialCityCreate.vue?vue&type=template&id=e891ec7e");
/* harmony import */ var _IndustrialCityCreate_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./IndustrialCityCreate.vue?vue&type=script&lang=js */ "./resources/js/components/settings/industrial-city/IndustrialCityCreate.vue?vue&type=script&lang=js");
/* harmony import */ var C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_IndustrialCityCreate_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_IndustrialCityCreate_vue_vue_type_template_id_e891ec7e__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/settings/industrial-city/IndustrialCityCreate.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/settings/industrial-city/IndustrialCityEdit.vue":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/settings/industrial-city/IndustrialCityEdit.vue ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _IndustrialCityEdit_vue_vue_type_template_id_fc4e71e2__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./IndustrialCityEdit.vue?vue&type=template&id=fc4e71e2 */ "./resources/js/components/settings/industrial-city/IndustrialCityEdit.vue?vue&type=template&id=fc4e71e2");
/* harmony import */ var _IndustrialCityEdit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./IndustrialCityEdit.vue?vue&type=script&lang=js */ "./resources/js/components/settings/industrial-city/IndustrialCityEdit.vue?vue&type=script&lang=js");
/* harmony import */ var C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_IndustrialCityEdit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_IndustrialCityEdit_vue_vue_type_template_id_fc4e71e2__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/settings/industrial-city/IndustrialCityEdit.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/settings/industrial-city/IndustrialCityList.vue":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/settings/industrial-city/IndustrialCityList.vue ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _IndustrialCityList_vue_vue_type_template_id_72909fa3__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./IndustrialCityList.vue?vue&type=template&id=72909fa3 */ "./resources/js/components/settings/industrial-city/IndustrialCityList.vue?vue&type=template&id=72909fa3");
/* harmony import */ var _IndustrialCityList_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./IndustrialCityList.vue?vue&type=script&lang=js */ "./resources/js/components/settings/industrial-city/IndustrialCityList.vue?vue&type=script&lang=js");
/* harmony import */ var C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_IndustrialCityList_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_IndustrialCityList_vue_vue_type_template_id_72909fa3__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/settings/industrial-city/IndustrialCityList.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/settings/industrial-city/MasterPlanEdit.vue":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/settings/industrial-city/MasterPlanEdit.vue ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _MasterPlanEdit_vue_vue_type_template_id_e61c2c94__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MasterPlanEdit.vue?vue&type=template&id=e61c2c94 */ "./resources/js/components/settings/industrial-city/MasterPlanEdit.vue?vue&type=template&id=e61c2c94");
/* harmony import */ var _MasterPlanEdit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./MasterPlanEdit.vue?vue&type=script&lang=js */ "./resources/js/components/settings/industrial-city/MasterPlanEdit.vue?vue&type=script&lang=js");
/* harmony import */ var C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_MasterPlanEdit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_MasterPlanEdit_vue_vue_type_template_id_e61c2c94__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/settings/industrial-city/MasterPlanEdit.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/settings/industrial-city/IndustrialCityCreate.vue?vue&type=script&lang=js":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/settings/industrial-city/IndustrialCityCreate.vue?vue&type=script&lang=js ***!
  \***********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_IndustrialCityCreate_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_IndustrialCityCreate_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./IndustrialCityCreate.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/IndustrialCityCreate.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/settings/industrial-city/IndustrialCityEdit.vue?vue&type=script&lang=js":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/components/settings/industrial-city/IndustrialCityEdit.vue?vue&type=script&lang=js ***!
  \*********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_IndustrialCityEdit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_IndustrialCityEdit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./IndustrialCityEdit.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/IndustrialCityEdit.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/settings/industrial-city/IndustrialCityList.vue?vue&type=script&lang=js":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/components/settings/industrial-city/IndustrialCityList.vue?vue&type=script&lang=js ***!
  \*********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_IndustrialCityList_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_IndustrialCityList_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./IndustrialCityList.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/IndustrialCityList.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/settings/industrial-city/MasterPlanEdit.vue?vue&type=script&lang=js":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/settings/industrial-city/MasterPlanEdit.vue?vue&type=script&lang=js ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_MasterPlanEdit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_MasterPlanEdit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./MasterPlanEdit.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/MasterPlanEdit.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/settings/industrial-city/IndustrialCityCreate.vue?vue&type=template&id=e891ec7e":
/*!*****************************************************************************************************************!*\
  !*** ./resources/js/components/settings/industrial-city/IndustrialCityCreate.vue?vue&type=template&id=e891ec7e ***!
  \*****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_IndustrialCityCreate_vue_vue_type_template_id_e891ec7e__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_IndustrialCityCreate_vue_vue_type_template_id_e891ec7e__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./IndustrialCityCreate.vue?vue&type=template&id=e891ec7e */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/IndustrialCityCreate.vue?vue&type=template&id=e891ec7e");


/***/ }),

/***/ "./resources/js/components/settings/industrial-city/IndustrialCityEdit.vue?vue&type=template&id=fc4e71e2":
/*!***************************************************************************************************************!*\
  !*** ./resources/js/components/settings/industrial-city/IndustrialCityEdit.vue?vue&type=template&id=fc4e71e2 ***!
  \***************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_IndustrialCityEdit_vue_vue_type_template_id_fc4e71e2__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_IndustrialCityEdit_vue_vue_type_template_id_fc4e71e2__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./IndustrialCityEdit.vue?vue&type=template&id=fc4e71e2 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/IndustrialCityEdit.vue?vue&type=template&id=fc4e71e2");


/***/ }),

/***/ "./resources/js/components/settings/industrial-city/IndustrialCityList.vue?vue&type=template&id=72909fa3":
/*!***************************************************************************************************************!*\
  !*** ./resources/js/components/settings/industrial-city/IndustrialCityList.vue?vue&type=template&id=72909fa3 ***!
  \***************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_IndustrialCityList_vue_vue_type_template_id_72909fa3__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_IndustrialCityList_vue_vue_type_template_id_72909fa3__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./IndustrialCityList.vue?vue&type=template&id=72909fa3 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/IndustrialCityList.vue?vue&type=template&id=72909fa3");


/***/ }),

/***/ "./resources/js/components/settings/industrial-city/MasterPlanEdit.vue?vue&type=template&id=e61c2c94":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/settings/industrial-city/MasterPlanEdit.vue?vue&type=template&id=e61c2c94 ***!
  \***********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_MasterPlanEdit_vue_vue_type_template_id_e61c2c94__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_MasterPlanEdit_vue_vue_type_template_id_e61c2c94__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./MasterPlanEdit.vue?vue&type=template&id=e61c2c94 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/industrial-city/MasterPlanEdit.vue?vue&type=template&id=e61c2c94");


/***/ })

}]);