import{l as G,m as K,D as O,e as i,f as N,x as q,E as P,J as Y,K as j,r as H,o as T,c as X,b as e,t as c,u as a,d as S,h as V,A as C,G as J,g as A,a as v,w as D,n as y,F as W,H as Q,I as Z}from"./app-CMZRKKOv.js";import{d as ee}from"./debounce-XxfNuXcX.js";import{b as te,a as se,u as ae}from"./notifier-gadloFR7.js";import{__ as u}from"@wordpress/i18n";import{u as ne,a as le,o as oe}from"./switch-DTKM9ggX.js";import"./isObjectLike-mqpIr8Ea.js";import"./isSymbol-BpHlYMiq.js";const ie={class:"mr:8 font:24"},re={class:"form-table",role:"presentation"},ue={scope:"row"},ce=e("span",{class:"fg:red-35"},"*",-1),de={scope:"row"},fe=e("span",{class:"fg:red-35"},"*",-1),ve={class:"flex"},me={class:"rel flex mr:8 align-items:center"},pe=["type"],ye=e("span",{class:"text"},"Generate",-1),be=e("p",{class:"description"},' This value is compatible and can be used to fill the "Remote Templates Password" field. ',-1),he={scope:"row"},ge={scope:"row"},_e={class:"flex"},xe={scope:"row"},we={class:"flex"},ke={scope:"row"},Se={class:"flex"},Ve={class:"flex align-items:center"},De=["disabled"],qe={__name:"Edit",setup(Ue){const x=te(),F=G(),$=K(),b=se(),d=ae(),w=O(),m=i(""),h=i(""),o=i(!0),g=i(null),f=i(null),_=i(null),k=i(!0),r=i({}),U=i(!1),E=i([]),I=N(()=>E.value.map(t=>({label:`${t.name} (${t.email})`,value:parseInt(t.id)}))),M=ee((t,s)=>{t&&(s(!0),x.request({method:"GET",url:"/admin/licenses/search_user",params:{s:t}}).then(n=>{E.value=n.data.data}).catch(n=>{b.error(n)}).finally(()=>{s(!1)}))},200);async function L(){return d.add("licenses.edit:fetch-item"),x.request({method:"GET",url:`/admin/licenses/detail/${F.params.id}`}).then(t=>t.data).then(t=>{m.value=t.license_key,h.value=t.title,o.value=t.status,g.value=t.max_sites,t.expired_at&&(f.value=new Date(t.expired_at*1e3).toISOString().split("T")[0]),t.user&&(_.value={label:`${t.user.name} (${t.user.email})`,value:t.user.id}),r.value=t}).finally(()=>{d.remove("licenses.edit:fetch-item")})}q(f,(t,s)=>{t===""&&(f.value=null)});function R(t){var n;t.preventDefault(),d.add("license.edit:send-form");let s=x.request({method:"POST",url:`/admin/licenses/update/${r.value.id}`,data:{title:h.value,license_key:m.value,status:o.value,max_sites:g.value,expired_at:f.value,user_id:(n=_.value)==null?void 0:n.value}}).then(l=>{w.add({type:"success",message:"<p>License updated successfully.</p>"}),L()}).finally(()=>{d.remove("license.edit:send-form")});b.async(s,"License updated successfully.",void 0,"Updating license...")}function z(){confirm(u("Are you sure you want to delete the license?","yabe-ukiyo"))&&(U.value=!0,d.add("licenses.edit:delete"),x.request({method:"POST",url:`/admin/licenses/delete/${r.value.id}`}).then(t=>{$.push({name:"licenses.index"})}).catch(function(t){b.alert(t.message)}).finally(()=>{U.value=!1,d.remove("licenses.edit:delete")}))}const B=N(()=>{var t,s;return r.value?r.value.license_key!==m.value||r.value.title!==h.value||r.value.status!==o.value||r.value.max_sites!==g.value||((t=r.value.user)==null?void 0:t.id)!==((s=_.value)==null?void 0:s.value)||r.value.expired_at!==(f.value?Math.floor(new Date(f.value)/1e3):null):!1}),p=i(null);return q(B,(t,s)=>{t&&!p.value?p.value=w.add({type:"warning",message:"<p>You have unsaved changes.</p>"}):(w.remove(p.value),p.value=null)}),P(()=>{let t=L();b.async(t,"License details loaded.",s=>{b.alert(s.response&&s.response.status===404?"License not found.":"Failed to load license details."),$.go(-1)},"Fetching license details...")}),Y((t,s,n)=>{B.value&&!confirm(u("You have unsaved changes. Are you sure you want to leave?","yabe-ukiyo"))||n()}),window.onbeforeunload=function(t){if(B.value)return u("You have unsaved changes. Are you sure you want to leave?","yabe-ukiyo")},j(()=>{window.onbeforeunload=null,p.value&&w.remove(p.value)}),(t,s)=>{const n=H("font-awesome-icon");return T(),X(W,null,[e("span",ie,"» "+c(a(u)("Edit","yabe-ukiyo")),1),e("form",{onSubmit:R},[e("div",null,[e("table",re,[e("tbody",null,[e("tr",null,[e("th",ue,[e("label",null,[S(c(a(u)("Title","yabe-ukiyo"))+" ",1),ce])]),e("td",null,[V(e("input",{type:"text",name:"title","onUpdate:modelValue":s[0]||(s[0]=l=>h.value=l),required:""},null,512),[[C,h.value,void 0,{trim:!0,lazy:!0}]])])]),e("tr",null,[e("th",de,[e("label",null,[S(c(a(u)("License Key","yabe-ukiyo"))+" ",1),fe])]),e("td",null,[e("div",ve,[e("div",me,[V(e("input",{type:k.value?"text":"password",name:"secret_license_key","onUpdate:modelValue":s[1]||(s[1]=l=>m.value=l),autocomplete:"current-password",class:"min-w:300 hide::-ms-reveal",required:""},null,8,pe),[[J,m.value]]),e("span",{onClick:s[2]||(s[2]=l=>k.value=!k.value),class:"flex align-items:center ml:-24 fg:gray-60 fg:gray-40:hover cursor:pointer"},[k.value?(T(),A(n,{key:1,icon:["fas","eye-slash"],class:"font:15"})):(T(),A(n,{key:0,icon:["fas","eye"],class:"font:15"}))])]),e("div",{onClick:s[3]||(s[3]=l=>m.value=a(Q)()),class:"button flex align-items:center"},[v(n,{icon:["fas","shuffle"],class:"font:15 mr:6"}),ye])]),be])]),e("tr",null,[e("th",he,[e("label",null,c(a(u)("Status","yabe-ukiyo")),1)]),e("td",null,[v(a(oe),{as:"div",class:"flex align-items:center"},{default:D(()=>[v(a(ne),{modelValue:o.value,"onUpdate:modelValue":s[4]||(s[4]=l=>o.value=l),class:y([[o.value?"bg:sky-60":"opacity:.5 bg:gray-20"],"rel inline-flex p:0 h:24 w:44 flex-shrink:0 cursor:pointer rounded b:2 b:transparent transition-property:color,background-color,border-color,text-decoration-color,fill,stroke transition-duration:200 transition-timing-function:cubic-bezier(0.4,0,0.2,1) box-shadow:rgb(255,255,255)|0|0|0|2,rgb(14,165,233)|0|0|0|4,rgba(0,0,0,0)|0|0|0|0:focus outline:2|solid|transparent:focus"])},{default:D(()=>[e("span",{class:y([[o.value?"translateX(20)":"translateX(0)"],"pointer-events:none rel inline-block font:12 h:20 w:20 rounded bg:white transition-property:color,background-color,border-color,text-decoration-color,fill,stroke,opacity,box-shadow,transform,filter,backdrop-filter transition-duration:200 transition-timing-function:cubic-bezier(0.4,0,0.2,1) box-shadow:rgb(255,255,255)|0|0|0|0,rgba(59,130,246,0.5)|0|0|0|0,rgba(0,0,0,0.1)|0|1|3|0,rgba(0,0,0,0.1)|0|1|2|-1"])},[e("span",{"aria-hidden":"true",class:y([[o.value?"opacity:0 transition-timing-function:ease-out transition-duration:100":"opacity:1 transition-timing-function:ease-in transition-duration:200"],"abs inset:0 flex h:full w:full align-items:center justify-content:center tw-transition-opacity"])},[v(n,{icon:["fas","xmark"],class:"fg:gray-60"})],2),e("span",{"aria-hidden":"true",class:y([[o.value?"opacity:1 transition-timing-function:ease-in transition-duration:200":"opacity:0 transition-timing-function:ease-out transition-duration:100"],"abs inset:0 flex h:full w:full align-items:center justify-content:center tw-transition-opacity"])},[v(n,{icon:["fas","check"],class:"fg:sky-60"})],2)],2)]),_:1},8,["modelValue","class"]),v(a(le),{as:"span",class:y([[o.value?"fg:black":"fg:gray-60"],"ml:8 font:medium tw-cursor-pointer"])},{default:D(()=>[S(c(o.value?"enabled":"disabled"),1)]),_:1},8,["class"])]),_:1})])]),e("tr",null,[e("th",ge,[e("label",null,c(a(u)("Max activations","yabe-ukiyo")),1)]),e("td",null,[e("div",_e,[V(e("input",{type:"number","onUpdate:modelValue":s[5]||(s[5]=l=>g.value=l),min:"0"},null,512),[[C,g.value]])])])]),e("tr",null,[e("th",xe,[e("label",null,c(a(u)("Expired at","yabe-ukiyo")),1)]),e("td",null,[e("div",we,[V(e("input",{type:"date","onUpdate:modelValue":s[6]||(s[6]=l=>f.value=l)},null,512),[[C,f.value]])])])]),e("tr",null,[e("th",ke,[e("label",null,c(a(u)("User","yabe-ukiyo")),1)]),e("td",null,[e("div",Se,[v(a(Z),{modelValue:_.value,"onUpdate:modelValue":s[7]||(s[7]=l=>_.value=l),options:I.value,onSearch:a(M),filterable:!1,placeholder:"Choose user",class:"min-w:300"},{"no-options":D(()=>[S(" Search for a user... ")]),_:1},8,["modelValue","options","onSearch"])])])])])]),e("div",Ve,[e("button",{type:"submit",name:"save",id:"save",disabled:a(d).isBusy,class:"button button-primary button-large",value:"save"},"Save",8,De),e("a",{class:y([{"cursor:wait":a(d).isBusy},"ml:12 fg:red-40 text:underline cursor:pointer fg:red-30:hover"]),onClick:z},c(U.value?"Deleting...":"Delete"),3)])])],32)],64)}}};export{qe as default};
