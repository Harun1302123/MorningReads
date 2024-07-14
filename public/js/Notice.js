"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["Notice"],{

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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/notice/NoticeCreate.vue?vue&type=script&lang=js":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/notice/NoticeCreate.vue?vue&type=script&lang=js ***!
  \**********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _tinymce_tinymce_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @tinymce/tinymce-vue */ "./node_modules/@tinymce/tinymce-vue/lib/es2015/main/ts/index.js");

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      allerros: [],
      success: false,
      notice: {
        heading: '',
        heading_en: '',
        details: '',
        details_en: '',
        photo: null,
        notice_document: null,
        importance: '',
        ordering_prefix: '',
        status: ''
      }
    };
  },
  mounted: function mounted() {
    // customClass.onlyNumber();
    // customClass.isEmail();
  },
  components: {
    'editor': _tinymce_tinymce_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  methods: {
    onFileChange: function onFileChange(event) {
      var vm = this;
      vm.notice.photo = event.target.files[0];
    },
    onChangeNoticeDoc: function onChangeNoticeDoc(event) {
      var vm = this;
      vm.notice.notice_document = event.target.files[0];
    },
    saveForm: function saveForm() {
      var app = this;
      var notice_data = new FormData();
      notice_data.append('heading', app.notice.heading);
      notice_data.append('heading_en', app.notice.heading_en);
      notice_data.append('photo', app.notice.photo);
      notice_data.append('notice_document', app.notice.notice_document);
      notice_data.append('details', app.notice.details);
      notice_data.append('details_en', app.notice.details_en);
      notice_data.append('importance', app.notice.importance);
      notice_data.append('ordering_prefix', app.notice.ordering_prefix);
      notice_data.append('status', app.notice.status);
      axios.defaults.headers.post['Content-Type'] = 'multipart/form-data';
      axios.post('/settings/store-notice', notice_data).then(function (resp) {
        if (resp.data.status === true) {
          app.$toast.success('Your notice crate successfully.');
          app.$router.push({
            path: '/notice-list'
          });
        }
      })["catch"](function (error) {
        app.allerros = error.response.data.errors;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/notice/NoticeEdit.vue?vue&type=script&lang=js":
/*!********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/notice/NoticeEdit.vue?vue&type=script&lang=js ***!
  \********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _tinymce_tinymce_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @tinymce/tinymce-vue */ "./node_modules/@tinymce/tinymce-vue/lib/es2015/main/ts/index.js");

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      notice_id: null,
      allerrors: [],
      notice: {
        heading: '',
        heading_en: '',
        details: '',
        details_en: '',
        photo: null,
        notice_document: null,
        ordering_prefix: '',
        importance: '',
        status: ''
      }
    };
  },
  components: {
    'editor': _tinymce_tinymce_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  mounted: function mounted() {
    // customClass.onlyNumber();
    // customClass.isEmail();
  },
  created: function created() {
    var app = this;
    var id = app.$route.params.id;
    app.notice_id = id;
    axios.get('/settings/edit-notice/' + id).then(function (resp) {
      app.notice = resp.data;
    })["catch"](function () {
      alert("Could not load your Notice");
    });
  },
  methods: {
    onFileChange: function onFileChange(event) {
      var vm = this;
      vm.notice.photo = event.target.files[0];
    },
    onChangeNoticeDoc: function onChangeNoticeDoc(event) {
      var vm = this;
      vm.notice.notice_document = event.target.files[0];
    },
    saveForm: function saveForm() {
      var app = this;
      var notice_data = new FormData();
      notice_data.append('heading', app.notice.heading);
      notice_data.append('heading_en', app.notice.heading_en);
      notice_data.append('photo', app.notice.photo);
      notice_data.append('notice_document', app.notice.notice_document);
      notice_data.append('details', app.notice.details);
      notice_data.append('details_en', app.notice.details_en);
      notice_data.append('importance', app.notice.importance);
      notice_data.append('ordering_prefix', app.notice.ordering_prefix);
      notice_data.append('status', app.notice.status);
      axios.defaults.headers.post['Content-Type'] = 'multipart/form-data';
      axios.post('/settings/update-notice/' + app.notice_id, notice_data).then(function (resp) {
        if (resp.data.status === true) {
          app.$toast.success('Your data update successfully.');
          app.$router.push('/notice-list');
        }
      })["catch"](function (error) {
        app.allerrors = error.response.data.errors;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/notice/NoticeList.vue?vue&type=script&lang=js":
/*!********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/notice/NoticeList.vue?vue&type=script&lang=js ***!
  \********************************************************************************************************************************************************************************************************************/
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
      axios__WEBPACK_IMPORTED_MODULE_0___default().get('/settings/notice-list?page=' + page + is_search + max_limit).then(function (response) {
        app.laravelData = response.data;
        console.log(app.laravelData);
        app.data = response.data;
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/notice/NoticeCreate.vue?vue&type=template&id=43fb2b6c":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/notice/NoticeCreate.vue?vue&type=template&id=43fb2b6c ***!
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
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h5", {
  "class": "card-title pt-2 pb-2"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("strong", null, "Create Notice")])], -1 /* HOISTED */);
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
  "class": "control-label col-md-2 required-star"
}, "Heading (Bangla):", -1 /* HOISTED */);
var _hoisted_7 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_8 = {
  "class": "row form-group"
};
var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2 required-star"
}, "Heading (English):", -1 /* HOISTED */);
var _hoisted_10 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_11 = {
  "class": "row form-group"
};
var _hoisted_12 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2 required-star"
}, "Details (বাংলা):", -1 /* HOISTED */);
var _hoisted_13 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_14 = {
  "class": "row form-group"
};
var _hoisted_15 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2 required-star"
}, "Details (English):", -1 /* HOISTED */);
var _hoisted_16 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_17 = {
  "class": "row form-group"
};
var _hoisted_18 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2 required-star"
}, "Photo:", -1 /* HOISTED */);
var _hoisted_19 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "help-block",
  style: {
    "margin-bottom": "0"
  }
}, "[File Format: .jpeg, .png, .jpg, .gif, .svg | File size within 1 MB]", -1 /* HOISTED */);
var _hoisted_20 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_21 = {
  "class": "row form-group"
};
var _hoisted_22 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2"
}, "Document:", -1 /* HOISTED */);
var _hoisted_23 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "help-block",
  style: {
    "margin-bottom": "0"
  }
}, "[File Format: .pdf | File size within 2 MB]", -1 /* HOISTED */);
var _hoisted_24 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_25 = {
  "class": "row form-group"
};
var _hoisted_26 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2 required-star"
}, "Importance:", -1 /* HOISTED */);
var _hoisted_27 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createStaticVNode)("<option value=\"\"> Select one</option><option value=\"danger\"> Danger</option><option value=\"info\"> Info</option><option value=\"top\">Top</option><option value=\"warning\">Warning</option>", 5);
var _hoisted_32 = [_hoisted_27];
var _hoisted_33 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_34 = {
  "class": "row form-group"
};
var _hoisted_35 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2 required-star"
}, "Order:", -1 /* HOISTED */);
var _hoisted_36 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_37 = {
  "class": "row form-group"
};
var _hoisted_38 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-2 required-star"
}, "Status: ", -1 /* HOISTED */);
var _hoisted_39 = {
  "class": "col-md-10"
};
var _hoisted_40 = {
  "class": "radio-inline"
};
var _hoisted_41 = {
  "class": "radio-inline"
};
var _hoisted_42 = {
  "class": "radio-inline"
};
var _hoisted_43 = {
  "class": "radio-inline"
};
var _hoisted_44 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_45 = {
  "class": "col-md-12"
};
var _hoisted_46 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "float-right"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
  type: "submit",
  "class": "btn btn-primary pull-right"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-chevron-circle-right"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Save ")])], -1 /* HOISTED */);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_editor = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("editor");
  var _component_router_link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("router-link");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [_hoisted_2, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    onSubmit: _cache[12] || (_cache[12] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.saveForm();
    }, ["prevent"])),
    enctype: "multipart/form-data"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [_hoisted_6, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerros.heading ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return _ctx.notice.heading = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.notice.heading]]), _ctx.allerros.heading ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.heading[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_8, [_hoisted_9, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerros.heading_en ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return _ctx.notice.heading_en = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.notice.heading_en]]), _ctx.allerros.heading_en ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_10, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.heading_en[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_11, [_hoisted_12, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-10', _ctx.allerros.details ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_editor, {
    modelValue: _ctx.notice.details,
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return _ctx.notice.details = $event;
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
  }, null, 8 /* PROPS */, ["modelValue"]), _ctx.allerros.details ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_13, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.details[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_14, [_hoisted_15, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-10', _ctx.allerros.details_en ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_editor, {
    modelValue: _ctx.notice.details_en,
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      return _ctx.notice.details_en = $event;
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
  }, null, 8 /* PROPS */, ["modelValue"]), _ctx.allerros.details_en ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.details_en[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_17, [_hoisted_18, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerros.photo ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "file",
    "class": "form-control",
    id: "photo",
    ref: "photo",
    onChange: _cache[4] || (_cache[4] = function () {
      return $options.onFileChange && $options.onFileChange.apply($options, arguments);
    })
  }, null, 544 /* HYDRATE_EVENTS, NEED_PATCH */), _hoisted_19, _ctx.allerros.photo ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_20, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.photo[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_21, [_hoisted_22, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerros.notice_document ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "file",
    "class": "form-control",
    id: "notice_document",
    ref: "notice_document",
    onChange: _cache[5] || (_cache[5] = function () {
      return $options.onChangeNoticeDoc && $options.onChangeNoticeDoc.apply($options, arguments);
    }),
    accept: "application/pdf"
  }, null, 544 /* HYDRATE_EVENTS, NEED_PATCH */), _hoisted_23, _ctx.allerros.notice_document ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_24, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.notice_document[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_25, [_hoisted_26, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerros.importance ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "onUpdate:modelValue": _cache[6] || (_cache[6] = function ($event) {
      return _ctx.notice.importance = $event;
    }),
    "class": "form-control input-sm"
  }, _hoisted_32, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, _ctx.notice.importance]]), _ctx.allerros.importance ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_33, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.importance[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_34, [_hoisted_35, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerros.ordering_prefix ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "number",
    "onUpdate:modelValue": _cache[7] || (_cache[7] = function ($event) {
      return _ctx.notice.ordering_prefix = $event;
    }),
    "class": "form-control",
    size: "10x5",
    min: "0"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.notice.ordering_prefix]]), _ctx.allerros.ordering_prefix ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_36, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.ordering_prefix[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_37, [_hoisted_38, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_39, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_40, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[8] || (_cache[8] = function ($event) {
      return _ctx.notice.status = $event;
    }),
    name: "status",
    type: "radio",
    value: "draft"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelRadio, _ctx.notice.status]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Draft   ")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_41, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[9] || (_cache[9] = function ($event) {
      return _ctx.notice.status = $event;
    }),
    name: "status",
    type: "radio",
    value: "private"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelRadio, _ctx.notice.status]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Private   ")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_42, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[10] || (_cache[10] = function ($event) {
      return _ctx.notice.status = $event;
    }),
    name: "status",
    type: "radio",
    value: "unpublished"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelRadio, _ctx.notice.status]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Unpublished   ")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_43, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[11] || (_cache[11] = function ($event) {
      return _ctx.notice.status = $event;
    }),
    name: "status",
    type: "radio",
    value: "Public"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelRadio, _ctx.notice.status]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Public ")])]), _ctx.allerros.status ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_44, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerros.status[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_45, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    to: "/notice-list",
    "class": "btn btn-default"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Back")];
    }),
    _: 1 /* STABLE */
  }), _hoisted_46])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("<div class=\"panel-footer\">\r\n          <div class=\"float-left\">\r\n\r\n          </div>\r\n          <div class=\"clearfix\"></div>\r\n        </div>")], 32 /* HYDRATE_EVENTS */)])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/notice/NoticeEdit.vue?vue&type=template&id=0764b5d8":
