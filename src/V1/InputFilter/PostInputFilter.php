<?php
namespace Strapieno\Auth\Api\V1\InputFilter;


/**
 * Class PostInputFilter
 */
class PostInputFilter extends InputFilter
{
    public function init()
    {
        parent::init();

        $this->updateClientIdInput();
    }

    /**
     * @return $this
     */
    protected function updateClientIdInput()
    {
        $input = $this->get('client_id');
        $validatorManager = $this->getFactory()->getDefaultValidatorChain()->getPluginManager();
        $input->getValidatorChain()->attach($validatorManager->get('oauthclient-clientidalreadyexist'));
        return $this;
    }
}