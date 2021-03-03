/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 11);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/web-speech-recognizer/dist/web_speech_recognizer.js":
/*!**************************************************************************!*\
  !*** ./node_modules/web-speech-recognizer/dist/web_speech_recognizer.js ***!
  \**************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

!function(e,t){ true?module.exports=t():undefined}(window,function(){return function(e){var t={};function n(r){if(t[r])return t[r].exports;var i=t[r]={i:r,l:!1,exports:{}};return e[r].call(i.exports,i,i.exports,n),i.l=!0,i.exports}return n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var i in e)n.d(r,i,function(t){return e[t]}.bind(null,i));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=2)}([function(e,t,n){var r,i=n(1);"undefined"!=typeof window&&(r=window.AudioContext||window.webkitAudioContext);var o=null;e.exports=function(e,t){var n=new i;if(!r)return n;var s,a,c,u=(t=t||{}).smoothing||.1,l=t.interval||50,f=t.threshold,p=t.play,h=t.history||10,g=!0;o=t.audioContext||o||new r,(c=o.createAnalyser()).fftSize=512,c.smoothingTimeConstant=u,a=new Float32Array(c.frequencyBinCount),e.jquery&&(e=e[0]),e instanceof HTMLAudioElement||e instanceof HTMLVideoElement?(s=o.createMediaElementSource(e),void 0===p&&(p=!0),f=f||-50):(s=o.createMediaStreamSource(e),f=f||-50),s.connect(c),p&&c.connect(o.destination),n.speaking=!1,n.suspend=function(){return o.suspend()},n.resume=function(){return o.resume()},Object.defineProperty(n,"state",{get:function(){return o.state}}),o.onstatechange=function(){n.emit("state_change",o.state)},n.setThreshold=function(e){f=e},n.setInterval=function(e){l=e},n.stop=function(){g=!1,n.emit("volume_change",-100,f),n.speaking&&(n.speaking=!1,n.emit("stopped_speaking")),c.disconnect(),s.disconnect()},n.speakingHistory=[];for(var d=0;d<h;d++)n.speakingHistory.push(0);var v=function(){setTimeout(function(){if(g){var e=function(e,t){var n=-1/0;e.getFloatFrequencyData(t);for(var r=4,i=t.length;r<i;r++)t[r]>n&&t[r]<0&&(n=t[r]);return n}(c,a);n.emit("volume_change",e,f);var t=0;if(e>f&&!n.speaking){for(var r=n.speakingHistory.length-3;r<n.speakingHistory.length;r++)t+=n.speakingHistory[r];t>=2&&(n.speaking=!0,n.emit("speaking"))}else if(e<f&&n.speaking){for(r=0;r<n.speakingHistory.length;r++)t+=n.speakingHistory[r];0==t&&(n.speaking=!1,n.emit("stopped_speaking"))}n.speakingHistory.shift(),n.speakingHistory.push(0+(e>f)),v()}},l)};return v(),n}},function(e,t){function n(){}e.exports=n,n.mixin=function(e){var t=e.prototype||e;t.isWildEmitter=!0,t.on=function(e,t,n){this.callbacks=this.callbacks||{};var r=3===arguments.length,i=r?arguments[1]:void 0,o=r?arguments[2]:arguments[1];return o._groupName=i,(this.callbacks[e]=this.callbacks[e]||[]).push(o),this},t.once=function(e,t,n){var r=this,i=3===arguments.length,o=i?arguments[1]:void 0,s=i?arguments[2]:arguments[1];function a(){r.off(e,a),s.apply(this,arguments)}return this.on(e,o,a),this},t.releaseGroup=function(e){var t,n,r,i;for(t in this.callbacks=this.callbacks||{},this.callbacks)for(n=0,r=(i=this.callbacks[t]).length;n<r;n++)i[n]._groupName===e&&(i.splice(n,1),n--,r--);return this},t.off=function(e,t){this.callbacks=this.callbacks||{};var n,r=this.callbacks[e];return r?1===arguments.length?(delete this.callbacks[e],this):(-1!==(n=r.indexOf(t))&&(r.splice(n,1),0===r.length&&delete this.callbacks[e]),this):this},t.emit=function(e){this.callbacks=this.callbacks||{};var t,n,r,i=[].slice.call(arguments,1),o=this.callbacks[e],s=this.getWildcardCallbacks(e);if(o)for(t=0,n=(r=o.slice()).length;t<n&&r[t];++t)r[t].apply(this,i);if(s)for(n=s.length,t=0,n=(r=s.slice()).length;t<n&&r[t];++t)r[t].apply(this,[e].concat(i));return this},t.getWildcardCallbacks=function(e){this.callbacks=this.callbacks||{};var t,n,r=[];for(t in this.callbacks)n=t.split("*"),("*"===t||2===n.length&&e.slice(0,n[0].length)===n[0])&&(r=r.concat(this.callbacks[t]));return r}},n.mixin(n)},function(e,t,n){"use strict";n.r(t);var r={};n.r(r),n.d(r,"init",function(){return V}),n.d(r,"start",function(){return q}),n.d(r,"stop",function(){return z});var i={};n.r(i),n.d(i,"init",function(){return re}),n.d(i,"start",function(){return ie}),n.d(i,"stop",function(){return oe});var o=n(0),s=n.n(o);function a(e,t,n,r,i,o,s){try{var a=e[o](s),c=a.value}catch(e){return void n(e)}a.done?t(c):Promise.resolve(c).then(r,i)}function c(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter(function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable})),n.push.apply(n,r)}return n}function u(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}function l(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}var f,p,h,g,d,v=function(){function e(t){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.settings=function(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?c(n,!0).forEach(function(t){u(e,t,n[t])}):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):c(n).forEach(function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))})}return e}({onSpeaking:function(){},onStopSpeaking:function(){},onVolumeChange:function(){}},t)}var t,n,r,i,o;return t=e,(n=[{key:"start",value:(i=regeneratorRuntime.mark(function e(){var t;return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,e.next=3,navigator.mediaDevices.getUserMedia({audio:!0,video:!1});case 3:t=e.sent,this.audioStream=t,this.trackSpeaking(t),this.trackVolume(t),e.next=12;break;case 9:e.prev=9,e.t0=e.catch(0),console.error(e.t0);case 12:case"end":return e.stop()}},e,this,[[0,9]])}),o=function(){var e=this,t=arguments;return new Promise(function(n,r){var o=i.apply(e,t);function s(e){a(o,n,r,s,c,"next",e)}function c(e){a(o,n,r,s,c,"throw",e)}s(void 0)})},function(){return o.apply(this,arguments)})},{key:"trackSpeaking",value:function(e){var t=this.settings;this.audioStreamSpeechEvents=s()(e,{interval:125}),this.audioStreamSpeechEvents.on("speaking",t.onSpeaking),this.audioStreamSpeechEvents.on("stopped_speaking",t.onStopSpeaking)}},{key:"trackVolume",value:function(e){var t=this,n=this.settings,r=new AudioContext;this.levels=r.createScriptProcessor(2048,1,1),this.analyser=r.createAnalyser(),this.analyser.smoothingTimeConstant=.4,this.analyser.fftSize=1024,this.levels.onaudioprocess=function(){var e=new Uint8Array(t.analyser.frequencyBinCount);t.analyser.getByteFrequencyData(e);var r,i=0===(r=e).length?0:r.reduce(function(e,t){return e+t},0)/r.length;n.onVolumeChange(i)},this.source=r.createMediaStreamSource(e),this.levels.connect(r.destination),this.source.connect(this.analyser),this.analyser.connect(this.levels)}},{key:"stop",value:function(){this.audioStream&&this.audioStream.getTracks().forEach(function(e){return e.stop()}),this.audioStreamSpeechEvents&&this.audioStreamSpeechEvents.stop(),this.levels&&this.levels.disconnect(),this.source&&this.source.disconnect(),this.analyser&&this.analyser.disconnect()}}])&&l(t.prototype,n),r&&l(t,r),e}();function b(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter(function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable})),n.push.apply(n,r)}return n}function y(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?b(n,!0).forEach(function(t){m(e,t,n[t])}):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):b(n).forEach(function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))})}return e}function m(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}var k,O,S,w,j=!1,P=12e4,x=3e3,T={error:null,status:"stopped",transcriptions:[],finalTranscriptions:!1},E=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};k(y({},T,{},e))},C={lang:"en-US",interimResults:!0,maxAlternatives:10};function D(){clearTimeout(h),clearTimeout(g)}function R(){D(),p.abort(),E(),O(0)}function A(){E({status:"starting"}),O(0);try{p.start()}catch(e){console.error(e)}}function _(){D(),E(),O(0),j||function e(){try{setTimeout(A,100)}catch(t){e()}}()}function U(){E({status:"recording"}),O(0)}function H(e){if(e&&e.results){var t=e.results[e.resultIndex],n=Object.values(t).map(function(e){return{confidence:e.confidence,text:e.transcript}});E({finalTranscriptions:t.isFinal,status:"recording",transcriptions:n}),function(e,t){clearTimeout(h),t||(h=setTimeout(function(){E({finalTranscriptions:!0,status:"recording",transcriptions:e}),R()},x))}(n,t.isFinal)}}function M(e){E({error:e.error,status:"error"}),O(0)}function F(){d||R()}function V(e){var t,n,r,i,o,s=y({},C,{},e);k=e.onUserSpeech,O=e.onUserSpeak,n=(t=s).lang,r=t.interimResults,i=t.maxAlternatives,o=window.SpeechRecognition||window.webkitSpeechRecognition,(p=new o).continuous=!0,p.lang=n,p.interimResults=r,p.maxAlternatives=i,p.onstart=U,p.onresult=H,p.onerror=M,p.onend=_}function q(){j=!1,O&&(f=new v({onSpeaking:function(){d=!0},onStopSpeaking:function(){d=!1,clearTimeout(g),g=setTimeout(F,P)},onVolumeChange:function(e){O(e)}}),O(0),f.start()),k&&A()}function z(){j=!0,D(),O&&(f&&f.stop(),O(0)),k&&(D(),p&&p.stop(),E(),O(0))}function B(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter(function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable})),n.push.apply(n,r)}return n}function I(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?B(n,!0).forEach(function(t){L(e,t,n[t])}):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):B(n).forEach(function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))})}return e}function L(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}var W,N,G,J=!1,K={lang:"en-US",interimResults:!0,maxAlternatives:10},Q={error:null,status:"stopped",transcriptions:[],finalTranscriptions:!1},X=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};W(I({},Q,{},e))};function Y(){X({status:"recording"})}function Z(){N(0),S&&S.stop()}function $(e,t){clearTimeout(G),t||(G=setTimeout(function(){X({finalTranscriptions:!0,transcriptions:e}),N&&Z(),w.abort(),J=!1,X()},2e3))}function ee(e){if(e&&e.results){var t=e.results[e.resultIndex],n=Object.values(t).map(function(e){return{confidence:e.confidence,text:e.transcript}});X({finalTranscriptions:t.isFinal,status:"recording",transcriptions:n}),$(n,t.isFinal)}}function te(){J=!1,clearTimeout(G),N&&Z(),X()}function ne(e){X({error:e.error,status:"error"}),N&&Z()}function re(e){var t,n,r,i,o,s=I({},K,{},e);n=(t=s).lang,r=t.interimResults,i=t.maxAlternatives,o=window.SpeechRecognition||window.webkitSpeechRecognition,(w=new o).continuous=!1,w.lang=n,w.interimResults=r,w.maxAlternatives=i,w.onstart=Y,w.onresult=ee,w.onerror=ne,w.onend=te,W=e.onUserSpeech,N=e.onUserSpeak}function ie(){N&&((S=new v({onVolumeChange:function(e){N(e)}})).start(),N(0)),W&&function(){if(!J){X({status:"starting"});try{w.start(),J=!0}catch(e){console.error(e)}}}()}function oe(){N&&Z(),W&&(N&&Z(),J=!1,clearTimeout(G),X())}var se,ae=navigator.language||navigator.userLanguage||"en-US";t.default={init:function(e){var t=e.continuesRecognition,n=void 0===t||t,o=e.lang,s=void 0===o?ae:o,a=e.onUserSpeech,c=e.onUserSpeak;return se&&se.stop&&se.stop(),(se=n?r:i).init({lang:s,onUserSpeech:a,onUserSpeak:c}),{start:se.start,stop:se.stop}}}}])});
//# sourceMappingURL=web_speech_recognizer.js.map

/***/ }),