/*!************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/notice/NoticeEdit.vue?vue&type=template&id=0764b5d8 ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************/
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
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("strong", null, "Edit Notice")])], -1 /* HOISTED */);
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
  "class": "control-label col-md-2 required-star"
}, "Heading (Bangla):", -1 /* HOISTED */);
var _hoisted_7 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_8 = {
  "class": "row form-group"
};
var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2 required-star"
}, "Heading (English):", -1 /* HOISTED */);
var _hoisted_10 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_11 = {
  "class": "row form-group"
};
var _hoisted_12 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2 required-star"
}, "Details (বাংলা):", -1 /* HOISTED */);
var _hoisted_13 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_14 = {
  "class": "row form-group"
};
var _hoisted_15 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2 required-star"
}, "Details (English):", -1 /* HOISTED */);
var _hoisted_16 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_17 = {
  "class": "row form-group"
};
var _hoisted_18 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2 required-star"
}, "Photo:", -1 /* HOISTED */);
var _hoisted_19 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "help-block",
  style: {
    "margin-bottom": "0"
  }
}, "[File Format: .jpeg, .png, .jpg, .gif, .svg | File size within 1 MB]", -1 /* HOISTED */);
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
  "class": "control-label col-md-2"
}, "Document:", -1 /* HOISTED */);
var _hoisted_26 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "help-block",
  style: {
    "margin-bottom": "0"
  }
}, "[File Format: .pdf | File size within 2 MB]", -1 /* HOISTED */);
var _hoisted_27 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_28 = {
  "class": "col-md-2"
};
var _hoisted_29 = ["href"];
var _hoisted_30 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-file-image-o"
}, null, -1 /* HOISTED */);
var _hoisted_31 = {
  "class": "row form-group"
};
var _hoisted_32 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2 required-star"
}, "Importance:", -1 /* HOISTED */);
var _hoisted_33 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createStaticVNode)("<option value=\"\"> Select one</option><option value=\"danger\"> Danger</option><option value=\"info\"> Info</option><option value=\"top\">Top</option><option value=\"warning\">Warning</option>", 5);
var _hoisted_38 = [_hoisted_33];
var _hoisted_39 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_40 = {
  "class": "row form-group"
};
var _hoisted_41 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "control-label col-md-2 required-star"
}, "Order:", -1 /* HOISTED */);
var _hoisted_42 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_43 = {
  "class": "row form-group"
};
var _hoisted_44 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "col-md-2 required-star"
}, "Status: ", -1 /* HOISTED */);
var _hoisted_45 = {
  "class": "col-md-10"
};
var _hoisted_46 = {
  "class": "radio-inline"
};
var _hoisted_47 = {
  "class": "radio-inline"
};
var _hoisted_48 = {
  "class": "radio-inline"
};
var _hoisted_49 = {
  "class": "radio-inline"
};
var _hoisted_50 = {
  key: 0,
  "class": /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['text-danger'])
};
var _hoisted_51 = {
  "class": "col-md-12"
};
var _hoisted_52 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "float-right"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
  type: "submit",
  "class": "btn btn-primary"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-chevron-circle-right"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Save ")])], -1 /* HOISTED */);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_editor = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("editor");
  var _component_router_link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("router-link");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [_hoisted_2, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    onSubmit: _cache[12] || (_cache[12] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.saveForm();
    }, ["prevent"])),
    enctype: "multipart/form-data"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [_hoisted_6, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerrors.heading ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return _ctx.notice.heading = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.notice.heading]]), _ctx.allerrors.heading ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerrors.heading[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_8, [_hoisted_9, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerrors.heading_en ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return _ctx.notice.heading_en = $event;
    }),
    "class": "form-control"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.notice.heading_en]]), _ctx.allerrors.heading_en ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_10, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerrors.heading_en[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_11, [_hoisted_12, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-10', _ctx.allerrors.details ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_editor, {
    modelValue: _ctx.notice.details,
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return _ctx.notice.details = $event;
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
  }, null, 8 /* PROPS */, ["modelValue"]), _ctx.allerrors.details ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_13, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerrors.details[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_14, [_hoisted_15, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-10', _ctx.allerrors.details_en ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_editor, {
    modelValue: _ctx.notice.details_en,
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      return _ctx.notice.details_en = $event;
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
  }, null, 8 /* PROPS */, ["modelValue"]), _ctx.allerrors.details_en ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerrors.details_en[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_17, [_hoisted_18, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerrors.photo ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "file",
    "class": "form-control",
    id: "photo",
    ref: "photo",
    onChange: _cache[4] || (_cache[4] = function () {
      return $options.onFileChange && $options.onFileChange.apply($options, arguments);
    })
  }, null, 544 /* HYDRATE_EVENTS, NEED_PATCH */), _hoisted_19, _ctx.allerrors.photo ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_20, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerrors.photo[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_21, [_ctx.notice.photo ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("a", {
    key: 0,
    "class": "btn btn-info",
    target: "_blank",
    href: '/' + _ctx.notice.photo
  }, [_hoisted_23, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" View Photo")], 8 /* PROPS */, _hoisted_22)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_24, [_hoisted_25, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerrors.notice_document ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "file",
    "class": "form-control",
    id: "notice_document",
    ref: "notice_document",
    onChange: _cache[5] || (_cache[5] = function () {
      return $options.onChangeNoticeDoc && $options.onChangeNoticeDoc.apply($options, arguments);
    })
  }, null, 544 /* HYDRATE_EVENTS, NEED_PATCH */), _hoisted_26, _ctx.allerrors.notice_document ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_27, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerrors.notice_document[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_28, [_ctx.notice.notice_document ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("a", {
    key: 0,
    "class": "btn btn-info",
    target: "_blank",
    href: '/' + _ctx.notice.notice_document
  }, [_hoisted_30, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" View Document")], 8 /* PROPS */, _hoisted_29)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_31, [_hoisted_32, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerrors.importance ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "onUpdate:modelValue": _cache[6] || (_cache[6] = function ($event) {
      return _ctx.notice.importance = $event;
    }),
    "class": "form-control input-sm"
  }, _hoisted_38, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, _ctx.notice.importance]]), _ctx.allerrors.importance ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_39, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerrors.importance[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_40, [_hoisted_41, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['col-md-8', _ctx.allerrors.ordering_prefix ? 'has-error' : ''])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "number",
    "onUpdate:modelValue": _cache[7] || (_cache[7] = function ($event) {
      return _ctx.notice.ordering_prefix = $event;
    }),
    "class": "form-control",
    size: "10x5",
    min: "0"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.notice.ordering_prefix]]), _ctx.allerrors.ordering_prefix ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_42, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerrors.ordering_prefix[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_43, [_hoisted_44, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_45, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_46, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[8] || (_cache[8] = function ($event) {
      return _ctx.notice.status = $event;
    }),
    name: "status",
    type: "radio",
    value: "draft"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelRadio, _ctx.notice.status]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Draft   ")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_47, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[9] || (_cache[9] = function ($event) {
      return _ctx.notice.status = $event;
    }),
    name: "status",
    type: "radio",
    value: "private"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelRadio, _ctx.notice.status]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Private   ")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_48, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[10] || (_cache[10] = function ($event) {
      return _ctx.notice.status = $event;
    }),
    name: "status",
    type: "radio",
    value: "unpublished"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelRadio, _ctx.notice.status]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Unpublished   ")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_49, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[11] || (_cache[11] = function ($event) {
      return _ctx.notice.status = $event;
    }),
    name: "status",
    type: "radio",
    value: "public"
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelRadio, _ctx.notice.status]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Public   ")])]), _ctx.allerrors.status ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_50, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.allerrors.status[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_51, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    to: "/notice-list",
    "class": "btn btn-default"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Back")];
    }),
    _: 1 /* STABLE */
  }), _hoisted_52])])])], 32 /* HYDRATE_EVENTS */)])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/notice/NoticeList.vue?vue&type=template&id=0fc6e328":
