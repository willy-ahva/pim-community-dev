<?php

namespace Pim\Bundle\TransformBundle\Normalizer\Flat;

use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Doctrine\Common\Collections\Collection;

/**
 * Normalize a doctrine collection
 *
 * @see Pim\Bundle\TransformBundle\Normalizer\Flat\ProductNormalizer
 *
 * @author    Gildas Quemener <gildas@akeneo.com>
 * @copyright 2014 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class CollectionNormalizer extends SerializerAwareNormalizer implements NormalizerInterface
{
    /** @var array */
    protected $supportedFormats = array('csv', 'flat');

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Collection && in_array($format, $this->supportedFormats);
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = array())
    {
        $result = [];
        foreach ($object as $item) {
            $normalizedItem = $this->serializer->normalize($item, $format, $context);
            if (is_array($normalizedItem)) {
                foreach (array_keys($normalizedItem) as $key) {
                    if (array_key_exists($key, $result)) {
                        throw new \RuntimeException(
                            sprintf(
                                'Key "%s" is already used (value: "%s")',
                                $key,
                                $result[$key]
                            )
                        );
                    }
                }
                $result = array_merge($result, $normalizedItem);
            } else {
                if (is_array($result)) {
                    $result = '';
                }
                $result .= $normalizedItem . ',';
            }
        }

        if (is_array($result) && count($result) > 0) {
            return $result;
        }

        if (!isset($context['field_name'])) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Missing required "field_name" context value, got "%s"',
                    implode(', ', array_keys($context))
                )
            );
        }

        if (is_array($result)) {
            $result = '';
        }

        return [$context['field_name'] => rtrim($result, ',')];
    }
}