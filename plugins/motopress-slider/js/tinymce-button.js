jQuery(function(e){mpslSliderList&&mpslSliderList.length&&"undefined"!==typeof tinymce&&"undefined"===typeof MPSL&&tinymce.PluginManager.add("mpslTinymceSliderList",function(c){var b=[],d=tinymce.activeEditor;mpslSliderList.forEach(function(a){b.push({text:a.title,value:a.shortcode})});c.addButton("mpsl_slider_list_btn",{type:"menubutton",text:mpslLang.title,icon:!1,menu:b,onselect:function(a){d.selection.setContent(a.control.settings.value)}})})});
