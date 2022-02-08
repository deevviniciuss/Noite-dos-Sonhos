window.AFFWP=window.AFFWP||{},window.AFFWP.portal=window.AFFWP.portal||{},window.AFFWP.portal.portalForm=function(t){var e={};function n(r){if(e[r])return e[r].exports;var i=e[r]={i:r,l:!1,exports:{}};return t[r].call(i.exports,i,i.exports,n),i.l=!0,i.exports}return n.m=t,n.c=e,n.d=function(t,e,r){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:r})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var i in t)n.d(r,i,function(e){return t[e]}.bind(null,i));return r},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="",n(n.s=41)}({0:function(t,e){!function(){t.exports=this.regeneratorRuntime}()},2:function(t,e){function n(t,e,n,r,i,o,s){try{var a=t[o](s),u=a.value}catch(t){return void n(t)}a.done?e(u):Promise.resolve(u).then(r,i)}t.exports=function(t){return function(){var e=this,r=arguments;return new Promise((function(i,o){var s=t.apply(e,r);function a(t){n(s,i,o,a,u,"next",t)}function u(t){n(s,i,o,a,u,"throw",t)}a(void 0)}))}}},21:function(t,e){!function(){t.exports=this.AFFWP.portal.alpineForm}()},3:function(t,e,n){"use strict";function r(t){return new Promise((function(e){return setTimeout(e,t)}))}function i(t){return"string"!=typeof t||t.endsWith("/")?t:"".concat(t,"/")}n.d(e,"a",(function(){return r})),n.d(e,"b",(function(){return i}))},4:function(t,e){t.exports=function(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}},41:function(t,e,n){"use strict";n.r(e);var r=n(0),i=n.n(r),o=n(2),s=n.n(o),a=n(4),u=n.n(a),c=n(21),f=n.n(c),d=n(3),l=n(5);function p(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,r)}return n}function v(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?p(Object(n),!0).forEach((function(e){u()(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):p(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}e.default=function(t){return v(v({},f.a),{sectionId:t,isLoading:!0,isValidating:!1,isSubmitting:!1,showingSuccessMessage:!1,exportFields:function(){return this.fields.reduce((function(t,e){return t[e.id]=e.value,t}),{})},hasValidations:function(t){var e=this.getField(t);return!1!==e&&!0===e.hasValidations},validateControl:function(t){var e=this;return s()(i.a.mark((function n(){var r,o;return i.a.wrap((function(n){for(;;)switch(n.prev=n.next){case 0:if(!1!==e.hasValidations(t)){n.next=2;break}return n.abrupt("return");case 2:return e.isValidating=!0,n.next=5,Object(l.validateControl)(t,e.exportFields());case 5:r=n.sent,o=r.validations.passed.map((function(t){return t.id})),e.removeErrors(o),e.addErrors(r.validations.failed),e.isValidating=!1;case 10:case"end":return n.stop()}}),n)})))()},setupSubmit:function(){return u()({},"x-bind:disabled",(function(){return this.hasErrors()||this.isLoading||this.isValidating||this.isSubmitting}))},setupField:function(t){var e,n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"",r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"",i=f.a.setupField.bind(this),o=i(t,n,r),s=o["x-on:input"].bind(this),a=["checkbox","select","radio"].includes(n),c=(e={},u()(e,"x-on:input",(function(e){var n=this;if(s(e),a)this.validateControl(t);else{var r=this.fields.findIndex((function(e){return e.id===t}));void 0!==this.fields[r].validating&&window.clearTimeout(this.fields[r].validating),this.isLoading=!0,this.fields[r].validating=window.setTimeout((function(){n.validateControl(t),delete n.fields[r].validating,n.isLoading=!1}),200)}})),u()(e,"x-on:blur",(function(){this.validateControl(t),this.isLoading=!1})),e);return v(v({},o),c)},submitForm:function(){var t=this;return s()(i.a.mark((function e(){var n;return i.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.isSubmitting=!0,e.next=3,Object(l.submitSection)(t.sectionId,t.exportFields());case 3:n=e.sent,t.removeErrors(n.validations.passed),t.addErrors(n.validations.failed),t.isSubmitting=!1,t.hasErrors()||t.flashSuccessMessage();case 8:case"end":return e.stop()}}),e)})))()},flashSuccessMessage:function(){var t=this;return s()(i.a.mark((function e(){return i.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.showingSuccessMessage=!0,e.next=3,Object(d.a)(1e3);case 3:t.showingSuccessMessage=!1;case 4:case"end":return e.stop()}}),e)})))()},setupForm:function(){return u()({},"x-on:submit",(function(t){var e=this;return s()(i.a.mark((function n(){return i.a.wrap((function(n){for(;;)switch(n.prev=n.next){case 0:t.preventDefault(),e.submitForm();case 2:case"end":return n.stop()}}),n)})))()}))},init:function(){var t=this;return s()(i.a.mark((function e(){var n;return i.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,Object(l.portalSectionFields)(t.sectionId);case 2:n=e.sent,t.fields=n.fields.map((function(t){return"checkbox"===t.type&&("on"===t.value&&(t.value=!0),"off"===t.value&&(t.value=!1)),t})),t.isLoading=!1;case 5:case"end":return e.stop()}}),e)})))()}})}},5:function(t,e){!function(){t.exports=this.AFFWP.portal.sdk}()}});