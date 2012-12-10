<?php /* Smarty version Smarty-3.1.7, created on 2012-07-28 08:55:10
         compiled from "/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_system_plugins/base/views/components/console_member.html" */ ?>
<?php /*%%SmartyHeaderCode:132123260550140b5e344d66-77224010%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '420ee7e1af7de13d1143985db5bc22b483e3a7fa' => 
    array (
      0 => '/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_system_plugins/base/views/components/console_member.html',
      1 => 1343225879,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '132123260550140b5e344d66-77224010',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'items' => 0,
    'item' => 0,
    'links' => 0,
    'titles' => 0,
    'displayName' => 0,
    'switchLanguage' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_50140b5e4cd05',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50140b5e4cd05')) {function content_50140b5e4cd05($_smarty_tpl) {?><?php if (!is_callable('smarty_block_style')) include '/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_smarty/plugin/block.style.php';
?><?php $_smarty_tpl->smarty->_tag_stack[] = array('style', array()); $_block_repeat=true; echo smarty_block_style(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>


.ow_console a.ow_console_my_profile{
    text-align:center;
    padding-top:6px;
    padding-left: 20px;
    height:25px;
    width:auto;
    background-position: left center;
}

<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_style(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>


<div class="ow_console clearfix">
    <div class="ow_console_body clearfix">
        <div style="float:right;">
            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
            <?php if (!empty($_smarty_tpl->tpl_vars['item']->value['block'])){?>
                <div class="console_item notification_shortcut<?php if (!empty($_smarty_tpl->tpl_vars['item']->value['block_class'])){?> <?php echo $_smarty_tpl->tpl_vars['item']->value['block_class'];?>
<?php }?>"<?php if (!empty($_smarty_tpl->tpl_vars['item']->value['block_id'])){?> id="<?php echo $_smarty_tpl->tpl_vars['item']->value['block_id'];?>
"<?php }?>>
                    <div class="fake_node">
                        <a class="<?php if (!empty($_smarty_tpl->tpl_vars['item']->value['icon_class'])){?><?php echo $_smarty_tpl->tpl_vars['item']->value['icon_class'];?>
<?php }else{ ?>ow_ic_file<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
"<?php if (!empty($_smarty_tpl->tpl_vars['item']->value['id'])){?> id="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"<?php }?><?php if (!empty($_smarty_tpl->tpl_vars['item']->value['title'])){?> title="<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
"<?php }?>>
                        <?php if (!empty($_smarty_tpl->tpl_vars['item']->value['block_items_count'])){?><span class="ow_txt_value"><?php echo $_smarty_tpl->tpl_vars['item']->value['block_items_count'];?>
</span><?php }else{ ?>&nbsp;<?php }?>
                        </a>
                    </div>
                </div>
            <?php }?>
            <?php } ?>
            <div class="console_item common_shortcuts">
                <div class="fake_node">
                <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                <?php if (empty($_smarty_tpl->tpl_vars['item']->value['block'])){?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
"<?php if (!empty($_smarty_tpl->tpl_vars['item']->value['title'])){?> title="<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
"<?php }?><?php if (!empty($_smarty_tpl->tpl_vars['item']->value['icon_class'])){?> class="<?php echo $_smarty_tpl->tpl_vars['item']->value['icon_class'];?>
"<?php }?><?php if (!empty($_smarty_tpl->tpl_vars['item']->value['id'])){?> id="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
}"<?php }?>>&nbsp</a>
                <?php }?>
                <?php } ?>
                </div>
            </div>
            <div class="console_item common_shortcuts">
                <div class="fake_node">
                    <a class="ow_console_my_profile ow_ic_user" href="<?php echo $_smarty_tpl->tpl_vars['links']->value['profile'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['titles']->value['profile'];?>
"><?php echo $_smarty_tpl->tpl_vars['displayName']->value;?>
</a>
                </div>
            </div>
        	<div class="console_item common_shortcuts">
                <div class="fake_node">
                    <a style="text-align:center;padding-top:6px;height:25px;width:auto;" onclick="OW.trigger('base.sign_out_click', [ '<?php echo $_smarty_tpl->tpl_vars['displayName']->value;?>
' ] );" href="<?php echo $_smarty_tpl->tpl_vars['links']->value['sign_out'];?>
"><?php echo $_smarty_tpl->tpl_vars['titles']->value['sign_out'];?>
</a>
                </div>
            </div>       
            <?php if ($_smarty_tpl->tpl_vars['switchLanguage']->value){?>
            <div class="console_item common_shortcuts">
                <div class="fake_node">
                <?php echo $_smarty_tpl->tpl_vars['switchLanguage']->value;?>

                </div>
            </div>
            <?php }?>    
        </div>       
    </div>
</div><?php }} ?>