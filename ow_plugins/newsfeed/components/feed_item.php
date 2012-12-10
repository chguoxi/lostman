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

/**
 * Feed Item component
 *
 * @author Sergey Kambalin <greyexpert@gmail.com>
 * @package ow_plugins.newsfeed.components
 * @since 1.0
 */
class NEWSFEED_CMP_FeedItem extends OW_Component
{
    /**
     *
     * @var NEWSFEED_CLASS_Action
     */
    private $action;
    private $autoId;
    private $displayType;

    private $remove = false;

    private $sharedData = array();

    public function __construct( NEWSFEED_CLASS_Action $action, $sharedData )
    {
        parent::__construct();

        $this->displayType = NEWSFEED_CMP_Feed::DISPLAY_TYPE_ACTION;
        $this->action = $action;
        $this->sharedData = $sharedData;

        $this->autoId = 'action-' . $this->sharedData['feedAutoId'] . '-' . $action->getId();

        $this->remove = OW::getUser()->isAuthenticated()
            && ( $action->getUserId() == OW::getUser()->getId() || OW::getUser()->isAuthorized('newsfeed') );
    }

    public function setDisplayType( $type )
    {
        $this->displayType = $type;
    }

    private function mergeData( $data, NEWSFEED_CLASS_Action $action )
    {
        $data = empty($data) ? array() : $data;

        $action = array( 'userId' => $action->getUserId(), 'createTime' => $action->getCreateTime() );
        $view = array( 'iconClass' => 'ow_ic_add', 'class' => '', 'style' => '' );
        $defaults = array(
            'line' => null, 'string' => null, 'content' => null, 'toolbar' => array(), 'context' => array(),
            'features' => array( 'comments', 'likes' )
        );

        foreach ( $defaults as $key => $value )
        {
            if ( !isset($data[$key]) )
            {
                $data[$key] = $value;
            }
        }

        if ( !isset($data['view']) || !is_array($data['view']) )
        {
            $data['view'] = array();
        }

        $data['view'] = array_merge($view, $data['view']);

        if ( !isset($data['action']) || !is_array($data['action']) )
        {
            $data['action'] = array();
        }

        $data['action'] = array_merge($action, $data['action']);

        return $data;
    }

    private function getActionData( NEWSFEED_CLASS_Action $action )
    {
        $activity = array();
        $createActivity = null;
        $lastActivity = null;

        foreach ( $action->getActivityList() as $a )
        {
            /* @var $a NEWSFEED_BOL_Activity */

            $activity[$a->id] = array(
                'activityType' => $a->activityType,
                'activityId' => $a->activityId,
                'id' => $a->id,
                'data' => json_decode($a->data, true),
                'timeStamp' => $a->timeStamp,
                'privacy' => $a->privacy,
                'userId' => $a->userId,
                'visibility' =>$a->visibility
            );

            if ( $createActivity === null && $a->activityType == NEWSFEED_BOL_Service::SYSTEM_ACTIVITY_CREATE )
            {
                $createActivity = $activity[$a->id];
            }

            if ( $lastActivity === null && !in_array($activity[$a->id]['activityType'], NEWSFEED_BOL_Service::getInstance()->SYSTEM_ACTIVITIES) )
            {
                $lastActivity = $activity[$a->id];
            }
        }

        $data = $this->mergeData($action->getData(), $action);

        $eventParams = array(
            'action' => array(
                'id' => $action->getId(),
                'entityType' => $action->getEntity()->type,
                'entityId' => $action->getEntity()->id,
                'pluginKey' => $action->getPluginKey(),
                'createTime' => $action->getCreateTime(),
                'userId' => $action->getUserId(),
                'data' => $data
            ),

            'activity' => $activity,
            'createActivity' => $createActivity,
            'lastActivity' => $lastActivity,
            'feedType' => $this->sharedData['feedType'],
            'feedId' => $this->sharedData['feedId'],
            'feedAutoId' => $this->sharedData['feedAutoId'],
            'autoId' => $this->autoId
        );

        $data = $action->getData();

        $override = $this->displayType == NEWSFEED_CMP_Feed::DISPLAY_TYPE_ACTIVITY && $lastActivity !== null;

        /* TODO: Hot Fix - require refactoring in the future*/
        $override = $override && ( !empty($lastActivity['data']['string']) || !empty($lastActivity['data']['line']) );

        if ( $override )
        {
            $actionOverride = $lastActivity['data'];

            $data['action'] = array(
                'userId' => $lastActivity['userId'],
                'createTime' => empty($actionOverride['timeStamp'])
                    ? $lastActivity['timeStamp']
                    : $actionOverride['timeStamp']
            );

            if ( !empty($actionOverride['params']) )
            {
                $actionOverride['action'] = $actionOverride['params'];
                unset($actionOverride['params']);
            }

            foreach ( $actionOverride as $key => $value )
            {
                if ( $key == 'view' )
                {
                    if ( is_array($value) )
                    {
                        $data[$key] = array_merge($data[$key], $value);
                    }
                }
                else
                {
                    $data[$key] = $value;
                }
            }
        }

        $event = new OW_Event('feed.on_item_render', $eventParams, $data);
        OW::getEventManager()->trigger($event);

        return $this->mergeData( $event->getData(), $action );
    }



