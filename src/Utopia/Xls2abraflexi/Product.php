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
 * Description of Product.
 *
 * @author Vitex <info@vitexsoftware.cz>
 */
class Product extends \AbraFlexi\Cenik
{
    public function createNew($productData)
    {
        $this->addStatusMessage($productData['nazev'], $this->sync($productData) ? 'success' : 'error');

        return $this;
    }

    public function loadByEan($ean)
    {
        $candidat = $this->getColumnsFromAbraFlexi('kod', ['eanKod' => $ean]);

        return $this->loadFromAbraFlexi(\AbraFlexi\Functions::code($candidat[0]['kod']));
    }
}
