import{g as i,s as u}from"./get-D6nU50df.js";import{u as v}from"./setting-BqinFiiq.js";import{N as S,r as V,o as R,c as T,b as e,t as o,u as t,a as b,d as N,F as B}from"./app-DmP38fiz.js";import{a as D,b as P,u as C}from"./notifier-oDSeFarO.js";import"./cloneDeep-Dnkf_cep.js";import"./isObjectLike-mqpIr8Ea.js";import"./isSymbol-BpHlYMiq.js";const E={class:"form-table",role:"presentation"},I={scope:"row"},L={for:"enable_integration"},A={class:""},G=["checked","value"],M={for:"enable_integration"},$={class:"description"},q={scope:"row"},F={for:"print_purchase_page"},K={class:""},O=["checked","value"],U={for:"print_purchase_page"},W={class:"description"},j={scope:"row"},z={for:"print_receipt_email"},H={class:""},J=["checked","value"],Q={for:"print_receipt_email"},X={class:"description"},Y={scope:"row"},Z={for:"payment_status_deactivate"},x={class:"description"},ee={scope:"row"},te={for:"payment_status_activate"},se={class:"description"},oe=e("h3",null,"Misc.",-1),ae={class:"form-table",role:"presentation"},ne={scope:"row"},ie={for:"generate_missing_license_keys"},le={class:""},de=["disabled"],re={class:"description"},ce={scope:"row"},_e={for:"hard_reset"},ue={class:""},pe=["disabled"],me={class:"description mt:10"},ye={class:"bg:yellow-20 p:4"},he=e("b",null,"WARNING:",-1),Re={__name:"EasyDigitalDownloads",setup(ge){const w=v(),{setting:a}=S(w),p=D(),m=P(),c=C(),y=["abandoned","refunded","failed","pending","preapproved","processing","revoked","payment_deleted","item_removed"],h=s=>!i(a.value,"ecommerce.easydigitaldownloads.deactivate_when_payment_status",[]).includes(s)&&!i(a.value,"ecommerce.easydigitaldownloads.revoke_when_payment_status",[]).includes(s);function f(){if(!confirm("Are you sure you want to generate the missing license keys?"))return;c.add("settings.ecommerce.easy-digital-downloads:generate-missing-license");let s=m.request({method:"POST",url:"/ecommerce/easydigitaldownloads/generate-missing-license"}).then(n=>{}).finally(()=>{c.remove("settings.ecommerce.easy-digital-downloads:generate-missing-license")});p.async(s,"License keys generated successfully.",void 0,"Generating the missing license keys...")}function k(){if(!confirm("Are you sure you want to reset?"))return;c.add("settings.ecommerce.easy-digital-downloads:hard-reset");let s=m.request({method:"POST",url:"/ecommerce/easydigitaldownloads/hard-reset"}).then(n=>{}).finally(()=>{c.remove("settings.ecommerce.easy-digital-downloads:hard-reset")});p.async(s,"Reset successfully.",void 0,"Resetting...")}return(s,n)=>{const g=V("VueSelect");return R(),T(B,null,[e("table",E,[e("tbody",null,[e("tr",null,[e("th",I,[e("label",L,o(s.__("Enable Integration","yabe-ukiyo")),1)]),e("td",null,[e("div",A,[e("input",{type:"checkbox",name:"enable_integration",id:"enable_integration",checked:t(i)(t(a),"ecommerce.easydigitaldownloads.enable_integration",!1),value:t(i)(t(a),"ecommerce.easydigitaldownloads.enable_integration",!1),onInput:n[0]||(n[0]=_=>{var l,d,r;return t(u)(t(a),"ecommerce.easydigitaldownloads.enable_integration",!((r=(d=(l=t(a))==null?void 0:l.ecommerce)==null?void 0:d.easydigitaldownloads)!=null&&r.enable_integration))}),class:"mr:8"},null,40,G),e("label",M,o(s.__("To enable integration, please tick this box.","yabe-ukiyo")),1)]),e("p",$,o(s.__("The Easy Digital Downloads integration module will be loaded.","yabe-ukiyo")),1)])]),e("tr",null,[e("th",q,[e("label",F,o(s.__("Purchase Page","yabe-ukiyo")),1)]),e("td",null,[e("div",K,[e("input",{type:"checkbox",name:"print_purchase_page",id:"print_purchase_page",checked:t(i)(t(a),"ecommerce.easydigitaldownloads.print_purchase_page",!1),value:t(i)(t(a),"ecommerce.easydigitaldownloads.print_purchase_page",!1),onInput:n[1]||(n[1]=_=>{var l,d,r;return t(u)(t(a),"ecommerce.easydigitaldownloads.print_purchase_page",!((r=(d=(l=t(a))==null?void 0:l.ecommerce)==null?void 0:d.easydigitaldownloads)!=null&&r.print_purchase_page))}),class:"mr:8"},null,40,O),e("label",U,o(s.__("License detail on the purchase page.","yabe-ukiyo")),1)]),e("p",W,o(s.__("The license will be shown on the user's purchase history page.")),1)])]),e("tr",null,[e("th",j,[e("label",z,o(s.__("Receipt Email","yabe-ukiyo")),1)]),e("td",null,[e("div",H,[e("input",{type:"checkbox",name:"print_receipt_email",id:"print_receipt_email",checked:t(i)(t(a),"ecommerce.easydigitaldownloads.print_receipt_email",!1),value:t(i)(t(a),"ecommerce.easydigitaldownloads.print_receipt_email",!1),onInput:n[2]||(n[2]=_=>{var l,d,r;return t(u)(t(a),"ecommerce.easydigitaldownloads.print_receipt_email",!((r=(d=(l=t(a))==null?void 0:l.ecommerce)==null?void 0:d.easydigitaldownloads)!=null&&r.print_receipt_email))}),class:"mr:8"},null,40,J),e("label",Q,o(s.__("License detail on the receipt email.","yabe-ukiyo")),1)]),e("p",X,o(s.__("The license will be included in the receipt email for each successful purchase.")),1)])]),e("tr",null,[e("th",Y,[e("label",Z,o(s.__("Deactivate when Payment Status :","yabe-ukiyo")),1)]),e("td",null,[b(g,{multiple:"",options:y,selectable:h,modelValue:t(i)(t(a),"ecommerce.easydigitaldownloads.deactivate_when_payment_status",[]),"onUpdate:modelValue":n[3]||(n[3]=_=>t(u)(t(a),"ecommerce.easydigitaldownloads.deactivate_when_payment_status",_)),class:"w:25em"},null,8,["modelValue"]),e("p",x,o(s.__('The license will be deactivated when the payment status changes from "Completed" to the following status.',"yabe-ukiyo")),1)])]),e("tr",null,[e("th",ee,[e("label",te,o(s.__("Revoke when Payment Status :","yabe-ukiyo")),1)]),e("td",null,[b(g,{multiple:"",options:y,selectable:h,modelValue:t(i)(t(a),"ecommerce.easydigitaldownloads.revoke_when_payment_status",[]),"onUpdate:modelValue":n[4]||(n[4]=_=>t(u)(t(a),"ecommerce.easydigitaldownloads.revoke_when_payment_status",_)),class:"w:25em"},null,8,["modelValue"]),e("p",se,o(s.__('The license will be revoked or deleted when the payment status changes from "Completed" to the following status.',"yabe-ukiyo")),1)])])])]),oe,e("table",ae,[e("tbody",null,[e("tr",null,[e("th",ne,[e("label",ie,o(s.__("Missing license","yabe-ukiyo")),1)]),e("td",null,[e("div",le,[e("button",{type:"button",onClick:f,disabled:t(c).isBusy,class:"button button-secondary"},o(s.__("Generate Missing License Keys","yabe-ukiyo")),9,de)]),e("p",re,o(s.__("Generate the missing license keys for each purchase that was made before the integration was enabled.","yabe-ukiyo")),1)])]),e("tr",null,[e("th",ce,[e("label",_e,o(s.__("Reset","yabe-ukiyo")),1)]),e("td",null,[e("div",ue,[e("button",{type:"button",onClick:k,disabled:t(c).isBusy,class:"button button-secondary"},"⚠️ "+o(s.__("Reset related database data","yabe-ukiyo"))+" ⚠️",9,pe)]),e("p",me,[e("span",ye,[he,N(" "+o(s.__("Reset the related database table for cleaner start","yabe-ukiyo")),1)])])])])])])],64)}}};export{Re as default};