    public function generateJs( $data )
    {
        $js = UTIL_JsGenerator::composeJsString('
            window.ow_newsfeed_feed_list[{$feedAutoId}].actions[{$uniq}] = new NEWSFEED_FeedItem({$autoId}, window.ow_newsfeed_feed_list[{$feedAutoId}]);
            window.ow_newsfeed_feed_list[{$feedAutoId}].actions[{$uniq}].construct({$data});
        ', array(
            'uniq' => $data['entityType'] . '.' . $data['entityId'],
            'feedAutoId' => $this->sharedData['feedAutoId'],
            'autoId' => $this->autoId,
            'id' => $this->action->getId(),
            'data' => array(
                'entityType' => $data['entityType'],
                'entityId' => $data['entityId'],
                'id' => $data['id'],
                'updateStamp' => $this->action->getUpdateTime(),
                'likes' => $data['likes'] ? $data['likes']['count'] : 0,
                'comments' => $data['comments'] ? $data['comments']['count'] : 0,
                'cycle' => $data['cycle'],
                'displayType' => $this->displayType
            )
        ));

        OW::getDocument()->addOnloadScript($js, 50);
    }

    private function processAssigns( $content, $assigns )
    {
        $search = array();
        $values = array();

        foreach ( $assigns as $key => $item )
        {
            $search[] = '[ph:' . $key . ']';
            $values[] = $item;
        }

        $result = str_replace($search, $values, $content);
        $result = preg_replace('/\[ph\:\w+\]/', '', $result);

        return $result;
    }

    private function applyTemplates( $var )
    {
        if ( !is_array($var) )
        {
            return $var;
        }

        if ( !empty($var['templateFile']) )
        {
            $tplFile = $var['templateFile'];
        }
        else if ( !empty($var['template']) )
        {
            $tplFile = OW::getPluginManager()->getPlugin('newsfeed')->getViewDir() . 'templates' . DS . trim($var['template']) . '.html';
        }
        else
        {
            return '';
        }

        $template = new NEWSFEED_CMP_Template();
        $template->setTemplate($tplFile);

        $vars = empty($var['vars']) || !is_array($var['vars']) ? array() : $var['vars'];
        foreach ( $vars as $k => $v )
        {
            $template->assign($k, $v);
        }

        return $template->render();
    }

    private function getUserInfo( $userId )
    {
        $usersInfo = $this->sharedData['usersInfo'];

        if ( !in_array($userId, $this->sharedData['usersIdList']) )
        {
            $userInfo = BOL_AvatarService::getInstance()->getDataForUserAvatars(array($userId));

            $usersInfo['avatars'][$userId] = $userInfo[$userId]['src'];
            $usersInfo['urls'][$userId] = $userInfo[$userId]['url'];
            $usersInfo['names'][$userId] = $userInfo[$userId]['title'];
            $usersInfo['roleLabels'][$userId] = array(
                'label' => $userInfo[$userId]['label'],
                'labelColor' => $userInfo[$userId]['labelColor']
            );
        }

        $user = array(
            'id' => $userId,
            'avatarUrl' => $usersInfo['avatars'][$userId],
            'url' => $usersInfo['urls'][$userId],
            'name' => $usersInfo['names'][$userId],
            'roleLabel' => empty($usersInfo['roleLabels'][$userId])
                ? array('label' => '', 'labelColor' => '')
                : $usersInfo['roleLabels'][$userId]
        );

        return $user;
    }

    public function renderMarkup( $cycle )
    {
        $action = $this->action;
        $data = $this->getActionData($action);

        $usersInfo = $this->sharedData['usersInfo'];

        $configs = $this->sharedData['configs'];

        $userNameEmbed = '<a href="' . $usersInfo['urls'][$action->getUserId()] . '"><b>' . $usersInfo['names'][$action->getUserId()] . '</b></a>';
        $assigns = empty($data['assign']) ? array() : $data['assign'];
        $replaces = array_merge(array(
            'user' => $userNameEmbed
        ), $assigns);

        $data['content'] = $this->applyTemplates($data['content']);

        foreach ( $assigns as & $item )
        {
            $item = $this->applyTemplates($item);
        }

        $permalink = empty($data['permalink'])
            ? NEWSFEED_BOL_Service::getInstance()->getActionPermalink($action->getId(), $this->sharedData['feedType'], $this->sharedData['feedId'])
            : null;

        $userId = (int) $data['action']['userId'];

        $item = array(
            'id' => $action->getId(),
            'view' => $data['view'],
            'toolbar' => $data['toolbar'],
            'string' => $this->processAssigns($data['string'], $assigns),
            'line' => $this->processAssigns($data['line'], $assigns),
            'content' => $this->processAssigns($data['content'], $assigns),
            'context' => $data['context'],
            'entityType' => $action->getEntity()->type,
            'entityId' => $action->getEntity()->id,
            'createTime' => UTIL_DateTime::formatDate($data['action']['createTime']),
            'updateTime' => $action->getUpdateTime(),
            'featuresExpanded' => (bool) $configs['features_expanded'],

            'user' => $this->getUserInfo($userId),
            'remove' => $this->remove,
            'permalink' => $permalink,

            'cycle' => $cycle,

            'comments' => false,
            'likes' => false
        );

        if ( $configs['allow_comments'] && in_array('comments', $data['features']) )
        {
            $authGroup = $action->getPluginKey();
            $authActionDto = BOL_AuthorizationService::getInstance()->findAction($action->getPluginKey(), 'add_comment');

            if ( $authActionDto === null )
            {
                $authGroup = 'newsfeed';
            }

            $commentsParams = new BASE_CommentsParams($authGroup, $action->getEntity()->type);
            $commentsParams->setEntityId($action->getEntity()->id);
            $commentsParams->setDisplayType(BASE_CommentsParams::DISPLAY_TYPE_BOTTOM_FORM_WITH_PARTIAL_LIST_AND_MINI_IPC);
            $commentsParams->setCommentCountOnPage($configs['comments_count']);
            $commentsParams->setOwnerId($action->getUserId());
            $commentCmp = new BASE_CMP_Comments($commentsParams);
            $commentTemplate = OW::getPluginManager()->getPlugin('newsfeed')->getCmpViewDir() . 'comments.html';
            $commentCmp->setTemplate($commentTemplate);
            $item['comments']['cmp'] = $commentCmp->render();
            $item['comments']['count'] = BOL_CommentService::getInstance()->findCommentCount($action->getEntity()->type, $action->getEntity()->id);
            $item['comments']['allow'] = OW::getUser()->isAuthorized($authGroup, 'add_comment');
        }

        if ( $configs['allow_likes'] && in_array('likes', $data['features']) )
        {
           $likes = NEWSFEED_BOL_Service::getInstance()->findEntityLikes($action->getEntity()->type, $action->getEntity()->id);

           $userLiked = false;
           foreach ( $likes as $like )
           {
                if ( $like->userId == OW::getUser()->getId() )
                {
                    $userLiked = true;
                }
           }

           $likeCmp = new NEWSFEED_CMP_Likes($action->getEntity()->type, $action->getEntity()->id, $likes);
           $item['likes']['count'] = count($likes);
           $item['likes']['liked'] = $userLiked;
           $item['likes']['allow'] = OW::getUser()->isAuthenticated() && $action->getUserId() != OW::getUser()->getId();
           $item['likes']['cmp'] = $likeCmp->render();
        }

        $item['autoId'] = $this->autoId;

        $this->generateJs($item);

        $this->assign('item', $item);

        return $this->render();
    }
}