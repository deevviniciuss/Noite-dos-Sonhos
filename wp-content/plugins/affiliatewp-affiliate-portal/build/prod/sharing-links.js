window.AFFWP=window.AFFWP||{},window.AFFWP.portal=window.AFFWP.portal||{},window.AFFWP.portal.sharingLinks=function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}return n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=43)}({43:function(e,t,n){"use strict";n.r(t),t.default=function(){return{text:"",subject:"",body:"",twitterInit:function(){document.getElementById("referral-sharing-twitter").parentElement.classList.add("inline-block")},twitterReferralLink:function(){var e=AFFWP.portal.core.store.get("urlGeneratorUrls").generated.url,t="&text="+encodeURIComponent(this.text),n="https://twitter.com/intent/tweet?url="+encodeURIComponent(e)+t;return window.open(n,"twitterwindow","left=20,top=20,width=600,height=300,toolbar=0,resizable=1"),!1},facebookInit:function(){document.getElementById("referral-sharing-facebook").parentElement.classList.add("inline-block")},fbReferralLink:function(){var e=AFFWP.portal.core.store.get("urlGeneratorUrls").generated.url,t="https://www.facebook.com/sharer/sharer.php?u="+encodeURIComponent(e);return window.open(t,"facebookwindow","left=20,top=20,width=600,height=700,toolbar=0,resizable=1"),!1},emailInit:function(){document.getElementById("referral-sharing-email").parentElement.classList.add("inline-block")},emailReferralLink:function(e){e.preventDefault();var t="?subject="+encodeURIComponent(this.subject),n="&body="+encodeURIComponent(this.body)+" ",r=AFFWP.portal.core.store.get("urlGeneratorUrls").generated.url,o=document.getElementById("referral-sharing-email"),i="mailto:"+t+n+encodeURIComponent(r);window.open(i,"_self"),o.href=i,o.click(),o.href=""}}}}});