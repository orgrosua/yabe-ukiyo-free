import{e as y,x as f,z as v,o as s,c as n,h as u,u as r,d,b as c,A as B,k as x,t as m}from"./app-CMZRKKOv.js";import{u as h}from"./notifier-gadloFR7.js";const k={class:"pagination-links"},$=["disabled"],q=["disabled"],C={class:"paging-input mx:2"},N=["disabled","max"],w={class:"tablenav-paging-text mx:2"},E={class:"total-pages"},V=["disabled"],D=["disabled"],S={__name:"ThePagination",props:{isEnableGoto:{type:Boolean,default:!1,required:!1},firstPage:{type:Boolean,default:!1,required:!1},previousPage:{type:Boolean,default:!1,required:!1},nextPage:{type:Boolean,default:!1,required:!1},lastPage:{type:Boolean,default:!1,required:!1},totalPage:{type:Number,default:0,required:!1},currentPage:{type:Number,default:0,required:!1}},emits:["changePage"],setup(t,{emit:P}){const o=t,i=h(),p=P,g=y(o.currentPage);return f(g,(a,e)=>{a>0&&a<=o.totalPage&&a!==e&&a!==o.currentPage&&p("changePage",a)}),f(()=>o.currentPage,(a,e)=>{a!==e&&(g.value=o.currentPage)}),(a,e)=>{const b=v("ripple");return s(),n("span",k,[u((s(),n("button",{type:"button",disabled:r(i).isBusy||!t.firstPage,class:"tablenav-pages-navspan button mx:2",onClick:e[0]||(e[0]=l=>a.$emit("changePage",1))},[d(" « ")],8,$)),[[b]]),u((s(),n("button",{type:"button",disabled:r(i).isBusy||!t.previousPage,class:"tablenav-pages-navspan button mx:2",onClick:e[1]||(e[1]=l=>a.$emit("changePage",t.currentPage-1))},[d(" ‹ ")],8,q)),[[b]]),c("span",C,[t.isEnableGoto?u((s(),n("input",{key:0,"onUpdate:modelValue":e[2]||(e[2]=l=>g.value=l),class:"current-page tw-w-14",type:"number",disabled:r(i).isBusy,min:"1",max:t.totalPage},null,8,N)),[[B,g.value,void 0,{number:!0}]]):x("",!0),c("span",w,[d(m(t.isEnableGoto===!1?t.currentPage:"")+" of ",1),c("span",E,m(t.totalPage),1)])]),u((s(),n("button",{type:"button",disabled:r(i).isBusy||!t.nextPage,class:"next-page button mx:2",onClick:e[3]||(e[3]=l=>a.$emit("changePage",t.currentPage+1))},[d(" › ")],8,V)),[[b]]),u((s(),n("button",{type:"button",disabled:r(i).isBusy||!t.lastPage,class:"tablenav-pages-navspan button mx:2",onClick:e[4]||(e[4]=l=>a.$emit("changePage",t.totalPage))},[d(" » ")],8,D)),[[b]])])}}};export{S as _};
