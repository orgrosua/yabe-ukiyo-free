import{l as E,m as R,D as K,e as c,x as M,E as $,r as j,o as f,c as g,b as e,t as i,u as n,d as y,h,A as B,a as m,F as C,n as d,k as q,G as A,g as F,w}from"./app-CMZRKKOv.js";import{d as G}from"./debounce-XxfNuXcX.js";import{b as X,a as I,u as L}from"./notifier-gadloFR7.js";import{__ as l}from"@wordpress/i18n";import{u as O,a as P,o as W}from"./switch-DTKM9ggX.js";import"./isObjectLike-mqpIr8Ea.js";import"./isSymbol-BpHlYMiq.js";const Y={class:"mr:8 font:24"},H={class:"form-table",role:"presentation"},J={scope:"row"},Q=e("span",{class:"fg:red-35"},"*",-1),Z={scope:"row"},ee=e("span",{class:"fg:red-35"},"*",-1),te={key:0,class:"description"},ae={key:0},se={class:"font:semibold"},ne=e("br",null,null,-1),oe=e("span",{class:"font:semibold"},"Bricks: ",-1),le=e("br",null,null,-1),ie=e("span",{class:"font:semibold"},"Yabe Ukiyo: ",-1),re={scope:"row"},ue=e("span",{class:"fg:red-35"},"*",-1),ce={class:"flex"},de={class:"rel flex mr:8 align-items:center"},fe=["type"],me=e("p",{class:"description"},null,-1),ye={scope:"row"},xe={__name:"Show",props:{showSaveButton:{type:Boolean}},setup(pe){const x=X(),N=E(),U=R(),D=I(),S=L();K();const z=c({});c(!1);const p=c(!0),v=c(""),k=c(""),u=c(!0),b=c(""),V=c(null),_={status:null,connected:!1,yabeUkiyoDetected:!1,bricksDetected:!1},a=c({..._});M(b,G((s,t)=>{s!==t&&(a.value={..._},s!==""&&V.value.checkValidity()&&(a.value.status="loading",x.request({method:"POST",url:"/admin/settings/central_management/check-connection",data:{url:s.trim().replace(/\/$/,"")}}).then(r=>{r.status===200?(a.value={...a.value,status:!0,connected:!0},a.value.yabeUkiyoDetected=r.data.namespaces.find(o=>o==="yabe-ukiyo/v1")!==void 0,a.value.bricksDetected=r.data.namespaces.find(o=>o==="bricks/v1")!==void 0):a.value.status=!1}).catch(r=>{a.value={..._,status:!1}})))},100));async function T(){return S.add("settings.central_management.edit:fetch-item"),x.request({method:"GET",url:`/admin/settings/central_management/detail/${N.params.id}`}).then(s=>s.data).then(s=>{v.value=s.secret_key,k.value=s.title,u.value=s.status,b.value=s.url,z.value=s}).finally(()=>{S.remove("settings.central_management.edit:fetch-item")})}return $(()=>{let s=T();D.async(s,"Site details loaded.",t=>{D.alert(t.response&&t.response.status===404?"Site not found.":"Failed to load site details."),U.go(-1)},"Fetching site details...")}),(s,t)=>{const r=j("font-awesome-icon");return f(),g(C,null,[e("span",Y,"» "+i(n(l)("Edit","yabe-ukiyo")),1),e("form",{onSubmit:t[5]||(t[5]=(...o)=>s.sendForm&&s.sendForm(...o))},[e("div",null,[e("table",H,[e("tbody",null,[e("tr",null,[e("th",J,[e("label",null,[y(i(n(l)("Title","yabe-ukiyo"))+" ",1),Q])]),e("td",null,[h(e("input",{type:"text",name:"title","onUpdate:modelValue":t[0]||(t[0]=o=>k.value=o),readonly:""},null,512),[[B,k.value,void 0,{trim:!0,lazy:!0}]])])]),e("tr",null,[e("th",Z,[e("label",null,[y(i(n(l)("Site URL","yabe-ukiyo"))+" ",1),ee])]),e("td",null,[h(e("input",{type:"url",ref_key:"urlField",ref:V,name:"url","onUpdate:modelValue":t[1]||(t[1]=o=>b.value=o),readonly:""},null,512),[[B,b.value,void 0,{trim:!0,lazy:!0}]]),a.value.status!==null?(f(),g("p",te,[a.value.status==="loading"?(f(),g("span",ae,[m(r,{icon:["fas","spinner"],class:"mr:4 fg:gray-60 animation:rotate|linear|1s|infinite"}),y(" "+i(n(l)("Connecting","yabe-ukiyo"))+"... ",1)])):(f(),g(C,{key:1},[e("span",se,i(n(l)("Server","yabe-ukiyo"))+": ",1),e("span",{class:d(a.value.connected?"fg:green-50":"fg:red-40")},i(a.value.connected?n(l)("Connected","yabe-ukiyo"):n(l)("Failed to connect","yabe-ukiyo")),3),ne,oe,e("span",{class:d(a.value.bricksDetected?"fg:green-50":"fg:red-40")},i(a.value.bricksDetected?n(l)("Detected","yabe-ukiyo"):n(l)("Not detected","yabe-ukiyo")),3),le,ie,e("span",{class:d(a.value.yabeUkiyoDetected?"fg:green-50":"fg:yellow-60")},i(a.value.yabeUkiyoDetected?n(l)("Detected","yabe-ukiyo"):n(l)("Not detected","yabe-ukiyo")),3)],64))])):q("",!0)])]),e("tr",null,[e("th",re,[e("label",null,[y(i(n(l)("Secret Key","yabe-ukiyo"))+" ",1),ue])]),e("td",null,[e("div",ce,[e("div",de,[h(e("input",{type:p.value?"text":"password",name:"secret_key","onUpdate:modelValue":t[2]||(t[2]=o=>v.value=o),autocomplete:"current-password",class:"min-w:300 hide::-ms-reveal",readonly:""},null,8,fe),[[A,v.value]]),e("span",{onClick:t[3]||(t[3]=o=>p.value=!p.value),class:"flex align-items:center ml:-24 fg:gray-60 fg:gray-40:hover cursor:pointer"},[p.value?(f(),F(r,{key:1,icon:["fas","eye-slash"],class:"font:15"})):(f(),F(r,{key:0,icon:["fas","eye"],class:"font:15"}))])])]),me])]),e("tr",null,[e("th",ye,[e("label",null,i(n(l)("Status","yabe-ukiyo")),1)]),e("td",null,[m(n(W),{as:"div",class:"flex align-items:center"},{default:w(()=>[m(n(O),{modelValue:u.value,"onUpdate:modelValue":t[4]||(t[4]=o=>u.value=o),"aria-disabled":"true",class:d([[u.value?"bg:sky-60":"opacity:.5 bg:gray-20"],"rel inline-flex p:0 h:24 w:44 flex-shrink:0 cursor:pointer rounded b:2 b:transparent transition-property:color,background-color,border-color,text-decoration-color,fill,stroke transition-duration:200 transition-timing-function:cubic-bezier(0.4,0,0.2,1) box-shadow:rgb(255,255,255)|0|0|0|2,rgb(14,165,233)|0|0|0|4,rgba(0,0,0,0)|0|0|0|0:focus outline:2|solid|transparent:focus"])},{default:w(()=>[e("span",{class:d([[u.value?"translateX(20)":"translateX(0)"],"pointer-events:none rel inline-block font:12 h:20 w:20 rounded bg:white transition-property:color,background-color,border-color,text-decoration-color,fill,stroke,opacity,box-shadow,transform,filter,backdrop-filter transition-duration:200 transition-timing-function:cubic-bezier(0.4,0,0.2,1) box-shadow:rgb(255,255,255)|0|0|0|0,rgba(59,130,246,0.5)|0|0|0|0,rgba(0,0,0,0.1)|0|1|3|0,rgba(0,0,0,0.1)|0|1|2|-1"])},[e("span",{"aria-hidden":"true",class:d([[u.value?"opacity:0 transition-timing-function:ease-out transition-duration:100":"opacity:1 transition-timing-function:ease-in transition-duration:200"],"abs inset:0 flex h:full w:full align-items:center justify-content:center tw-transition-opacity"])},[m(r,{icon:["fas","xmark"],class:"fg:gray-60"})],2),e("span",{"aria-hidden":"true",class:d([[u.value?"opacity:1 transition-timing-function:ease-in transition-duration:200":"opacity:0 transition-timing-function:ease-out transition-duration:100"],"abs inset:0 flex h:full w:full align-items:center justify-content:center tw-transition-opacity"])},[m(r,{icon:["fas","check"],class:"fg:sky-60"})],2)],2)]),_:1},8,["modelValue","class"]),m(n(P),{as:"span",class:d([[u.value?"fg:black":"fg:gray-60"],"ml:8 font:medium tw-cursor-pointer"])},{default:w(()=>[y(i(u.value?"enabled":"disabled"),1)]),_:1},8,["class"])]),_:1})])])])])])],32)],64)}}};export{xe as default};
