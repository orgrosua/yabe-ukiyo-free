import{N as u,e as d}from"./app-CMZRKKOv.js";import{c}from"./cloneDeep-Dnkf_cep.js";import{u as l,b as g,a as m}from"./notifier-gadloFR7.js";const S=u("setting",()=>{const e=l(),o=g(),s=m(),n=d({});async function a(){return e.add("setting.doPull"),await o.request({method:"GET",url:"/admin/settings/index"}).then(t=>{n.value=c(t.data.options)}).catch(t=>{s.alert(t.message)}).finally(()=>{e.remove("setting.doPull")})}async function i(){e.add("setting.doPush");const t=o.request({method:"POST",url:"/admin/settings/store",data:{options:n.value}}).catch(r=>{s.alert(r.message)}).finally(()=>{e.remove("setting.doPush")});s.async(t,"Setting saved.","Failed to save the setting.","Saving the setting changes...")}return{setting:n,doPull:a,doPush:i}});export{S as u};
