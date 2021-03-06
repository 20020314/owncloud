<?php

/**
 * ownCloud - roundcube mail plugin
 *
 * @author Martin Reinhardt and David Jaedke
 * @copyright 2012 Martin Reinhardt contact@martinreinhardt-online.de
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

// ensure that only admin user access this page
OCP\User::checkAdminUser();

OCP\Util::addStyle('roundcube', 'adminSettings');

// fill template
$params = array('maildir', 'removeHeaderNav', 'removeControlNav', 'autoLogin', 'noSSLverify','enableDebug', 'rcHost', 'rcPort', 'rcInternalAddress', 'rcRefreshInterval');


// workaround to detect OC version
$ocVersion = OCP\Util::getVersion();
// below OC7
if ($ocVersion[0] < 7) {
	OCP\Util::addScript('roundcube', 'adminSettings.oc6');
	$tmpl = new OCP\Template('roundcube', 'tpl.adminSettings.oc6');
} else {
	// OC7.x
	if ($ocVersion[0] < 8) {
		OCP\Util::addScript('roundcube', 'adminSettings.oc7');
		$tmpl = new OCP\Template('roundcube', 'tpl.adminSettings.oc7');
	} else {
		OCP\Util::addScript('roundcube', 'adminSettings');
		$tmpl = new OCP\Template('roundcube', 'tpl.adminSettings');
	}
}


foreach ($params as $param) {
	$value = OCP\Config::getAppValue('roundcube', $param, '');
	$tmpl -> assign($param, $value);
}

// workaround to detect OC version
$tmpl->assign('ocVersion', $ocVersion);

return $tmpl -> fetchPage();
