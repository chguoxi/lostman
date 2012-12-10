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
 * Feed component
 *
 * @author Sergey Kambalin <greyexpert@gmail.com>
 * @package ow_plugins.newsfeed.components
 * @since 1.0
 */
class NEWSFEED_CMP_Feed extends OW_Component
{
    private static $feedCounter = 0;

    /**
     *
     * @var NEWSFEED_CLASS_Driver
     */
    private $driver;

    private $data = array();
    private $displayType = 'action';
    private $autoId;

    private $actionList = null;

    const DISPLAY_TYPE_ACTION = 'action';
    const DISPLAY_TYPE_ACTIVITY = 'activity';
    const DISPLAY_TYPE_PAGE = 'page';

    public function __construct( NEWSFEED_CLASS_Driver $driver, $feedType, $feedId )
    {
        parent::__construct();
        self::$feedCounter++;

        $this->autoId = 'feed' . self::$feedCounter;
        $this->driver = $driver;

        $this->data['feedType'] = $feedType;
        $this->data['feedId'] = $feedId;
        $this->data['feedAutoId'] = $this->autoId;
        $this->data['startTime'] = time();
        $this->data['displayType'] = $this->displayType;
    }

    public function addAction( NEWSFEED_CLASS_Action $action )
    {
        if ( $this->actionList === null )
        {
            $this->actionList = array();
        }

        $this->actionList[$action->getId()] = $action;
    }

    public function setDisplayType( $type )
    {
        $this->displayType = $type;
    }

    public function addStatusForm( $type, $id, $visibility = null )
    {
        $status = OW::getEventManager()->call('feed.get_status_update_cmp', array(
            'entityType' => $type,
            'entityId' => $id,
            'feedAutoId' => $this->autoId,
            'visibility' => $visibility
        ));

        if ( $status === null )
        {
            $cmp = new NEWSFEED_CMP_UpdateStatus($this->autoId, $type, $id, $visibility);
        }
        else
        {
            $cmp = $status;
        }

        $this->addComponent('status', $cmp);
    }

    public function setup( $data )
    {
        $this->data = array_merge($this->data, $data);
        $driverOptions = $this->data;

        $driverOptions['offset'] = 0;

        $this->driver->setup($driverOptions);
    }

    public function initializeJs()
    {
        OW::getDocument()->addScript( OW::getPluginManager()->getPlugin('newsfeed')->getStaticJsUrl() . 'newsfeed.js' );

        $total = $this->getActionsCount();

        $js = UTIL_JsGenerator::composeJsString('
            window.ow_newsfeed_const.LIKE_RSP = {$like};
            window.ow_newsfeed_const.UNLIKE_RSP = {$unlike};
            window.ow_newsfeed_const.DELETE_RSP = {$delete};
            window.ow_newsfeed_const.LOAD_ITEM_RSP = {$loadItem};
            window.ow_newsfeed_const.LOAD_ITEM_LIST_RSP = {$loadItemList};
            window.ow_newsfeed_const.REMOVE_ATTACHMENT = {$removeAttachment};
        ', array(
            'like' => OW::getRouter()->urlFor('NEWSFEED_CTRL_Ajax', 'like'),
            'unlike' => OW::getRouter()->urlFor('NEWSFEED_CTRL_Ajax', 'unlike'),
            'delete' => OW::getRouter()->urlFor('NEWSFEED_CTRL_Ajax', 'remove'),
            'loadItem' => OW::getRouter()->urlFor('NEWSFEED_CTRL_Ajax', 'loadItem'),
            'loadItemList' => OW::getRouter()->urlFor('NEWSFEED_CTRL_Ajax', 'loadItemList'),
            'removeAttachment' => OW::getRouter()->urlFor('NEWSFEED_CTRL_Ajax', 'removeAttachment')
        ));

        OW::getDocument()->addOnloadScript($js);

        $js = UTIL_JsGenerator::composeJsString('
            window.ow_newsfeed_feed_list[{$autoId}] = new NEWSFEED_Feed({$autoId}, {$data});
            window.ow_newsfeed_feed_list[{$autoId}].totalItems = {$total};
        ', array(
            'total' => $total,
            'autoId' => $this->autoId,
            'data' => array( 'data' => $this->data, 'driver' => $this->driver->getState() )
        ));

        OW::getDocument()->addOnloadScript($js, 50);
    }

    protected function getActionsList()
    {
        if ( $this->actionList === null )
        {
            $this->actionList = $this->driver->getActionList();
        }

        return $this->actionList;
    }

    protected function getActionsCount()
    {
        return $this->driver->getActionCount();
    }

    public function render()
    {
        $this->actionList = $this->getActionsList();
        $this->initializeJs();

        $this->data['displayType'] = $this->displayType;

        $list = new NEWSFEED_CMP_FeedList($this->actionList, $this->data);
        $list->setDisplayType($this->displayType);

        $this->assign('list', $list->render());
        $this->assign('autoId', $this->autoId);
        $this->assign('data', $this->data);

        if ( $this->displayType == self::DISPLAY_TYPE_PAGE )
        {
            $viewMore = false;
        }
        else
        {
            $viewMore = $this->data['viewMore'] && $this->getActionsCount() > $this->data['displayCount'];
        }

        $this->assign('viewMore', $viewMore);

        return parent::render();
    }
}