<?php
/*
 * ----------------------------------------------------------------------
 *
 *                          Borlabs Cookie
 *                      developed by Borlabs
 *
 * ----------------------------------------------------------------------
 *
 * Copyright 2018-2020 Borlabs - Benjamin A. Bornschein. All rights reserved.
 * This file may not be redistributed in whole or significant part.
 * Content of this file is protected by international copyright laws.
 *
 * ----------------- Borlabs Cookie IS NOT FREE SOFTWARE -----------------
 *
 * @copyright Borlabs - Benjamin A. Bornschein, https://borlabs.io
 * @author Benjamin A. Bornschein, Borlabs ben@borlabs.io
 *
 */

namespace BorlabsCookie\Cookie\Frontend\ContentBlocker;

use BorlabsCookie\Cookie\Frontend\ContentBlocker;

class Instagram
{
    private static $instance;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
    }

    protected function __construct()
    {
    }

    /**
     * getDefault function.
     *
     * @access public
     * @return void
     */
    public function getDefault()
    {
        $data = [
            'contentBlockerId' => 'instagram',
            'name' => 'Instagram',
            'description' => '',
            'privacyPolicyURL' => _x('https://www.instagram.com/legal/privacy/', 'Frontend / Content Blocker / Instagram / URL', 'borlabs-cookie'),
            'hosts' => [
                'instagram.com',
            ],
            'previewHTML' => '<div class="_brlbs-content-blocker">
	<div class="_brlbs-embed _brlbs-instagram">
    	<img class="_brlbs-thumbnail" src="%%thumbnail%%" alt="%%name%%">
		<div class="_brlbs-caption">
			<p>' . _x("By loading the post, you agree to Instagram's privacy policy.", 'Frontend / Content Blocker / Instagram / Text', 'borlabs-cookie') .'<br><a href="%%privacy_policy_url%%" target="_blank" rel="nofollow noopener noreferrer">' . _x('Learn more', 'Frontend / Content Blocker / Instagram / Text', 'borlabs-cookie') . '</a></p>
			<p><a class="_brlbs-btn" href="#" data-borlabs-cookie-unblock role="button">' . _x('Load post', 'Frontend / Content Blocker / Instagram / Text', 'borlabs-cookie') . '</a></p>
			<p><label><input type="checkbox" name="unblockAll" value="1" checked> <small>' . _x('Always unblock Instagram posts', 'Frontend / Content Blocker / Instagram / Text', 'borlabs-cookie') . '</small></label></p>
		</div>
	</div>
</div>',
            'previewCSS' => '.BorlabsCookie ._brlbs-instagram {
    border: 1px solid #e1e8ed;
    border-radius: 6px;
	max-width: 516px;
	padding: 3px 0;
}


.BorlabsCookie ._brlbs-instagram a._brlbs-btn {
	background: #3897f0;
	border-radius: 4px;
}

.BorlabsCookie ._brlbs-instagram a._brlbs-btn:hover {
	background: #117ee4;
}
',
            'globalJS' => '',
            'initJS' => 'if (typeof instgrm === "object") { instgrm.Embeds.process(); }',
            'settings' => [
                'executeGlobalCodeBeforeUnblocking' => false,
            ],
            'status' => true,
            'undeletable' => true,
        ];

        return $data;
    }

    /**
     * modify function.
     *
     * @access public
     * @param mixed $content
     * @param mixed $atts (default: [])
     * @return void
     */
    public function modify($content, $atts = [])
    {
        // Get settings of the Content Blocker
        $contentBlockerData = ContentBlocker::getInstance()->getContentBlockerData('instagram');

        // Default thumbnail
        $thumbnail = BORLABS_COOKIE_PLUGIN_URL . 'images/cb-instagram.png';

        // Get the title which was maybe set via title-attribute in a shortcode
        $title = ContentBlocker::getInstance()->getCurrentTitle();

        // If no title was set use the Content Blocker name as title
        if (empty($title)) {
            $title = $contentBlockerData['name'];
        }

        // Replace text variables
        if (!empty($atts)) {

            foreach ($atts as $key => $value) {
                $contentBlockerData['previewHTML'] = str_replace('%%'.$key.'%%', $value, $contentBlockerData['previewHTML']);
            }
        }

        $contentBlockerData['previewHTML'] = str_replace(
            [
                '%%name%%',
                '%%thumbnail%%',
                '%%privacy_policy_url%%',
            ],
            [
                $title,
                $thumbnail,
                $contentBlockerData['privacyPolicyURL'],
            ],
            $contentBlockerData['previewHTML']
        );

        return $contentBlockerData['previewHTML'];
    }
}