/*!************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/notice/NoticeList.vue?vue&type=template&id=0fc6e328 ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************/
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
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("strong", null, "List of Notices")])])], -1 /* HOISTED */);
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
var _hoisted_17 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("thead", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Sl"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Heading"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Details"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Importance"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Status"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Action")])], -1 /* HOISTED */);
var _hoisted_18 = ["innerHTML"];
var _hoisted_19 = ["innerHTML"];
var _hoisted_20 = {
  style: {
    "width": "10%"
  }
};
var _hoisted_21 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa fa-edit"
}, null, -1 /* HOISTED */);
var _hoisted_22 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "col-md-5"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("                    Showing {{laravelData.from}} to {{laravelData.to}} of {{laravelData.total}} entries")], -1 /* HOISTED */);
var _hoisted_23 = {
  "class": "col-md-7"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _$data$laravelData$to, _$data$limits;
  var _component_router_link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("router-link");
  var _component_pagination = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("pagination");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("    <div class=\"col-lg-12\">"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("<div class=\"form-group\">"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("<router-link :to=\"{name: 'BankCreate'}\" class=\"btn btn-success\">Create new Bank</router-link>"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("</div>"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [_hoisted_3, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    to: {
      name: 'NoticeCreate'
    },
    "class": "btn btn-success"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Create Notice")];
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
  }, null, 544 /* HYDRATE_EVENTS, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.search]])]), _hoisted_13, _hoisted_14, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_15, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_16, [_hoisted_17, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tbody", null, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.laravelData.data, function (notice) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", {
      key: notice.id
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("                        :key=\"notice.id\""), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(notice.si), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
      style: {
        "width": "20%"
      },
      innerHTML: notice.heading.length > 50 ? notice.heading.slice(0, 50) + '...' : notice.heading
    }, null, 8 /* PROPS */, _hoisted_18), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
      innerHTML: notice.details.length > 100 ? notice.details.slice(0, 100) + '...' : notice.details
    }, null, 8 /* PROPS */, _hoisted_19), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(notice.importance), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(notice.status), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_20, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
      to: {
        name: 'NoticeEdit',
        params: {
          id: notice.id
        }
      },
      "class": "btn btn-xs btn-primary"
    }, {
      "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
        return [_hoisted_21, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Edit ")];
      }),
      _: 2 /* DYNAMIC */
    }, 1032 /* PROPS, DYNAMIC_SLOTS */, ["to"])])]);
  }), 128 /* KEYED_FRAGMENT */))])])]), _hoisted_22, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_23, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_pagination, {
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

/***/ "./resources/js/components/settings/notice/NoticeCreate.vue":
/*!******************************************************************!*\
  !*** ./resources/js/components/settings/notice/NoticeCreate.vue ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _NoticeCreate_vue_vue_type_template_id_43fb2b6c__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./NoticeCreate.vue?vue&type=template&id=43fb2b6c */ "./resources/js/components/settings/notice/NoticeCreate.vue?vue&type=template&id=43fb2b6c");
