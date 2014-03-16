<?php

namespace Pim\Bundle\CatalogBundle\Entity;

use JMS\Serializer\Annotation\ExclusionPolicy;
use Pim\Bundle\FlexibleEntityBundle\Model\AbstractAttributeOptionValue;

/**
 * Attribute option values
 *
 * @author    Nicolas Dupont <nicolas@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 * @ExclusionPolicy("all")
 */
class AttributeOptionValue extends AbstractAttributeOptionValue
{
    /**
     * Overrided to change target option name
     *
     * @var AttributeOption $option
     */
    protected $option;

    /**
     * Returns the label of the attribute
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->value;
    }

    /**
     * Sets the label
     *
     * @param string $label
     *
     * @return AttributeOptionValue
     */
    public function setLabel($label)
    {
        $this->value = $label;

        return $this;
    }
}