/***/ "./resources/js/schedule_celebration/speech_recognize.js":
/*!***************************************************************!*\
  !*** ./resources/js/schedule_celebration/speech_recognize.js ***!
  \***************************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var web_speech_recognizer__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! web-speech-recognizer */ "./node_modules/web-speech-recognizer/dist/web_speech_recognizer.js");
/* harmony import */ var web_speech_recognizer__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(web_speech_recognizer__WEBPACK_IMPORTED_MODULE_0__);

/* 
const speechRecognizer = WebSpeechRecognizer.init({
  lang: 'pt-BR',
  continuesRecognition: true,
  onUserSpeech: (recognition) => {
    console.log('Speech recognition', recognition)
  },
  onUserSpeak: (volume) => {
    console.log('Speak volume', volume)
  }
});
*/

var speakBtn = document.querySelector('#btn_speech');
var resultSpeaker = document.querySelector('#results_speak');

if (window.SpeechRecognition || window.webkitSpeechRecognition) {
  var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition;
  var myRecognition = new SpeechRecognition();
  myRecognition.lang = 'pt-BR';
  speakBtn.addEventListener('click', function () {
    try {
      myRecognition.start();
      resultSpeaker.innerHTML = "Estou te ouvindo!";
    } catch (erro) {
      alert('erro:' + erro.message);
    }
  }, false);
  myRecognition.addEventListener('result', function (evt) {
    var resultSpeak = evt.results[0][0].transcript;
    console.log(resultSpeak);
    resultSpeaker.innerHTML = resultSpeak;

    switch (resultSpeak.toLowerCase()) {
      case 'clarear':
        document.body.style.backgroundColor = '#33cc99';
        break;

      case 'escurecer':
        document.body.style.backgroundColor = '#047751';
        break;

      case 'meu site':
        window.location.href = 'https://www.jetersonlordano.com.br';
        break;
    }

    if (resultSpeak.match(/buscar por/)) {
      resultSpeaker.innerHTML = 'Redirecionando...';
      setTimeout(function () {
        var resultado = resultSpeak.split('buscar por');
        window.location.href = 'https://www.google.com.br/search?q=' + resultado[1];
      }, 2000);
    }
  }, false);
  myRecognition.addEventListener('error', function (evt) {
    resultSpeaker.innerHTML = 'Se você disse alguma coisa, não ouvi muito bem!';
  }, false);
} else {
  resultSpeaker.innerHTML = 'Seu navegador não suporta tanta tecnoligia!';
}

/***/ }),

/***/ 11:
/*!*********************************************************************!*\
  !*** multi ./resources/js/schedule_celebration/speech_recognize.js ***!
  \*********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\sgp\resources\js\schedule_celebration\speech_recognize.js */"./resources/js/schedule_celebration/speech_recognize.js");


/***/ })

/******/ });