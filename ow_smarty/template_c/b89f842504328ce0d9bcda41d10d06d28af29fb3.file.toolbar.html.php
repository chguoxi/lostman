<?php /* Smarty version Smarty-3.1.7, created on 2012-07-28 08:55:09
         compiled from "/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_plugins/ajaxim/views/components/toolbar.html" */ ?>
<?php /*%%SmartyHeaderCode:36352632950140b5deaa0d0-38620982%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b89f842504328ce0d9bcda41d10d06d28af29fb3' => 
    array (
      0 => '/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_plugins/ajaxim/views/components/toolbar.html',
      1 => 1343225878,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '36352632950140b5deaa0d0-38620982',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'debug_mode' => 0,
    'online_list_url' => 0,
    'privacyPluginActive' => 0,
    'privacy_settings_url' => 0,
    'avatar_proto_data' => 0,
    'no_avatar_url' => 0,
    'ajaximSoundUrl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_50140b5e032bc',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50140b5e032bc')) {function content_50140b5e032bc($_smarty_tpl) {?><?php if (!is_callable('smarty_block_block_decorator')) include '/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_smarty/plugin/block.block_decorator.php';
if (!is_callable('smarty_function_text')) include '/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_smarty/plugin/function.text.php';
if (!is_callable('smarty_block_form')) include '/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_smarty/plugin/block.form.php';
if (!is_callable('smarty_function_label')) include '/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_smarty/plugin/function.label.php';
if (!is_callable('smarty_function_input')) include '/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_smarty/plugin/function.input.php';
if (!is_callable('smarty_function_submit')) include '/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_smarty/plugin/function.submit.php';
if (!is_callable('smarty_function_decorator')) include '/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_smarty/plugin/function.decorator.php';
?><?php if ($_smarty_tpl->tpl_vars['debug_mode']->value){?><div id="server_msg_container"></div><?php }?>
<div id="im_console">
    <div class="clearfix">
    <?php $_smarty_tpl->smarty->_tag_stack[] = array('block_decorator', array('name'=>'tooltip','addClass'=>'contacts_widget ow_hidden')); $_block_repeat=true; echo smarty_block_block_decorator(array('name'=>'tooltip','addClass'=>'contacts_widget ow_hidden'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

            <div id="contacts_friends" style="display: block;"><div id="contacts_friends_label" style="display: none;"><?php echo smarty_function_text(array('key'=>'ajaxim+friends_online'),$_smarty_tpl);?>
</div><div id="contacts_friends_list"></div></div>
            <div id="contacts_other" style="display: block;"><div id="contacts_other_label" style="display: none;"><?php echo smarty_function_text(array('key'=>'ajaxim+others_online'),$_smarty_tpl);?>
</div><div id="contacts_other_list"></div></div>
            <div id="contacts_online_list_label" class="contact ow_alt2 new_mail clearfix" style="display: none;">
                <div title="<?php echo smarty_function_text(array('key'=>'base+view_all'),$_smarty_tpl);?>
"  class="ow_center" ><a href="<?php echo $_smarty_tpl->tpl_vars['online_list_url']->value;?>
" target="_blank" ><span>...</span></a></div>
            </div>
            <div id="user_settings_container">
                <a id="user_settings" href="javascript://" ><?php echo smarty_function_text(array('key'=>'ajaxim+user_settings_link'),$_smarty_tpl);?>
</a>
                <div style="display: none;">
                    <div id="user_settings_form" style="padding: 10px;">
                        <?php $_smarty_tpl->smarty->_tag_stack[] = array('form', array('name'=>'user_settings_form')); $_block_repeat=true; echo smarty_block_form(array('name'=>'user_settings_form'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

                        <table class="ow_table_4 ow_automargin">
                            <tr>
                                <td class="ow_label">
                                    <?php echo smarty_function_label(array('name'=>'ajaxim_enable_sound'),$_smarty_tpl);?>

                                </td>
                                <td class="ow_value">
                                    <?php echo smarty_function_input(array('name'=>'ajaxim_enable_sound'),$_smarty_tpl);?>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div style="text-align: center;padding: 10px;"><?php echo smarty_function_submit(array('name'=>'submit'),$_smarty_tpl);?>
</div>
                                </td>
                            </tr>
                        </table>
                        <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_form(array('name'=>'user_settings_form'), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                        <?php if ($_smarty_tpl->tpl_vars['privacyPluginActive']->value){?>
                        <div class="ow_center">
                            <a target="_blank" href="<?php echo $_smarty_tpl->tpl_vars['privacy_settings_url']->value;?>
"><?php echo smarty_function_text(array('key'=>'ajaxim+change_privacy_settings'),$_smarty_tpl);?>
</a>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_block_decorator(array('name'=>'tooltip','addClass'=>'contacts_widget ow_hidden'), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

    </div>

    <!-- IM prototypes description -->

    <span id="main_tab_label_proto" class="ow_txt_value im_main_tab_text" style="display: none;" ><?php echo smarty_function_text(array('key'=>'ajaxim+chat'),$_smarty_tpl);?>
</span>
    <span id="no_online_users" style="display: none;"><?php echo smarty_function_text(array('key'=>'ajaxim+no_contacts_online'),$_smarty_tpl);?>
</span>
    <span id="new_message_label" style="display: none;"><?php echo smarty_function_text(array('key'=>'ajaxim+new_message'),$_smarty_tpl);?>
</span>
    <span id="last_message_sent_label" style="display: none;"><?php echo smarty_function_text(array('key'=>'ajaxim+last_message_sent'),$_smarty_tpl);?>
</span>
    <span id="user_offline_message" style="display: none;"><?php echo smarty_function_text(array('key'=>'ajaxim+user_is_offline'),$_smarty_tpl);?>
</span>
    <span id="user_online_message" style="display: none;"><?php echo smarty_function_text(array('key'=>'ajaxim+user_is_online'),$_smarty_tpl);?>
</span>

    <div id="main_tab_contact_proto" class="console_item notification_shortcut" style="display: none; position: relative; z-index: 99;">
        <div class="fake_node">
            <a href="javascript://" class="ow_preloader new_mail main_tab_contact_click">
                <span class="ow_txt_value im_main_tab_text"></span>
            </a>
        </div>
            <div class="talkbox" style="display: none; z-index: 99;">
                <?php $_smarty_tpl->smarty->_tag_stack[] = array('block_decorator', array('name'=>'tooltip')); $_block_repeat=true; echo smarty_block_block_decorator(array('name'=>'tooltip'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

                <div class="cap">
                    <div id="talkbox_contact_info" class="clearfix">
                        <?php echo smarty_function_decorator(array('name'=>'avatar_item','data'=>$_smarty_tpl->tpl_vars['avatar_proto_data']->value),$_smarty_tpl);?>

                        <div class="talkbox_username"><a href="#" target="_blank">&nbsp;</a></div>
                        <div class="talk_box_status ow_remark" style="display: none;"><?php echo smarty_function_text(array('key'=>'ajaxim+user_offline'),$_smarty_tpl);?>
</div>
                    </div>
                    <div class="talk_box_cap_panel clearfix">
                        <div class="close_cmd">x</div>
                        <div class="min_cmd">-</div>
                    </div>
                </div>
                <div class="box ow_small ow_alt2"><div id="message_list"></div><div id="message_preloader" class="ow_dnd_preloader ow_preloader_content"></div></div>
                <div style="padding: 10px 0 10px 0;">
                    <input type="text" class="talkbox_msg" name="msg" />
                    <!--<div class="im_history_cmd ow_ic_calendar"> </div>-->
                    <!--<input type="button" class="talkbox-send" value="<?php echo smarty_function_text(array('key'=>'ajaxim+send'),$_smarty_tpl);?>
" /> -->
                </div>
                <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_block_decorator(array('name'=>'tooltip'), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

            </div>
    </div>


    <!-- Contact item in contact list prototype -->
    <div id="contact_proto" class="contact ow_alt2 new_mail clearfix" style="display: none;">
        <div class="contact_avatar">
            <img src="<?php echo $_smarty_tpl->tpl_vars['no_avatar_url']->value;?>
" />
        </div>
        <div class="contact_username" ></div>
    </div>

    <!-- Prototype of message in talkbox -->
    <div id="talk_box_msg_proto" class="talk_box_msg clearfix" style="display: none;">
        <div class="message_cap"></div>
        <div class="message"></div>
    </div>



</div>

<audio id="ajaxim_sound_player_audio" src="<?php echo $_smarty_tpl->tpl_vars['ajaximSoundUrl']->value;?>
" /><?php }} ?>