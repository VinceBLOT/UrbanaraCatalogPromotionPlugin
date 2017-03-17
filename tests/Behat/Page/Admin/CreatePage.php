<?php

namespace Tests\Acme\SyliusCatalogPromotionPlugin\Behat\Page\Admin;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Behaviour\NamesIt;
use Sylius\Behat\Behaviour\SpecifiesItsCode;
use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;

class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    use NamesIt;
    use SpecifiesItsCode;

    public function makeExclusive()
    {
        $this->getDocument()->checkField('Exclusive');
    }

    /**
     * {@inheritdoc}
     */
    public function setStartsAt(\DateTime $dateTime)
    {
        $timestamp = $dateTime->getTimestamp();

        $this->getDocument()->fillField('acme_sylius_catalog_promotion_startsAt_date', date('Y-m-d', $timestamp));
        $this->getDocument()->fillField('acme_sylius_catalog_promotion_startsAt_time', date('H:i', $timestamp));
    }

    /**
     * {@inheritdoc}
     */
    public function setEndsAt(\DateTime $dateTime)
    {
        $timestamp = $dateTime->getTimestamp();

        $this->getDocument()->fillField('acme_sylius_catalog_promotion_endsAt_date', date('Y-m-d', $timestamp));
        $this->getDocument()->fillField('acme_sylius_catalog_promotion_endsAt_time', date('H:i', $timestamp));
    }

    /**
     * {@inheritdoc}
     */
    public function chooseActionType($type)
    {
        $this->getDocument()->selectFieldOption('acme_sylius_catalog_promotion_type', $type);
    }

    /**
     * {@inheritdoc}
     */
    public function fillActionAmount($field, $amount)
    {
        /** @var NodeElement $element */
        $element = $this->getDocument()->find('css', '#acme_sylius_catalog_promotion_configuration_values');
        $element->fillField($field, $amount);
    }

    /**
     * {@inheritdoc}
     */
    public function fillActionForChannel($channelName, $option, $value)
    {
        $channel = $this
            ->getDocument()
            ->find('css', sprintf('.configuration .field:contains("%s")', $channelName))
        ;

        $channel->fillField($option, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function checkChannel($name)
    {
        $this->getDocument()->checkField($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements()
    {
        return [
            'code' => '#acme_sylius_catalog_promotion_code',
            'price_for_channel' => '#acme_sylius_catalog_promotion_configuration_values',
            'ends_at' => '#acme_sylius_catalog_promotion_endsAt',
            'name' => '#acme_sylius_catalog_promotion_name',
        ];
    }
}
