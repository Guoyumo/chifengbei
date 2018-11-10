@extends('layouts.admin')

@section('content')

    <div class="menu_setting_box js_menuBox dn" style="display: block;">
    <div class="highlight_box border icon_wrap menu_setting_msg js_menustatus dn" id="menustatus_1" style="display: none;">
        <i class="icon icon icon_msg_small success"></i>
        <p class="title">菜单使用中</p>
        <p class="desc">可在手机查看菜单内容。若停用菜单，请<a href="/cgi-bin/plugindetails?t=service/profile&amp;pluginid=10007&amp;action=intro&amp;token=1849635325&amp;lang=zh_CN" class="js_closeMenu">点击这里</a></p>
    </div>
    <div class="highlight_box border icon_wrap menu_setting_msg js_menustatus dn" id="menustatus_2" style="display: none;">
        <i class="icon icon_msg_small info"></i>
        <p class="title">菜单编辑中</p>
        <p class="desc">菜单未发布，请确认菜单编辑完成后点击“保存并发布”同步到手机。若停用菜单，请<a href="/cgi-bin/plugindetails?t=service/profile&amp;pluginid=10007&amp;action=intro&amp;token=1849635325&amp;lang=zh_CN" class="js_closeMenu">点击这里</a></p>
    </div>
    <div class="highlight_box icon_wrap border menu_setting_msg js_menustatus dn" id="menustatus_3" style="display: none;">
        <i class="icon icon_msg_small waiting"></i>
        <p class="title">菜单已发布</p>
        <p class="desc"><span class="js_waitHour"></span>小时后可在手机查看菜单内容。若停用菜单，请<a href="/cgi-bin/plugindetails?t=service/profile&amp;pluginid=10007&amp;action=intro&amp;token=1849635325&amp;lang=zh_CN" class="js_closeMenu">点击这里</a></p>
    </div>
    <div class="highlight_box icon_wrap border icon_small menu_setting_msg js_menustatus dn" id="menustatus_4" style="display: none;">
        <i class="icon lock"></i>
        <p class="title">未开启自定义菜单</p>
        <p class="desc">通过编辑和发布自定义菜单来进行便携管理。若开启菜单，请<a href="/cgi-bin/plugindetails?t=service/profile&amp;pluginid=10007&amp;action=intro&amp;token=1849635325&amp;lang=zh_CN" class="js_closeMenu">点击这里</a></p>
    </div>
    <div class="highlight_box icon_wrap border icon_small menu_setting_msg js_menustatus dn" id="menustatus_5" style="display: none;">
        <i class="icon lock"></i>
        <p class="title">未开启自定义菜单</p>
        <p class="desc">由于开发者通过接口修改了菜单配置，当前菜单配置已失效并停用。你可以前往<a href="/advanced/advanced?action=dev&amp;t=advanced/dev&amp;token=1849635325&amp;lang=zh_CN">开发者中心</a>进行停用。</p>
    </div>
    <div class="highlight_box icon_wrap border menu_setting_msg js_menustatus dn" id="menustatus_6" style="display: none;">
        <i class="icon icon icon_msg_small success"></i>
        <p class="title">API版本菜单使用中</p>
        <p class="desc">该页面显示的菜单版本已失效。当前生效版本请调用API查看。若停用菜单，请<a href="/cgi-bin/plugindetails?t=service/profile&amp;pluginid=10007&amp;action=intro&amp;token=1849635325&amp;lang=zh_CN" class="js_closeMenu">点击这里</a></p>
    </div>
    <div class="highlight_box icon_wrap border menu_setting_msg js_menustatus dn" id="menustatus_7" style="display: none;">
        <i class="icon icon icon_msg_small success"></i>
        <p class="title">API版本/个性化菜单使用中</p>
        <p class="desc">该页面显示的菜单版本已失效。当前生效版本请调用API查看。若停用菜单，请<a href="/cgi-bin/plugindetails?t=service/profile&amp;pluginid=10007&amp;action=intro&amp;token=1849635325&amp;lang=zh_CN" class="js_closeMenu">点击这里</a></p>
    </div>
    <div class="highlight_box icon_wrap border menu_setting_msg js_menustatus dn" id="menustatus_8" style="display: none;">
        <i class="icon icon_msg_small waiting"></i>
        <p class="title">菜单已发布/个性化菜单使用中</p>
        <p class="desc"><span class="js_waitHour"></span>小时后可在手机查看菜单内容。当前生效的个性化菜单内容请调用API查看。若停用菜单，请<a href="/cgi-bin/plugindetails?t=service/profile&amp;pluginid=10007&amp;action=intro&amp;token=1849635325&amp;lang=zh_CN" class="js_closeMenu">点击这里</a></p>
    </div>
    <div class="highlight_box icon_wrap border menu_setting_msg js_menustatus dn" id="menustatus_9" style="display: none;">
        <i class="icon icon_msg_small info"></i>
        <p class="title">菜单编辑中/个性化菜单使用中</p>
        <p class="desc">菜单未发布，请确认菜单编辑完成后点击“保存并发布”同步到手机。当前生效的个性化菜单内容请调用API查看。若停用菜单，请<a href="/cgi-bin/plugindetails?t=service/profile&amp;pluginid=10007&amp;action=intro&amp;token=1849635325&amp;lang=zh_CN" class="js_closeMenu">点击这里</a></p>
    </div>
    <div class="highlight_box icon_wrap border menu_setting_msg js_menustatus dn" id="menustatus_10" style="display: none;">
        <i class="icon icon icon_msg_small success"></i>
        <p class="title">菜单使用中/个性化菜单使用中</p>
        <p class="desc">可在手机查看菜单内容，当前生效的个性化菜单内容请调用API查看。若停用菜单，请<a href="/cgi-bin/plugindetails?t=service/profile&amp;pluginid=10007&amp;action=intro&amp;token=1849635325&amp;lang=zh_CN" class="js_closeMenu">点击这里</a></p>
    </div>
    <div class="page_msg mini plugin_update_tips js_authorized" style="display:none;margin:-20px 30px 0 30px">
        <div class="inner group">
            <span class="msg_icon_wrp"><i class="icon_msg_mini info"></i></span>
            <div class="msg_content">
                <p>你已授权给<span class="js_auth_name"></span>帮助你运营公众号，点击管理<a href="/cgi-bin/component_unauthorize?action=list&amp;t=service/auth_plugins&amp;token=1849635325&amp;lang=zh_CN">已授权的第三方平台</a></p>
            </div>
        </div>
    </div>
    <div class="menu_setting_area js_editBox row">
        <div class="menu_preview_area col-md-4" style="margin:unset;">
            <div class="mobile_menu_preview">
                <div class="mobile_hd tc">
                    @{{ gzh_name }}
                </div>
                <div class="mobile_bd">
                    <ul class="pre_menu_list grid_line ui-sortable ui-sortable-disabled no_menu" style="z-index:3;" id="menuList">
                        <li v-for="(btn,index) in menu.button" :key="btn.id" class="jsMenu pre_menu_item grid_item jslevel1 size1of3 ui-sortable ui-sortable-disabled">
                                <a href="javascript:void(0);" @click="menu_selected(btn.name,index)" :class="[{pre_menu_link: index===activeMenuIndex && activeMenuType()==1}]" draggable="false">
                                <i class="icon_menu_dot js_icon_menu_dot dn"></i>
                                <i class="icon20_common sort_gray"></i>
                                <span class='js_l1Title'>@{{ btn.name }}</span>
                            </a>
                            <div class="sub_pre_menu_box js_l2TitleBox" v-if="index===activeMenuIndex">
                                <ul class="sub_pre_menu_list">
                                    <li v-for="(sub,index) in btn.sub_button" :key="sub.id" class='jslevel2'><a href="javascript:void(0);"  @click="menu_item_selected(sub.name,index)" :class="[{pre_menu_link: index===activeMenuItemIndex && activeMenuType()==2}]" class="jsSubView" draggable="false"><span class="sub_pre_menu_inner js_sub_pre_menu_inner"><i class="icon20_common sort_gray"></i><span class='js_l2Title'>@{{ sub.name }}</span></span></a></li>
                                    <li class='js_addMenuBox' v-if="isSet(menu.button[activeMenuIndex].sub_button)&&btn.sub_button.length>=0&&btn.sub_button.length<5"><a href="javascript:void(0);" class="jsSubView js_addL2Btn" title="最多添加5个子菜单" @click="menu_item_add()" draggable="false"><span class="sub_pre_menu_inner js_sub_pre_menu_inner"><i class="icon14_menu_add"></i></span></a></li>
                                </ul>
                                <i class="arrow arrow_out"></i>
                                <i class="arrow arrow_in"></i>
                            </div>
                        </li>
                        <li class="js_addMenuBox pre_menu_item grid_item no_extra size1of1"> <a href="javascript:void(0);" v-if="isSet(menu.button)?(menu.button.length>=0&&menu.button.length<3):false"  @click="menu_add()" :class="[{pre_menu_link: activeMenuIndex===''}]" class="js_addL1Btn" title="最多添加3个一级菜单" draggable="false"> <i class="icon14_menu_add"></i> <span class="js_addMenuTips">{{trans('admin.add_menu')}}</span></a> </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="menu_form_area col-md-8" style="margin:unset;">
            <div id="js_none" class="menu_initial_tips tips_global" style="display: none;"></div>
            <div id="js_rightBox" class="portable_editor to_left"  style="display: none;" v-show="activeMenuIndex > 0 || activeMenuIndex === 0 || activeMenuItemIndex > 0 || activeMenuIndex === 0 ">
                <div class="editor_inner">
                    <div class="global_mod float_layout menu_form_hd js_second_title_bar">
                        <h4 class="global_info"> {{trans('admin.menu_name')}} </h4>
                        <div class="global_extra">
                            <a href="javascript:void(0);" id="jsDelBt" @click="menu_del()" v-if="showDelBtnType===1">Delete Menu</a>
                            <a href="javascript:void(0);" id="jsDelBt" @click="menu_item_del()" v-if="showDelBtnType===2">Delete sub-menu</a>
                        </div>
                    </div>
                    <div class="menu_form_bd" id="view">
                        <div id="js_innerNone" style="display:none;" class="msg_sender_tips tips_global"></div>
                        <div class="frm_control_group js_setNameBox">
                            <label for="" class="frm_label"> <strong class="title js_menuTitle">{{trans('admin.menu_name')}}</strong> </label>
                            <div class="frm_controls">
                                <span class="frm_input_box with_counter counter_in append" v-if="activeMenuType() == 1 && isSet(menu.button[activeMenuIndex])"> <input type="text" class="frm_input js_menu_name" v-model="menu.button[activeMenuIndex].name" /> </span>
                                <span class="frm_input_box with_counter counter_in append" v-if="activeMenuType() == 2 && isSet(menu.button[activeMenuIndex].sub_button[activeMenuItemIndex])"> <input type="text" class="frm_input js_menu_name" v-model="menu.button[activeMenuIndex].sub_button[activeMenuItemIndex].name" /> </span>
                                <p class="frm_msg fail js_titleEorTips dn">字数超过上限</p>
                                <p class="frm_msg fail js_titlenoTips dn" style="display: none;">请输入菜单名称</p>
                                <p class="frm_tips js_titleNolTips">Can't more than 8 characters</p>
                            </div>
                        </div>
                        <div class="frm_control_group" v-show="((activeMenuIndex > 0 || activeMenuIndex === 0) && (menu.button[activeMenuIndex].sub_button.length == 0)) || (activeMenuItemIndex > 0 || activeMenuItemIndex === 0) " style="display: none;">
                            <label for="" class="frm_label"> <strong class="title js_menuContent">Menu Content</strong> </label>
                            <div class="frm_controls frm_vertical_pt">
                                <label class="frm_radio_label js_radio_sendMsg" @click="radio_label_selected(1)" :class="[{selected:showMenuContentType===1}]" data-editing="0"> <i class="icon_radio"></i> <span class="lbl_content">Send Message</span> <input type="radio" name="hello" class="frm_radio" /> </label>
                                <label class="frm_radio_label js_radio_url" @click="radio_label_selected(2)" :class="[{selected:showMenuContentType===2}]" data-editing="0"> <i class="icon_radio"></i> <span class="lbl_content">WEB Page</span> <input type="radio" name="hello" class="frm_radio" /> </label>
                            </div>
                        </div>
                        <div class="menu_content_container">
                            <div class="menu_content send jsMain" id="edit" v-show="showMenuContentType===1" style="display: none;">
                                <div class="msg_sender" id="editDiv">
                                    <div class="msg_tab">
                                        <div class="tab_navs_panel">
                                            <span class="tab_navs_switch_wrp switch_prev js_switch_prev"> <span class="tab_navs_switch"></span> </span>
                                            <span class="tab_navs_switch_wrp switch_next js_switch_next" style="display: none;"> <span class="tab_navs_switch"></span> </span>
                                            <div class="tab_navs_wrp" style="width: 650px">
                                                <ul class="tab_navs js_tab_navs" style="margin-left:0;">
                                                    <li class="tab_nav tab_appmsg width4" :class="[{selected:showMenuContentMsgType===1}]" data-type="10" data-tab=".js_appmsgArea" data-tooltip="图文消息"> <a href="javascript:void(0);" @click="content_msg_tab_nav(1)">&nbsp;<i class="icon_msg_sender"></i><span class="msg_tab_title">News</span></a> </li>
                                                    <li class="tab_nav tab_img width4" :class="[{selected:showMenuContentMsgType===2}]" data-type="2" data-tab=".js_imgArea" data-tooltip="图片"> <a href="javascript:void(0);" @click="content_msg_tab_nav(2)">&nbsp;<i class="icon_msg_sender"></i><span class="msg_tab_title">Image</span></a> </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="tab_panel">
                                        <span class="" v-if="activeMenuType() == 1 && isSet(menu.button[activeMenuIndex])">
                                        
                                            <div class="radio" v-show="showMenuContentMsgType===1" style="display: none;">
                                            <div v-for="article in articleList" class="col-md-12">
                                                <label>
                                                    <input type="radio" name="media_id" v-model="menu.button[activeMenuIndex].media_id" :value="article.media_id">@{{article.content[0].title}} 
                                                </label>
                                            </div>
                                            </div>
                                            <div class="radio" v-show="showMenuContentMsgType===2" style="display: none;">
					                        <div class="col-md-12"  v-for="image in imageList" v-show="!(image.name == 'CropImage')">
                                            <label>
                                                <input type="radio" v-if="!(image.name == 'CropImage')" name="media_id"  v-model="menu.button[activeMenuIndex].media_id"      :value="image.media_id">@{{image.name}}
                                            
					                        </label>
					                        </div>
                                            </div>
                                        </span>
                                        <span class="" v-if="activeMenuType() == 2 && isSet(menu.button[activeMenuIndex].sub_button[activeMenuItemIndex])"> 
                                            <div class="radio" v-show="showMenuContentMsgType===1" style="display: none;">
                                            <div v-for="article in articleList" class="col-md-12">
                                                <label>
                                                    <input type="radio" name="media_id" v-model="menu.button[activeMenuIndex].sub_button[activeMenuItemIndex].media_id"  :value="article.media_id">@{{article.content[0].title}} 
                                                </label>
                                            </div>
                                            </div>
                                            <div class="radio" v-show="showMenuContentMsgType===2" style="display: none;">
						<div class="col-md-12"  v-for="image in imageList" v-show="!(image.name == 'CropImage')">
                                            <label>
                                                <input type="radio" v-if="!(image.name == 'CropImage')" name="media_id"  v-model="menu.button[activeMenuIndex].sub_button[activeMenuItemIndex].media_id"      :value="image.media_id">@{{image.name}}
                                           
						 </label>
						 </div>
                                            </div>
                                        </span>
                                        </div>
                                    </div>
                <b-pagination align="right" v-if="showImage" :total-rows="{{$image_count}}"  v-model="imageCurrentPage" :per-page="20">
                </b-pagination> 
                <b-pagination align="right" v-if="showArticle" :total-rows="{{$news_count}}"  v-model="articleCurrentPage" :per-page="20">
                </b-pagination>
					<div style="display:none;">@{{paginateNews}}  @{{paginateImage}}</div>
                                </div>
                                <p class="profile_link_msg_global menu_send mini_tips warn dn js_warn"> 请勿添加其他公众号的主页链接 </p>
                            </div>
                            <div class="menu_content url jsMain" id="url" v-show="showMenuContentType===2" style="display: none;">
                                <form action="" id="urlForm" onsubmit="return false;">
                                    <p class="menu_content_tips tips_global">Redirect Url</p>
                                    <div class="frm_control_group">
                                        <label for="" class="frm_label">Url</label>
                                        <div class="frm_controls">
                                            <span class="frm_input_box" v-if="activeMenuType() == 1"> <input type="text" class="frm_input" id="urlText" name="urlText" v-model="menu.button[activeMenuIndex].url" /> </span>
                                            <span class="frm_input_box" v-if="activeMenuType() == 2"> <input type="text" class="frm_input" id="urlText" name="urlText" v-model="menu.button[activeMenuIndex].sub_button[activeMenuItemIndex].url" /> </span>
                                            <p class="profile_link_msg_global menu_url"> Need http:// or https://</p>
                                            <p class="frm_tips" id="js_urlTitle" style="display: none;"> 来自<span class="js_name"></span><span style="display:none;"> -《<span class="js_title"></span>》</span> </p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="menu_content sended" style="display:none;">
                                <p class="menu_content_tips tips_global">订阅者点击该子菜单会跳到以下链接</p>
                                <div class="msg_wrp" id="viewDiv"></div>
                                <p class="frm_tips">来自<span class="js_name">素材库</span><span style="display:none;"> -《<span class="js_title"></span>》</span></p>
                            </div>
                            <div id="js_errTips" style="display:none;" class="msg_sender_msg mini_tips warn"></div>
                        </div>
                    </div>
                </div>
                <span class="editor_arrow_wrp"> <i class="editor_arrow editor_arrow_out"></i> <i class="editor_arrow editor_arrow_in"></i> </span>
            </div>
        </div>
    </div>
	
    <div class="tool_bar tc js_editBox">
        <span id="pubBt" class="btn btn_input btn_primary" style="display: block;" @click="saveData()"><button>Save and Publish</button></span>
        <!--<a href="javascript:void(0);" class="btn btn_default" id="viewBt" style="display: block;">预览</a>-->
    </div>
