import{i as p,M as I,a as _,b as x}from"./cloneDeep-Dnkf_cep.js";import{S as l,i as g}from"./isObjectLike-mqpIr8Ea.js";import{i as d}from"./isSymbol-BpHlYMiq.js";var C=/\.|\[(?:[^[\]]*|(["'])(?:(?!\1)[^\\]|\\.)*?\1)\]/,P=/^\w*$/;function M(r,n){if(p(r))return!1;var t=typeof r;return t=="number"||t=="symbol"||t=="boolean"||r==null||d(r)?!0:P.test(r)||!C.test(r)||n!=null&&r in Object(n)}var N="Expected a function";function h(r,n){if(typeof r!="function"||n!=null&&typeof n!="function")throw new TypeError(N);var t=function(){var e=arguments,i=n?n.apply(this,e):e[0],f=t.cache;if(f.has(i))return f.get(i);var o=r.apply(this,e);return t.cache=f.set(i,o)||f,o};return t.cache=new(h.Cache||I),t}h.Cache=I;var $=500;function w(r){var n=h(r,function(e){return t.size===$&&t.clear(),e}),t=n.cache;return n}var A=/[^.[\]]+|\[(?:(-?\d+(?:\.\d+)?)|(["'])((?:(?!\2)[^\\]|\\.)*?)\2)\]|(?=(?:\.|\[\])(?:\.|\[\]|$))/g,O=/\\(\\)?/g,z=w(function(r){var n=[];return r.charCodeAt(0)===46&&n.push(""),r.replace(A,function(t,e,i,f){n.push(i?f.replace(O,"$1"):e||t)}),n});function F(r,n){for(var t=-1,e=r==null?0:r.length,i=Array(e);++t<e;)i[t]=n(r[t],t,r);return i}var R=1/0,m=l?l.prototype:void 0,y=m?m.toString:void 0;function S(r){if(typeof r=="string")return r;if(p(r))return F(r,S)+"";if(d(r))return y?y.call(r):"";var n=r+"";return n=="0"&&1/r==-R?"-0":n}function K(r){return r==null?"":S(r)}function E(r,n){return p(r)?r:M(r,n)?[r]:z(K(r))}var X=1/0;function T(r){if(typeof r=="string"||d(r))return r;var n=r+"";return n=="0"&&1/r==-X?"-0":n}function Y(r,n,t,e){if(!g(r))return r;n=E(n,r);for(var i=-1,f=n.length,o=f-1,u=r;u!=null&&++i<f;){var s=T(n[i]),a=t;if(s==="__proto__"||s==="constructor"||s==="prototype")return r;if(i!=o){var c=u[s];a=e?e(c,s,u):void 0,a===void 0&&(a=g(c)?c:_(n[i+1])?[]:{})}x(u,s,a),u=u[s]}return r}function q(r,n,t){return r==null?r:Y(r,n,t)}function Z(r,n){n=E(n,r);for(var t=0,e=n.length;r!=null&&t<e;)r=r[T(n[t++])];return t&&t==e?r:void 0}function B(r,n,t){var e=r==null?void 0:Z(r,n);return e===void 0?t:e}export{B as g,q as s};