/* harmony import */ var _NoticeCreate_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./NoticeCreate.vue?vue&type=script&lang=js */ "./resources/js/components/settings/notice/NoticeCreate.vue?vue&type=script&lang=js");
/* harmony import */ var C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_NoticeCreate_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_NoticeCreate_vue_vue_type_template_id_43fb2b6c__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/settings/notice/NoticeCreate.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/settings/notice/NoticeEdit.vue":
/*!****************************************************************!*\
  !*** ./resources/js/components/settings/notice/NoticeEdit.vue ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _NoticeEdit_vue_vue_type_template_id_0764b5d8__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./NoticeEdit.vue?vue&type=template&id=0764b5d8 */ "./resources/js/components/settings/notice/NoticeEdit.vue?vue&type=template&id=0764b5d8");
/* harmony import */ var _NoticeEdit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./NoticeEdit.vue?vue&type=script&lang=js */ "./resources/js/components/settings/notice/NoticeEdit.vue?vue&type=script&lang=js");
/* harmony import */ var C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_NoticeEdit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_NoticeEdit_vue_vue_type_template_id_0764b5d8__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/settings/notice/NoticeEdit.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/settings/notice/NoticeList.vue":
/*!****************************************************************!*\
  !*** ./resources/js/components/settings/notice/NoticeList.vue ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _NoticeList_vue_vue_type_template_id_0fc6e328__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./NoticeList.vue?vue&type=template&id=0fc6e328 */ "./resources/js/components/settings/notice/NoticeList.vue?vue&type=template&id=0fc6e328");
