"use strict";(self.webpackChunkyabe_ukiyo_src=self.webpackChunkyabe_ukiyo_src||[]).push([[658],{9967:(e,t,n)=>{n.r(t),n.d(t,{default:()=>$});n(3485),n(4978);var o=n(6440),r=n(1040),c=n(2811),a=n(7339),l=n(5390),i=n(9773),u=n(1900),s={class:"form-table",role:"presentation"},_={scope:"row"},m={for:"enable_integration"},p={class:""},d=["checked","value"],h={for:"enable_integration"},f={class:"description"},v={scope:"row"},w={for:"print_purchase_page"},y={class:""},b=["checked","value"],g={for:"print_purchase_page"},Z={class:"description"},S={scope:"row"},k={for:"print_receipt_email"},U={class:""},z=["checked","value"],C={for:"print_receipt_email"},V={class:"description"},T={scope:"row"},x={for:"payment_status_deactivate"},I={class:"description"},E={scope:"row"},P={for:"payment_status_activate"},W={class:"description"};const $={__name:"WooCommerce",setup:function(e){var t=(0,i.V)(),n=(0,u.Jk)(t).setting,$=["failed","on-hold","pending","processing","refunded","expired","pending-cancel","cancelled"],j=function(e){return!(0,l.Z)(n.value,"ecommerce.woocommerce.deactivate_when_payment_status",[]).includes(e)&&!(0,l.Z)(n.value,"ecommerce.woocommerce.revoke_when_payment_status",[]).includes(e)};return function(e,t){var i=(0,o.up)("VueSelect");return(0,o.wg)(),(0,o.iD)("table",s,[(0,o._)("tbody",null,[(0,o._)("tr",null,[(0,o._)("th",_,[(0,o._)("label",m,(0,r.zw)(e.__("Enable Integration","yabe-ukiyo")),1)]),(0,o._)("td",null,[(0,o._)("div",p,[(0,o._)("input",{type:"checkbox",name:"enable_integration",id:"enable_integration",checked:(0,c.SU)(l.Z)((0,c.SU)(n),"ecommerce.woocommerce.enable_integration",!1),value:(0,c.SU)(l.Z)((0,c.SU)(n),"ecommerce.woocommerce.enable_integration",!1),onInput:t[0]||(t[0]=function(e){var t;return(0,c.SU)(a.Z)((0,c.SU)(n),"ecommerce.woocommerce.enable_integration",!(null!==(t=(0,c.SU)(n))&&void 0!==t&&null!==(t=t.ecommerce)&&void 0!==t&&null!==(t=t.woocommerce)&&void 0!==t&&t.enable_integration))}),class:"mr:8"},null,40,d),(0,o._)("label",h,(0,r.zw)(e.__("To enable integration, please tick this box.","yabe-ukiyo")),1)]),(0,o._)("p",f,(0,r.zw)(e.__("The WooCommerce integration module will be loaded.","yabe-ukiyo")),1)])]),(0,o._)("tr",null,[(0,o._)("th",v,[(0,o._)("label",w,(0,r.zw)(e.__("Purchase Page","yabe-ukiyo")),1)]),(0,o._)("td",null,[(0,o._)("div",y,[(0,o._)("input",{type:"checkbox",name:"print_purchase_page",id:"print_purchase_page",checked:(0,c.SU)(l.Z)((0,c.SU)(n),"ecommerce.woocommerce.print_purchase_page",!1),value:(0,c.SU)(l.Z)((0,c.SU)(n),"ecommerce.woocommerce.print_purchase_page",!1),onInput:t[1]||(t[1]=function(e){var t;return(0,c.SU)(a.Z)((0,c.SU)(n),"ecommerce.woocommerce.print_purchase_page",!(null!==(t=(0,c.SU)(n))&&void 0!==t&&null!==(t=t.ecommerce)&&void 0!==t&&null!==(t=t.woocommerce)&&void 0!==t&&t.print_purchase_page))}),class:"mr:8"},null,40,b),(0,o._)("label",g,(0,r.zw)(e.__("License detail on the purchase page.","yabe-ukiyo")),1)]),(0,o._)("p",Z,(0,r.zw)(e.__("The license will be shown on the user's purchase history page.")),1)])]),(0,o._)("tr",null,[(0,o._)("th",S,[(0,o._)("label",k,(0,r.zw)(e.__("Receipt Email","yabe-ukiyo")),1)]),(0,o._)("td",null,[(0,o._)("div",U,[(0,o._)("input",{type:"checkbox",name:"print_receipt_email",id:"print_receipt_email",checked:(0,c.SU)(l.Z)((0,c.SU)(n),"ecommerce.woocommerce.print_receipt_email",!1),value:(0,c.SU)(l.Z)((0,c.SU)(n),"ecommerce.woocommerce.print_receipt_email",!1),onInput:t[2]||(t[2]=function(e){var t;return(0,c.SU)(a.Z)((0,c.SU)(n),"ecommerce.woocommerce.print_receipt_email",!(null!==(t=(0,c.SU)(n))&&void 0!==t&&null!==(t=t.ecommerce)&&void 0!==t&&null!==(t=t.woocommerce)&&void 0!==t&&t.print_receipt_email))}),class:"mr:8"},null,40,z),(0,o._)("label",C,(0,r.zw)(e.__("License detail on the receipt email.","yabe-ukiyo")),1)]),(0,o._)("p",V,(0,r.zw)(e.__("The license will be included in the receipt email for each successful purchase.")),1)])]),(0,o._)("tr",null,[(0,o._)("th",T,[(0,o._)("label",x,(0,r.zw)(e.__("Deactivate when Payment Status :","yabe-ukiyo")),1)]),(0,o._)("td",null,[(0,o.Wm)(i,{multiple:"",options:$,selectable:j,modelValue:(0,c.SU)(l.Z)((0,c.SU)(n),"ecommerce.woocommerce.deactivate_when_payment_status",[]),"onUpdate:modelValue":t[3]||(t[3]=function(e){return(0,c.SU)(a.Z)((0,c.SU)(n),"ecommerce.woocommerce.deactivate_when_payment_status",e)}),class:"w:25em"},null,8,["modelValue"]),(0,o._)("p",I,(0,r.zw)(e.__('The license will be deactivated when the payment status changes from "Completed" to the following status.',"yabe-ukiyo")),1)])]),(0,o._)("tr",null,[(0,o._)("th",E,[(0,o._)("label",P,(0,r.zw)(e.__("Revoke when Payment Status :","yabe-ukiyo")),1)]),(0,o._)("td",null,[(0,o.Wm)(i,{multiple:"",options:$,selectable:j,modelValue:(0,c.SU)(l.Z)((0,c.SU)(n),"ecommerce.woocommerce.revoke_when_payment_status",[]),"onUpdate:modelValue":t[4]||(t[4]=function(e){return(0,c.SU)(a.Z)((0,c.SU)(n),"ecommerce.woocommerce.revoke_when_payment_status",e)}),class:"w:25em"},null,8,["modelValue"]),(0,o._)("p",W,(0,r.zw)(e.__('The license will be revoked or deleted when the payment status changes from "Completed" to the following status.',"yabe-ukiyo")),1)])])])])}}}},1140:(e,t,n)=>{n.d(t,{Z:()=>b});var o=n(6052),r=n(8111),c=/\.|\[(?:[^[\]]*|(["'])(?:(?!\1)[^\\]|\\.)*?\1)\]/,a=/^\w*$/;const l=function(e,t){if((0,o.Z)(e))return!1;var n=typeof e;return!("number"!=n&&"symbol"!=n&&"boolean"!=n&&null!=e&&!(0,r.Z)(e))||(a.test(e)||!c.test(e)||null!=t&&e in Object(t))};var i=n(5440);function u(e,t){if("function"!=typeof e||null!=t&&"function"!=typeof t)throw new TypeError("Expected a function");var n=function(){var o=arguments,r=t?t.apply(this,o):o[0],c=n.cache;if(c.has(r))return c.get(r);var a=e.apply(this,o);return n.cache=c.set(r,a)||c,a};return n.cache=new(u.Cache||i.Z),n}u.Cache=i.Z;const s=u;var _=/[^.[\]]+|\[(?:(-?\d+(?:\.\d+)?)|(["'])((?:(?!\2)[^\\]|\\.)*?)\2)\]|(?=(?:\.|\[\])(?:\.|\[\]|$))/g,m=/\\(\\)?/g;const p=function(e){var t=s(e,(function(e){return 500===n.size&&n.clear(),e})),n=t.cache;return t}((function(e){var t=[];return 46===e.charCodeAt(0)&&t.push(""),e.replace(_,(function(e,n,o,r){t.push(o?r.replace(m,"$1"):n||e)})),t}));var d=n(6711);const h=function(e,t){for(var n=-1,o=null==e?0:e.length,r=Array(o);++n<o;)r[n]=t(e[n],n,e);return r};var f=d.Z?d.Z.prototype:void 0,v=f?f.toString:void 0;const w=function e(t){if("string"==typeof t)return t;if((0,o.Z)(t))return h(t,e)+"";if((0,r.Z)(t))return v?v.call(t):"";var n=t+"";return"0"==n&&1/t==-Infinity?"-0":n};const y=function(e){return null==e?"":w(e)};const b=function(e,t){return(0,o.Z)(e)?e:l(e,t)?[e]:p(y(e))}},3383:(e,t,n)=>{n.d(t,{Z:()=>r});var o=n(8111);const r=function(e){if("string"==typeof e||(0,o.Z)(e))return e;var t=e+"";return"0"==t&&1/e==-Infinity?"-0":t}},5390:(e,t,n)=>{n.d(t,{Z:()=>a});var o=n(1140),r=n(3383);const c=function(e,t){for(var n=0,c=(t=(0,o.Z)(t,e)).length;null!=e&&n<c;)e=e[(0,r.Z)(t[n++])];return n&&n==c?e:void 0};const a=function(e,t,n){var o=null==e?void 0:c(e,t);return void 0===o?n:o}},8111:(e,t,n)=>{n.d(t,{Z:()=>c});var o=n(9572),r=n(3795);const c=function(e){return"symbol"==typeof e||(0,r.Z)(e)&&"[object Symbol]"==(0,o.Z)(e)}},7339:(e,t,n)=>{n.d(t,{Z:()=>u});var o=n(1572),r=n(1140),c=n(9313),a=n(2433),l=n(3383);const i=function(e,t,n,i){if(!(0,a.Z)(e))return e;for(var u=-1,s=(t=(0,r.Z)(t,e)).length,_=s-1,m=e;null!=m&&++u<s;){var p=(0,l.Z)(t[u]),d=n;if("__proto__"===p||"constructor"===p||"prototype"===p)return e;if(u!=_){var h=m[p];void 0===(d=i?i(h,p,m):void 0)&&(d=(0,a.Z)(h)?h:(0,c.Z)(t[u+1])?[]:{})}(0,o.Z)(m,p,d),m=m[p]}return e};const u=function(e,t,n){return null==e?e:i(e,t,n)}}}]);