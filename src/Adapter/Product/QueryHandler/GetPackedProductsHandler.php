<?php
/**
 * 2007-2020 PrestaShop SA and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

declare(strict_types=1);

namespace PrestaShop\PrestaShop\Adapter\Product\QueryHandler;

use Pack;
use PrestaShop\PrestaShop\Core\Domain\Product\Query\GetPackedProducts;
use PrestaShop\PrestaShop\Core\Domain\Product\QueryHandler\GetPackedProductsHandlerInterface;
use PrestaShop\PrestaShop\Core\Domain\Product\QueryResult\PackedProduct;

/**
 * Handles GetPackedProducts query using legacy object model
 */
class GetPackedProductsHandler implements GetPackedProductsHandlerInterface
{
    /**
     * @var int
     */
    private $defaultLangId;

    /**
     * @param int $defaultLangId
     */
    public function __construct(int $defaultLangId)
    {
        $this->defaultLangId = $defaultLangId;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(GetPackedProducts $query): array
    {
        $packId = $query->getPackId()->getValue();

        $packedItems = Pack::getItems($packId, $this->defaultLangId);

        $packedProducts = [];
        foreach ($packedItems as $packedItem) {
            $packedProducts[] = new PackedProduct(
                (int) $packedItem->id,
                (int) $packedItem->pack_quantity,
                (int) $packedItem->id_pack_product_attribute
            );
        }

        return $packedProducts;
    }
}
