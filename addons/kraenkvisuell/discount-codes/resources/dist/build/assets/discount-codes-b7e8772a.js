function d(a,e,i,f,o,r,_,c){var n=typeof a=="function"?a.options:a;e&&(n.render=e,n.staticRenderFns=i,n._compiled=!0),f&&(n.functional=!0),r&&(n._scopeId="data-v-"+r);var t;if(_?(t=function(s){s=s||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext,!s&&typeof __VUE_SSR_CONTEXT__<"u"&&(s=__VUE_SSR_CONTEXT__),o&&o.call(this,s),s&&s._registeredComponents&&s._registeredComponents.add(_)},n._ssrRegister=t):o&&(t=c?function(){o.call(this,(n.functional?this.parent:this).$root.$options.shadowRoot)}:o),t)if(n.functional){n._injectStyles=t;var v=n.render;n.render=function(p,u){return t.call(u),v(p,u)}}else{var l=n.beforeCreate;n.beforeCreate=l?[].concat(l,t):[t]}return{exports:a,options:n}}const m={mixins:[Fieldtype]};var h=function(){var e=this,i=e._self._c;return i("div")},g=[],$=d(m,h,g,!1,null,null,null,null);const C=$.exports,R={mixins:[IndexFieldtype],computed:{usedUp(){return this.value.allowed_usages?this.value.usages/this.value.allowed_usages>=1:!1}}};var U=function(){var e=this,i=e._self._c;return i("div",{class:{"text-green-500":!e.usedUp,"text-red-500":e.usedUp}},[e._v(" "+e._s(e.value.usages)+"/"+e._s(e.value.allowed_usages?e.value.allowed_usages:"∞")+" ")])},w=[],F=d(R,U,w,!1,null,null,null,null);const S=F.exports;Statamic.booting(()=>{Statamic.$components.register("discount_code_usages-fieldtype",C),Statamic.$components.register("discount_code_usages-fieldtype-index",S)});