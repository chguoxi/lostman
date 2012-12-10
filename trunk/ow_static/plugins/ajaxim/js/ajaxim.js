IMTalkBox = function(node){

    var self = this;
    this.newMessageTimeout = 0;

    this.node = node;

    this.isOpened = false;
    this.isActive = false;
    this.isOffline = false;
    this.isLoaded = false;
    this.isLogLoaded = false;
    this.unreadMessages = 0;

    var cont = $("#main_tab_contact_proto").clone();

    cont.attr('id', 'main_tab_contact_'+this.node);

    $('#main_im_tab_container').parent().after(cont);

    this.mainTabContact = $('#main_tab_contact_'+this.node);
    this.$cont = $('div.talkbox', this.mainTabContact );
    this.$cont.click(function(e){
        if(!$(e.target).is('div.min_cmd', self.$cont))
        {
            self.activate();
        }
    });

    $('div.min_cmd', this.$cont).click(
        function(){
            self.hide();
        });

    $('div.close_cmd', this.$cont).click(
        function(){
            self.hideTab();
        });

    this.talkboxUsername = $('div.talkbox_username', this.$cont);
    this.talkboxMsg = $('input.talkbox_msg', this.$cont);

    $('#main_tab_contact_'+this.node+' .fake_node a.main_tab_contact_click').click(
        function(){
            self.toggle();
            self.annul();
            $('.contacts_widget').hide();
        });

    this.box = $('div.box', this.$cont);
    this._input = $('input[name=msg]', this.$cont);
    this._input.keydown( function(e){

        if(e.keyCode != 13)
            return;

        if ( $.trim(self._input.val()) == '')
            return;

        var message = self._input.val();
        self._input.val('');

        var data = {
            'to': self.node,
            'message': message
        };

        ajaximBindInProcess = true;

        $.ajax({
            'type': 'POST',
            'url': window.ajaximLogMsgUrl,
            'data': data,
            'success': function(data){

                self.writeTimeDelimiter();
                self.write(data);

                ajaximBindInProcess = false;
            },
            'error': function(){
                ajaximBindInProcess = false;
                ajaximLog('logmsg error occured');
            },
            'complete': function(){
                ajaximBindInProcess = false;
            },
            'dataType': 'json'
        });

    });

    $.post(ajaximUpdateUserInfoUrl, {
        userId: this.node,
        action: 'open',
        from: 'tabConstruct'
    }, function(data){

        if ( typeof data != 'undefined')
        {
            ajaximContactManager.contacts[self.node] = data;
            $('a.main_tab_contact_click', self.mainTabContact).removeClass('ow_preloader');
            $('a.main_tab_contact_click', self.mainTabContact).addClass('ow_ic_chat');
            self.mainTabContact.addClass('ow_mild_green');
            $('.im_main_tab_text', cont).html(data['username']);

            $('#talkbox_contact_info .ow_avatar a img', self.$cont).attr('src', ajaximContactManager.contacts[self.node].user_avatar_src);
            $('#talkbox_contact_info .ow_avatar a img', self.$cont).attr('alt', ajaximContactManager.contacts[self.node].username);
            $('#talkbox_contact_info .ow_avatar a img', self.$cont).attr('title', ajaximContactManager.contacts[self.node].username);

            $('a', self.talkboxUsername).html('<b>'+ajaximContactManager.contacts[self.node].username+'</b>' );
            $('a', self.talkboxUsername).attr('href', ajaximContactManager.contacts[self.node].user_url);
            $('#talkbox_contact_info .ow_avatar a', self.$cont).attr('href', ajaximContactManager.contacts[self.node].user_url);
            $('#talkbox_contact_info .ow_avatar a', self.$cont).attr('target', '_blank');

            self.align();
            OW.trigger(self.node+'_isLoaded');
            self.isLoaded = true;

        }
        else
        {
            $('.im_main_tab_text', cont).html(self.node);
        }
    }, 'json');

    this.align = function()
    {
        var padding_left = self.mainTabContact.css( 'padding-left' );
        if (typeof padding_left == 'undefined')
        {
            padding_left = 0;
        }
        else
        {
            padding_left = parseInt(padding_left.substring(0, 1));
        }
        var margin_left = self.mainTabContact.css( 'margin-left' );
        if (typeof margin_left == 'undefined')
        {
            margin_left = 0;
        }
        else
        {
            margin_left = parseInt(margin_left.substring(0, 1));
        }
        var padding_right = self.mainTabContact.css( 'padding-right' );
        if (typeof padding_right == 'undefined')
        {
            padding_right = 0;
        }
        else
        {
            padding_right = parseInt( padding_right.substring(0, 1) );
        }
        var margin_right = self.mainTabContact.css( 'margin-right' );
        if (typeof margin_right == 'undefined')
        {
            margin_right = 0;
        }
        else
        {
            margin_right = parseInt( margin_right.substring(0, 1) );
        }
        self.left = parseInt(( self.mainTabContact.width() + padding_left + margin_left + padding_right + margin_right )/2 - 50);
        self.top = self.mainTabContact.height();
        self.$cont.css({
            'left': self.left+'px',
            'top': self.top+'px'
        });

    }

    this.annul = function(){

        if (typeof ajaximContactManager.contacts[this.node] != 'undefined')
        {
            this.unreadMessages = 0;
            $('.im_main_tab_text', this.mainTabContact).html( ajaximContactManager.contacts[this.node].username );
        }

        self.align();

        if ( self.newMessageTimeout !== 0 )
        {
            clearInterval( self.newMessageTimeout );
            document.title = ajaximOldTitle;
            self.newMessageTimeout = 0;

            if ( !cont.hasClass('ow_mild_green') )
            {
                cont.addClass('ow_mild_green');
            }

        }
    }

    this.activate = function(){
        ajaximActiveContact = this.node;
        this.isActive = true;
        this.isOpened = true;

        this.$cont.css('z-index', '99');
        $('.contacts_widget').hide();

        if (typeof ajaximContactManager.contacts[self.node] == 'undefined')
        {
            return self;
        }

        ajaximContactManager.contacts[self.node].is_active = true;
        ajaximContactManager.contacts[self.node].is_opened = true;

        return self;
    }

    this.hide = function(){
        this.$cont.hide();
        self.isActive = false;
        ajaximActiveContact = '';

        if (typeof ajaximContactManager.contacts[self.node] == 'undefined')
        {
            return self;
        }
        ajaximContactManager.contacts[self.node].is_active = false;

        $.post(ajaximUpdateUserInfoUrl, {
            userId: self.node,
            action: 'min',
            from: 'min_cmd'
        }, function(data){

            }, 'json');

        return self;
    }

    this.hideTab = function(){
        self.$cont.hide();
        self.mainTabContact.hide();

        if (typeof ajaximContactManager.contacts[self.node] == 'undefined')
        {
            return;
        }

        $.post(ajaximUpdateUserInfoUrl, {
            userId: this.node,
            action: 'close',
            from: 'hideTab'
        }, function(data){
            self.isActive = false;
            ajaximContactManager.contacts[self.node].is_active = false;
            self.isOpened = false;
            ajaximContactManager.contacts[self.node].is_opened = false;

            self.$cont.remove();
            self.mainTabContact.remove();
            delete ajaximWindows[self.node];

        }, 'json');

    }

    this.isVisible = function(){
        return this.$cont.css('display') == 'block';
    }

    this.notifyOnNewMessage = function(){

        this.unreadMessages++;

        $('.im_main_tab_text', '#main_tab_contact_'+this.node).html( ajaximContactManager.contacts[this.node].username + ' ('+this.unreadMessages+')' );

        var msg = $("#new_message_label").html();

        if ( self.newMessageTimeout === 0  )
        {
            self.newMessageTimeout = setInterval(function() {
                document.title = document.title == msg ? ajaximOldTitle : msg;

                if ( cont.hasClass('ow_mild_green') )
                {
                    cont.removeClass('ow_mild_green');
                }
                else
                {
                    cont.addClass('ow_mild_green');
                }

            }, 1000);
        }
        return self;
    }

    this.setOnline = function(){
        if (this.isOffline)
        {
            this.isOffline = false;
            if ( ajaximContactManager.contacts[this.node].is_friend )
            {
                $('.talk_box_status', this.$cont).css( 'display', 'none' );
                $('b',this.talkboxUsername).removeClass('ow_remark');

                this.updateStatus( $('#user_online_message').html().replace("[username]", ajaximContactManager.contacts[this.node].username) );
            }
        //this.mainTabContact.addClass('ow_mild_green');
        }
        return self;
    }

    this.setOffline = function(){
        if (!this.isOffline)
        {
            this.isOffline = true;
            if ( ajaximContactManager.contacts[this.node].is_friend )
            {
                $('.talk_box_status', this.$cont).css( 'display', 'block' );
                $('b', this.talkboxUsername).addClass('ow_remark');
                this.updateStatus($('#user_offline_message').html().replace("[username]", ajaximContactManager.contacts[this.node].username));
            //this.mainTabContact.removeClass('ow_mild_green');
            }
        }

        return self;
    }

    this.onShow = function(){
        ajaximWindowManager.deactivateAll(self.node);
        self.activate();
        self.$cont.show();

        self.box = $('div.box', self.$cont);
        //self.box.attr('scrollTop', self.box.attr('scrollHeight'));
        self.box[0].scrollTop = self.box[0].scrollHeight;
        self.talkboxMsg.focus();

        if (typeof ajaximContactManager.contacts[self.node] == 'undefined')
        {
            return self;
        }

        $.post(ajaximUpdateUserInfoUrl, {
            userId: self.node,
            action: 'open',
            option: 'activate',
            from: 'show'
        }, function(){}, 'json');
    }

    this.show = function(){
        if (self.isOpened)
        {
            self.onShow();
        }
        else
        {
            OW.bind(self.node+'_tabOpened', function(){
                self.onShow();
                OW.unbind(self.node+'_tabOpened');
            });
        }

        return self;
    }

    this.onShowTab = function(omit_last_message){
        self.align();

        self.isOpened = true;
        ajaximContactManager.contacts[self.node].is_opened = true;
        OW.trigger(self.node+'_tabOpened');
        ajaximLog(self.node+'_tabOpened', 1);

        if(ajaximGetLogInProcess[self.node])
        {
            ajaximLog('ajaximGetLogInProcess['+self.node+']', 1);
        }

        if ( !this.isLogLoaded && !ajaximGetLogInProcess[self.node] )
        {
            ajaximGetLogInProcess[self.node] = true;
            $.ajax({
                url: ajaximGetLogUrl,
                type: 'POST',
                data: {
                    userId: this.node,
                    lastMessageTimestamp: ajaximContactManager.contacts[self.node].last_message_timestamp,
                    omit_last_message: omit_last_message
                },
                success: function(data){
                    $('#message_preloader', self.$cont).remove();
                    if ( data.length > 0 )
                    {
                        var lastMessageTimeString = '';
                        $(data).each(function(){
                            self.write(this, 'ow_remark');
                            lastMessageTimeString = this.read;
                        });

                        self.writeTimeDelimiter($('#last_message_sent_label').html()+' '+lastMessageTimeString);
                        var date = new Date();
                        ajaximContactManager.updateLastMessageTimestamp(self.node, parseInt(date.getTime() / 1000));
                    }

                    OW.trigger(self.node+'_isLogLoaded');
                    self.isLogLoaded = true;

                    ajaximGetLogInProcess[self.node] = false;

                },
                error: function(){
                    ajaximLog('getLog error occured');
                    ajaximGetLogInProcess[self.node] = false;
                },
                complete: function(){
                    ajaximGetLogInProcess[self.node] = false;
                },
                dataType: 'json'
            });
        }
    }

    this.showTab = function(omit_last_message){

        if (typeof omit_last_message == 'undefined')
            omit_last_message = 0;

        self.mainTabContact.show();

        if ( this.isLoaded )
        {
            self.onShowTab(omit_last_message);
        }
        else
        {
            OW.bind(self.node+'_isLoaded', function(){

                self.onShowTab(omit_last_message);

                OW.unbind(self.node+'_isLoaded');
            });
        }
        return this;
    }

    this.toggle = function(){
        if(!this.isVisible())
        {
            return self.show();
        }
        else
        {
            return self.hide();
        }
    }

    this.splitLongMessage = function(text)
    {
        var strings = text.split(' ');
        var str = '';
        for (var i = 0; i < strings.length; i++)
        {
            if ( strings[i].length > 30  )
            {
                str = strings[i].substr(0, 30)+' '+this.splitLongMessage(strings[i].substr(30, strings[i].length-1));
            }
            else
            {
                str += strings[i];
            }
        }

        return str;

    }

    this.write = function(msg, css_class){

        var message_container = $('#talk_box_msg_proto').clone();

        message_container.removeAttr('id');
        message_container.removeAttr('style');

        if ( ajaximSoundEnabled && typeof css_class == 'undefined' )
        {
            var audioTag = document.createElement('audio');
            if (!(!!(audioTag.canPlayType) && ("no" != audioTag.canPlayType("audio/mpeg")) && ("" != audioTag.canPlayType("audio/mpeg")) && ("maybe" != audioTag.canPlayType("audio/mpeg")) )) {
                AudioPlayer.embed("ajaxim_sound_player_audio", {
                    soundFile: ajaximSoundUrl,
                    autostart: 'yes'
                });
            }
            else
            {
                $('#ajaxim_sound_player_audio')[0].play();
            }

        }

        if( msg.from == ajaximMy.node ){
            $('.message_cap', message_container).html("<img src='"+ajaximMy.avatar+"' alt='"+ajaximMy.username+"' title='"+ajaximMy.username+"' />");
        }
        else{
            $('.message_cap', message_container).html("<img src='"+ajaximContactManager.contacts[this.node].user_avatar_src+"' alt='"+ajaximContactManager.contacts[this.node].username+"' title='"+ajaximContactManager.contacts[this.node].username+"' />");

        }

        if ( typeof msg != 'undefined' && typeof msg.message != 'undefined' )
        {
            var text = msg.message.replace(/&lt;/g,'<').replace(/&gt;/g,'>').replace(/&amp;/g,'&').replace(/&quot;/g,'"');
            $('.message', message_container).html( text );
        }


        if (typeof css_class != 'undefined')
        {
            $('.message', message_container).addClass(css_class);
        }

        $('#message_list', this.box).append(message_container);

        //this.box.append(message_container);
        //this.lastMessageTimestamp = msg.timestamp;
        ajaximContactManager.updateLastMessageTimestamp(this.node, parseInt(msg.timestamp));

        this.box[0].scrollTop = this.box[0].scrollHeight;

        return self;
    }

    this.writeTimeDelimiter = function(message){

        if ( ajaximContactManager.contacts[this.node].last_message_timestamp == 0 )
        {
            return self;
        }
        var notification_container = $('#talk_box_msg_proto').clone();

        notification_container.removeAttr('id');
        notification_container.removeAttr('style');

        if (typeof message == 'undefined')
        {
            var currentDate = new Date();
            currentDate = parseInt(currentDate.getTime() / 1000);
            if ( currentDate - ajaximContactManager.contacts[self.node].last_message_timestamp > 300 ) // TODO Set 300 sec
            {
                var time = new Date(ajaximContactManager.contacts[self.node].last_message_timestamp*1000);
                var minutes = time.getMinutes();
                if ( time.getMinutes() < 10 )
                {
                    minutes = '0'+time.getMinutes();
                }
                message=time.getHours()+':'+minutes; //  TODO remove getSeconds()
            }
            else
                return self;
        }

        $('.message', notification_container).addClass('ow_tiny ow_remark ow_center');
        $('.message', notification_container).html(message);

        //this.box.append(notification_container);
        $('#message_list', this.box).append(notification_container);
        this.box[0].scrollTop = this.box[0].scrollHeight;

        return self
    }

    this.updateStatus = function(status){

        var notification_container = $('#talk_box_msg_proto').clone();

        notification_container.removeAttr('id');
        notification_container.removeAttr('style');

        $('.message', notification_container).addClass('ow_tiny ow_remark ow_center');
        $('.message', notification_container).html(status);

        $('#message_list', this.box).append(notification_container);
        //this.box.append(notification_container);

        this.box[0].scrollTop = this.box[0].scrollHeight;
    }
}

