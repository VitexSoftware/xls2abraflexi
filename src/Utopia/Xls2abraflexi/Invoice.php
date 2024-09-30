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

/**
 * Description of Invoice.
 *
 * @author Vitex <info@vitexsoftware.cz>
 */
class Invoice extends \AbraFlexi\FakturaVydana
{
    public function isKnown($invoiceNumber)
    {
        return $this->recordExists(['kod' => $invoiceNumber]);
    }
}
