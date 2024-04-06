import{_ as ae,f as L,i as ne,r as K,o as p,g as $,w as C,c as x,b as e,t as o,d as R,n as y,h as B,j as ie,u as n,v as M,a as b,T as oe,l as Y,m as Z,p as G,e as _,q as le,y as re,s as ce,D as c,k as H,F as N,C as Q,G as ue,A as z,H as de}from"./app-BbZnQG7Y.js";import{u as P,b as ee,a as te}from"./notifier-BGaUWsto.js";import{_ as W}from"./TheBulkAction-DCumUWkp.js";import{_ as J}from"./ThePagination-Dq-IGcCv.js";import{u as X,a as pe,o as fe}from"./switch-DypvrI6H.js";const me={key:0,class:"plugin-deleted-tr inactive deleted"},ge={colspan:"5",class:"plugin-update colspanchange"},ye=["value","disabled"],he={class:"manage-column vertical-align:middle w:44"},_e={class:"vertical-align:middle rel w:3/10"},be={class:"flex align-items:center"},ve=["href"],ke={class:"invisible ml:4 .yabe-ukiyo-site-row:hover_{visible} fg:gray-60 font:normal"},we={class:"row-actions visible"},xe={class:"vertical-align:middle rel w:3/10"},$e={class:"flex align-items:center"},Se={__name:"TheSiteIndexRow",props:{item:{type:Object,required:!0}},emits:["delete","updateStatus"],setup(l,{emit:k}){const q=P(),I=l,h=L(()=>new Date(I.item.created_at*1e3)),D=k,w=ne("selectedItems");function U(i){i.code==="Space"&&(i.preventDefault(),D("updateStatus"))}return(i,s)=>{const v=K("font-awesome-icon");return p(),$(oe,{mode:"out-in"},{default:C(()=>[l.item.isDeleted?(p(),x("tr",me,[e("td",ge,[e("strong",null,o(l.item.title),1),R(" was successfully deleted. ")])])):(p(),x("tr",{key:1,class:y([{active:l.item.status,inactive:!l.item.status},"yabe-ukiyo-site-row"])},[e("th",{scope:"row",class:y([{"pl:6":!l.item.status},"vertical-align:middle py:8 yabe-ukiyo-check-column"])},[B(e("input",{"onUpdate:modelValue":s[0]||(s[0]=V=>ie(w)?w.value=V:null),type:"checkbox",value:l.item.id,disabled:n(q).isBusy,class:"ml:14"},null,8,ye),[[M,n(w)]])],2),e("td",he,[b(n(X),{"aria-disabled":n(q).isBusy,checked:l.item.status,onClick:s[1]||(s[1]=V=>i.$emit("updateStatus")),onKeyup:U,class:y([[l.item.status?"bg:sky-55":"opacity:.5 bg:gray-85"],"rel inline-flex p:0 h:24 w:44 flex-shrink:0 cursor:pointer rounded b:2 b:transparent transition-property:color,background-color,border-color,text-decoration-color,fill,stroke transition-duration:200 transition-timing-function:cubic-bezier(0.4,0,0.2,1) box-shadow:rgb(255,255,255)|0|0|0|2,rgb(14,165,233)|0|0|0|4,rgba(0,0,0,0)|0|0|0|0:focus outline:2|solid|transparent:focus"])},{default:C(()=>[e("span",{class:y([[l.item.status?"translateX(20)":"translateX(0)"],"pointer-events:none rel inline-block h:20 w:20 rounded bg:white transition-property:color,background-color,border-color,text-decoration-color,fill,stroke,opacity,box-shadow,transform,filter,backdrop-filter transition-duration:200 transition-timing-function:cubic-bezier(0.4,0,0.2,1) box-shadow:rgb(255,255,255)|0|0|0|0,rgba(59,130,246,0.5)|0|0|0|0,rgba(0,0,0,0.1)|0|1|3|0,rgba(0,0,0,0.1)|0|1|2|-1"])},[e("span",{"aria-hidden":"true",class:y([[l.item.status?"opacity:0 transition-timing-function:ease-out transition-duration:100":"opacity:1 transition-timing-function:ease-in transition-duration:200"],"abs inset:0 flex h:full w:full align-items:center justify-content:center tw-transition-opacity"])},[l.item.isUpdatingStatus?(p(),$(v,{key:1,icon:["fas","spinner"],class:"animation:rotate|linear|1s|infinite fg:gray-60"})):(p(),$(v,{key:0,icon:["fas","xmark"],class:"fg:gray-60"}))],2),e("span",{"aria-hidden":"true",class:y([[l.item.status?"opacity:1 transition-timing-function:ease-in transition-duration:200":"opacity:0 transition-timing-function:ease-out transition-duration:100"],"abs inset:0 flex h:full w:full align-items:center justify-content:center tw-transition-opacity"])},[l.item.isUpdatingStatus?(p(),$(v,{key:1,icon:["fas","spinner"],class:"animation:rotate|linear|1s|infinite fg:sky-55"})):(p(),$(v,{key:0,icon:["fas","check"],class:"fg:sky-55"}))],2)],2)]),_:1},8,["aria-disabled","checked","class"])]),e("td",_e,[e("div",be,[e("a",{"aria-disabled":"true",class:y([{"font:semibold":l.item.status},"rel"])},o(l.item.site_url),3),e("a",{href:l.item.site_url,target:"_blank",rel:"noopener noreferrer"},[b(v,{icon:["fas","up-right-from-square"],class:"font:11 mx:4 top:-1.5 absolute"})],8,ve),e("span",ke,"ID: "+o(l.item.id),1)]),e("div",we,[e("a",null,o(i.__("Edit","yabe-webfont")),1),R(" | "),e("a",{class:y([{"cursor:wait":n(q).isBusy},"fg:red-60 cursor:pointer fg:red-80:hover"]),onClick:s[2]||(s[2]=V=>i.$emit("delete"))},o(l.item.isDeleting?"Deleting...":"Delete"),3)])]),e("td",xe,[e("div",$e,o(h.value.toISOString().split("T")[0]),1)])],2))]),_:1})}}},qe=ae(Se,[["__scopeId","data-v-b2ce61d9"]]),De={class:"tablenav top"},Ue={class:"tablenav-pages pb:12"},Ve={class:"displaying-num"},Ie=e("br",{class:"clear"},null,-1),Ae={class:"wp-list-table widefat table-auto min-w:100% plugins"},Be={class:"manage-column column-cb yabe-ukiyo-check-column px:8 vertical-align:middle"},Te=e("td",{class:"manage-column w:44"},null,-1),Ce={scope:"col",class:"w:3/4"},Re={scope:"col"},Ee={key:0},Ne={key:1},je={class:"inactive tw-animate-pulse animation:tw-pulse|cubic-bezier(0.4,0,0.6,1)|2s|infinite"},ze=e("th",{scope:"row",class:"py:8 vertical-align:middle yabe-ukiyo-check-column"},[e("input",{type:"checkbox",value:"0",class:"ml:14",disabled:""})],-1),Le={class:"manage-column vertical-align:middle w:44"},Me={class:"translateX(0) pointer-events:none rel inline-block h:20 w:20 rounded bg:white box-shadow:0|0"},Ke={"aria-hidden":"true",class:"abs inset:0 flex h:full w:full align-items:center justify-content:center opacity:1"},Pe={class:"w:3/10"},Xe=e("div",{class:"h:12 bg:slate-60 rounded w:3/4"},null,-1),Fe={class:"row-actions visible mt:4 align-items:center flex"},Oe={class:"px:4 cursor:pointer"},Ge={class:"px:4 fg:red-60 cursor:wait fg:red-80:hover"},He=e("td",{class:"w:3/10 align-items:center vertical-align:middle"},[e("div",{class:"h:12 bg:slate-60 rounded w:1/2"})],-1),Qe={key:2},We={colspan:"5"},Je={class:"manage-column column-cb yabe-ukiyo-check-column px:8 vertical-align:middle"},Ye=e("td",{class:"manage-column"},null,-1),Ze={scope:"col",class:"w:3/4"},et={scope:"col"},tt={class:"tablenav bottom"},st={class:"tablenav-pages"},at={class:"displaying-num"},nt=e("br",{class:"clear"},null,-1),it={__name:"Index",props:{licenseId:{type:Number,required:!0}},setup(l){const k=Y(),q=Z(),I=ee(),h=P(),D=te(),w=h.hasTask,U=l,i=G({page:k.query.page?Number(k.query.page):1,search:k.query.search||"",per_page:k.query.per_page?Number(k.query.per_page):20}),s=G({current_page:0,from:0,last_page:0,to:0,total_filtered:0,total_exists:0});function v(){q.push({name:"licenses.show",params:{id:U.licenseId},query:{...k.query,...i}})}const V=L(()=>m.value.length>0?m.value.length:1),m=_([]),S=_([]);le("selectedItems",S);const T=L({get(){if(m.value.length>0){let t=!0;for(const[a,d]of m.value.entries())if(S.value.includes(d.id)||(t=!1),!t)break;return t}return!1},set(t){const a=[];t&&m.value.forEach(d=>{a.push(d.id)}),S.value=a}});function r(){S.value=[]}const u=_("-1"),A=_([{key:"activate",label:"Activate"},{key:"deactivate",label:"Deactivate"},{key:"delete",label:"Delete"}]);function E(t){if(t!=="-1")switch(t){case"delete":confirm(c("Are you sure you want to delete the selected site(s)?","yabe-ukiyo"))&&(S.value.forEach(async a=>{const d=m.value.find(f=>f.id===a);O(d,!1)}),r());break;case"deactivate":confirm(c("Are you sure you want to deactivate the selected site(s)?","yabe-ukiyo"))&&(S.value.forEach(async a=>{const d=m.value.find(f=>f.id===a);j(d,!1)}),r());break;case"activate":confirm(c("Are you sure you want to activate the selected site(s)?","yabe-ukiyo"))&&(S.value.forEach(async a=>{const d=m.value.find(f=>f.id===a);j(d,!0)}),r());break}}function g(t){i.page=t,v()}function F(){h.add("sites.index:fetch-items"),I.request({method:"GET",url:`/admin/licenses/sites/${U.licenseId}`,params:{page:i.page,search:i.search,per_page:i.per_page}}).then(t=>t.data).then(t=>{m.value=t.data.map(a=>(a.isDeleted=!1,a.isDeleting=!1,a.isUpdatingStatus=!1,a)),s.total_exists=t.meta.total_exists,s.total_filtered=t.meta.total_filtered,s.current_page=t.meta.page,s.from=t.meta.from,s.to=t.meta.to,s.last_page=t.meta.total_pages}).catch(function(t){D.alert(t.message)}).finally(()=>{h.remove("sites.index:fetch-items"),r()})}re((t,a)=>{t.query.page!==a.query.page&&(i.page=t.query.page?Number(t.query.page):1),t.query.per_page!==a.query.per_page&&(i.per_page=t.query.per_page?Number(t.query.per_page):20),F()});function j(t,a=null){a!==t.status&&(h.add("sites.index:update-status"),t.isUpdatingStatus=!0,I.request({method:"PATCH",url:`/admin/sites/update-status/${t.id}`,data:{status:a!==null?a:!t.status}}).then(d=>d.data).then(d=>{t.status=d.status}).catch(function(d){D.alert(d.message)}).finally(()=>{t.isUpdatingStatus=!1,h.remove("sites.index:update-status")}))}function O(t,a=!0){a&&!confirm(c("Are you sure you want to delete this site?","yabe-ukiyo"))||(t.isDeleting=!0,h.add("sites.index:delete"),I.request({method:"POST",url:`/admin/sites/delete/${t.id}`}).then(d=>{t.isDeleted=!0}).catch(function(d){D.alert(d.message)}).finally(()=>{t.isDeleting=!1,h.remove("sites.index:delete")}))}return ce(()=>{F()}),(t,a)=>{const d=K("font-awesome-icon");return p(),x(N,null,[e("div",De,[b(W,{modelValue:u.value,"onUpdate:modelValue":a[0]||(a[0]=f=>u.value=f),actions:A.value,onBulkActions:E},null,8,["modelValue","actions"]),e("div",Ue,[e("span",Ve,o(`${s.total_filtered} ${n(c)("items","yabe-ukiyo")}`),1),s.last_page>1?(p(),$(J,{key:0,"is-enable-goto":!0,"current-page":s.current_page,"first-page":s.current_page-1>1,"previous-page":s.current_page>1,"next-page":s.current_page<s.last_page,"last-page":s.current_page+1<s.last_page,"total-page":s.last_page,onChangePage:g},null,8,["current-page","first-page","previous-page","next-page","last-page","total-page"])):H("",!0)]),Ie]),e("table",Ae,[e("thead",null,[e("tr",null,[e("td",Be,[B(e("input",{"onUpdate:modelValue":a[1]||(a[1]=f=>T.value=f),class:"ml:12",type:"checkbox"},null,512),[[M,T.value]])]),Te,e("th",Ce,o(n(c)("Site URL","yabe-ukiyo")),1),e("th",Re,o(n(c)("Registered","yabe-ukiyo")),1)])]),m.value.length>0&&!n(w)("sites.index:fetch-items")?(p(),x("tbody",Ee,[(p(!0),x(N,null,Q(m.value,f=>(p(),$(qe,{key:f.id,item:f,onDelete:se=>O(f),onUpdateStatus:se=>j(f,null)},null,8,["item","onDelete","onUpdateStatus"]))),128))])):n(w)("sites.index:fetch-items")?(p(),x("tbody",Ne,[(p(!0),x(N,null,Q(V.value,f=>(p(),x("tr",je,[ze,e("td",Le,[b(n(X),{checked:!1,class:"opacity:.5 bg:gray-20 rel inline-flex p:0 h:24 w:44 flex-shrink:0 cursor:pointer rounded b:2 b:transparent"},{default:C(()=>[e("span",Me,[e("span",Ke,[b(d,{icon:["fas","spinner"],class:"animation:rotate|linear|1s|infinite font:12 fg:gray-60"})])])]),_:1})]),e("td",Pe,[Xe,e("div",Fe,[e("a",Oe,o(n(c)("Edit","yabe-ukiyo")),1),R(" | "),e("a",Ge,o(n(c)("Delete","yabe-ukiyo")),1)])]),He]))),256))])):(p(),x("tbody",Qe,[e("tr",null,[e("td",We,o(n(c)("It looks like you don't have any sites.","yabe-ukiyo")),1)])])),e("tfoot",null,[e("tr",null,[e("td",Je,[B(e("input",{"onUpdate:modelValue":a[2]||(a[2]=f=>T.value=f),class:"ml:12",type:"checkbox"},null,512),[[M,T.value]])]),Ye,e("th",Ze,o(n(c)("Site URL","yabe-ukiyo")),1),e("th",et,o(n(c)("Registered","yabe-ukiyo")),1)])])]),e("div",tt,[b(W,{modelValue:u.value,"onUpdate:modelValue":a[3]||(a[3]=f=>u.value=f),actions:A.value,onBulkActions:E},null,8,["modelValue","actions"]),e("div",st,[e("span",at,o(`${s.total_filtered} ${n(c)("items","yabe-ukiyo")}`),1),s.last_page>1?(p(),$(J,{key:0,"current-page":s.current_page,"first-page":s.current_page-1>1,"previous-page":s.current_page>1,"next-page":s.current_page<s.last_page,"last-page":s.current_page+1<s.last_page,"total-page":s.last_page,onChangePage:g},null,8,["current-page","first-page","previous-page","next-page","last-page","total-page"])):H("",!0)]),nt])],64)}}},ot={class:"mr:8 font:24"},lt={class:"form-table",role:"presentation"},rt={scope:"row"},ct=e("span",{class:"fg:red-35"},"*",-1),ut={scope:"row"},dt=e("span",{class:"fg:red-35"},"*",-1),pt={class:"flex"},ft={class:"rel flex mr:8 align-items:center"},mt=["type"],gt=e("p",{class:"description"},null,-1),yt={scope:"row"},ht={scope:"row"},_t={class:"flex"},bt={scope:"row"},vt={class:"flex"},kt={scope:"row"},wt={class:"flex"},xt=["value"],$t={class:"mt:18"},St={class:"font:20"},At={__name:"Show",setup(l){const k=ee(),q=Y(),I=Z(),h=te(),D=P(),w=_(""),U=_(""),i=_(!0),s=_(null),v=_(null),V=_(null),m=_(!0),S=_({});async function T(){return D.add("licenses.edit:fetch-item"),k.request({method:"GET",url:`/admin/licenses/detail/${q.params.id}`}).then(r=>r.data).then(r=>{w.value=r.license_key,U.value=r.title,i.value=r.status,s.value=r.max_sites,r.expired_at&&(v.value=new Date(r.expired_at*1e3).toISOString().split("T")[0]),r.user&&(V.value={label:`${r.user.name} (${r.user.email})`,value:r.user.id}),S.value=r}).finally(()=>{D.remove("licenses.edit:fetch-item")})}return ue(()=>{let r=T();h.async(r,"License details loaded.",u=>{h.alert(u.response&&u.response.status===404?"License not found.":"Failed to load license details."),I.go(-1)},"Fetching license details...")}),(r,u)=>{var E;const A=K("font-awesome-icon");return p(),x(N,null,[e("span",ot,"» "+o(n(c)("Detail","yabe-ukiyo")),1),e("div",null,[e("table",lt,[e("tbody",null,[e("tr",null,[e("th",rt,[e("label",null,[R(o(n(c)("Title","yabe-ukiyo"))+" ",1),ct])]),e("td",null,[B(e("input",{type:"text",name:"title","onUpdate:modelValue":u[0]||(u[0]=g=>U.value=g),readonly:""},null,512),[[z,U.value,void 0,{trim:!0,lazy:!0}]])])]),e("tr",null,[e("th",ut,[e("label",null,[R(o(n(c)("License Key","yabe-ukiyo"))+" ",1),dt])]),e("td",null,[e("div",pt,[e("div",ft,[B(e("input",{type:m.value?"text":"password",name:"secret_license_key","onUpdate:modelValue":u[1]||(u[1]=g=>w.value=g),autocomplete:"current-password",class:"min-w:300 hide::-ms-reveal",readonly:""},null,8,mt),[[de,w.value]]),e("span",{onClick:u[2]||(u[2]=g=>m.value=!m.value),class:"flex align-items:center ml:-24 fg:gray-60 fg:gray-40:hover cursor:pointer"},[m.value?(p(),$(A,{key:1,icon:["fas","eye-slash"],class:"font:15"})):(p(),$(A,{key:0,icon:["fas","eye"],class:"font:15"}))])])]),gt])]),e("tr",null,[e("th",yt,[e("label",null,o(n(c)("Status","yabe-ukiyo")),1)]),e("td",null,[b(n(fe),{as:"div",class:"flex align-items:center"},{default:C(()=>[b(n(X),{modelValue:i.value,"onUpdate:modelValue":u[3]||(u[3]=g=>i.value=g),"aria-disabled":"true",class:y([[i.value?"bg:sky-60":"opacity:.5 bg:gray-20"],"rel inline-flex p:0 h:24 w:44 flex-shrink:0 cursor:pointer rounded b:2 b:transparent transition-property:color,background-color,border-color,text-decoration-color,fill,stroke transition-duration:200 transition-timing-function:cubic-bezier(0.4,0,0.2,1) box-shadow:rgb(255,255,255)|0|0|0|2,rgb(14,165,233)|0|0|0|4,rgba(0,0,0,0)|0|0|0|0:focus outline:2|solid|transparent:focus"])},{default:C(()=>[e("span",{class:y([[i.value?"translateX(20)":"translateX(0)"],"pointer-events:none rel inline-block font:12 h:20 w:20 rounded bg:white transition-property:color,background-color,border-color,text-decoration-color,fill,stroke,opacity,box-shadow,transform,filter,backdrop-filter transition-duration:200 transition-timing-function:cubic-bezier(0.4,0,0.2,1) box-shadow:rgb(255,255,255)|0|0|0|0,rgba(59,130,246,0.5)|0|0|0|0,rgba(0,0,0,0.1)|0|1|3|0,rgba(0,0,0,0.1)|0|1|2|-1"])},[e("span",{"aria-hidden":"true",class:y([[i.value?"opacity:0 transition-timing-function:ease-out transition-duration:100":"opacity:1 transition-timing-function:ease-in transition-duration:200"],"abs inset:0 flex h:full w:full align-items:center justify-content:center tw-transition-opacity"])},[b(A,{icon:["fas","xmark"],class:"fg:gray-60"})],2),e("span",{"aria-hidden":"true",class:y([[i.value?"opacity:1 transition-timing-function:ease-in transition-duration:200":"opacity:0 transition-timing-function:ease-out transition-duration:100"],"abs inset:0 flex h:full w:full align-items:center justify-content:center tw-transition-opacity"])},[b(A,{icon:["fas","check"],class:"fg:sky-60"})],2)],2)]),_:1},8,["modelValue","class"]),b(n(pe),{as:"span",class:y([[i.value?"fg:black":"fg:gray-60"],"ml:8 font:medium tw-cursor-pointer"])},{default:C(()=>[R(o(i.value?"enabled":"disabled"),1)]),_:1},8,["class"])]),_:1})])]),e("tr",null,[e("th",ht,[e("label",null,o(n(c)("Max activations","yabe-ukiyo")),1)]),e("td",null,[e("div",_t,[B(e("input",{type:"number","onUpdate:modelValue":u[4]||(u[4]=g=>s.value=g),min:"0",readonly:""},null,512),[[z,s.value]])])])]),e("tr",null,[e("th",bt,[e("label",null,o(n(c)("Expired at","yabe-ukiyo")),1)]),e("td",null,[e("div",vt,[B(e("input",{type:"date","onUpdate:modelValue":u[5]||(u[5]=g=>v.value=g),readonly:""},null,512),[[z,v.value]])])])]),e("tr",null,[e("th",kt,[e("label",null,o(n(c)("User","yabe-ukiyo")),1)]),e("td",null,[e("div",wt,[e("input",{type:"text",value:(E=V.value)==null?void 0:E.label,class:"min-w:300",readonly:""},null,8,xt)])])])])]),e("div",$t,[e("span",St,o(n(c)("Sites","yabe-ukiyo")),1),b(it,{"license-id":parseInt(n(q).params.id)},null,8,["license-id"])])])],64)}}};export{At as default};
