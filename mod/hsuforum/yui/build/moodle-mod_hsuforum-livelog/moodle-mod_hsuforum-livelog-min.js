YUI.add("moodle-mod_hsuforum-livelog",function(i,t){function e(){e.superclass.constructor.apply(this,arguments)}e.NAME=t,e.ATTRS={logBox:{value:i.Node.create("<div></div>"),readOnly:!0},classNames:{value:"accesshide",validator:i.Lang.isString},logTemplate:{value:"<p></p>",validator:i.Lang.isString},ariaLive:{value:"polite",validator:i.Lang.isString},ariaRelevant:{value:"additions text",validator:i.Lang.isString},ariaAtomic:{value:"false",validator:i.Lang.isString}},i.extend(e,i.Widget,{renderUI:function(){this.get("contentBox").append(this.get("logBox")),this._updateAttributes()},bindUI:function(){this.after(["ariaLiveChange","ariaRelevantChange","ariaAtomicChange","classNamesChange"],this._updateAttributes,this)},logText:function(t){var e=i.Node.create(this.get("logTemplate"));e.set("text",t),this.logNode(e)},logNode:function(t){this.get("logBox").append(t),this.fire("logAdded",{},t)},_updateAttributes:function(){this.get("logBox").setAttribute("role","log").setAttribute("class",this.get("classNames")).setAttribute("aria-relevant",this.get("ariaRelevant")).setAttribute("aria-atomic",this.get("ariaAtomic")).setAttribute("aria-live",this.get("ariaLive"))}}),M.mod_hsuforum=M.mod_hsuforum||{},M.mod_hsuforum.LiveLog=e,M.mod_hsuforum.init_livelog=function(t){t=new e(t);return t.render(),t}},"@VERSION@",{requires:["widget"]});