AJAXIM_WindowManager = function(){
    ajaximWindows = {};

    this.get = function(node){
        if( typeof ajaximWindows[node] == 'undefined' ){

            ajaximWindows[node] = new IMTalkBox(node);
        }

        return ajaximWindows[node];
    }

    this.deactivateAll = function(node){

        for(var key in ajaximWindows)
        {
            if ( node != key && ajaximWindows[key].isActive )
            {
                ajaximWindows[key].hide();
            }
        }
    }
}


AJAXIM_ContactManager = function(){
    var self = this;

    this.onlineCount = 0;
    this.count = 0;
    this.countOthers = 0;
    //this.contacts = [];
    this.contacts = {};
    //    this.contact_info = [];
    this.timestamps = {};

    this.contactsWidget = $('.contacts_widget');

    $('#main_im_tab').click( function(){
        /*if ( typeof im_bindConnection != 'undefined' )
        {
            bind();
        }*/
        self.toggleRoster();
    } )

    this.connect = function(){
        $('#main_im_tab').removeClass('ow_preloader');
        $('#main_im_tab').addClass('ow_ic_chat');
    }

    this.disconnect = function(){
        $('#main_im_tab').removeClass('ow_ic_chat');
        $('#main_im_tab').addClass('ow_preloader');
    }

    this.add = function(node){
        /*if ( typeof this.contacts[node.node] == 'undefined' )
        {
            this.contacts[node.node] = node;
        }*/
        this.contacts[node.node] = node;

        if ( (node.node != ajaximMy.node) && $('#contact_'+node.node).length == 0 )
        {
            this.addRoster(node);
        }
    }

    this.addRoster = function(node){

        var contacts_item = $('#contact_proto').clone();
        contacts_item.attr('id', 'contact_'+node.node);
        contacts_item.removeAttr('style');

        $('#main_im_tab').unbind('mouseover.owtip');

        if ( node['is_active'] )
        {
            node['is_opened'] = true;
        }
        else
        {
            node['is_opened'] = false;
        }

        $( '.contact_username', contacts_item ).attr('title', node['username']);
        $( '.contact_avatar img', contacts_item ).attr('src', node['user_avatar_src']);
        $( '.contact_username', contacts_item ).html(node['username']);

        if ( node['is_friend'] )
        {
            self.count++;

            $('#contacts_friends').find( '#contacts_friends_list' ).append( contacts_item );

            $('#contacts_friends_label').css('display', 'block');

            if ( self.countOthers > 0 )
            {
                $('#contacts_other_label').css('display', 'block');
            }
        }
        else
        {
            self.countOthers++;

            if ( self.count > 0 )
            {
                $('#contacts_friends_label').css('display', 'block');
                $('#contacts_other_label').css('display', 'block');
            }

            $('#contacts_other').css('display', 'block');

            $('#contacts_other').find( '#contacts_other_list' ).append( contacts_item );
        }


        if ( $.inArray(node.node, ajaximActiveList)>=0 )
        {
            var box = ajaximWindowManager.get(node.node);
            box.showTab();
            if (ajaximActiveContact == node.node)
            {
                box.show();
            }
        }

        if ( typeof ajaximWindows[node.node] != 'undefined' && ajaximWindows[node.node].isLoaded )
        {
            ajaximWindowManager.get(node.node).setOnline();
        }

        $('#contact_'+node.node).click(
            function(){
                var box = ajaximWindowManager.get(node.node);
                box.showTab();
                box.show();
                self.contactsWidget.hide();
            });

    }

    this.del = function(rosterItem){
        this.contacts[rosterItem.node] = rosterItem;
        this.deleteRoster(rosterItem.node);
    }

    this.deleteRoster = function(node){

        if( typeof this.contacts[node] == 'undefined')
            return;

        if ( $('#contact_'+node).length != 0 )
        {
            if ( ajaximContactManager.contacts[node]['is_friend'] )
            {
                this.count--;
                if ( this.count == 0 )
                {
                    $('#contacts_friends_label').css('display', 'none');
                    $('#contacts_other_label').css('display', 'none');
                }
            }
            else
            {
                this.countOthers--;
                if ( this.countOthers == 0 )
                {
                    $('#contacts_other').css('display', 'none');
                }
            }

            $('#contact_'+node).remove();
            //ajaximWindows[node].setOffline();
            if ( typeof ajaximWindows[node] != "undefined" )
            {
                ajaximWindows[node].setOffline();
            }
        /*else
            {
                delete self.contacts[node];
            }*/
        }


    }

    this.toggleRoster = function(){
        if ( this.getCount() != 0 )
        {
            $(window).bind( 'click.im_contacts_widget',
                function(e){
                    if(!$(e.target).is('.contacts_widget *, #main_im_tab *, .contacts_widget, #main_im_tab'))
                    {
                        self.contactsWidget.hide();
                    }

                });
            this.contactsWidget.css('left',  ($('.main_im_tab_container').width() - this.contactsWidget.width()) / 2 + 8  );
            this.contactsWidget.toggle();
        }
        else
        {
            $(document).unbind( 'click.im_contacts_widget');
            this.contactsWidget.hide();

            $('#main_im_tab').bind('mouseover.owtip', function(){

                OW.showTip($(this), {
                    side:'bot',
                    hideEvent: 'mouseout'
                });

            }).bind('mouseout.owtip',  function(){
                $(this).data('owTipHide', true);
            });

        }
    }

    this.getContacts = function(){
        return this.contacts;
    }

    this.get = function(node){

        if ( typeof this.contacts[node] == 'undefined' )
            return false;

        return this.contacts[node];
    }

    this.getCount = function(){
        return this.count+this.countOthers;
    }

    this.getOnlineCount = function(){
        /*var count=0;
        $.each(this.contacts, function(){
            if (!this.isOffline)
                {
                    count++;
                }
        });*/

        return this.onlineCount;
    }

    this.setOnlineCount = function( usersOnline )
    {
        this.onlineCount = usersOnline;

        if( this.onlineCount == 0 ){
            this.toggleRoster();
            $('span', '#main_im_tab').html($('#main_tab_label_proto').html());
            $('#main_im_tab').attr('title', $("#no_online_users").html() );
        }
        else
        {
            $('span', '#main_im_tab').html($('#main_tab_label_proto').html()+' ('+this.onlineCount+')');
            $('#main_im_tab').removeAttr('title');
        }

    }


    this.getLastMessageTimestamps = function(){

        $.each(this.contacts, function(){
            if ( this.type == 'online' )
            {
                self.timestamps[this.node] = parseInt(this.last_message_timestamp);
            }
            else
            {
                delete self.timestamps[this.node];
            }
        });

        return self.timestamps;
    }

    this.updateLastMessageTimestamp = function( node, timestamp )
    {
        this.contacts[node].last_message_timestamp = timestamp;
    }


}



