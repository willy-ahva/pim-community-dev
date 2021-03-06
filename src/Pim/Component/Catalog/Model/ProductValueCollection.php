<?php

namespace Pim\Component\Catalog\Model;

/**
 * Business collection to handle product values.
 *
 * The collection is indexed internally by attribute-channel-locale. The index could be for instance:
 *      description-ecommerce-en_US     for a localizable and scopable attribute
 *      name-<all_channels>-en_US       for a localizable attribute
 *      price-ecommerce-<all_locales>   for a scopable attribute
 *
 * This collection also contains the list of attributes used in the collection. The attributes
 * are indexed by attribute codes.
 *
 * The collection also contains the list of unique values.
 *
 * @author    Julien Janvier <j.janvier@gmail.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ProductValueCollection implements ProductValueCollectionInterface
{
    /** @var ProductValueInterface[] */
    private $values;

    /** @var ProductValueInterface[] */
    private $uniqueValues;

    /** @var AttributeInterface[] */
    private $attributes;

    /**
     * @param ProductValueInterface[] $values
     */
    public function __construct(array $values = [])
    {
        $this->values = [];
        $this->uniqueValues = [];
        $this->attributes = [];

        foreach ($values as $value) {
            $this->add($value);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return $this->values;
    }

    /**
     * {@inheritDoc}
     */
    public function first()
    {
        return reset($this->values);
    }

    /**
     * {@inheritDoc}
     */
    public function last()
    {
        return end($this->values);
    }

    /**
     * {@inheritDoc}
     */
    public function key()
    {
        return key($this->values);
    }

    /**
     * {@inheritDoc}
     */
    public function next()
    {
        return next($this->values);
    }

    /**
     * {@inheritDoc}
     */
    public function current()
    {
        return current($this->values);
    }

    /**
     * {@inheritDoc}
     */
    public function removeKey($key)
    {
        if (!array_key_exists($key, $this->values)) {
            return null;
        }

        $removed = $this->values[$key];
        unset($this->values[$key]);
        unset($this->uniqueValues[$key]);

        $this->reIndexAllAttributes();

        return $removed;
    }

    /**
     * {@inheritDoc}
     */
    public function remove(ProductValueInterface $value)
    {
        $key = array_search($value, $this->values, true);

        if (false === $key) {
            return false;
        }

        unset($this->values[$key]);
        unset($this->uniqueValues[$key]);

        $this->reIndexAllAttributes();

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function removeByAttribute(AttributeInterface $attribute)
    {
        $removed = false;
        foreach ($this->values as $value) {
            if ($attribute === $value->getAttribute()) {
                $this->remove($value);
                $removed = true;
            }
        }

        return $removed;
    }

    /**
     * {@inheritDoc}
     */
    public function containsKey($key)
    {
        return array_key_exists($key, $this->values);
    }

    /**
     * {@inheritDoc}
     */
    public function contains(ProductValueInterface $value)
    {
        return in_array($value, $this->values, true);
    }

    /**
     * {@inheritDoc}
     */
    public function getByKey($key)
    {
        return isset($this->values[$key]) ? $this->values[$key] : null;
    }

    /**
     * {@inheritDoc}
     */
    public function getByCodes($attributeCode, $channelCode = null, $localeCode = null)
    {
        $channelCode = null !== $channelCode ? $channelCode : '<all_channels>';
        $localeCode = null !== $localeCode ? $localeCode : '<all_locales>';
        $key = sprintf('%s-%s-%s', $attributeCode, $channelCode, $localeCode);

        return $this->getByKey($key);
    }

    /**
     * {@inheritDoc}
     */
    public function getKeys()
    {
        return array_keys($this->values);
    }

    /**
     * {@inheritDoc}
     */
    public function getValues()
    {
        return array_values($this->values);
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return count($this->values);
    }

    /**
     * {@inheritDoc}
     */
    public function add(ProductValueInterface $value)
    {
        if (false !== array_search($value, $this->values, true)) {
            return false;
        }

        $attribute = $value->getAttribute();
        $channelCode = null !== $value->getScope() ? $value->getScope() : '<all_channels>';
        $localeCode = null !== $value->getLocale() ? $value->getLocale() : '<all_locales>';
        $key = sprintf('%s-%s-%s', $attribute->getCode(), $channelCode, $localeCode);

        $this->values[$key] = $value;

        if ($attribute->isUnique() && null !== $value->getData()) {
            $this->uniqueValues[$key] = $value;
        }

        $this->indexAttribute($attribute);

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function isEmpty()
    {
        return empty($this->values);
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->values);
    }

    /**
     * {@inheritDoc}
     */
    public function clear()
    {
        $this->values = [];
        $this->uniqueValues = [];
        $this->attributes = [];
    }

    /**
     * {@inheritDoc}
     */
    public function getAttributesKeys()
    {
        return array_keys($this->attributes);
    }

    /**
     * {@inheritDoc}
     */
    public function getAttributes()
    {
        return array_values($this->attributes);
    }

    /**
     * {@inheritDoc}
     */
    public function getUniqueValues()
    {
        return $this->uniqueValues;
    }

    /**
     * Index an attribute
     *
     * @param AttributeInterface $attribute
     */
    private function indexAttribute(AttributeInterface $attribute)
    {
        if (!array_key_exists($attribute->getCode(), $this->attributes)) {
            $this->attributes[$attribute->getCode()] = $attribute;
        }
    }

    /**
     * Re index all the attributes by parsing the values collection.
     * Useful in case of value removal for instance.
     */
    private function reIndexAllAttributes()
    {
        $this->attributes = [];

        foreach ($this->values as $value) {
            $attribute = $value->getAttribute();
            $attributeCode = $attribute->getCode();

            if (!array_key_exists($attributeCode, $this->attributes)) {
                $this->attributes[$attributeCode] = $attribute;
            }
        }
    }
}
