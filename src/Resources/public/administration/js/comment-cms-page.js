!function(e){function t(t){for(var n,r,a=t[0],i=t[1],c=0,s=[];c<a.length;c++)r=a[c],Object.prototype.hasOwnProperty.call(o,r)&&o[r]&&s.push(o[r][0]),o[r]=0;for(n in i)Object.prototype.hasOwnProperty.call(i,n)&&(e[n]=i[n]);for(u&&u(t);s.length;)s.shift()()}var n={},r={"comment-cms-page":0},o={"comment-cms-page":0};function a(t){if(n[t])return n[t].exports;var r=n[t]={i:t,l:!1,exports:{}};return e[t].call(r.exports,r,r.exports,a),r.l=!0,r.exports}a.e=function(e){var t=[];r[e]?t.push(r[e]):0!==r[e]&&{0:1,1:1}[e]&&t.push(r[e]=new Promise((function(t,n){for(var o="static/css/"+({}[e]||e)+".css",i=a.p+o,c=document.getElementsByTagName("link"),s=0;s<c.length;s++){var u=(m=c[s]).getAttribute("data-href")||m.getAttribute("href");if("stylesheet"===m.rel&&(u===o||u===i))return t()}var l=document.getElementsByTagName("style");for(s=0;s<l.length;s++){var m;if((u=(m=l[s]).getAttribute("data-href"))===o||u===i)return t()}var f=document.createElement("link");f.rel="stylesheet",f.type="text/css";f.onerror=f.onload=function(o){if(f.onerror=f.onload=null,"load"===o.type)t();else{var a=o&&("load"===o.type?"missing":o.type),c=o&&o.target&&o.target.href||i,s=new Error("Loading CSS chunk "+e+" failed.\n("+c+")");s.code="CSS_CHUNK_LOAD_FAILED",s.type=a,s.request=c,delete r[e],f.parentNode.removeChild(f),n(s)}},f.href=i,document.head.appendChild(f)})).then((function(){r[e]=0})));var n=o[e];if(0!==n)if(n)t.push(n[2]);else{var i=new Promise((function(t,r){n=o[e]=[t,r]}));t.push(n[2]=i);var c,s=document.createElement("script");s.charset="utf-8",s.timeout=120,a.nc&&s.setAttribute("nonce",a.nc),s.src=function(e){return a.p+"static/js/"+({}[e]||e)+".js"}(e);var u=new Error;c=function(t){s.onerror=s.onload=null,clearTimeout(l);var n=o[e];if(0!==n){if(n){var r=t&&("load"===t.type?"missing":t.type),a=t&&t.target&&t.target.src;u.message="Loading chunk "+e+" failed.\n("+r+": "+a+")",u.name="ChunkLoadError",u.type=r,u.request=a,n[1](u)}o[e]=void 0}};var l=setTimeout((function(){c({type:"timeout",target:s})}),12e4);s.onerror=s.onload=c,document.head.appendChild(s)}return Promise.all(t)},a.m=e,a.c=n,a.d=function(e,t,n){a.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},a.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},a.t=function(e,t){if(1&t&&(e=a(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(a.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)a.d(n,r,function(t){return e[t]}.bind(null,r));return n},a.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return a.d(t,"a",t),t},a.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},a.p=(window.__sw__.assetPath + '/bundles/commentcmspage/'),a.oe=function(e){throw console.error(e),e};var i=this["webpackJsonpPlugincomment-cms-page"]=this["webpackJsonpPlugincomment-cms-page"]||[],c=i.push.bind(i);i.push=t,i=i.slice();for(var s=0;s<i.length;s++)t(i[s]);var u=c;a(a.s="Mluj")}({Mluj:function(e,t,n){var r=Shopware,o=r.Service,a=r.Component;a.override("sw-category-detail-base",(function(){return n.e(2).then(n.bind(null,"ectu"))})),a.override("sw-flow-mail-send-modal",(function(){return n.e(3).then(n.bind(null,"MkaU"))})),a.register("sw-cms-el-component-comments",(function(){return n.e(0).then(n.bind(null,"QOgP"))})),a.register("sw-cms-el-preview-comments",(function(){return n.e(1).then(n.bind(null,"2iiV"))})),o("cmsService").registerCmsElement({name:"comments",label:"sw-cms.elements.comments.label",component:"sw-cms-el-component-comments",previewComponent:"sw-cms-el-preview-comments",defaultConfig:{},defaultData:{comments:[{comment:"Lorem Ipsum",firstName:"John",lastName:"Doe",createdAt:new Date},{comment:"Lorem Ipsum",firstName:"John",lastName:"Doe",createdAt:new Date}]}})}});
//# sourceMappingURL=comment-cms-page.js.map