</div>

@endsection

@section('custom-javascript')
<script>
    var app = new Vue({
        el: '.menu_setting_box.js_menuBox',
        data:function () {
                return {
                    "gzh_name":'Preview',
                    //                    "menu":{"button":[{"type":"view","name":"今日歌曲","key":"V1001_TODAY_MUSIC","url":"","sub_button":[]},{"type":"click","name":"歌手简介","key":"V1001_TODAY_SINGER","sub_button":[]},{"name":"菜单","sub_button":[{"type":"view","name":"搜索","url":"http://www.soso.com/","sub_button":[]},{"type":"view","name":"视频","url":"http://v.qq.com/","sub_button":[]},{"type":"click","name":"赞一下我们","key":"V1001_GOOD","sub_button":[]}]}]},
                    // "menu":{},
                   "menu":{'button':[]},
                    "new_menu":{'button':[]},
                    "activeMenuName":'',
                    "activeMenuIndex":'',
                    "activeMenuItemName":'',
                    "activeMenuItemIndex":'',
                    "showDelBtnType":'', //1:delMenu 2:delMenuItem
                    "showMenuContentType":'', //1:发送消息 2:跳转链接
                    "showMenuContentMsgType":'', //1:图文信息 2:图片 3:语音 4:视频
                    "articleList":[],
                    "imageList":[],
                    showImage:false,
                    showArticle:false,
                    "imageCurrentPage":1,
                    "articleCurrentPage":1
                }
            },
        mounted:function(){
            console.log('mounted');
            console.log(this.menu);
            var that = this;
            $.ajax({
                url: '{{url("/admin/getMenu")}}',
                method: "GET",
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData: false,
                contentType: false
            }).done(function(result) {
                console.log(result);
                that.menu = Object.assign({}, result);
                console.log(that.menu);
            });

            console.log(this.menu);
        },
	computed:{
		paginateImage :function(){
			var that = this;
               var formData = new FormData();
                formData.append('type','image');
                formData.append('count',this.imageCurrentPage);
                $.ajax({
                    url: '{{url("getMaterialList")}}',
                    method: "POST",
                    data: formData,
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    contentType: false
                }).done(function(result) {
			that.imageList = result;
                    return  that.imageCurrentPage;
                });
		},
		paginateNews:function(){
			var that = this;
                        var formData = new FormData();
                        formData.append('type','news');
                        formData.append('count',this.articleCurrentPage);
              	  $.ajax({
                	    url: '{{url("getMaterialList")}}',
                   	 method: "POST",
                   	 data: formData,
                  	  headers:{
                       	 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   	 },
                   	 processData: false,
                  	  contentType: false
               	 }).done(function(result) {
                        that.articleList = result;
               	 });

			 return  this.articleCurrentPage;
		}
	},
        methods:{
            menu_data_completing:function () {
                for(var i=0;i<this.menu.button.length;i++){
                    if(!('type' in this.menu.button[i])){
                        this.menu.button[i].type = 'media_id';
                    }
                    if(!('name' in this.menu.button[i])){
                        this.menu.button[i].name = '';
                    }
                    if(!('media_id' in this.menu.button[i])){
                        this.menu.button[i].media_id = '';
                    }
                    if(!('url' in this.menu.button[i])){
                        this.menu.button[i].url = '';
                    }
                    if(!('sub_button' in this.menu.button[i])){
                        this.menu.button[i].sub_button = [];
                    }
                    if(this.menu.button[i].sub_button.length>0){
                        for(var j=0;j<this.menu.button[i].sub_button.length;j++) {
                            if (!('type' in this.menu.button[i].sub_button[j])) {
                                this.menu.button[i].sub_button[j].type = 'media_id';
                            }
                            if (!('name' in this.menu.button[i].sub_button[j])) {
                                this.menu.button[i].sub_button[j].name = '';
                            }
                            if (!('media_id' in this.menu.button[i].sub_button[j])) {
                                this.menu.button[i].sub_button[j].media_id = '';
                            }
                            if (!('url' in this.menu.button[i].sub_button[j])) {
                                this.menu.button[i].sub_button[j].url = '';
                            }
                            if (!('sub_button' in this.menu.button[i].sub_button[j])) {
                                this.menu.button[i].sub_button[j].sub_button = [];
                            }
                        }
                    }
                }
            },
            saveData:function () {
                //补全数据,无数据也要为空
                this.menu_data_completing();
                console.log(this.menu);
                for(var i=0;i<this.menu.button.length;i++){
                    if(this.menu.button[i].sub_button.length>0){
                        var _sub_button = [];
                        for(var j=0;j<this.menu.button[i].sub_button.length;j++){
                            if(this.menu.button[i].sub_button[j].type == 'media_id'){
                                _sub_button[j]={
                                    "type":this.menu.button[i].sub_button[j].type,
                                    "name":this.menu.button[i].sub_button[j].name,
                                    "media_id":this.menu.button[i].sub_button[j].media_id
                                };
                            }else if(this.menu.button[i].sub_button[j].type == 'view'){
                                _sub_button[j]={
                                    "type":this.menu.button[i].sub_button[j].type,
                                    "name":this.menu.button[i].sub_button[j].name,
                                    "url":this.menu.button[i].sub_button[j].url
                                };
                            }
                        }
                        if(this.menu.button[i].type == 'media_id'){
                            this.new_menu.button[i]={
                                "name":this.menu.button[i].name,
                                "sub_button":_sub_button
                            };
                        }else if(this.menu.button[i].type == 'view'){
                            this.new_menu.button[i]={
                                "name":this.menu.button[i].name,
                                "sub_button":_sub_button
                            };
                        }
                    }else{
                        if(this.menu.button[i].type == 'media_id'){
                            this.new_menu.button[i]={
                                "type":this.menu.button[i].type,
                                "name":this.menu.button[i].name,
                                "media_id":this.menu.button[i].media_id
                            };
                        }else if(this.menu.button[i].type == 'view'){
                            this.new_menu.button[i]= {
                                "type": this.menu.button[i].type,
                                "name": this.menu.button[i].name,
                                "url": this.menu.button[i].url
                            };
                        }
                    }
                }
                console.log(this.new_menu);
//                $('#result').html(this.new_menu);
                console.log(JSON.parse(JSON.stringify(this.new_menu)));
                console.log(JSON.stringify(this.new_menu));
                 var formData = new FormData();
                formData.append('menu',JSON.stringify(this.new_menu));
                console.log('{{url("/admin/menus")}}');
                $.ajax({
                    url: '{{url("/admin/menus")}}',
                    method: "POST",
                    data:formData,
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    contentType: false
                }).done(function(result) {
                        if(result == 1){
                           window.location.reload();
                        }else{
                            alert(result);
                        }
                });

            },
            menu_selected:function (name,index) {
                //console.log(name);
                //console.log(index);
                //console.log(this.$el);
                //console.log($(e.srcElement));
                //console.log($(e.target));
                this.showDelBtnType = 1;
                this.activeMenuName = name;
                this.activeMenuIndex = index;
                this.activeMenuItemName = '';
                this.activeMenuItemIndex = '';

                //补全数据,无数据也要为空
                this.menu_data_completing();

                if(this.menu.button[this.activeMenuIndex].sub_button.length > 0){
                    this.showMenuContentType = '';
                }else{
                    this.showMenuContentType = this.activeMenuBtnType();
                }
            },
            menu_item_selected:function (name,index) {
                this.showDelBtnType = 2;
                this.activeMenuItemName = name;
                this.activeMenuItemIndex = index;

                //补全数据,无数据也要为空
                this.menu_data_completing();

                if(this.activeMenuIndex > 0 || this.activeMenuIndex === 0){
                    if(this.menu.button[this.activeMenuIndex].sub_button.length > 0){
                        this.showMenuContentType = this.activeMenuBtnType();
                    }
                }
            },
            menu_add:function () {
                if(this.menu.button.length < 3){
                    this.activeMenuItemIndex = '';
                    this.activeMenuItemName = '';
                    this.menu.button.push({"type":"media_id","name":"Menu name","media_id":"","url":"","sub_button":[]});
                    this.activeMenuIndex = this.menu.button.length-1;
                    this.activeMenuName = 'Menu name';
                    this.showDelBtnType = 1;
                    //补全数据,无数据也要为空
                    this.menu_data_completing();
                }else{
                    alert('最多3个一级菜单');
                }
            },
            menu_item_add:function () {
                if(this.menu.button[this.activeMenuIndex].sub_button.length < 5){
                    this.menu.button[this.activeMenuIndex].sub_button.push({"type":"media_id","name":"sub-menu name","media_id":"","url":"","sub_button":[]});
                    this.activeMenuItemIndex = this.menu.button[this.activeMenuIndex].sub_button.length-1;
                    this.activeMenuItemName = 'sub-menu name';
                    this.showDelBtnType = 2;
                    //补全数据,无数据也要为空
                    this.menu_data_completing();
                }else{
                    alert('最多5个二级菜单');
                }
            },
            menu_del:function () {
                if(this.menu.button.length <= 3 && this.menu.button.length >0){

                    if((this.activeMenuIndex !== 0) && (this.activeMenuIndex == this.menu.button.length-1)){
                        this.menu.button.splice(this.activeMenuIndex,1);
                        this.activeMenuIndex -= 1;
                    }else if(this.activeMenuIndex == 0){
                        this.menu.button.splice(this.activeMenuIndex,1);
                        this.activeMenuIndex = 0;
                    }else{
                        this.menu.button.splice(this.activeMenuIndex,1);
                    }

                    if(this.menu.button.length == 0){
                        this.activeMenuIndex = '';
                        this.activeMenuName = '';
                        this.activeMenuItemIndex = '';
                        this.activeMenuItemName = '';
                    }
                }
            },
            menu_item_del:function () {
                if(this.menu.button[this.activeMenuIndex].sub_button.length <=5 && this.menu.button[this.activeMenuIndex].sub_button.length>0 ){
                    if(this.activeMenuItemIndex == this.menu.button[this.activeMenuIndex].sub_button.length-1){
                        this.menu.button[this.activeMenuIndex].sub_button.splice(this.activeMenuItemIndex,1);
                        this.activeMenuItemIndex -= 1;
                    }else if(this.activeMenuItemIndex == 0){
                        this.menu.button[this.activeMenuIndex].sub_button.splice(this.activeMenuItemIndex,1);
                        this.activeMenuItemIndex = 0;
                    }else{
                        this.menu.button[this.activeMenuIndex].sub_button.splice(this.activeMenuItemIndex,1);
                    }

                    if(this.menu.button[this.activeMenuIndex].sub_button.length == 0){
                        this.activeMenuIndex = '';
                        this.activeMenuName = '';
                        this.activeMenuItemIndex = '';
                        this.activeMenuItemName = '';
                    }
                    this.showMenuContentType = this.activeMenuBtnType();
                }
            },
            radio_label_selected:function (val) {
                this.showMenuContentType = val;
                if(val == 1){
                    this.setType('media_id');
                }else if(val == 2){
                    this.setType('view');
                }
            },
            content_msg_tab_nav:function (val) {
                this.showMenuContentMsgType = val;
                var that = this;
                if(val == 1){
                    this.showImage = false;
                    this.showArticle = true;
                }
                if(val == 2){
                    this.showImage = true;
                    this.showArticle = false;
                }
                
            },
            activeMenuType:function () {
                if(this.activeMenuIndex !== '' && this.activeMenuItemIndex !== ''){
                    //子菜单、二级菜单
                    return 2;
                }else if(this.activeMenuIndex !== '' && this.activeMenuItemIndex === ''){
                    //一级菜单
                    return 1;
                }else{
                    return 0;
                }
            },
            activeMenuBtnType:function () {
                if(this.activeMenuType() === 1){
                    //一级菜单
                    switch(this.menu.button[this.activeMenuIndex].type){
                        case 'media_id':
                            return 1;
                        case 'view':
                            return 2;
                        default:
                            return 0;
                    }
                }else if(this.activeMenuType() === 2){
                    //子菜单、二级菜单
                    switch(this.menu.button[this.activeMenuIndex].sub_button[this.activeMenuItemIndex].type){
                        case 'media_id':
                            return 1;
                        case 'view':
                            return 2;
                        default:
                            return 0;
                    }
                }else{
                    return '';
                }
            },
            isSet:function (variable) {
                if(typeof(variable)!='undefined'){
                    return true;
                }else{
                    return false;
                }
            },
            setType:function (type) {
                console.log(this.activeMenuIndex);
                if(this.activeMenuType() == 1){
                    this.menu.button[this.activeMenuIndex].type = type;
                }else if(this.activeMenuType() == 2){
                    this.menu.button[this.activeMenuIndex].sub_button[this.activeMenuItemIndex].type = type;
                }
            },
            setNemMenuObj:function () {
                for(var i=0;i<this.menu.button.length;i++){
                    if(this.menu.button[i].sub_button.length>0){
                        this.new_menu.push({"name":this.menu.button[i].name,"sub_button":this.menu.button[i].sub_button});
                    }else{
                        if(this.menu.button[i].type == 'media_id'){
                            this.new_menu.push({"name":this.menu.button[i].name,"type":this.menu.button[i].type,"media_id":this.menu.button[i].media_id,"sub_button":[]});
                        }else if(this.menu.button[i].type == 'view'){
                            this.new_menu.push({"name":this.menu.button[i].name,"type":this.menu.button[i].type,"url":this.menu.button[i].url,"sub_button":[]});
                        }
                    }
                }
            }
        }
    })
</script>

@endsection
