<?php

/**
 * This software is intended for use with Oxwall Free Community Software http://www.oxwall.org/ and is
 * licensed under The BSD license.

 * ---
 * Copyright (c) 2011, Oxwall Foundation
 * All rights reserved.

 * Redistribution and use in source and binary forms, with or without modification, are permitted provided that the
 * following conditions are met:
 *
 *  - Redistributions of source code must retain the above copyright notice, this list of conditions and
 *  the following disclaimer.
 *
 *  - Redistributions in binary form must reproduce the above copyright notice, this list of conditions and
 *  the following disclaimer in the documentation and/or other materials provided with the distribution.
 *
 *  - Neither the name of the Oxwall Foundation nor the names of its contributors may be used to endorse or promote products
 *  derived from this software without specific prior written permission.

 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES,
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
function birthdays_add_userlist_data( BASE_CLASS_EventCollector $event )
{
    $event->add(
        array(
            'label' => OW::getLanguage()->text('base', 'user_list_menu_item_birthdays'),
            'url' => OW::getRouter()->urlForRoute('base_user_lists', array('list' => 'birthdays')),
            'iconClass' => 'ow_ic_calendar',
            'key' => 'birthdays',
            'order' => 5,
            'dataProvider' => array(BIRTHDAYS_BOL_Service::getInstance(), 'getUserListData')
        )
    );
}
OW::getEventManager()->bind('base.add_user_list', 'birthdays_add_userlist_data');

$credits = new BIRTHDAYS_CLASS_Credits();
OW::getEventManager()->bind('usercredits.on_action_collect', array($credits, 'bindCreditActionsCollect'));

function birthdays_privacy_add_action( BASE_CLASS_EventCollector $event )
{
    $language = OW::getLanguage();

    $action = array(
        'key' => 'birthdays_view_my_birthdays',
        'pluginKey' => 'birthdays',
        'label' => $language->text('birthdays', 'privacy_action_view_my_birthday'),
        'description' => '',
        'defaultValue' => 'everybody'
    );

    $event->add($action);
}
OW::getEventManager()->bind('plugin.privacy.get_action_list', 'birthdays_privacy_add_action');

function birthdays_on_today_birthday( OW_Event $e )
{
    $params = $e->getParams();
    $userIds = $params['userIdList'];
    $usersData = BOL_AvatarService::getInstance()->getDataForUserAvatars($userIds);

    $actionParams = array(
        'entityType' => 'birthday',
        'pluginKey' => 'birthdays',
        'replace' => true
    );
    $actionData = array(
        'time' => time()
    );

    foreach ( $userIds as $userId )
    {
        $userEmbed = '<a href="' . $usersData[$userId]['url'] . '">' . $usersData[$userId]['title'] . '</a>';
        $actionParams['userId'] = $userId;
        $actionParams['entityId'] = $userId;
        $actionData['line'] = OW::getLanguage()->text('birthdays', 'feed_item_line', array('user' => $userEmbed));
        $actionData['content'] = OW::getThemeManager()->processDecorator('avatar_item', $usersData[$userId]);
        $event = new OW_Event('feed.action', $actionParams, $actionData);

        OW::getEventManager()->trigger($event);
    }
}
OW::getEventManager()->bind('birthdays.today_birthday_user_list', 'birthdays_on_today_birthday');

function birthdays_on_change_privacy( OW_Event $e )
{
    $params = $e->getParams();
    $userId = (int) $params['userId'];

    $actionList = $params['actionList'];

    if ( empty($actionList['birthdays_view_my_birthdays']) )
    {
        return;
    }

    $privacyDto = BIRTHDAYS_BOL_Service::getInstance()->findBirthdayPrivacyByUserId($userId);

    if ( empty($privacyDto) )
    {
        $privacyDto = new BIRTHDAYS_BOL_Privacy();
        $privacyDto->userId = $userId;
    }

    $privacyDto->privacy = $actionList['birthdays_view_my_birthdays'];

    BIRTHDAYS_BOL_Service::getInstance()->saveBirthdayPrivacy($privacyDto);
}
OW::getEventManager()->bind('plugin.privacy.on_change_action_privacy', 'birthdays_on_change_privacy');

function birthdays_on_user_unregister( OW_Event $e )
{
    $params = $e->getParams();
    $userId = (int) $params['userId'];
    BIRTHDAYS_BOL_Service::getInstance()->deleteBirthdayPrivacyByUserId($userId);
}
OW::getEventManager()->bind(OW_EventManager::ON_USER_UNREGISTER, 'birthdays_on_user_unregister');

function birthdays_feed_collect_configurable_activity( BASE_CLASS_EventCollector $event )
{
    $language = OW::getLanguage();
    $event->add(array(
        'label' => $language->text('birthdays', 'feed_content_label'),
        'activity' => '*:birthday'
    ));
}
OW::getEventManager()->bind('feed.collect_configurable_activity', 'birthdays_feed_collect_configurable_activity');

function birthdays_feed_comment( OW_Event $event )
{
    $params = $event->getParams();
    $data = $event->getData();
    
    if ( $params['entityType'] != 'birthday' )
    {
        return;
    }

    $userId = (int) $params['entityId'];

    if ( $userId == $params['userId'] )
    {
        $string = OW::getLanguage()->text('birthdays', 'feed_activity_self_birthday_string');
    }
    else
    {
        $userName = BOL_UserService::getInstance()->getDisplayName($userId);
        $userUrl = BOL_UserService::getInstance()->getUserUrl($userId);
        $userEmbed = '<a href="' . $userUrl . '">' . $userName . '</a>';

        $string = OW::getLanguage()->text('birthdays', 'feed_activity_birthday_string', array(
                    'user' => $userEmbed
                ));
    }

    OW::getEventManager()->trigger(new OW_Event('feed.activity', array(
            'activityType' => 'comment',
            'activityId' => $params['commentId'],
            'entityId' => $userId,
            'entityType' => $params['entityType'],
            'userId' => $params['userId'],
            'pluginKey' => 'birthdays'
            ), array(
            'string' => $string,
            'line' => null
        )));

    if ( $userId != OW::getUser()->getId() )
    {
        $userName = BOL_UserService::getInstance()->getDisplayName(OW::getUser()->getId());
        $userUrl = BOL_UserService::getInstance()->getUserUrl(OW::getUser()->getId());
        $userEmbed = '<a href="' . $userUrl . '">' . $userName . '</a>';

        $string = OW::getLanguage()->text('birthdays', 'email_notification_comment', array( 'user' => $userEmbed ));

        $url = OW::getEventManager()->call( 'feed.get_item_permalink', array( 'actionId' =>  $userId, 'entityType' => $params['entityType'] ));

        $paramsList = array(
            'plugin' => 'birthdays',
            'action' => 'comment',
            'string' => $string,
            'url' => $url,
            'content' => $data['message'],
            'time' => time(),
            'userId' => $params['entityId']
        );

        $notifyEvent = new OW_Event('base.notify', $paramsList);
        OW::getEventManager()->trigger($notifyEvent);
    }
}
OW::getEventManager()->bind('feed.after_comment_add', 'birthdays_feed_comment');

function birthdays_feed_like( OW_Event $event )
{
    $params = $event->getParams();

    if ( $params['entityType'] != 'birthday' )
    {
        return;
    }

    $userId = (int) $params['entityId'];

    $userName = BOL_UserService::getInstance()->getDisplayName($userId);
    $userUrl = BOL_UserService::getInstance()->getUserUrl($userId);
    $userEmbed = '<a href="' . $userUrl . '">' . $userName . '</a>';
    
    OW::getEventManager()->trigger(new OW_Event('feed.activity', array(
            'activityType' => 'like',
            'activityId' => $params['userId'],
            'entityId' => $userId,
            'entityType' => $params['entityType'],
            'userId' => $params['userId'],
            'pluginKey' => 'birthdays'
            ), array(
            'string' => OW::getLanguage()->text('birthdays', 'feed_activity_birthday_string_like', array('user' => $userEmbed)),
            'line' => null
        )));

    if ( $userId != OW::getUser()->getId() )
    {
        $userName = BOL_UserService::getInstance()->getDisplayName(OW::getUser()->getId());
        $userUrl = BOL_UserService::getInstance()->getUserUrl(OW::getUser()->getId());
        $userEmbed = '<a href="' . $userUrl . '">' . $userName . '</a>';

        $string = OW::getLanguage()->text('birthdays', 'email_notification_like', array( 'user' => $userEmbed ));

        $url = OW::getEventManager()->call( 'feed.get_item_permalink', array( 'actionId' =>  $userId, 'entityType' => $params['entityType'] ));

        $paramsList = array(
            'plugin' => 'birthdays',
            'action' => 'like',
            'string' => $string,
            'url' => $url,
            'time' => time(),
            'userId' => $params['entityId']
        );

        $notifyEvent = new OW_Event('base.notify', $paramsList);
        OW::getEventManager()->trigger($notifyEvent);
    }
}
OW::getEventManager()->bind('feed.after_like_added', 'birthdays_feed_like');

function birthdays_notification_actions( OW_Event $event )
{
        $event->add(array(
            'section' => 'birthdays',
            'action' => 'comment',
            'sectionIcon' => 'ow_ic_calendar',
            'sectionLabel' => OW::getLanguage()->text('birthdays', 'email_notifications_section_label'),
            'description' => OW::getLanguage()->text('birthdays', 'email_notifications_setting_status_comment'),
            'selected' => true
        ));

        $event->add(array(
            'section' => 'birthdays',
            'action' => 'like',
            'sectionIcon' => 'ow_ic_calendar',
            'sectionLabel' => OW::getLanguage()->text('birthdays', 'email_notifications_section_label'),
            'description' => OW::getLanguage()->text('birthdays', 'email_notifications_setting_status_like'),
            'selected' => true
        ));
}
OW::getEventManager()->bind('base.notify_actions', 'birthdays_notification_actions');