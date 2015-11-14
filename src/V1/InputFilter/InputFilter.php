<?php
namespace Strapieno\Auth\Api\V1\InputFilter;

use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter as ZendInputFilter;

/**
 * Class PostInputFilter
 */
class InputFilter extends ZendInputFilter
{
    public function init()
    {
        $this->addClientIdInput()
            ->addClientSecret();
    }

    /**
     * @return $this
     */
    protected function addClientIdInput()
    {
        $input = new Input('client_id');
        // Filter
        $filterManager = $this->getFactory()->getDefaultFilterChain()->getPluginManager();
        $input->getFilterChain()->attach($filterManager->get('stringtrim'));
        $validatorManager = $this->getFactory()->getDefaultValidatorChain()->getPluginManager();
        $input->getFilterChain()->attach($validatorManager->get('oauthclient-clientidalreadyexist'));
        $this->add($input);
        return $this;
    }

    /**
     * @return $this
     */
    protected function addClientSecret()
    {
        $input = new Input('password');
        // Filter
        $filterManager = $this->getFactory()->getDefaultFilterChain()->getPluginManager();
        $input->getFilterChain()->attach($filterManager->get('stringtrim'));

        $this->add($input);
        return $this;
    }

    /**
     * @return $this
     */
    protected function addClientSecret()
    {
        $input = new Input('type');
        // Filter
        $filterManager = $this->getFactory()->getDefaultFilterChain()->getPluginManager();
        $input->getFilterChain()->attach($filterManager->get('stringtrim'));
        // Validator
        $validatorManager = $this->getFactory()->getDefaultValidatorChain()->getPluginManager();
        $input->getFilterChain()->attach($validatorManager->get('OauthClientTypesValidator'));
        $this->add($input);
        return $this;
    }
}