/* harmony import */ var _NoticeList_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./NoticeList.vue?vue&type=script&lang=js */ "./resources/js/components/settings/notice/NoticeList.vue?vue&type=script&lang=js");
/* harmony import */ var C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_xampp7_4_htdocs_ossp_v3_0_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_NoticeList_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_NoticeList_vue_vue_type_template_id_0fc6e328__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/settings/notice/NoticeList.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/settings/notice/NoticeCreate.vue?vue&type=script&lang=js":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/settings/notice/NoticeCreate.vue?vue&type=script&lang=js ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_NoticeCreate_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_NoticeCreate_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./NoticeCreate.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/notice/NoticeCreate.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/settings/notice/NoticeEdit.vue?vue&type=script&lang=js":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/settings/notice/NoticeEdit.vue?vue&type=script&lang=js ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_NoticeEdit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_NoticeEdit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./NoticeEdit.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/notice/NoticeEdit.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/settings/notice/NoticeList.vue?vue&type=script&lang=js":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/settings/notice/NoticeList.vue?vue&type=script&lang=js ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_NoticeList_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_NoticeList_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./NoticeList.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/notice/NoticeList.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/settings/notice/NoticeCreate.vue?vue&type=template&id=43fb2b6c":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/settings/notice/NoticeCreate.vue?vue&type=template&id=43fb2b6c ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_NoticeCreate_vue_vue_type_template_id_43fb2b6c__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_NoticeCreate_vue_vue_type_template_id_43fb2b6c__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./NoticeCreate.vue?vue&type=template&id=43fb2b6c */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/notice/NoticeCreate.vue?vue&type=template&id=43fb2b6c");


/***/ }),

/***/ "./resources/js/components/settings/notice/NoticeEdit.vue?vue&type=template&id=0764b5d8":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/settings/notice/NoticeEdit.vue?vue&type=template&id=0764b5d8 ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_NoticeEdit_vue_vue_type_template_id_0764b5d8__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_NoticeEdit_vue_vue_type_template_id_0764b5d8__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./NoticeEdit.vue?vue&type=template&id=0764b5d8 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/notice/NoticeEdit.vue?vue&type=template&id=0764b5d8");


/***/ }),

/***/ "./resources/js/components/settings/notice/NoticeList.vue?vue&type=template&id=0fc6e328":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/settings/notice/NoticeList.vue?vue&type=template&id=0fc6e328 ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_NoticeList_vue_vue_type_template_id_0fc6e328__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_NoticeList_vue_vue_type_template_id_0fc6e328__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./NoticeList.vue?vue&type=template&id=0fc6e328 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/notice/NoticeList.vue?vue&type=template&id=0fc6e328");


/***/ })

}]);