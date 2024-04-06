import{_ as se,e as S,f as L,i as ae,r as K,o as c,g as q,w as D,c as _,b as e,t as n,d as m,n as x,h as U,j as ne,u as a,v as H,a as g,T as ie,l as oe,m as le,p as G,q as re,s as ce,x as ue,y as de,z as me,k as z,A as pe,B as ge,F as P,C as Q,D as l}from"./app-BbZnQG7Y.js";import{u as Y,a as Z,b as fe}from"./notifier-BGaUWsto.js";import{_ as W}from"./TheBulkAction-DCumUWkp.js";import{_ as J}from"./ThePagination-Dq-IGcCv.js";import{u as ee}from"./switch-DypvrI6H.js";const ye={key:0,class:"plugin-deleted-tr inactive deleted"},he={colspan:"5",class:"plugin-update colspanchange"},_e=["value","disabled"],be={class:"manage-column vertical-align:middle w:44"},ve={class:"vertical-align:middle rel w:1/4"},ke={class:"flex align-items:center"},we={class:"invisible ml:4 .yabe-ukiyo-license-row:hover_{visible} fg:gray-60 font:normal"},xe={class:"row-actions visible"},$e={class:"vertical-align:middle rel w:1/4"},qe={class:"flex align-items:center"},De={class:"flex align-items:center"},Be=["href"],Se={class:"vertical-align:middle rel w:2/5"},Ue={class:"flex align-items:center"},Ae={class:"flex align-items:center fg:gray-60"},Ce={class:"vertical-align:middle w:1/5"},Te={class:"flex align-items:center"},Ve={__name:"TheRemoteIndexRow",props:{item:{type:Object,required:!0}},emits:["delete","updateStatus"],setup(o,{emit:y}){const A=Y(),B=Z(),u=o,C=S(!1),T=L(()=>new Date(u.item.updated_at*1e3)),p=L(()=>C.value?u.item.license_key:u.item.license_key.replace(/./g,"●")),i=y,V=ae("selectedItems");function f(h){h.code==="Space"&&(h.preventDefault(),i("updateStatus"))}function v(){const h=btoa(`${u.item.remote_url}
${u.item.title}
${u.item.license_key}`);navigator.clipboard.writeText(h).then(()=>{B.success("Token copied to clipboard")},()=>{B.error("Failed to copy the Token to clipboard")})}return(h,b)=>{const k=K("font-awesome-icon"),I=K("router-link");return c(),q(ie,{mode:"out-in"},{default:D(()=>[o.item.isDeleted?(c(),_("tr",ye,[e("td",he,[e("strong",null,n(o.item.title),1),m(" was successfully deleted. ")])])):(c(),_("tr",{key:1,class:x([{active:o.item.status,inactive:!o.item.status},"yabe-ukiyo-license-row"])},[e("th",{scope:"row",class:x([{"pl:6":!o.item.status},"vertical-align:middle py:8 yabe-ukiyo-check-column"])},[U(e("input",{"onUpdate:modelValue":b[0]||(b[0]=$=>ne(V)?V.value=$:null),type:"checkbox",value:o.item.id,disabled:a(A).isBusy,class:"ml:14"},null,8,_e),[[H,a(V)]])],2),e("td",be,[g(a(ee),{"aria-disabled":a(A).isBusy,checked:o.item.status,onClick:b[1]||(b[1]=$=>h.$emit("updateStatus")),onKeyup:f,class:x([[o.item.status?"bg:sky-60":"opacity:.5 bg:gray-20"],"rel inline-flex p:0 h:24 w:44 flex-shrink:0 cursor:pointer rounded b:2 b:transparent transition-property:color,background-color,border-color,text-decoration-color,fill,stroke transition-duration:200 transition-timing-function:cubic-bezier(0.4,0,0.2,1) box-shadow:rgb(255,255,255)|0|0|0|2,rgb(14,165,233)|0|0|0|4,rgba(0,0,0,0)|0|0|0|0:focus outline:2|solid|transparent:focus"])},{default:D(()=>[e("span",{class:x([[o.item.status?"translateX(20)":"translateX(0)"],"pointer-events:none rel inline-block font:12 h:20 w:20 rounded bg:white transition-property:color,background-color,border-color,text-decoration-color,fill,stroke,opacity,box-shadow,transform,filter,backdrop-filter transition-duration:200 transition-timing-function:cubic-bezier(0.4,0,0.2,1) box-shadow:rgb(255,255,255)|0|0|0|0,rgba(59,130,246,0.5)|0|0|0|0,rgba(0,0,0,0.1)|0|1|3|0,rgba(0,0,0,0.1)|0|1|2|-1"])},[e("span",{"aria-hidden":"true",class:x([[o.item.status?"opacity:0 transition-timing-function:ease-out transition-duration:100":"opacity:1 transition-timing-function:ease-in transition-duration:200"],"abs inset:0 flex h:full w:full align-items:center justify-content:center tw-transition-opacity"])},[o.item.isUpdatingStatus?(c(),q(k,{key:1,icon:["fas","spinner"],class:"animation:rotate|linear|1s|infinite fg:gray-60"})):(c(),q(k,{key:0,icon:["fas","xmark"],class:"fg:gray-60"}))],2),e("span",{"aria-hidden":"true",class:x([[o.item.status?"opacity:1 transition-timing-function:ease-in transition-duration:200":"opacity:0 transition-timing-function:ease-out transition-duration:100"],"abs inset:0 flex h:full w:full align-items:center justify-content:center tw-transition-opacity"])},[o.item.isUpdatingStatus?(c(),q(k,{key:1,icon:["fas","spinner"],class:"animation:rotate|linear|1s|infinite fg:sky-60"})):(c(),q(k,{key:0,icon:["fas","check"],class:"fg:sky-60"}))],2)],2)]),_:1},8,["aria-disabled","checked","class"])]),e("td",ve,[e("div",ke,[g(I,{to:{name:"remotes.show",params:{id:o.item.id}},class:x({"font:semibold":o.item.status})},{default:D(()=>[m(n(o.item.title),1)]),_:1},8,["to","class"]),e("span",we,"ID: "+n(o.item.id),1)]),e("div",xe,[g(I,{to:{name:"remotes.edit",params:{id:o.item.id}}},{default:D(()=>[m(n(h.__("Edit","yabe-webfont")),1)]),_:1},8,["to"]),m(" | "),e("a",{class:x([{"cursor:wait":a(A).isBusy},"fg:red-60 cursor:pointer fg:red-80:hover"]),onClick:b[2]||(b[2]=$=>h.$emit("delete"))},n(o.item.isDeleting?"Deleting...":"Delete"),3)])]),e("td",$e,[e("div",qe,[m(n(o.item.site)+" ",1),e("div",De,[m(n(o.item.remote_url)+" ",1),e("a",{href:o.item.remote_url,target:"_blank",rel:"noopener noreferrer"},[g(k,{icon:["fas","up-right-from-square"],class:"font:11 mx:4 top:-1.5 absolute"})],8,Be)])])]),e("td",Se,[e("div",Ue,[m(n(o.item.site)+" ",1),e("div",Ae,[e("code",{onDblclick:b[3]||(b[3]=$=>C.value=!C.value),class:"fg:black"},n(p.value),33),g(k,{onClick:v,icon:["far","clipboard"],class:"pl:4 font:18 cursor:pointer"})])])]),e("td",Ce,[e("div",Te,n(T.value.toISOString().split("T")[0]),1)])],2))]),_:1})}}},Ie=se(Ve,[["__scopeId","data-v-3231fe5a"]]),Re={key:0,class:"subtitle"},Ne=["disabled"],Ee=e("hr",{class:"invisible m:0 mt:-2"},null,-1),Le={class:"subsubsub"},Ke={class:"all"},je={class:"count"},ze={class:"search-box rel"},Pe=["disabled"],He=["disabled"],Fe={class:"tablenav top"},Me={class:"tablenav-pages pb:12"},Oe={class:"displaying-num"},Xe=e("br",{class:"clear"},null,-1),Ge={class:"wp-list-table widefat table-auto min-w:100% plugins"},Qe={class:"manage-column column-cb yabe-ukiyo-check-column px:8 vertical-align:middle"},We=e("td",{class:"manage-column w:44"},null,-1),Je={scope:"col",class:"w:1/4"},Ye={scope:"col",class:"w:1/4"},Ze={scope:"col",class:"w:2/5"},et={scope:"col",class:"w:1/5"},tt={key:0},st={key:1},at={class:"inactive animation:tw-pulse|cubic-bezier(0.4,0,0.6,1)|2s|infinite"},nt=e("th",{scope:"row",class:"py:8 vertical-align:middle yabe-ukiyo-check-column"},[e("input",{type:"checkbox",value:"0",class:"ml:14",disabled:""})],-1),it={class:"manage-column vertical-align:middle w:44"},ot={class:"translateX(0) pointer-events:none rel inline-block h:20 w:20 rounded bg:white box-shadow:0|0"},lt={"aria-hidden":"true",class:"abs inset:0 flex h:full w:full align-items:center justify-content:center opacity:1"},rt={class:"w:1/4"},ct=e("div",{class:"h:12 bg:slate-60 rounded w:1/2"},null,-1),ut={class:"row-actions visible mt:4 align-items:center flex"},dt={class:"px:4 cursor:pointer"},mt={class:"px:4 fg:red-60 cursor:wait fg:red-80:hover"},pt=e("td",{class:"align-items:center vertical-align:middle w:1/4"},[e("div",{class:"h:12 bg:slate-60 rounded w:1/2"})],-1),gt=e("td",{class:"align-items:center vertical-align:middle w:2/5"},[e("div",{class:"h:12 bg:slate-60 rounded w:1/2"})],-1),ft=e("td",{class:"align-items:center vertical-align:middle w:full"},[e("div",{class:"h:12 bg:slate-60 rounded w:1/2"})],-1),yt={key:2},ht={colspan:"5"},_t={class:"manage-column column-cb yabe-ukiyo-check-column px:8 vertical-align:middle"},bt=e("td",{class:"manage-column w:44"},null,-1),vt={scope:"col",class:"w:1/4"},kt={scope:"col",class:"w:1/4"},wt={scope:"col",class:"w:2/5"},xt={scope:"col",class:"w:1/5"},$t={class:"tablenav bottom"},qt={class:"tablenav-pages"},Dt={class:"displaying-num"},Bt=e("br",{class:"clear"},null,-1),Vt={__name:"Index",setup(o){const y=oe(),A=le(),B=fe(),u=Y(),C=S(null),T=Z(),p=G({page:y.query.page?Number(y.query.page):1,search:y.query.search||"",per_page:y.query.per_page?Number(y.query.per_page):20}),i=G({current_page:0,from:0,last_page:0,to:0,total_filtered:0,total_exists:0}),V=L(()=>f.value.length>0?f.value.length:1),f=S([]),v=S([]);re("selectedItems",v);const h=u.hasTask;function b(){A.push({name:"remotes.index",query:{...y.query,...p}})}ce(()=>{u.reset(),$()}),ue(()=>p.search,(t,s)=>{t===""&&y.query.search.trim()!==t&&I(!0)});function k(t){p.page=t,b()}de((t,s)=>{t.query.page!==s.query.page&&(p.page=t.query.page?Number(t.query.page):1),t.query.per_page!==s.query.per_page&&(p.per_page=t.query.per_page?Number(t.query.per_page):20),$()});function I(t=!1){p.page=1,t&&(p.search=""),b()}function $(){u.add("remotes.index:fetch-items"),B.request({method:"GET",url:"/admin/remotes/index",params:{page:p.page,search:p.search,per_page:p.per_page}}).then(t=>t.data).then(t=>{f.value=t.data.map(s=>(s.isDeleted=!1,s.isDeleting=!1,s.isUpdatingStatus=!1,s)),i.total_exists=t.meta.total_exists,i.total_filtered=t.meta.total_filtered,i.current_page=t.meta.page,i.from=t.meta.from,i.to=t.meta.to,i.last_page=t.meta.total_pages,R()}).catch(function(t){T.alert(t.message)}).finally(()=>{u.remove("remotes.index:fetch-items"),R()})}function j(t,s=null){s!==t.status&&(u.add("remotes.index:update-status"),t.isUpdatingStatus=!0,B.request({method:"PATCH",url:`/admin/remotes/update-status/${t.id}`,data:{status:s!==null?s:!t.status}}).then(r=>r.data).then(r=>{t.status=r.status}).catch(function(r){T.alert(r.message)}).finally(()=>{t.isUpdatingStatus=!1,u.remove("remotes.index:update-status")}))}function F(t,s=!0){s&&!confirm(l("Are you sure you want to delete this remote?","yabe-ukiyo"))||(t.isDeleting=!0,u.add("remotes.index:delete"),B.request({method:"POST",url:`/admin/remotes/delete/${t.id}`}).then(r=>{t.isDeleted=!0}).catch(function(r){T.alert(r.message)}).finally(()=>{t.isDeleting=!1,u.remove("remotes.index:delete")}))}const N=L({get(){if(f.value.length>0){let t=!0;for(const[s,r]of f.value.entries())if(v.value.includes(r.id)||(t=!1),!t)break;return t}return!1},set(t){const s=[];t&&f.value.forEach(r=>{s.push(r.id)}),v.value=s}});function R(){v.value=[]}const E=S("-1"),M=S([{key:"activate",label:"Activate"},{key:"deactivate",label:"Deactivate"},{key:"delete",label:"Delete"}]);function O(t){if(t!=="-1")switch(t){case"delete":confirm(l("Are you sure you want to delete the selected remote(s)?","yabe-ukiyo"))&&(v.value.forEach(async s=>{const r=f.value.find(w=>w.id===s);F(r,!1)}),R());break;case"deactivate":confirm(l("Are you sure you want to deactivate the selected remote(s)?","yabe-ukiyo"))&&(v.value.forEach(async s=>{const r=f.value.find(w=>w.id===s);j(r,!1)}),R());break;case"activate":confirm(l("Are you sure you want to activate the selected remote(s)?","yabe-ukiyo"))&&(v.value.forEach(async s=>{const r=f.value.find(w=>w.id===s);j(r,!0)}),R());break}}return(t,s)=>{const r=K("router-link"),w=K("font-awesome-icon"),X=me("ripple");return c(),_(P,null,[g(r,{to:{name:"remotes.create"},class:"page-title-action"},{default:D(()=>[m(n(a(l)("Add New","yabe-ukiyo")),1)]),_:1},8,["to"]),a(y).query.search?(c(),_("span",Re,[m(n(a(l)("Search results for","yabe-ukiyo"))+": ",1),e("strong",null,n(a(y).query.search),1)])):z("",!0),U((c(),_("button",{type:"button",disabled:a(u).isBusy,onClick:$,class:"button float:right flex! align-items:center gap-x:5"},[m(n(a(l)("refresh","yabe-ukiyo"))+" ",1),g(w,{icon:["far","arrows-rotate"],class:x([{"animation:rotate|1s|infinite":a(u).isBusy&&a(h)("remotes.index:fetch-items")},"font:15"])},null,8,["class"])],8,Ne)),[[X]]),Ee,e("ul",Le,[e("li",Ke,[g(r,{to:{name:"remotes.index",query:{...a(y).query,page:1}},class:"current"},{default:D(()=>[m(n(a(l)("All","yabe-ukiyo"))+" ",1),e("span",je," ("+n(i.total_exists)+") ",1)]),_:1},8,["to"])])]),e("p",ze,[U(e("input",{type:"search",id:"searchInput",name:"s","onUpdate:modelValue":s[0]||(s[0]=d=>p.search=d),onKeyup:s[1]||(s[1]=ge(d=>t.$refs.searchBtn.click(),["enter"])),disabled:a(u).isBusy},null,40,Pe),[[pe,p.search,void 0,{trim:!0,lazy:!0}]]),U((c(),_("button",{type:"button",class:"button flex! align-items:center gap-x:5",disabled:a(u).isBusy,ref_key:"searchBtn",ref:C,onClick:s[2]||(s[2]=d=>I())},[m(n(a(l)("search","yabe-ukiyo"))+" ",1),g(w,{icon:["fas","magnifying-glass"],class:"font:15"})],8,He)),[[X]])]),e("div",Fe,[g(W,{modelValue:E.value,"onUpdate:modelValue":s[3]||(s[3]=d=>E.value=d),actions:M.value,onBulkActions:O},null,8,["modelValue","actions"]),e("div",Me,[e("span",Oe,n(`${i.total_filtered} ${a(l)("items","yabe-ukiyo")}`),1),i.last_page>1?(c(),q(J,{key:0,"is-enable-goto":!0,"current-page":i.current_page,"first-page":i.current_page-1>1,"previous-page":i.current_page>1,"next-page":i.current_page<i.last_page,"last-page":i.current_page+1<i.last_page,"total-page":i.last_page,onChangePage:k},null,8,["current-page","first-page","previous-page","next-page","last-page","total-page"])):z("",!0)]),Xe]),e("table",Ge,[e("thead",null,[e("tr",null,[e("td",Qe,[U(e("input",{"onUpdate:modelValue":s[4]||(s[4]=d=>N.value=d),class:"ml:12",type:"checkbox"},null,512),[[H,N.value]])]),We,e("th",Je,n(a(l)("Title","yabe-ukiyo")),1),e("th",Ye,n(a(l)("Host URL","yabe-ukiyo")),1),e("th",Ze,n(a(l)("License Key","yabe-ukiyo")),1),e("th",et,n(a(l)("Last Update","yabe-ukiyo")),1)])]),f.value.length>0&&!a(h)("remotes.index:fetch-items")?(c(),_("tbody",tt,[(c(!0),_(P,null,Q(f.value,d=>(c(),q(Ie,{key:d.id,item:d,onDelete:te=>F(d),onUpdateStatus:te=>j(d,null)},null,8,["item","onDelete","onUpdateStatus"]))),128))])):a(h)("remotes.index:fetch-items")?(c(),_("tbody",st,[(c(!0),_(P,null,Q(V.value,d=>(c(),_("tr",at,[nt,e("td",it,[g(a(ee),{checked:!1,class:"opacity:.5 bg:gray-85 rel inline-flex p:0 h:24 w:44 flex-shrink:0 cursor:pointer rounded b:2 b:transparent"},{default:D(()=>[e("span",ot,[e("span",lt,[g(w,{icon:["fas","spinner"],class:"animation:rotate|linear|1s|infinite font:12 fg:gray-60"})])])]),_:1})]),e("td",rt,[ct,e("div",ut,[e("a",dt,n(a(l)("Edit","yabe-ukiyo")),1),m(" | "),e("a",mt,n(a(l)("Delete","yabe-ukiyo")),1)])]),pt,gt,ft]))),256))])):(c(),_("tbody",yt,[e("tr",null,[e("td",ht,[m(n(a(l)("It looks like you don't have any remotes.","yabe-ukiyo"))+" ",1),g(r,{to:{name:"remotes.create"}},{default:D(()=>[m(n(a(l)("Perhaps you would like to add a new one?","yabe-ukiyo")),1)]),_:1},8,["to"])])])])),e("tfoot",null,[e("tr",null,[e("td",_t,[U(e("input",{"onUpdate:modelValue":s[5]||(s[5]=d=>N.value=d),class:"ml:12",type:"checkbox"},null,512),[[H,N.value]])]),bt,e("th",vt,n(a(l)("Title","yabe-ukiyo")),1),e("th",kt,n(a(l)("Host URL","yabe-ukiyo")),1),e("th",wt,n(a(l)("License Key","yabe-ukiyo")),1),e("th",xt,n(a(l)("Last Update","yabe-ukiyo")),1)])])]),e("div",$t,[g(W,{modelValue:E.value,"onUpdate:modelValue":s[6]||(s[6]=d=>E.value=d),actions:M.value,onBulkActions:O},null,8,["modelValue","actions"]),e("div",qt,[e("span",Dt,n(`${i.total_filtered} ${a(l)("items","yabe-ukiyo")}`),1),i.last_page>1?(c(),q(J,{key:0,"current-page":i.current_page,"first-page":i.current_page-1>1,"previous-page":i.current_page>1,"next-page":i.current_page<i.last_page,"last-page":i.current_page+1<i.last_page,"total-page":i.last_page,onChangePage:k},null,8,["current-page","first-page","previous-page","next-page","last-page","total-page"])):z("",!0)]),Bt])],64)}}};export{Vt as default};