$(function(){

    var im_console = document.getElementById('im_console');
    var main_im_tab = document.getElementById('main_im_tab');

    if ( typeof im_console == 'undefined' || im_console == null || typeof main_im_tab == 'undefined' || main_im_tab == null )
        return;

    $('#main_im_tab').parent().attr('id', 'main_im_tab_container');
    //    main_im_tab.parentNode.setAttribute('id', 'main_im_tab_container');
    main_im_tab.parentNode.appendChild(im_console.parentNode.removeChild(im_console));

    ajaximOnlineNowClickInProcess = [];
    ajaximGetLogInProcess = [];

    OW.getPing().addCommand('ajaxim', {
        params: {},
        before: function()
        {
            var timestamps = ajaximContactManager.getLastMessageTimestamps();
            var str = '';
            $.each(timestamps, function(key, time){
                str += '<p>'+key+":"+time+'</p>';
            });

            ajaximLog(str);

            var date = new Date();
            var time = parseInt(date.getTime() / 1000);

            this.params.action = 'get'
            this.params.lastMessageTimestamps = timestamps;
            this.params.onlineCount = ajaximContactManager.getOnlineCount();
            this.params.lastRequestTimestamp = time;

        },
        after: function( data )
        {

                if (typeof data.onlineCount != 'undefined' )
                {
                    if(data.onlineCount <= 15)
                    {
                        $('#contacts_online_list_label').hide();
                    }
                    else
                    {
                        $('#contacts_online_list_label').show();
                    }
                    ajaximContactManager.setOnlineCount(data.onlineCount);
                }

                if (typeof data.presenceList != 'undefined' && data.presenceList.length > 0)
                {
                    $.each(data.presenceList, function(){

                        if ( this.type == 'offline' )
                        {
                            ajaximContactManager.del( this );
                        }

                        if ( this.type == 'online' )
                        {
                            ajaximContactManager.add( this );
                        }

                    } );
                }

                if (data.messageListLength > 0)
                {
                    $.each(data.messageList, function(){
                        ajaximHandleMessage( this );
                    } );
                }
        }
    }).start(4000);

    OW.bind('base.online_now_click',
        function(userId){
            userId = parseInt(userId);

            if (ajaximOnlineNowClickInProcess[userId])
            {
                ajaximLog('double click', 1);
                return;
            }
            if (userId != ajaximMy.node)
            {
                ajaximOnlineNowClickInProcess[userId] = true;
                $.ajax({
                    url: ajaximUpdateUserInfoUrl,
                    type: 'POST',
                    data: {
                        userId: userId,
                        click: 'online_now_click'
                    },
                    success: function(data){

                        if ( typeof data != 'undefined')
                        {
                            if ( typeof data['warning'] != 'undefined' && data['warning'] )
                            {
                                OW.message(data['message'], data['type']);
                                ajaximOnlineNowClickInProcess[userId] = false;
                                return;
                            }
                            box = ajaximWindowManager.get(data['node']);

                            box.showTab();
                            OW.bind(data['node']+'_tabOpened', function(){

                                box.show();
                                OW.unbind(data['node']+'_tabOpened');
                            });
                        }

                        ajaximOnlineNowClickInProcess[userId] = false;
                    },
                    error: function(){
                        ajaximLog('onlinenow click error occured');
                        ajaximOnlineNowClickInProcess[userId] = false;
                    },
                    complete: function(){
                        ajaximOnlineNowClickInProcess[userId] = false;
                    },
                    dataType: 'json'
                });
            }
        });

    $('#main_im_tab').attr('title', $("#no_online_users").html() );
    $('#main_im_tab').bind('mouseover.owtip', function(){
        //$('#main_im_tab_container').bind('mouseover.owtip', function(){

        if ( ajaximContactManager.getCount() > 0 )
        {
            $(this).data('owTipHide', true);
            $(this).unbind('mouseover.owtip');
        }
        else
        {
            OW.showTip($(this), {
                side:'bot',
                hideEvent: 'mouseout'
            });
        }

    }).bind('mouseout.owtip',  function(){
        $(this).data('owTipHide', true);
    });

    ajaximContactManager = new AJAXIM_ContactManager();
    ajaximWindowManager = new AJAXIM_WindowManager();

    AudioPlayer.setup(ajaximSoundSwfUrl, {
                 width: 100
             });

});


