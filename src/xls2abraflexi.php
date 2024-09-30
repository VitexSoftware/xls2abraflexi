<?php

declare(strict_types=1);

/**
 * This file is part of the xls2abralexi package
 *
 * https://multiflexi.eu/
 *
 * (c) Vítězslav Dvořák <http://vitexsoftware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Utopia\Xls2abralexi;

require_once '../vendor/autoload.php';

\define('APP_NAME', 'XLS2AbraFlexi');

if (file_exists(\dirname(__DIR__).'/.env')) {
    \Ease\Shared::instanced()->loadConfig(\dirname(__DIR__).'/.env', true);
}

new \Ease\Locale('cs_CZ', '../i18n', 'xls2abraflexi');

\Ease\Shared::init([
    'ABRAFLEXI_URL',
    'ABRAFLEXI_LOGIN',
    'ABRAFLEXI_PASSWORD',
    'ABRAFLEXI_COMPANY',
    'ABRAFLEXI_INVOICE_TYPE',
], '../.env');

$engine = new Importer();
$engine->import('../tests/fleximport');

if (\Ease\Functions::cfg('INVOICE_DOWNLOAD') && \Ease\Functions::cfg('REPORTS_DIR')) {
    //    $engine->addStatusMessage(sprintf(_('Invoice saved as %s'), $engine->downloadInFormat('pdf', \Ease\Functions::cfg('REPORTS_DIR'))));
    //    $engine->addStatusMessage(sprintf(_('Invoice saved as %s'), $engine->downloadInFormat('isdocx', \Ease\Functions::cfg('REPORTS_DIR'))));
}