function ajaximHandleMessage(new_message) {

    if( typeof new_message.message != 'undefined' ){
        var box;
        // Message to my other resources
        if( new_message.from == ajaximMy.node ){
            if ( new_message.timestamp == ajaximContactManager.contacts[new_message.to].last_message_timestamp )
            {
                return;
            }

            box = ajaximWindowManager.get(new_message.to);

            if ( !box.isOpened )
            {
                box.showTab(1);

                OW.bind(new_message.to+'_tabOpened', function(){

                    OW.bind(new_message.to+'_isLogLoaded', function(){

                        ajaximLog(new_message.to+'_isLogLoaded', 1);
                        box.show();
                        box.writeTimeDelimiter();
                        //new_message.message += '_isLogLoaded';
                        box.write(new_message);

                        OW.unbind(new_message.to+'_isLogLoaded');
                    });

                    OW.unbind(new_message.to+'_tabOpened');
                });

            }
            else
            {
                if (!box.isActive)
                {
                    ajaximLog('!box.isActive', 1);
                    box.show();
                }
                box.writeTimeDelimiter();
                //new_message.message += 'box.isActive';
                box.write(new_message);
            }



        }
        else{
            // Message to other contact
            if ( new_message.timestamp == ajaximContactManager.contacts[new_message.from].last_message_timestamp )
            {
                return;
            }



            box = ajaximWindowManager.get(new_message.from);
            if( !box.isOpened )
            {
                box.showTab(1);

                OW.bind(new_message.from+'_tabOpened', function(){

                    OW.bind(new_message.from+'_isLogLoaded', function(){

                        ajaximLog(new_message.from+'_isLogLoaded', 1);

                        box.write(new_message).setOnline().notifyOnNewMessage()

                        OW.unbind(new_message.from+'_isLogLoaded');
                    });

                    OW.unbind(new_message.from+'_tabOpened');
                });

            }
            else
            {
                box.writeTimeDelimiter();
                box.write(new_message);

                if (!box.isActive)
                {
                    ajaximLog('!box.isActive', 1);
                    box.notifyOnNewMessage();
                }
            }
        }
    }

}

function ajaximSetInvisible(value)
{
//    ajaximLog(value);
}

function ajaximSetSoundEnabled(value)
{
    //    ajaximLog(value);
    ajaximSoundEnabled = value;
}

/* DEBUG MODE */
//ajaximLog = function(message){};
function ajaximLog(message, append){
/*
    if (append)
    {
        $("#server_msg_container2").append('<p>'+message+'</p>');
    }
    else
    {
        $("#server_msg_container").html('<p>'+message+'</p>');
    } */
}
